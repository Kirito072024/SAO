<?php
/**
 * Форма зворотного зв'язку.
 * Без JS відправляється на admin-post.php, з JS — через REST API (assets/js/contact.js).
 *
 * @package SAO_Aincrad
 */

$sao_sent = isset( $_GET['sent'] ) ? sanitize_key( $_GET['sent'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
?>
<form class="panel contact-form" id="contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate data-reveal>
	<input type="hidden" name="action" value="sao_contact">
	<?php wp_nonce_field( 'sao_contact', 'sao_contact_nonce' ); ?>

	<!-- пастка для ботів: людина цього поля не бачить -->
	<p class="hp-field" aria-hidden="true">
		<label for="website">Website</label>
		<input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
	</p>

	<div class="field">
		<label for="name"><?php esc_html_e( "Ім'я", 'sao-aincrad' ); ?></label>
		<input type="text" id="name" name="name" placeholder="<?php esc_attr_e( 'Як до тебе звертатися', 'sao-aincrad' ); ?>" autocomplete="name" required>
	</div>

	<div class="field-row">
		<div class="field">
			<label for="email"><?php esc_html_e( 'Електронна пошта', 'sao-aincrad' ); ?></label>
			<input type="email" id="email" name="email" placeholder="name@example.com" autocomplete="email" required aria-describedby="email-hint">
			<small id="email-hint" class="field-hint"></small>
		</div>
		<div class="field">
			<label for="phone"><?php esc_html_e( 'Телефон', 'sao-aincrad' ); ?></label>
			<input type="tel" id="phone" name="phone" placeholder="+380501234567" autocomplete="tel" required aria-describedby="phone-hint">
			<small id="phone-hint" class="field-hint"></small>
		</div>
	</div>

	<div class="field">
		<label for="topic"><?php esc_html_e( 'Тема звернення', 'sao-aincrad' ); ?></label>
		<select id="topic" name="topic">
			<?php foreach ( sao_contact_topics() as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<div class="field">
		<label for="message"><?php esc_html_e( 'Повідомлення', 'sao-aincrad' ); ?></label>
		<textarea id="message" name="message" rows="5" placeholder="<?php esc_attr_e( 'Напиши, що хочеш запитати', 'sao-aincrad' ); ?>" required></textarea>
	</div>

	<label class="checkbox">
		<input type="checkbox" id="agree" name="agree" value="1" required>
		<span><?php esc_html_e( 'Погоджуюсь на обробку даних', 'sao-aincrad' ); ?></span>
	</label>

	<button type="submit" class="btn btn--primary"><?php esc_html_e( 'Надіслати', 'sao-aincrad' ); ?></button>

	<div id="form-message" class="form-message<?php echo $sao_sent ? ( 'ok' === $sao_sent ? ' success' : ' error' ) : ''; ?>" role="status">
		<?php
		if ( 'ok' === $sao_sent ) {
			esc_html_e( 'Дякуємо! Повідомлення надіслано.', 'sao-aincrad' );
		} elseif ( 'error' === $sao_sent ) {
			esc_html_e( 'Не вдалося надіслати. Перевірте поля й спробуйте ще раз.', 'sao-aincrad' );
		}
		?>
	</div>
</form>
