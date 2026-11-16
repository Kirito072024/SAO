<?php
/**
 * Коментарі під записом.
 *
 * @package SAO_Aincrad
 */

if ( post_password_required() ) {
	return;
}
?>
<section class="panel comments" id="comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="section-title">
			<?php
			/* translators: %d: кількість коментарів */
			printf( esc_html__( 'Коментарі (%d)', 'sao-aincrad' ), (int) get_comments_number() );
			?>
		</h2>
		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 40,
				)
			);
			?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'  => __( 'Залишити коментар', 'sao-aincrad' ),
			'class_submit' => 'btn btn--primary',
		)
	);
	?>
</section>
