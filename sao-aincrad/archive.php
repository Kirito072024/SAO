<?php
/**
 * Архіви: /characters/ (персонажі), /guilds/ (гільдії), мітки й рубрики новин.
 *
 * @package SAO_Aincrad
 */

get_header();

if ( is_post_type_archive( 'sao_character' ) ) {
	$sao_layout = 'character';
	sao_page_hero( __( 'Персонажі', 'sao-aincrad' ), __( 'Герої Айнкрада, які пройшли «смертельну гру».', 'sao-aincrad' ), 'Party' );
} elseif ( is_post_type_archive( 'sao_guild' ) ) {
	$sao_layout = 'guild';
	sao_page_hero( __( 'Клани та гільдії', 'sao-aincrad' ), __( 'Угруповання Айнкрада — від штурмових гільдій до червоних кланів.', 'sao-aincrad' ), 'Guilds' );
} else {
	$sao_layout = 'news';
	sao_page_hero( wp_strip_all_tags( get_the_archive_title() ), wp_strip_all_tags( get_the_archive_description() ), 'Log' );
}
?>

<div class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<?php if ( 'news' === $sao_layout ) : ?>
				<div class="timeline">
			<?php else : ?>
				<div class="grid <?php echo 'character' === $sao_layout ? 'grid--4' : 'grid--2'; ?>">
			<?php endif; ?>

			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'news' === $sao_layout ? 'template-parts/news-item' : 'template-parts/card-' . $sao_layout );
			endwhile;
			?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
