<?php
/**
 * Підвал сайту.
 *
 * @package SAO_Aincrad
 */
?>
</main>

<footer class="site-footer">
	<div class="container site-footer__inner">
		<div class="site-footer__brand">
			<p class="site-footer__title"><?php bloginfo( 'name' ); ?></p>
			<p class="site-footer__text"><?php echo esc_html( sao_opt( 'sao_footer_text' ) ); ?></p>
		</div>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'Меню в підвалі', 'sao-aincrad' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'depth'          => 1,
					)
				);
				?>
			</nav>
		<?php endif; ?>

		<div class="site-footer__links">
			<?php if ( sao_opt( 'sao_github' ) ) : ?>
				<a href="<?php echo esc_url( sao_opt( 'sao_github' ) ); ?>" target="_blank" rel="noopener"><?php echo sao_icon( 'github' ); // phpcs:ignore ?> GitHub</a>
			<?php endif; ?>
			<?php if ( sao_opt( 'sao_email' ) ) : ?>
				<a href="mailto:<?php echo esc_attr( sao_opt( 'sao_email' ) ); ?>"><?php echo sao_icon( 'mail' ); // phpcs:ignore ?> <?php echo esc_html( sao_opt( 'sao_email' ) ); ?></a>
			<?php endif; ?>
		</div>
	</div>
	<p class="site-footer__copy container">
		&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> ·
		<?php esc_html_e( 'Тема', 'sao-aincrad' ); ?> «SAO Aincrad» · <?php esc_html_e( 'працює на', 'sao-aincrad' ); ?> WordPress
	</p>
</footer>

<a class="to-top" href="#top" aria-label="<?php esc_attr_e( 'Нагору', 'sao-aincrad' ); ?>">
	<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 15l6-6 6 6" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
