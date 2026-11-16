<?php
/**
 * Головна сторінка (Налаштування → Читання → «Статична сторінка»).
 *
 * Секції:
 * hero → вітання + цифри → Айнкрад → механіка → історія (текст самої сторінки з редактора)
 * → персонажі (CPT) → гільдії (CPT) → останні новини (записи) → заклик написати → цікавий факт
 *
 * @package SAO_Aincrad
 */

get_header();

$characters_url = get_post_type_archive_link( 'sao_character' );
$guilds_url     = get_post_type_archive_link( 'sao_guild' );
$news_url       = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
$contacts_page  = get_pages(
	array(
		'meta_key'   => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery
		'meta_value' => 'page-contacts.php', // phpcs:ignore WordPress.DB.SlowDBQuery
		'number'     => 1,
	)
);
$contacts_url   = $contacts_page ? get_permalink( $contacts_page[0] ) : '';
?>

<!-- ============ HERO ============ -->
<section class="hero">
	<?php sao_sky(); ?>
	<div class="hero__inner container">
		<p class="kicker kicker--glow"<?php sao_live( 'sao_hero_kicker' ); ?>><?php echo esc_html( sao_opt( 'sao_hero_kicker' ) ); ?></p>
		<h1 class="hero__title"<?php sao_live( 'sao_hero_title' ); ?>><?php echo esc_html( sao_opt( 'sao_hero_title' ) ); ?></h1>
		<p class="hero__subtitle"<?php sao_live( 'sao_hero_subtitle' ); ?>><?php echo esc_html( sao_opt( 'sao_hero_subtitle' ) ); ?></p>
		<div class="hero__actions">
			<a class="btn btn--primary" href="#aincrad"><span<?php sao_live( 'sao_hero_btn' ); ?>><?php echo esc_html( sao_opt( 'sao_hero_btn' ) ); ?></span> <?php echo sao_icon( 'arrow' ); // phpcs:ignore ?></a>
			<?php if ( sao_opt( 'sao_watch_url' ) ) : ?>
				<a class="btn btn--ghost" href="<?php echo esc_url( sao_opt( 'sao_watch_url' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo sao_icon( 'play' ); // phpcs:ignore ?> <span<?php sao_live( 'sao_watch_text' ); ?>><?php echo esc_html( sao_opt( 'sao_watch_text' ) ); ?></span></a>
			<?php endif; ?>
		</div>
	</div>
	<a class="hero__scroll" href="#welcome" aria-label="<?php esc_attr_e( 'Прокрутити вниз', 'sao-aincrad' ); ?>"><span></span></a>
</section>

<!-- ============ ВІТАННЯ + ЦИФРИ ============ -->
<section class="section" id="welcome">
	<div class="container">
		<div class="panel welcome" data-reveal>
			<h2 class="section-title"<?php sao_live( 'sao_welcome_title' ); ?>><?php echo esc_html( sao_opt( 'sao_welcome_title' ) ); ?></h2>
			<p class="lead"<?php sao_live( 'sao_intro' ); ?>><?php echo esc_html( sao_opt( 'sao_intro' ) ); ?></p>
		</div>

		<ul class="stats" data-reveal>
			<?php for ( $n = 1; $n <= 4; $n++ ) : ?>
				<li class="stat">
					<span class="stat__num" data-count="<?php echo (int) sao_opt( "sao_stat{$n}_num" ); ?>"<?php sao_live( "sao_stat{$n}_num" ); ?>><?php echo esc_html( sao_number( sao_opt( "sao_stat{$n}_num" ) ) ); ?></span>
					<span class="stat__label"<?php sao_live( "sao_stat{$n}_label" ); ?>><?php echo esc_html( sao_opt( "sao_stat{$n}_label" ) ); ?></span>
				</li>
			<?php endfor; ?>
		</ul>
	</div>
</section>

<!-- ============ АЙНКРАД ============ -->
<section class="section" id="aincrad">
	<div class="container">
		<div class="panel split" data-reveal>
			<figure class="split__media">
				<img class="float-img" src="<?php echo esc_url( SAO_URI . '/assets/images/aincrad-960.webp' ); ?>"
					srcset="<?php echo esc_url( SAO_URI . '/assets/images/aincrad-480.webp' ); ?> 480w, <?php echo esc_url( SAO_URI . '/assets/images/aincrad-960.webp' ); ?> 960w"
					sizes="(min-width: 860px) 480px, 100vw" width="960" height="540"
					alt="<?php esc_attr_e( 'Айнкрад — летючий залізний замок у небі', 'sao-aincrad' ); ?>" loading="lazy" decoding="async">
			</figure>
			<div class="split__text">
				<h2 class="section-title"<?php sao_live( 'sao_aincrad_title' ); ?>><?php echo esc_html( sao_opt( 'sao_aincrad_title' ) ); ?></h2>
				<p<?php sao_live( 'sao_aincrad_text' ); ?>><?php echo esc_html( sao_opt( 'sao_aincrad_text' ) ); ?></p>
				<ul class="floors">
					<?php for ( $n = 1; $n <= 4; $n++ ) : ?>
						<?php if ( sao_opt( "sao_floor{$n}_text" ) ) : ?>
							<li><b<?php sao_live( "sao_floor{$n}_num" ); ?>><?php echo esc_html( sao_opt( "sao_floor{$n}_num" ) ); ?></b> <span<?php sao_live( "sao_floor{$n}_text" ); ?>><?php echo esc_html( sao_opt( "sao_floor{$n}_text" ) ); ?></span></li>
						<?php endif; ?>
					<?php endfor; ?>
				</ul>
			</div>
		</div>
	</div>
