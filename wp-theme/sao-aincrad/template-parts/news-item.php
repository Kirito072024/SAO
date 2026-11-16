<?php
/**
 * Новина у вигляді пункту «лінії часу».
 *
 * @package SAO_Aincrad
 */

$sao_tag = sao_first_tag();
?>
<article <?php post_class( 'news-item' ); ?> data-reveal>
	<div class="news-item__meta">
		<time class="news-item__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( sao_world_date() ); ?></time>
		<?php if ( $sao_tag ) : ?>
			<span class="pill"><?php echo esc_html( $sao_tag ); ?></span>
		<?php endif; ?>
	</div>
	<h3 class="news-item__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p><?php echo esc_html( get_the_excerpt() ); ?></p>
</article>
