<?php
/**
 * Головний запасний шаблон. Також показує сторінку «Новини» (список записів блогу).
 * WordPress обирає шаблони за ієрархією: front-page.php → home.php → index.php.
 *
 * @package SAO_Aincrad
 */

get_header();

if ( is_home() && get_option( 'page_for_posts' ) ) {
	sao_page_hero( get_the_title( get_option( 'page_for_posts' ) ), __( 'Хроніка головних подій світу SAO — від першого дня до фінальної дуелі.', 'sao-aincrad' ), 'Log' );
} else {
	sao_page_hero( get_bloginfo( 'name' ), get_bloginfo( 'description' ) );
}
?>

<div class="section">
	<div class="container layout<?php echo is_active_sidebar( 'sidebar-news' ) ? ' layout--sidebar' : ''; ?>">
		<div class="layout__main">
			<?php if ( have_posts() ) : ?>
				<div class="timeline">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/news', 'item' );
					endwhile;
					?>
				</div>
				<?php
				the_posts_pagination(
					array(
						'prev_text' => '←',
						'next_text' => '→',
					)
				);
				?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
