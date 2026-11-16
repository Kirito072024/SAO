<?php
/**
 * Шапка сайту: <head>, верхня панель з логотипом, меню і перемикачем теми.
 *
 * @package SAO_Aincrad
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( sao_intro_active() ) : ?>
	<!-- Інтро «LINK START»: кольорові кільця летять назустріч, як при вході в гру.
	     Показується лише якщо скрипт у <head> додав клас .ls-play (раз за сесію), клік — пропустити -->
	<div class="link-start" id="link-start" aria-hidden="true">
		<div class="link-start__tunnel">
			<?php for ( $i = 0; $i < 10; $i++ ) : ?>
				<span style="--i: <?php echo (int) $i; ?>"></span>
			<?php endfor; ?>
		</div>
		<p class="link-start__text"><?php echo esc_html( sao_opt( 'sao_intro_text' ) ); ?></p>
	</div>
<?php endif; ?>

<a class="skip-link" href="#main"><?php esc_html_e( 'Перейти до основного вмісту', 'sao-aincrad' ); ?></a>

<!-- «Смужка HP» у стилі SAO: показує, скільки сторінки прокручено (керує theme.js) -->
<div class="hp-bar" aria-hidden="true"><span class="hp-bar__fill"></span></div>

<header class="topbar" id="top">
	<div class="topbar__inner container">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php if ( has_custom_logo() ) : ?>
				<?php echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'thumbnail', false, array( 'class' => 'brand__logo' ) ); ?>
			<?php else : ?>
				<svg class="brand__emblem" viewBox="0 0 40 40" aria-hidden="true">
					<circle cx="20" cy="20" r="18" fill="none" stroke="currentColor" stroke-width="1.5" opacity=".5"/>
					<path d="M13 30L27 9M27 30L13 9" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
					<path d="M10 26h6M24 26h6" style="stroke: var(--accent-color)" stroke-width="2.4" stroke-linecap="round"/>
				</svg>
			<?php endif; ?>
			<span class="brand__name"><?php bloginfo( 'name' ); ?></span>
		</a>

		<nav class="primary-nav" id="primary-nav" aria-label="<?php esc_attr_e( 'Головне меню', 'sao-aincrad' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu',
					'depth'          => 1,
					'fallback_cb'    => 'sao_menu_fallback',
				)
			);
			?>
		</nav>

		<div class="topbar__actions">
			<?php sao_theme_toggle(); ?>
			<button type="button" class="burger" id="burger" aria-controls="primary-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Відкрити меню', 'sao-aincrad' ); ?>">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<main id="main" tabindex="-1">
