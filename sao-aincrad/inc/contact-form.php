<?php
/**
 * Форма зворотного зв'язку.
 *
 * Як це працює:
 * 1. JavaScript (assets/js/contact.js) перевіряє поля і надсилає їх POST-запитом
 *    на REST API WordPress: /wp-json/sao/v1/contact
 * 2. Сервер ще раз перевіряє дані (на клієнті перевірку можна обійти),
 *    зберігає заявку як запис типу sao_message і надсилає лист адміністратору.
 * 3. Якщо JavaScript вимкнено, форма відправляється звичайним POST на
 *    wp-admin/admin-post.php — результат той самий.
 *
 * @package SAO_Aincrad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Теми звернення (value => підпис).
 */
function sao_contact_topics() {
	return array(
		'question' => __( 'Питання про сайт', 'sao-aincrad' ),
		'idea'     => __( 'Ідея для розділу', 'sao-aincrad' ),
		'guild'    => __( 'Хочу у гільдію', 'sao-aincrad' ),
		'other'    => __( 'Інше', 'sao-aincrad' ),
	);
}

/**
 * Перевірка та збереження заявки. Спільна для REST і звичайного POST.
 *
 * @param array $raw Сирі дані форми.
 * @return true|WP_Error
 */
function sao_handle_contact( $raw ) {
	// «Пастка для ботів»: приховане поле, яке людина не бачить і не заповнює
	if ( ! empty( $raw['website'] ) ) {
		return true; // вдаємо успіх, але нічого не зберігаємо
	}

	$data = array(
		'name'    => sanitize_text_field( $raw['name'] ?? '' ),
		'email'   => sanitize_email( $raw['email'] ?? '' ),
		'phone'   => preg_replace( '/[\s()-]/', '', sanitize_text_field( $raw['phone'] ?? '' ) ),
		'topic'   => sanitize_key( $raw['topic'] ?? 'other' ),
		'message' => sanitize_textarea_field( $raw['message'] ?? '' ),
		'agree'   => ! empty( $raw['agree'] ),
	);

	$errors = array();
	if ( '' === $data['name'] ) {
		$errors[] = __( "Введіть ім'я.", 'sao-aincrad' );
	}
	if ( ! is_email( $data['email'] ) ) {
		$errors[] = __( 'Перевірте формат email, наприклад name@example.com.', 'sao-aincrad' );
	}
	if ( ! preg_match( '/^\+380\d{9}$/', $data['phone'] ) ) {
		$errors[] = __( 'Телефон має бути у форматі +380XXXXXXXXX.', 'sao-aincrad' );
	}
	if ( '' === $data['message'] ) {
		$errors[] = __( 'Напишіть повідомлення.', 'sao-aincrad' );
	}
	if ( ! $data['agree'] ) {
		$errors[] = __( 'Потрібна згода на обробку даних.', 'sao-aincrad' );
	}
	if ( $errors ) {
		return new WP_Error( 'sao_invalid', implode( "\n", $errors ), array( 'status' => 400 ) );
	}

	// Захист від спаму: не частіше ніж раз на 30 секунд з однієї IP-адреси
	$ip_key = 'sao_contact_' . md5( $_SERVER['REMOTE_ADDR'] ?? 'unknown' ); // phpcs:ignore
	if ( get_transient( $ip_key ) ) {
		return new WP_Error( 'sao_too_fast', __( 'Зачекайте трохи перед наступним повідомленням.', 'sao-aincrad' ), array( 'status' => 429 ) );
	}
	set_transient( $ip_key, 1, 30 );

	$topics = sao_contact_topics();
	$topic  = $topics[ $data['topic'] ] ?? $topics['other'];

	// Зберігаємо заявку в адмінці (меню «Заявки»)
	$post_id = wp_insert_post(
		array(
			'post_type'    => 'sao_message',
			'post_status'  => 'private',
			'post_title'   => $data['name'],
			'post_content' => $data['message'],
		),
		true
	);
	if ( is_wp_error( $post_id ) ) {
		return new WP_Error( 'sao_save', __( 'Не вдалося зберегти заявку.', 'sao-aincrad' ), array( 'status' => 500 ) );
	}
	update_post_meta( $post_id, 'sao_email', $data['email'] );
	update_post_meta( $post_id, 'sao_phone', $data['phone'] );
	update_post_meta( $post_id, 'sao_topic', $topic );

	// Лист адміністратору (на безкоштовному хостингу пошта може не працювати — заявка все одно збережена)
	$to = sao_opt( 'sao_email' ) ? sao_opt( 'sao_email' ) : get_option( 'admin_email' );
	wp_mail(
		$to,
		sprintf( '[%s] %s: %s', get_bloginfo( 'name' ), $topic, $data['name'] ),
		sprintf( "Ім'я: %s\nEmail: %s\nТелефон: %s\nТема: %s\n\n%s", $data['name'], $data['email'], $data['phone'], $topic, $data['message'] ),
		array( 'Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>' )
	);

	return true;
}

/**
 * REST-маршрут POST /wp-json/sao/v1/contact
 */
function sao_register_contact_route() {
	register_rest_route(
		'sao/v1',
		'/contact',
		array(
			'methods'             => 'POST',
			'permission_callback' => '__return_true', // форма доступна всім відвідувачам
			'callback'            => function ( WP_REST_Request $request ) {
				$result = sao_handle_contact( $request->get_params() );
				if ( is_wp_error( $result ) ) {
					return $result;
				}
				return rest_ensure_response( array( 'ok' => true ) );
			},
		)
	);
}
add_action( 'rest_api_init', 'sao_register_contact_route' );

/**
 * Запасний варіант без JavaScript: admin-post.php?action=sao_contact
 */
function sao_contact_fallback() {
	check_admin_referer( 'sao_contact', 'sao_contact_nonce' );
	$result   = sao_handle_contact( wp_unslash( $_POST ) ); // дані очищуються всередині sao_handle_contact
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$redirect = add_query_arg( 'sent', is_wp_error( $result ) ? 'error' : 'ok', $redirect );
	wp_safe_redirect( $redirect . '#contact-form' );
	exit;
}
add_action( 'admin_post_nopriv_sao_contact', 'sao_contact_fallback' );
add_action( 'admin_post_sao_contact', 'sao_contact_fallback' );
