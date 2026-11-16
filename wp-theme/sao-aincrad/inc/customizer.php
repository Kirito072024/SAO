<?php
/**
 * Налаштування теми в «Вигляд → Налаштувати» (WordPress Customizer).
 * Тексти головного екрана, посилання і контакти можна змінювати без коду.
 *
 * @package SAO_Aincrad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Значення за замовчуванням (використовуються, поки адмін нічого не змінив).
 */
function sao_defaults() {
	return array(
		'sao_hero_kicker'   => 'Link Start',
		'sao_hero_title'    => 'Sword Art Online: Айнкрад',
		'sao_hero_subtitle' => 'Механіка гри, історія «смертельної гри», герої та гільдії летючого замку зі 100 поверхів.',
		'sao_intro'         => '6 листопада 2022 року десять тисяч гравців увійшли в гру Sword Art Online і не змогли з неї вийти. Тут ти дізнаєшся, як влаштований світ гри, що сталося на початку та хто в ньому виживав.',
		'sao_watch_url'     => 'https://uakino.best/animeukr/anime-series/10037-svord-art-onlayn-1-sezon.html',
		'sao_fact'          => 'Гільдії в Sword Art Online можна було створити лише після виконання квесту на 3-му поверсі.',
		'sao_email'         => '', // порожньо — заявки йдуть на email адміністратора сайту
		'sao_github'        => 'https://github.com/Kirito072024/SAO',
		'sao_footer_text'   => 'Фан-проєкт для навчання. Sword Art Online створив Рекі Кавахара, аніме зробила студія A-1 Pictures.',
	);
}

/**
 * Отримати налаштування з урахуванням значення за замовчуванням.
 */
function sao_opt( $key ) {
	$defaults = sao_defaults();
	return get_theme_mod( $key, $defaults[ $key ] ?? '' );
}

function sao_customize_register( $wp_customize ) {
	$defaults = sao_defaults();

	$wp_customize->add_panel(
		'sao_panel',
		array(
			'title'    => __( 'Тема SAO Aincrad', 'sao-aincrad' ),
			'priority' => 30,
		)
	);

	$sections = array(
		'sao_hero'    => array(
			'title'  => __( 'Головний екран', 'sao-aincrad' ),
			'fields' => array(
				'sao_hero_kicker'   => array( __( 'Надпис над заголовком', 'sao-aincrad' ), 'text' ),
				'sao_hero_title'    => array( __( 'Заголовок', 'sao-aincrad' ), 'text' ),
				'sao_hero_subtitle' => array( __( 'Підзаголовок', 'sao-aincrad' ), 'textarea' ),
				'sao_intro'         => array( __( 'Текст блоку «Ласкаво просимо»', 'sao-aincrad' ), 'textarea' ),
				'sao_watch_url'     => array( __( 'Посилання «Дивитися аніме»', 'sao-aincrad' ), 'url' ),
				'sao_fact'          => array( __( 'Цікавий факт', 'sao-aincrad' ), 'textarea' ),
			),
		),
		'sao_contacts' => array(
			'title'  => __( 'Контакти та підвал', 'sao-aincrad' ),
			'fields' => array(
				'sao_email'       => array( __( 'Email для заявок (і показу на сайті)', 'sao-aincrad' ), 'email' ),
				'sao_github'      => array( __( 'Посилання на GitHub', 'sao-aincrad' ), 'url' ),
				'sao_footer_text' => array( __( 'Текст у підвалі', 'sao-aincrad' ), 'textarea' ),
			),
		),
	);

	foreach ( $sections as $section_id => $section ) {
		$wp_customize->add_section(
			$section_id,
			array(
				'title' => $section['title'],
				'panel' => 'sao_panel',
			)
		);

		foreach ( $section['fields'] as $key => $field ) {
			list( $label, $type ) = $field;

			$sanitize = 'sanitize_text_field';
			if ( 'url' === $type ) {
				$sanitize = 'esc_url_raw';
			} elseif ( 'email' === $type ) {
				$sanitize = 'sanitize_email';
			} elseif ( 'textarea' === $type ) {
				$sanitize = 'sanitize_textarea_field';
			}

			$wp_customize->add_setting(
				$key,
				array(
					'default'           => $defaults[ $key ],
					'sanitize_callback' => $sanitize,
					'transport'         => 'refresh',
				)
			);
			$wp_customize->add_control(
				$key,
				array(
					'label'   => $label,
					'section' => $section_id,
					'type'    => $type,
				)
			);
		}
	}
}
add_action( 'customize_register', 'sao_customize_register' );
