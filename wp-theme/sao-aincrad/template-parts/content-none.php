<?php
/**
 * Повідомлення «нічого не знайдено».
 *
 * @package SAO_Aincrad
 */
?>
<div class="panel empty">
	<h2 class="section-title"><?php esc_html_e( 'Тут поки порожньо', 'sao-aincrad' ); ?></h2>
	<p><?php esc_html_e( 'Записів не знайдено. Спробуй пошук:', 'sao-aincrad' ); ?></p>
	<?php get_search_form(); ?>
</div>
