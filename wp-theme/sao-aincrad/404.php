<?php
/**
 * Сторінка 404 — «ти загубився в лабіринті».
 *
 * @package SAO_Aincrad
 */

get_header();
sao_page_hero( '404', __( 'Цього поверху не існує. Схоже, ти заблукав у лабіринті.', 'sao-aincrad' ), 'System Error' );
?>
<div class="section">
	<div class="container container--narrow">
		<div class="panel empty" data-reveal>
			<p><?php esc_html_e( 'Спробуй пошук або повернись до Міста Початку.', 'sao-aincrad' ); ?></p>
			<?php get_search_form(); ?>
			<p><a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'На головну', 'sao-aincrad' ); ?></a></p>
		</div>
	</div>
</div>
<?php
get_footer();
