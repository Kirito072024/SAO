<?php
/**
 * Бічна панель (віджети). Показується, лише якщо в «Вигляд → Віджети» щось додано.
 *
 * @package SAO_Aincrad
 */

if ( ! is_active_sidebar( 'sidebar-news' ) ) {
	return;
}
?>
<aside class="layout__sidebar" aria-label="<?php esc_attr_e( 'Бічна панель', 'sao-aincrad' ); ?>">
	<?php dynamic_sidebar( 'sidebar-news' ); ?>
</aside>
