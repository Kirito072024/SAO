<?php
/**
 * Template Name: Контакти
 *
 * Шаблон сторінки з формою зворотного зв'язку.
 * Обирається в редакторі сторінки: «Сторінка → Шаблон → Контакти».
 *
 * @package SAO_Aincrad
 */

get_header();

while ( have_posts() ) :
	the_post();
	sao_page_hero( get_the_title(), has_excerpt() ? esc_html( get_the_excerpt() ) : '', 'Message' );
	?>
	<div class="section">
		<div class="container contact-layout">
			<div class="panel contact-info" data-reveal>
				<div class="entry-content"><?php the_content(); ?></div>
				<ul class="contact-list">
					<?php if ( sao_opt( 'sao_email' ) ) : ?>
						<li><?php echo sao_icon( 'mail' ); // phpcs:ignore ?> <a href="mailto:<?php echo esc_attr( sao_opt( 'sao_email' ) ); ?>"><?php echo esc_html( sao_opt( 'sao_email' ) ); ?></a></li>
					<?php endif; ?>
					<?php if ( sao_opt( 'sao_github' ) ) : ?>
						<li><?php echo sao_icon( 'github' ); // phpcs:ignore ?> <a href="<?php echo esc_url( sao_opt( 'sao_github' ) ); ?>" target="_blank" rel="noopener">GitHub</a></li>
					<?php endif; ?>
				</ul>
			</div>
			<?php get_template_part( 'template-parts/contact', 'form' ); ?>
		</div>
	</div>
	<?php
endwhile;

get_footer();