</section>

<!-- ============ МЕХАНІКА ============ -->
<section class="section" id="mechanics">
	<div class="container">
		<h2 class="section-title" data-reveal<?php sao_live( 'sao_mech_title' ); ?>><?php echo esc_html( sao_opt( 'sao_mech_title' ) ); ?></h2>
		<ul class="tiles">
			<?php
			$sao_icons = array( 'helmet', 'sword', 'shield', 'heart', 'shield', 'skull' ); // іконки плиток по порядку
			foreach ( $sao_icons as $i => $sao_icon ) :
				$n = $i + 1;
				?>
				<li class="tile<?php echo 'skull' === $sao_icon ? ' tile--danger' : ''; ?>" data-reveal style="--delay: <?php echo (int) $i * 60; ?>ms">
					<span class="tile__icon"><?php echo sao_icon( $sao_icon ); // phpcs:ignore ?></span>
					<h3 class="tile__title"<?php sao_live( "sao_tile{$n}_title" ); ?>><?php echo esc_html( sao_opt( "sao_tile{$n}_title" ) ); ?></h3>
					<p<?php sao_live( "sao_tile{$n}_text" ); ?>><?php echo esc_html( sao_opt( "sao_tile{$n}_text" ) ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<!-- ============ ІСТОРІЯ (текст сторінки «Головна» з редактора) ============ -->
<?php while ( have_posts() ) : the_post(); ?>
	<?php if ( get_the_content() ) : ?>
		<section class="section" id="story">
			<div class="container">
				<article class="panel story" data-reveal>
					<h2 class="section-title"<?php sao_live( 'sao_story_title' ); ?>><?php echo esc_html( sao_opt( 'sao_story_title' ) ); ?></h2>
					<div class="entry-content"><?php the_content(); ?></div>
				</article>
			</div>
		</section>
	<?php endif; ?>
<?php endwhile; ?>

<!-- ============ ПЕРСОНАЖІ ============ -->
<?php
$characters = new WP_Query(
	array(
		'post_type'      => 'sao_character',
		'posts_per_page' => 4,
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
	)
);
if ( $characters->have_posts() ) :
	?>
	<section class="section" id="characters">
		<div class="container">
			<div class="section-head" data-reveal>
				<h2 class="section-title"<?php sao_live( 'sao_characters_title' ); ?>><?php echo esc_html( sao_opt( 'sao_characters_title' ) ); ?></h2>
				<a class="link-more" href="<?php echo esc_url( $characters_url ); ?>"><?php esc_html_e( 'Усі персонажі', 'sao-aincrad' ); ?> <?php echo sao_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
			<div class="grid grid--4">
				<?php
				while ( $characters->have_posts() ) :
					$characters->the_post();
					get_template_part( 'template-parts/card', 'character' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- ============ ГІЛЬДІЇ ============ -->
<?php
$guilds = new WP_Query(
	array(
		'post_type'      => 'sao_guild',
		'posts_per_page' => 4,
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
	)
);
if ( $guilds->have_posts() ) :
	?>
	<section class="section" id="clans">
		<div class="container">
			<div class="section-head" data-reveal>
				<h2 class="section-title"<?php sao_live( 'sao_guilds_title' ); ?>><?php echo esc_html( sao_opt( 'sao_guilds_title' ) ); ?></h2>
				<a class="link-more" href="<?php echo esc_url( $guilds_url ); ?>"><?php esc_html_e( 'Усі гільдії', 'sao-aincrad' ); ?> <?php echo sao_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
			<div class="grid grid--2">
				<?php
				while ( $guilds->have_posts() ) :
					$guilds->the_post();
					get_template_part( 'template-parts/card', 'guild' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- ============ НОВИНИ ============ -->
<?php
$latest = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
	)
);
if ( $latest->have_posts() ) :
	?>
	<section class="section" id="news">
		<div class="container">
			<div class="section-head" data-reveal>
				<h2 class="section-title"<?php sao_live( 'sao_news_title' ); ?>><?php echo esc_html( sao_opt( 'sao_news_title' ) ); ?></h2>
				<a class="link-more" href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Уся хроніка', 'sao-aincrad' ); ?> <?php echo sao_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
			<div class="timeline">
				<?php
				while ( $latest->have_posts() ) :
					$latest->the_post();
					get_template_part( 'template-parts/news', 'item' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- ============ ЗАКЛИК + ФАКТ ============ -->
<section class="section">
	<div class="container">
		<div class="cta" data-reveal>
			<div>
				<h2 class="cta__title"<?php sao_live( 'sao_cta_title' ); ?>><?php echo esc_html( sao_opt( 'sao_cta_title' ) ); ?></h2>
				<p<?php sao_live( 'sao_cta_text' ); ?>><?php echo esc_html( sao_opt( 'sao_cta_text' ) ); ?></p>
			</div>
			<?php if ( $contacts_url ) : ?>
				<a class="btn btn--primary" href="<?php echo esc_url( $contacts_url ); ?>"><span<?php sao_live( 'sao_cta_btn' ); ?>><?php echo esc_html( sao_opt( 'sao_cta_btn' ) ); ?></span> <?php echo sao_icon( 'arrow' ); // phpcs:ignore ?></a>
			<?php endif; ?>
		</div>

		<?php if ( sao_opt( 'sao_fact' ) ) : ?>
			<aside class="fact" data-reveal>
				<p class="fact__label"><?php esc_html_e( 'Цікавий факт', 'sao-aincrad' ); ?></p>
				<p><?php echo esc_html( sao_opt( 'sao_fact' ) ); ?></p>
			</aside>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
