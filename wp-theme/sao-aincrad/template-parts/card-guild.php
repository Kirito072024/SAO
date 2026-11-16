<?php
/**
 * Картка гільдії. Червоні гільдії (тип містить «Червона») підсвічуються іншим кольором.
 *
 * @package SAO_Aincrad
 */

$sao_leader = get_post_meta( get_the_ID(), 'sao_leader', true );
$sao_type   = get_post_meta( get_the_ID(), 'sao_type', true );
$sao_red    = $sao_type && false !== mb_stripos( $sao_type, 'червон' );
?>
<article class="card card--guild<?php echo $sao_red ? ' card--red' : ''; ?>" data-reveal>
	<a class="card__link" href="<?php the_permalink(); ?>">
		<div class="card__body">
			<div class="card__guild-head">
				<span class="card__badge"><?php echo sao_icon( $sao_red ? 'skull' : 'shield' ); // phpcs:ignore ?></span>
				<div>
					<h3 class="card__title"><?php the_title(); ?></h3>
					<?php if ( $sao_type ) : ?>
						<p class="card__role"><?php echo esc_html( $sao_type ); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<p class="card__text"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php if ( $sao_leader ) : ?>
				<p class="card__meta"><?php esc_html_e( 'Лідер:', 'sao-aincrad' ); ?> <b><?php echo esc_html( $sao_leader ); ?></b></p>
			<?php endif; ?>
		</div>
	</a>
</article>
