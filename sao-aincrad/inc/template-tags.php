<?php
/**
 * Допоміжні функції для шаблонів: картинки, дати, іконки, перемикач теми.
 *
 * @package SAO_Aincrad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Картинка персонажа: мініатюра запису або запасна WebP з папки теми.
 */
function sao_character_image( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$alt     = get_the_title( $post_id ) . ( get_post_meta( $post_id, 'sao_role', true ) ? ' — ' . get_post_meta( $post_id, 'sao_role', true ) : '' );

	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail(
			$post_id,
			'sao-card',
			array(
				'class'   => 'card__img',
				'loading' => 'lazy',
				'alt'     => esc_attr( $alt ),
			)
		);
		return;
	}

	$slug = sanitize_key( get_post_meta( $post_id, 'sao_image', true ) );
	if ( $slug && file_exists( SAO_DIR . "/assets/images/{$slug}-400.webp" ) ) {
		$base = SAO_URI . "/assets/images/{$slug}";
		printf(
			'<img class="card__img" src="%1$s-400.webp" srcset="%1$s-400.webp 400w, %1$s-800.webp 800w" sizes="(min-width: 1024px) 25vw, (min-width: 640px) 50vw, 100vw" width="400" height="400" alt="%2$s" loading="lazy" decoding="async">',
			esc_url( $base ),
			esc_attr( $alt )
		);
		return;
	}

	// немає картинки — емблема з першою літерою імені
	printf(
		'<div class="card__img card__img--placeholder" aria-hidden="true"><span>%s</span></div>',
		esc_html( mb_substr( get_the_title( $post_id ), 0, 1 ) )
	);
}

/**
 * Дата новини «у світі SAO» (мета-поле) або звичайна дата публікації.
 */
function sao_world_date( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$date    = get_post_meta( $post_id, 'sao_world_date', true );
	return $date ? $date : get_the_date( '', $post_id );
}

/**
 * Перша мітка (tag) запису — показується як «пігулка» (напр. «Поверх 75»).
 */
function sao_first_tag( $post_id = null ) {
	$tags = get_the_tags( $post_id );
	return $tags ? $tags[0]->name : '';
}

/**
 * Невеликі SVG-іконки (inline, без зовнішніх файлів).
 */
function sao_icon( $name ) {
	$icons = array(
		'sword'  => '<path d="M14.5 3H21v6.5L9.5 21 8 19.5l-2 2L3.5 19l2-2L4 15.5z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M13 11l-2 2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>',
		'shield' => '<path d="M12 3l8 3v6c0 4.5-3.4 8.3-8 9-4.6-.7-8-4.5-8-9V6z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>',
		'heart'  => '<path d="M12 20s-7-4.4-7-10a4 4 0 017-2.6A4 4 0 0119 10c0 5.6-7 10-7 10z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>',
		'helmet' => '<path d="M4 14a8 8 0 0116 0v3H4z M4 17h16 M9 14h6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>',
		'skull'  => '<path d="M12 3a7 7 0 00-7 7c0 2.4 1.2 4 2.5 5v3h9v-3c1.3-1 2.5-2.6 2.5-5a7 7 0 00-7-7z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="9.5" cy="11" r="1.4" fill="currentColor"/><circle cx="14.5" cy="11" r="1.4" fill="currentColor"/>',
		'arrow'  => '<path d="M5 12h14M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
		'github' => '<path fill="currentColor" d="M12 2a10 10 0 00-3.2 19.5c.5.1.7-.2.7-.5v-1.7c-2.8.6-3.4-1.3-3.4-1.3-.4-1.2-1.1-1.5-1.1-1.5-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.5 2.3 1.1 2.9.8.1-.6.3-1.1.6-1.3-2.2-.3-4.6-1.1-4.6-5 0-1.1.4-2 1-2.7-.1-.3-.4-1.3.1-2.7 0 0 .8-.3 2.8 1a9.6 9.6 0 015 0c1.9-1.3 2.7-1 2.7-1 .6 1.4.2 2.4.1 2.7.7.7 1 1.6 1 2.7 0 3.9-2.3 4.7-4.6 5 .4.3.7.9.7 1.9V21c0 .3.2.6.7.5A10 10 0 0012 2z"/>',
		'mail'   => '<rect x="3" y="5" width="18" height="14" rx="2" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M3 7l9 6 9-6" fill="none" stroke="currentColor" stroke-width="1.8"/>',
		'play'   => '<path d="M8 5v14l11-7z" fill="currentColor"/>',
	);

	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}
	return '<svg class="icon icon--' . esc_attr( $name ) . '" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false">' . $icons[ $name ] . '</svg>'; // phpcs:ignore
}

