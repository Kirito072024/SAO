<?php
/**
 * Налаштування теми в «Вигляд → Налаштувати → Тема SAO Aincrad» (WordPress Customizer).
 *
 * Усі тексти головної сторінки, інтро, контакти й підвал змінюються без коду.
 * Текстові поля оновлюються в превʼю миттєво (transport = postMessage + assets/js/customize-preview.js),
 * посилання й перемикачі — перезавантаженням превʼю.
 *
 * Як це влаштовано:
 * 1. sao_customizer_sections() — єдиний опис усіх полів: секція → поле → [підпис, тип, значення за замовчуванням].
 * 2. sao_opt( 'ключ' ) — читає значення в шаблонах (get_theme_mod + значення за замовчуванням).
 * 3. sao_live( 'ключ' ) — додає до HTML-елемента атрибут data-sao="ключ" (лише в превʼю Customizer),
 *    щоб JavaScript знав, який елемент оновити, поки адмін друкує.
 *
 * @package SAO_Aincrad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Опис усіх налаштувань теми.
 * Типи: text, textarea, number, url, email, checkbox.
 */
function sao_customizer_sections() {
	return array(
		'sao_intro_section' => array(
			'title'       => __( 'Інтро LINK START', 'sao-aincrad' ),
			'description' => __( 'Анімація входу в гру при першому відкритті головної (раз за сесію браузера). У превʼю Customizer інтро не показується, щоб не заважати.', 'sao-aincrad' ),
			'fields'      => array(
				'sao_intro_enabled' => array( __( 'Показувати інтро', 'sao-aincrad' ), 'checkbox', true ),
				'sao_intro_text'    => array( __( 'Текст інтро', 'sao-aincrad' ), 'text', 'Link Start' ),
			),
		),

		'sao_hero'          => array(
			'title'  => __( 'Головний екран', 'sao-aincrad' ),
			'fields' => array(
				'sao_hero_kicker'   => array( __( 'Надпис над заголовком', 'sao-aincrad' ), 'text', 'Link Start' ),
				'sao_hero_title'    => array( __( 'Заголовок', 'sao-aincrad' ), 'text', 'Sword Art Online: Айнкрад' ),
				'sao_hero_subtitle' => array( __( 'Підзаголовок', 'sao-aincrad' ), 'textarea', 'Механіка гри, історія «смертельної гри», герої та гільдії летючого замку зі 100 поверхів.' ),
				'sao_hero_btn'      => array( __( 'Текст головної кнопки', 'sao-aincrad' ), 'text', 'Увійти в Айнкрад' ),
				'sao_watch_text'    => array( __( 'Текст кнопки «Дивитися»', 'sao-aincrad' ), 'text', 'Дивитися 1 сезон' ),
				'sao_watch_url'     => array( __( 'Посилання кнопки «Дивитися» (порожньо — кнопку сховано)', 'sao-aincrad' ), 'url', 'https://uakino.best/animeukr/anime-series/10037-svord-art-onlayn-1-sezon.html' ),
			),
		),

		'sao_welcome'       => array(
			'title'  => __( 'Вітання та цифри', 'sao-aincrad' ),
			'fields' => array(
				'sao_welcome_title' => array( __( 'Заголовок блоку', 'sao-aincrad' ), 'text', 'Ласкаво просимо' ),
				'sao_intro'         => array( __( 'Текст блоку', 'sao-aincrad' ), 'textarea', '6 листопада 2022 року десять тисяч гравців увійшли в гру Sword Art Online і не змогли з неї вийти. Тут ти дізнаєшся, як влаштований світ гри, що сталося на початку та хто в ньому виживав.' ),
				'sao_stat1_num'     => array( __( 'Цифра 1', 'sao-aincrad' ), 'number', 100 ),
				'sao_stat1_label'   => array( __( 'Підпис цифри 1', 'sao-aincrad' ), 'text', 'поверхів замку' ),
				'sao_stat2_num'     => array( __( 'Цифра 2', 'sao-aincrad' ), 'number', 10000 ),
				'sao_stat2_label'   => array( __( 'Підпис цифри 2', 'sao-aincrad' ), 'text', 'гравців у пастці' ),
				'sao_stat3_num'     => array( __( 'Цифра 3', 'sao-aincrad' ), 'number', 2 ),
				'sao_stat3_label'   => array( __( 'Підпис цифри 3', 'sao-aincrad' ), 'text', 'роки в грі' ),
				'sao_stat4_num'     => array( __( 'Цифра 4', 'sao-aincrad' ), 'number', 6147 ),
				'sao_stat4_label'   => array( __( 'Підпис цифри 4', 'sao-aincrad' ), 'text', 'повернулися додому' ),
			),
		),

		'sao_aincrad'       => array(
			'title'  => __( 'Блок «Айнкрад»', 'sao-aincrad' ),
			'fields' => array(
				'sao_aincrad_title'  => array( __( 'Заголовок', 'sao-aincrad' ), 'text', 'Айнкрад' ),
				'sao_aincrad_text'   => array( __( 'Текст', 'sao-aincrad' ), 'textarea', 'Айнкрад — величезний залізний замок, що висить у небі. Він складається зі 100 поверхів. На кожному є місто, лабіринт і бос, якого потрібно перемогти, щоб відкрити шлях вище.' ),
				'sao_floor1_num'     => array( __( 'Поверх 1 — номер', 'sao-aincrad' ), 'text', '1' ),
				'sao_floor1_text'    => array( __( 'Поверх 1 — опис', 'sao-aincrad' ), 'text', 'Місто Початку — тут почалася «смертельна гра»' ),
				'sao_floor2_num'     => array( __( 'Поверх 2 — номер', 'sao-aincrad' ), 'text', '22' ),
				'sao_floor2_text'    => array( __( 'Поверх 2 — опис', 'sao-aincrad' ), 'text', 'Тихий лісовий поверх, будиночок Кіріто й Асуни' ),
				'sao_floor3_num'     => array( __( 'Поверх 3 — номер', 'sao-aincrad' ), 'text', '74' ),
				'sao_floor3_text'    => array( __( 'Поверх 3 — опис', 'sao-aincrad' ), 'text', 'Бос «Блискучі очі» і подвійні мечі' ),
				'sao_floor4_num'     => array( __( 'Поверх 4 — номер', 'sao-aincrad' ), 'text', '75' ),
				'sao_floor4_text'    => array( __( 'Поверх 4 — опис', 'sao-aincrad' ), 'text', 'Колінія і фінальна дуель із Хізкліфом' ),
			),
		),

		'sao_mechanics'     => array(
			'title'  => __( 'Блок «Механіка гри»', 'sao-aincrad' ),
			'fields' => array(
				'sao_mech_title'  => array( __( 'Заголовок блоку', 'sao-aincrad' ), 'text', 'Механіка гри' ),
				'sao_tile1_title' => array( __( 'Плитка 1 — назва', 'sao-aincrad' ), 'text', 'NerveGear' ),
				'sao_tile1_text'  => array( __( 'Плитка 1 — текст', 'sao-aincrad' ), 'textarea', 'Шолом повністю занурює гравця у віртуальний світ — усі п\'ять відчуттів.' ),
				'sao_tile2_title' => array( __( 'Плитка 2 — назва', 'sao-aincrad' ), 'text', 'Sword Skills' ),
				'sao_tile2_text'  => array( __( 'Плитка 2 — текст', 'sao-aincrad' ), 'textarea', 'Магії немає: бої ведуться мечами та навичками меча. Унікальна навичка Кіріто — Dual Blades.' ),
				'sao_tile3_title' => array( __( 'Плитка 3 — назва', 'sao-aincrad' ), 'text', 'Рівні та гільдії' ),
				'sao_tile3_text'  => array( __( 'Плитка 3 — текст', 'sao-aincrad' ), 'textarea', 'Є рівні, смужка HP, інвентар, крафт і гільдії. Сильніше разом.' ),
				'sao_tile4_title' => array( __( 'Плитка 4 — назва', 'sao-aincrad' ), 'text', 'Безпечні зони' ),
				'sao_tile4_text'  => array( __( 'Плитка 4 — текст', 'sao-aincrad' ), 'textarea', 'У містах гравцям не можна завдати шкоди — тут відпочивають перед лабіринтом.' ),
				'sao_tile5_title' => array( __( 'Плитка 5 — назва', 'sao-aincrad' ), 'text', 'Колір курсора' ),
				'sao_tile5_text'  => array( __( 'Плитка 5 — текст', 'sao-aincrad' ), 'textarea', 'Зелений — звичайний гравець, жовтогарячий — злочинець, червоний — убивця.' ),
				'sao_tile6_title' => array( __( 'Плитка 6 — назва', 'sao-aincrad' ), 'text', 'Головне правило' ),
				'sao_tile6_text'  => array( __( 'Плитка 6 — текст', 'sao-aincrad' ), 'textarea', 'Смерть у грі означає смерть у реальності. Другого життя немає.' ),
			),
		),

		'sao_sections'      => array(
			'title'       => __( 'Заголовки інших секцій', 'sao-aincrad' ),
			'description' => __( 'Сам текст історії редагується на сторінці «Головна» (Сторінки → Головна). Персонажі, гільдії й новини — у відповідних розділах адмінки.', 'sao-aincrad' ),
			'fields'      => array(
				'sao_story_title'      => array( __( 'Заголовок історії', 'sao-aincrad' ), 'text', 'Чому гра стала смертельною' ),
				'sao_characters_title' => array( __( 'Заголовок «Персонажі»', 'sao-aincrad' ), 'text', 'Персонажі' ),
				'sao_guilds_title'     => array( __( 'Заголовок «Гільдії»', 'sao-aincrad' ), 'text', 'Клани та гільдії' ),
				'sao_news_title'       => array( __( 'Заголовок «Новини»', 'sao-aincrad' ), 'text', 'Новини Айнкраду' ),
			),
		),

		'sao_cta'           => array(
			'title'  => __( 'Заклик і цікавий факт', 'sao-aincrad' ),
			'fields' => array(
				'sao_cta_title' => array( __( 'Заголовок заклику', 'sao-aincrad' ), 'text', 'Є питання або ідея?' ),
				'sao_cta_text'  => array( __( 'Текст заклику', 'sao-aincrad' ), 'text', 'Напиши нам — заявка потрапить прямо в адмінку сайту.' ),
				'sao_cta_btn'   => array( __( 'Текст кнопки', 'sao-aincrad' ), 'text', 'Написати' ),
				'sao_fact'      => array( __( 'Цікавий факт (порожньо — блок сховано)', 'sao-aincrad' ), 'textarea', 'Гільдії в Sword Art Online можна було створити лише після виконання квесту на 3-му поверсі.' ),
			),
		),

		'sao_contacts'      => array(
			'title'  => __( 'Контакти та підвал', 'sao-aincrad' ),
			'fields' => array(
				'sao_email'       => array( __( 'Email для заявок (і показу на сайті)', 'sao-aincrad' ), 'email', '' ), // порожньо — заявки йдуть на email адміністратора
				'sao_github'      => array( __( 'Посилання на GitHub', 'sao-aincrad' ), 'url', 'https://github.com/Kirito072024/SAO' ),
				'sao_footer_text' => array( __( 'Текст у підвалі', 'sao-aincrad' ), 'textarea', 'Фан-проєкт для навчання. Sword Art Online створив Рекі Кавахара, аніме зробила студія A-1 Pictures.' ),
			),
		),
	);
}

