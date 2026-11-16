<?php
/**
 * Головний файл теми SAO Aincrad.
 *
 * WordPress автоматично завантажує functions.php активної теми.
 * Тут: налаштування теми, підключення стилів і скриптів,
 * а решта логіки винесена в окремі файли папки inc/.
 *
 * @package SAO_Aincrad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // захист від прямого відкриття файлу в браузері
}

define( 'SAO_VERSION', '1.0.0' );
define( 'SAO_DIR', get_template_directory() );
define( 'SAO_URI', get_template_directory_uri() );

require SAO_DIR . '/inc/post-types.php';    // типи записів: Персонажі, Гільдії, Заявки
require SAO_DIR . '/inc/customizer.php';    // налаштування в «Вигляд → Налаштувати»
require SAO_DIR . '/inc/template-tags.php'; // допоміжні функції для шаблонів
require SAO_DIR . '/inc/contact-form.php';  // обробка форми зворотного зв'язку
require SAO_DIR . '/inc/demo-content.php';  // демо-вміст при активації теми

/**
 * Базові можливості теми.
 */
function sao_setup() {
	load_theme_textdomain( 'sao-aincrad', SAO_DIR . '/languages' );

	add_theme_support( 'title-tag' );          // <title> формує WordPress
	add_theme_support( 'post-thumbnails' );    // мініатюри записів
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 64,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// стилі редактора блоків, щоб у адмінці текст виглядав схоже на сайт
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	add_image_size( 'sao-card', 800, 800, true );

	register_nav_menus(
		array(
			'primary' => __( 'Головне меню', 'sao-aincrad' ),
			'footer'  => __( 'Меню в підвалі', 'sao-aincrad' ),
		)
	);
}
add_action( 'after_setup_theme', 'sao_setup' );

/**
 * Підключення CSS і JS.
 */
function sao_enqueue_assets() {
	// Google Fonts: Exo 2 (заголовки) + Inter (текст)
	wp_enqueue_style(
		'sao-fonts',
		'https://fonts.googleapis.com/css2?family=Exo+2:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'sao-style', get_stylesheet_uri(), array(), SAO_VERSION );
	wp_enqueue_style( 'sao-main', SAO_URI . '/assets/css/main.css', array( 'sao-fonts' ), SAO_VERSION );

	wp_enqueue_script( 'sao-theme', SAO_URI . '/assets/js/theme.js', array(), SAO_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );

	if ( is_page_template( 'page-contacts.php' ) ) {
		wp_enqueue_script( 'sao-contact', SAO_URI . '/assets/js/contact.js', array(), SAO_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
		wp_localize_script(
			'sao-contact',
			'saoContact',
			array(
				'restUrl' => esc_url_raw( rest_url( 'sao/v1/contact' ) ),
				'nonce'   => wp_create_nonce( 'wp_rest' ),
			)
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sao_enqueue_assets' );

/**
 * Preconnect до Google Fonts — шрифти вантажаться швидше.
 */
function sao_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'sao_resource_hints', 10, 2 );

/**
 * Скрипт у <head>: ставимо тему ДО відмальовки сторінки,
 * щоб не було «блимання» світлої/темної теми.
 */
function sao_theme_boot_script() {
	?>
	<script>
	(function () {
		var t = 'dark';
		try {
			t = localStorage.getItem('sao-theme') ||
				(window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark');
		} catch (e) {}
		document.documentElement.setAttribute('data-theme', t);
		document.documentElement.classList.add('js'); // CSS знає, що JS працює (для анімацій появи)
		<?php if ( is_front_page() ) : ?>
		// Інтро «LINK START» — один раз за сесію і тільки якщо не ввімкнено «зменшити рух»
		try {
			if (!sessionStorage.getItem('sao-link-start') &&
				!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
				document.documentElement.classList.add('ls-play', 'ls-intro');
			}
		} catch (e) {}
		<?php endif; ?>
	})();
	</script>
	<meta name="theme-color" content="#1a0f3a">
	<?php
}
add_action( 'wp_head', 'sao_theme_boot_script', 1 );

/**
 * SEO-мітки: description та Open Graph (якщо не встановлено SEO-плагін).
 */
function sao_meta_tags() {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ) {
		return;
	}

	$description = get_bloginfo( 'description' );
	if ( is_singular() && has_excerpt() ) {
		$description = get_the_excerpt();
	}
	$title = is_singular() ? get_the_title() : get_bloginfo( 'name' );
	$image = is_singular() && has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'large' ) : SAO_URI . '/assets/images/og-image.jpg';
	$url   = is_singular() ? get_permalink() : home_url( '/' );

	printf( '<meta name="description" content="%s">' . "\n", esc_attr( wp_strip_all_tags( $description ) ) );
	printf( '<meta property="og:type" content="%s">' . "\n", is_singular( 'post' ) ? 'article' : 'website' );
	printf( '<meta property="og:locale" content="uk_UA">' . "\n" );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( wp_strip_all_tags( $title ) ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( wp_strip_all_tags( $description ) ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

	// запасна іконка, якщо в «Налаштувати → Ідентичність сайту» не задано свою
	if ( ! has_site_icon() ) {
		printf( '<link rel="icon" type="image/png" sizes="32x32" href="%s">' . "\n", esc_url( SAO_URI . '/assets/icons/favicon-32.png' ) );
		printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( SAO_URI . '/assets/icons/apple-touch-icon.png' ) );
	}
}
add_action( 'wp_head', 'sao_meta_tags', 2 );

/**
 * Пункти меню з якорем (#aincrad) WordPress вважає «поточними» на головній разом із «Головна».
 * Прибираємо цю позначку, щоб підсвічувався лише один пункт.
 */
function sao_menu_anchor_classes( $classes, $item ) {
	if ( false !== strpos( (string) $item->url, '#' ) ) {
		$classes = array_diff( $classes, array( 'current-menu-item', 'current_page_item', 'current-menu-ancestor' ) );
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'sao_menu_anchor_classes', 10, 2 );

function sao_menu_anchor_aria( $atts, $item ) {
	if ( false !== strpos( (string) $item->url, '#' ) ) {
		unset( $atts['aria-current'] );
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'sao_menu_anchor_aria', 10, 2 );

/**
 * Довжина та «…» для анонсів записів.
 */
add_filter(
	'excerpt_length',
	function () {
		return 28;
	}
);
add_filter(
	'excerpt_more',
	function () {
		return '…';
	}
);

/**
 * Віджети: бічна панель у блозі та колонка в підвалі.
 */
function sao_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Бічна панель новин', 'sao-aincrad' ),
			'id'            => 'sidebar-news',
			'description'   => __( 'Показується на сторінці новин і в окремих записах.', 'sao-aincrad' ),
			'before_widget' => '<section id="%1$s" class="widget sao-panel %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'sao_widgets_init' );
