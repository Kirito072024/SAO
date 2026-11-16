<?php
/**
 * Форма пошуку.
 *
 * @package SAO_Aincrad
 */
?>
<?php $sao_search_id = wp_unique_id( 'search-' ); ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $sao_search_id ); ?>"><?php esc_html_e( 'Пошук', 'sao-aincrad' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $sao_search_id ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Шукати в Айнкраді…', 'sao-aincrad' ); ?>">
	<button type="submit" class="btn btn--primary btn--small"><?php esc_html_e( 'Знайти', 'sao-aincrad' ); ?></button>
</form>
