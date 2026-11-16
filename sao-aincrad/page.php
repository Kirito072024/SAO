<?php
/**
 * Звичайна сторінка (наприклад «Про проєкт»).
 *
 * @package SAO_Aincrad
 */

get_header();

while ( have_posts() ) :
	the_post();
	sao_page_hero( get_the_title(), has_excerpt() ? esc_html( get_the_excerpt() ) : '' );
	?>
	<div class="section">
		<div class="container container--narrow">
			<article <?php post_class( 'panel entry' ); ?> data-reveal>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry__thumb"><?php the_post_thumbnail( 'large' ); ?></div>
				<?php endif; ?>
				<div class="entry-content">
					<?php
					the_content();
					wp_link_pages();
					?>
				</div>
			</article>
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
