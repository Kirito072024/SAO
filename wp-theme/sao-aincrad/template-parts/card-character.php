<?php
/**
 * Картка персонажа (використовується на головній і в архіві /characters/).
 *
 * @package SAO_Aincrad
 */

$sao_role = get_post_meta( get_the_ID(), 'sao_role', true );
?>
<article class="card card--character" data-reveal>
	<a class="card__link" href="<?php the_permalink(); ?>">
		<div class="card__media">
			<?php sao_character_image(); ?>
			<span class="card__corners" aria-hidden="true"></span>
		</div>
		<div class="card__body">
			<h3 class="card__title"><?php the_title(); ?></h3>
			<?php if ( $sao_role ) : ?>
				<p class="card__role"><?php echo esc_html( $sao_role ); ?></p>
			<?php endif; ?>
			<!-- декоративна смужка HP, як над головою гравця в SAO -->
			<span class="card__hp" aria-hidden="true"><span></span></span>
			<p class="card__text"><?php echo esc_html( get_the_excerpt() ); ?></p>
		</div>
	</a>
</article>