/**
 * Перемикач теми «сонце / місяць» у стилі інтерфейсу SAO.
 * Уся анімація — у CSS (розділ «Перемикач теми» в main.css), логіка — у theme.js.
 */
function sao_theme_toggle() {
	?>
	<button type="button" class="sao-toggle" id="theme-toggle" aria-label="<?php esc_attr_e( 'Перемкнути світлу / темну тему', 'sao-aincrad' ); ?>" aria-pressed="false">
		<span class="sao-toggle__ring" aria-hidden="true"></span>
		<svg class="sao-toggle__svg" viewBox="0 0 48 48" aria-hidden="true" focusable="false">
			<defs>
				<radialGradient id="saoSunCore" cx="40%" cy="38%" r="65%">
					<stop offset="0" stop-color="#fffbe6"/>
					<stop offset="0.45" stop-color="#ffd25e"/>
					<stop offset="1" stop-color="#ff8a1f"/>
				</radialGradient>
				<linearGradient id="saoMoonFill" x1="0" y1="0" x2="1" y2="1">
					<stop offset="0" stop-color="#ffffff"/>
					<stop offset="1" stop-color="#b7b0ea"/>
				</linearGradient>
				<mask id="saoMoonMask">
					<rect width="48" height="48" fill="#fff"/>
					<circle class="sao-toggle__bite" cx="33" cy="16" r="11" fill="#000"/>
				</mask>
			</defs>

			<!-- СОНЦЕ: ядро + 8 «клинків»-променів, що повільно обертаються -->
			<g class="sao-toggle__sun">
				<g class="sao-toggle__rays">
					<?php for ( $i = 0; $i < 8; $i++ ) : ?>
						<path d="M24 2.5l1.7 6.3L24 11l-1.7-2.2z" transform="rotate(<?php echo (int) ( $i * 45 ); ?> 24 24)"/>
					<?php endfor; ?>
				</g>
				<circle cx="24" cy="24" r="8.5" fill="url(#saoSunCore)"/>
				<circle cx="24" cy="24" r="11.5" fill="none" stroke="#ffb547" stroke-width="0.8" stroke-dasharray="2 2.6" opacity="0.8"/>
			</g>

			<!-- МІСЯЦЬ: серп (коло з «вкушеним» краєм через mask), кратери і зірки -->
			<g class="sao-toggle__moon">
				<g mask="url(#saoMoonMask)">
					<circle cx="24" cy="24" r="13" fill="url(#saoMoonFill)"/>
					<circle cx="18" cy="28" r="2.4" fill="#9a92d6" opacity="0.55"/>
					<circle cx="23" cy="34" r="1.5" fill="#9a92d6" opacity="0.5"/>
					<circle cx="15" cy="21" r="1.2" fill="#9a92d6" opacity="0.5"/>
				</g>
				<path class="sao-toggle__star s1" d="M37 27l.8 2.2 2.2.8-2.2.8-.8 2.2-.8-2.2-2.2-.8 2.2-.8z"/>
				<path class="sao-toggle__star s2" d="M34 36l.5 1.4 1.4.5-1.4.5-.5 1.4-.5-1.4-1.4-.5 1.4-.5z"/>
				<path class="sao-toggle__star s3" d="M40 17l.4 1.1 1.1.4-1.1.4-.4 1.1-.4-1.1-1.1-.4 1.1-.4z"/>
			</g>
		</svg>
	</button>
	<?php
}

/**
 * Небо з сонцем / місяцем, зорями, хмарами і силуетом Айнкрада.
 * Використовується в героїчному блоці головної та в шапках внутрішніх сторінок.
 */
