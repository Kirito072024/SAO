<?php
/**
 * Результати пошуку.
 *
 * @package SAO_Aincrad
 */

get_header();
/* translators: %s: пошуковий запит */
sao_page_hero( sprintf( esc_html__( 'Пошук: «%s»', 'sao-aincrad' ), esc_html( get_search_query() ) ), '', 'Search' );
?>
<div class="section">
	<div class="container container--narrow">
		<?php if ( have_posts() ) : ?>
			<div class="search-results">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article class="panel search-item" data-reveal>
						<p class="kicker"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></p>
						<h2 class="search-item__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html( get_the_excerpt() ); ?></p>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
