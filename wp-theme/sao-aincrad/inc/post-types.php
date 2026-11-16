<?php
/**
 * Власні типи записів (Custom Post Types) і додаткові поля (мета-бокси).
 *
 * - sao_character — «Персонажі» (команда сайту в стилі корпоративної сторінки «Наша команда»)
 * - sao_guild     — «Гільдії» (партнери / підрозділи)
 * - sao_message   — «Заявки» з форми зворотного зв'язку (видно лише в адмінці)
 *
 * @package SAO_Aincrad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Реєстрація типів записів.
 */
function sao_register_post_types() {
	register_post_type(
		'sao_character',
		array(
			'labels'       => array(
				'name'          => __( 'Персонажі', 'sao-aincrad' ),
				'singular_name' => __( 'Персонаж', 'sao-aincrad' ),
				'add_new'       => __( 'Додати персонажа', 'sao-aincrad' ),
				'add_new_item'  => __( 'Новий персонаж', 'sao-aincrad' ),
				'edit_item'     => __( 'Редагувати персонажа', 'sao-aincrad' ),
				'all_items'     => __( 'Усі персонажі', 'sao-aincrad' ),
			),
			'public'       => true,
			'has_archive'  => 'characters',
			'rewrite'      => array( 'slug' => 'characters' ),
			'menu_icon'    => 'dashicons-groups',
			'menu_position' => 5,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'show_in_rest' => true, // редактор блоків Gutenberg
		)
	);

	register_post_type(
		'sao_guild',
		array(
			'labels'       => array(
				'name'          => __( 'Гільдії', 'sao-aincrad' ),
				'singular_name' => __( 'Гільдія', 'sao-aincrad' ),
				'add_new'       => __( 'Додати гільдію', 'sao-aincrad' ),
				'add_new_item'  => __( 'Нова гільдія', 'sao-aincrad' ),
				'edit_item'     => __( 'Редагувати гільдію', 'sao-aincrad' ),
				'all_items'     => __( 'Усі гільдії', 'sao-aincrad' ),
			),
			'public'       => true,
			'has_archive'  => 'guilds',
			'rewrite'      => array( 'slug' => 'guilds' ),
			'menu_icon'    => 'dashicons-shield',
			'menu_position' => 6,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'show_in_rest' => true,
		)
	);

	register_post_type(
		'sao_message',
		array(
			'labels'          => array(
				'name'          => __( 'Заявки', 'sao-aincrad' ),
				'singular_name' => __( 'Заявка', 'sao-aincrad' ),
				'all_items'     => __( 'Усі заявки', 'sao-aincrad' ),
				'edit_item'     => __( 'Перегляд заявки', 'sao-aincrad' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'menu_icon'       => 'dashicons-email-alt',
			'menu_position'   => 25,
			'supports'        => array( 'title', 'editor' ),
			'capability_type' => 'post',
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ), // заявки створює лише форма
			'map_meta_cap'    => true,
		)
	);
}
add_action( 'init', 'sao_register_post_types' );

/**
 * Опис додаткових полів для кожного типу запису.
 * Ключ — назва мета-поля, значення — підпис у адмінці.
 */
function sao_meta_fields() {
	return array(
		'sao_character' => array(
			'sao_role'  => __( 'Роль / прізвисько (напр. «Чорний мечник»)', 'sao-aincrad' ),
			'sao_image' => __( 'Запасна картинка з теми (kirito, asuna, klein, yui), якщо немає мініатюри', 'sao-aincrad' ),
		),
		'sao_guild'     => array(
			'sao_leader' => __( 'Лідер гільдії', 'sao-aincrad' ),
			'sao_type'   => __( 'Тип (напр. «Штурмова», «Червона гільдія»)', 'sao-aincrad' ),
		),
		'post'          => array(
			'sao_world_date' => __( 'Дата в світі SAO (напр. «Грудень 2022»)', 'sao-aincrad' ),
		),
	);
}

/**
 * Мета-бокс «Дані SAO» у редакторі.
 */
function sao_add_meta_boxes() {
	foreach ( array_keys( sao_meta_fields() ) as $post_type ) {
		add_meta_box( 'sao_meta', __( 'Дані SAO', 'sao-aincrad' ), 'sao_render_meta_box', $post_type, 'side' );
	}
}
add_action( 'add_meta_boxes', 'sao_add_meta_boxes' );

function sao_render_meta_box( $post ) {
	$fields = sao_meta_fields();
	wp_nonce_field( 'sao_save_meta', 'sao_meta_nonce' );

	foreach ( $fields[ $post->post_type ] as $key => $label ) {
		printf(
			'<p><label for="%1$s" style="display:block;margin-bottom:4px">%2$s</label><input type="text" class="widefat" id="%1$s" name="%1$s" value="%3$s"></p>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( get_post_meta( $post->ID, $key, true ) )
		);
	}
}

function sao_save_meta( $post_id, $post ) {
	$fields = sao_meta_fields();

	if ( ! isset( $fields[ $post->post_type ], $_POST['sao_meta_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sao_meta_nonce'] ) ), 'sao_save_meta' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( array_keys( $fields[ $post->post_type ] ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
}
add_action( 'save_post', 'sao_save_meta', 10, 2 );

/**
 * Додаткові колонки в списку заявок: email, телефон, тема.
 */
function sao_message_columns( $columns ) {
	return array(
		'cb'        => $columns['cb'],
		'title'     => __( 'Ім\'я', 'sao-aincrad' ),
		'sao_email' => 'Email',
		'sao_phone' => __( 'Телефон', 'sao-aincrad' ),
		'sao_topic' => __( 'Тема', 'sao-aincrad' ),
		'date'      => $columns['date'],
	);
}
add_filter( 'manage_sao_message_posts_columns', 'sao_message_columns' );

function sao_message_column_content( $column, $post_id ) {
	if ( in_array( $column, array( 'sao_email', 'sao_phone', 'sao_topic' ), true ) ) {
		echo esc_html( get_post_meta( $post_id, $column, true ) );
	}
}
add_action( 'manage_sao_message_posts_custom_column', 'sao_message_column_content', 10, 2 );

/**
 * Лічильник заявок біля пункту меню «Заявки» (заявки зберігаються зі статусом private).
 */
function sao_message_menu_badge() {
	global $menu;
	$count = wp_count_posts( 'sao_message' )->private ?? 0;
	if ( ! $count ) {
		return;
	}
	foreach ( $menu as $i => $item ) {
		if ( 'edit.php?post_type=sao_message' === $item[2] ) {
			$menu[ $i ][0] .= ' <span class="awaiting-mod">' . (int) $count . '</span>'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
		}
	}
}
add_action( 'admin_menu', 'sao_message_menu_badge', 99 );