function sao_sky( $with_castle = true ) {
	?>
	<div class="sky" aria-hidden="true">
		<div class="sky__stars sky__stars--1"></div>
		<div class="sky__stars sky__stars--2"></div>
		<span class="sky__shooting"></span>

		<div class="sky__orb sky__orb--sun">
			<svg viewBox="0 0 200 200">
				<g class="sky__sun-rays">
					<?php for ( $i = 0; $i < 12; $i++ ) : ?>
						<path d="M100 4l5 22-5 8-5-8z" transform="rotate(<?php echo (int) ( $i * 30 ); ?> 100 100)"/>
					<?php endfor; ?>
				</g>
				<circle class="sky__sun-ring" cx="100" cy="100" r="58" fill="none" stroke-width="1.5" stroke-dasharray="6 8"/>
				<circle cx="100" cy="100" r="46" class="sky__sun-core"/>
			</svg>
		</div>

		<div class="sky__orb sky__orb--moon">
			<svg viewBox="0 0 200 200">
				<defs>
					<mask id="skyMoonMask">
						<rect width="200" height="200" fill="#fff"/>
						<circle cx="132" cy="72" r="58" fill="#000"/>
					</mask>
				</defs>
				<circle class="sky__moon-ring" cx="100" cy="100" r="74" fill="none" stroke-width="1" stroke-dasharray="3 7"/>
				<g mask="url(#skyMoonMask)">
					<circle cx="100" cy="100" r="62" class="sky__moon-core"/>
					<circle cx="72" cy="118" r="9" class="sky__crater"/>
					<circle cx="92" cy="146" r="6" class="sky__crater"/>
					<circle cx="60" cy="88" r="5" class="sky__crater"/>
				</g>
			</svg>
		</div>

		<div class="sky__cloud sky__cloud--1"></div>
		<div class="sky__cloud sky__cloud--2"></div>
		<div class="sky__cloud sky__cloud--3"></div>

		<?php if ( $with_castle ) : ?>
			<!-- Стилізований Айнкрад: 8 «поверхів»-дисків, що звужуються догори (кожен — трапеція з еліптичним краєм),
			     шпиль угорі і кам'яні «бурульки», що звисають з основи. Малюється циклом PHP. -->
			<svg class="sky__castle" viewBox="0 -14 240 250">
				<ellipse class="sky__castle-halo" cx="120" cy="176" rx="118" ry="16"/>
				<g class="sky__castle-body">
					<?php
					// бурульки знизу: [x, довжина]
					foreach ( array( array( 34, 16 ), array( 52, 30 ), array( 70, 22 ), array( 88, 44 ), array( 106, 34 ), array( 122, 56 ), array( 138, 38 ), array( 156, 48 ), array( 172, 26 ), array( 190, 32 ), array( 206, 18 ) ) as $drip ) {
						printf( '<path class="drip" d="M%1$d 176 L%2$d %3$d L%4$d 176Z"/>', $drip[0] - 6, $drip[0], 176 + $drip[1], $drip[0] + 6 );
					}
					for ( $i = 0; $i < 8; $i++ ) {
						$w = 216 - $i * 24;      // ширина поверху
						$y = 176 - $i * 20;      // нижній край поверху
						$x = 120 - $w / 2;
						printf( '<path d="M%1$s %2$d L%3$s %4$d L%5$s %4$d L%6$s %2$d Z"/>', $x, $y, $x + 7, $y - 17, $x + $w - 7, $x + $w );
						printf( '<ellipse class="rim" cx="120" cy="%1$d" rx="%2$s" ry="%3$s"/>', $y, $w / 2, 4 + ( 7 - $i ) * 0.5 );
					}
					?>
					<path d="M113 19 L120 -12 L127 19Z"/>
				</g>
				<g class="sky__castle-lights">
					<circle cx="120" cy="28" r="1.5"/><circle cx="104" cy="50" r="1.5"/><circle cx="140" cy="68" r="1.5"/>
					<circle cx="90" cy="90" r="1.5"/><circle cx="128" cy="108" r="1.5"/><circle cx="72" cy="128" r="1.5"/>
					<circle cx="168" cy="130" r="1.5"/><circle cx="110" cy="150" r="1.5"/><circle cx="46" cy="168" r="1.5"/>
					<circle cx="188" cy="166" r="1.5"/><circle cx="150" cy="170" r="1.5"/>
				</g>
			</svg>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Меню за замовчуванням, якщо в «Вигляд → Меню» нічого не призначено.
 */
function sao_menu_fallback() {
	$home  = home_url( '/' );
	$items = array(
		$home                                   => __( 'Головна', 'sao-aincrad' ),
		$home . '#aincrad'                      => __( 'Айнкрад', 'sao-aincrad' ),
		get_post_type_archive_link( 'sao_character' ) => __( 'Персонажі', 'sao-aincrad' ),
		get_post_type_archive_link( 'sao_guild' )     => __( 'Гільдії', 'sao-aincrad' ),
	);
	$posts_page = (int) get_option( 'page_for_posts' );
	if ( $posts_page ) {
		$items[ get_permalink( $posts_page ) ] = __( 'Новини', 'sao-aincrad' );
	}
	echo '<ul class="menu">';
	foreach ( $items as $url => $label ) {
		printf( '<li class="menu-item"><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

/**
 * Шапка внутрішньої сторінки (небо + заголовок).
 */
function sao_page_hero( $title, $subtitle = '', $kicker = '' ) {
	?>
	<section class="page-hero">
		<?php sao_sky( false ); ?>
		<div class="page-hero__inner container">
			<?php if ( $kicker ) : ?>
				<p class="kicker"><?php echo esc_html( $kicker ); ?></p>
			<?php endif; ?>
			<h1 class="page-hero__title"><?php echo wp_kses_post( $title ); ?></h1>
			<?php if ( $subtitle ) : ?>
				<p class="page-hero__subtitle"><?php echo wp_kses_post( $subtitle ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<?php
}
