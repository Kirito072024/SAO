<?php
/**
 * Окремий запис: новина, персонаж або гільдія.
 *
 * @package SAO_Aincrad
 */

get_header();

while ( have_posts() ) :
	the_post();

	$sao_type = get_post_type();
	$kicker   = '';
	$subtitle = '';

	if ( 'post' === $sao_type ) {
		$kicker   = sao_world_date();
		$subtitle = sao_first_tag();
	} elseif ( 'sao_character' === $sao_type ) {
		$kicker   = __( 'Персонаж', 'sao-aincrad' );
		$subtitle = get_post_meta( get_the_ID(), 'sao_role', true );
	} elseif ( 'sao_guild' === $sao_type ) {
		$kicker   = __( 'Гільдія', 'sao-aincrad' );
		$subtitle = get_post_meta( get_the_ID(), 'sao_type', true );
	}

	sao_page_hero( get_the_title(), esc_html( $subtitle ), $kicker );
	?>

	<div class="section">
		<div class="container container--narrow">
			<article <?php post_class( 'panel entry' ); ?> data-reveal>
				<?php if ( 'sao_character' === $sao_type ) : ?>
					<div class="entry__portrait"><?php sao_character_image(); ?></div>
				<?php elseif ( has_post_thumbnail() ) : ?>
					<div class="entry__thumb"><?php the_post_thumbnail( 'large' ); ?></div>
				<?php endif; ?>

				<?php if ( 'sao_guild' === $sao_type && get_post_meta( get_the_ID(), 'sao_leader', true ) ) : ?>
					<p class="pill pill--big"><?php esc_html_e( 'Лідер:', 'sao-aincrad' ); ?> <?php echo esc_html( get_post_meta( get_the_ID(), 'sao_leader', true ) ); ?></p>
				<?php endif; ?>

				<div class="entry-content">
					<?php
					the_content();
					wp_link_pages();
					?>
				</div>

				<?php if ( 'post' === $sao_type && has_tag() ) : ?>
					<footer class="entry__footer">
						<?php the_tags( '<span class="entry__tags">', '', '</span>' ); ?>
					</footer>
				<?php endif; ?>
			</article>

			<?php
			$back = array(
				'post'          => get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' ),
				'sao_character' => get_post_type_archive_link( 'sao_character' ),
				'sao_guild'     => get_post_type_archive_link( 'sao_guild' ),
			);
			?>
			<nav class="post-nav" aria-label="<?php esc_attr_e( 'Навігація між записами', 'sao-aincrad' ); ?>">
				<span class="post-nav__prev"><?php previous_post_link( '%link', '← %title' ); ?></span>
				<a class="btn btn--ghost btn--small" href="<?php echo esc_url( $back[ $sao_type ] ?? home_url( '/' ) ); ?>"><?php esc_html_e( 'До списку', 'sao-aincrad' ); ?></a>
				<span class="post-nav__next"><?php next_post_link( '%link', '%title →' ); ?></span>
			</nav>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</div>

	<?php
endwhile;

get_footer();