/**
 * Значення за замовчуванням (використовуються, поки адмін нічого не змінив).
 */
function sao_defaults() {
	static $defaults = null;
	if ( null === $defaults ) {
		$defaults = array();
		foreach ( sao_customizer_sections() as $section ) {
			foreach ( $section['fields'] as $key => $field ) {
				$defaults[ $key ] = $field[2];
			}
		}
	}
	return $defaults;
}

/**
 * Отримати налаштування з урахуванням значення за замовчуванням.
 */
function sao_opt( $key ) {
	$defaults = sao_defaults();
	return get_theme_mod( $key, $defaults[ $key ] ?? '' );
}

/**
 * Атрибут data-sao="ключ" для миттєвого оновлення тексту в превʼю Customizer.
 * На звичайному сайті нічого не виводить.
 */
function sao_live( $key ) {
	if ( is_customize_preview() ) {
		echo ' data-sao="' . esc_attr( $key ) . '"';
	}
}

/**
 * Число з пробілами між тисячами (10 000), як у лічильниках JS.
 */
function sao_number( $num ) {
	return number_format( (int) $num, 0, '', ' ' );
}

/**
 * Очищення значення чекбокса.
 */
function sao_sanitize_checkbox( $value ) {
	return (bool) $value;
}

function sao_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'sao_panel',
		array(
			'title'       => __( 'Тема SAO Aincrad', 'sao-aincrad' ),
			'description' => __( 'Тексти змінюються в превʼю одразу. Щоб зміни побачили відвідувачі, натисніть «Опублікувати».', 'sao-aincrad' ),
			'priority'    => 30,
		)
	);

	$sanitizers = array(
		'text'     => 'sanitize_text_field',
		'textarea' => 'sanitize_textarea_field',
		'number'   => 'absint',
		'url'      => 'esc_url_raw',
		'email'    => 'sanitize_email',
		'checkbox' => 'sao_sanitize_checkbox',
	);

	foreach ( sao_customizer_sections() as $section_id => $section ) {
		$wp_customize->add_section(
			$section_id,
			array(
				'title'       => $section['title'],
				'description' => $section['description'] ?? '',
				'panel'       => 'sao_panel',
			)
		);

		foreach ( $section['fields'] as $key => $field ) {
			list( $label, $type, $default ) = $field;

			// Текст і числа міняються миттєво; посилання, email і чекбокси показують/ховають цілі блоки — тому перезавантаження
			$live = in_array( $type, array( 'text', 'textarea', 'number' ), true ) && 'sao_fact' !== $key;

			$wp_customize->add_setting(
				$key,
				array(
					'default'           => $default,
					'sanitize_callback' => $sanitizers[ $type ],
					'transport'         => $live ? 'postMessage' : 'refresh',
				)
			);

			$control = array(
				'label'   => $label,
				'section' => $section_id,
				'type'    => $type,
			);
			if ( 'number' === $type ) {
				$control['input_attrs'] = array(
					'min'  => 0,
					'step' => 1,
				);
			}
			$wp_customize->add_control( $key, $control );
		}
	}

	// Назва сайту й опис теж оновлюються миттєво
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'sao_customize_register' );

/**
 * Скрипт превʼю: отримує нові значення з панелі й підставляє їх у сторінку без перезавантаження.
 */
function sao_customize_preview_js() {
	$keys = array();
	foreach ( sao_customizer_sections() as $section ) {
		foreach ( $section['fields'] as $key => $field ) {
			if ( in_array( $field[1], array( 'text', 'textarea', 'number' ), true ) && 'sao_fact' !== $key ) {
				$keys[ $key ] = $field[1];
			}
		}
	}

	wp_enqueue_script( 'sao-customize-preview', SAO_URI . '/assets/js/customize-preview.js', array( 'customize-preview' ), SAO_VERSION, true );
	wp_localize_script( 'sao-customize-preview', 'saoPreviewKeys', $keys );
}
add_action( 'customize_preview_init', 'sao_customize_preview_js' );
