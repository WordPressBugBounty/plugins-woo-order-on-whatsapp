<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="wrap">
	<h1>
		<?php esc_html_e( 'Dashboard', 'woo-order-on-whatsapp' ); ?>
	</h1>

	<section class="myd-custom-content-page">
		<div class="myd-admin-cards myd-card-1columns">
			<div class="mydd-admin-card mydd-newsletter">
				<div class="mydd-newsletter__intro">
					<h2 class="mydd-admin-card__title mydd-newsletter__title"><?php esc_html_e( 'Stay in the loop', 'woo-order-on-whatsapp' ); ?></h2>
					<p class="mydd-newsletter__description">
						<?php esc_html_e( 'Get product updates, new features and tips for your store. No spam.', 'woo-order-on-whatsapp' ); ?>
					</p>
				</div>

				<div class="newsletter-form-container mydd-newsletter__container">
					<form class="newsletter-form mydd-newsletter__form" action="https://app.loops.so/api/newsletter-form/cmmcdtvw903t70iwyrjjpq346" method="POST">
						<input class="newsletter-form-input mydd-newsletter__input" placeholder="<?php esc_attr_e( 'Your email', 'woo-order-on-whatsapp' ); ?>" required type="email" name="newsletter-form-input">
						<button type="submit" class="newsletter-form-button mydd-admin-button mydd-newsletter__submit"><?php esc_html_e( 'Subscribe', 'woo-order-on-whatsapp' ); ?></button>
						<button type="button" class="newsletter-loading-button mydd-admin-button mydd-newsletter__loading"><?php esc_html_e( 'Please wait…', 'woo-order-on-whatsapp' ); ?></button>
					</form>
					<div class="newsletter-success mydd-newsletter__success">
						<p class="newsletter-success-message"><?php esc_html_e( "Thanks! We'll be in touch.", 'woo-order-on-whatsapp' ); ?></p>
					</div>
					<div class="newsletter-error mydd-newsletter__error">
						<p class="newsletter-error-message"><?php esc_html_e( 'Oops! Something went wrong, please try again.', 'woo-order-on-whatsapp' ); ?></p>
					</div>
					<button type="button" class="newsletter-back-button mydd-newsletter__back">&larr; <?php esc_html_e( 'Back', 'woo-order-on-whatsapp' ); ?></button>
				</div>
			</div>
		</div>

		<div class="myd-admin-cards myd-card-2columns">
			<div class="mydd-admin-card">
				<h2 class="mydd-admin-card__title"><?php esc_html_e( 'Quick Access', 'woo-order-on-whatsapp' ); ?></h2>

				<div class="mydd-quick-access">
					<a class="mydd-quick-access__item" href="<?php echo esc_attr( site_url( '/wp-admin/admin.php?page=order-on-mobile-for-woocommerce-config' ) ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" color="#6a7282" fill="none">
							<path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="#6a7282" stroke-width="1.5" stroke-linejoin="round"></path>
							<path d="M8.5 10C7.67157 10 7 9.32843 7 8.5C7 7.67157 7.67157 7 8.5 7C9.32843 7 10 7.67157 10 8.5C10 9.32843 9.32843 10 8.5 10Z" stroke="#6a7282" stroke-width="1.5"></path>
							<path d="M15.5 17C16.3284 17 17 16.3284 17 15.5C17 14.6716 16.3284 14 15.5 14C14.6716 14 14 14.6716 14 15.5C14 16.3284 14.6716 17 15.5 17Z" stroke="#6a7282" stroke-width="1.5"></path>
							<path d="M10 8.5L17 8.5" stroke="#6a7282" stroke-width="1.5" stroke-linecap="round"></path>
							<path d="M14 15.5L7 15.5" stroke="#6a7282" stroke-width="1.5" stroke-linecap="round"></path>
						</svg>
						<div class="mydd-quick-access__text">
							<span class="mydd-quick-access__title"><?php esc_html_e( 'Settings', 'woo-order-on-whatsapp' ); ?></span>
							<span class="mydd-quick-access__description"><?php esc_html_e( 'General & checkout options', 'woo-order-on-whatsapp' ); ?></span>
						</div>
						<span class="mydd-quick-access__chevron">›</span>
					</a>
				</div>
			</div>

			<?php if ( \current_user_can( 'manage_options' ) ) : ?>
				<div class="mydd-admin-card mydd-addon-card">
					<div class="mydd-addon-card__header">
						<picture>
							<source srcset="<?php echo esc_url( OMW_PLUGIN_URL . 'assets/img/notifications-animation-1.avif' ); ?>" type="image/avif">
							<img src="<?php echo esc_url( OMW_PLUGIN_URL . 'assets/img/notifications-animation-1.webp' ); ?>" alt="<?php esc_attr_e( 'MyD Notifications', 'woo-order-on-whatsapp' ); ?>" class="mydd-addon-card__image">
						</picture>

						<div class="mydd-addon-card__header-text">
							<h3 class="mydd-addon-card__title"><?php esc_html_e( 'MyD Notifications', 'woo-order-on-whatsapp' ); ?></h3>

							<p class="mydd-addon-card__description">
								<?php esc_html_e( 'WhatsApp order status alerts for your customers via official WhatsApp API.', 'woo-order-on-whatsapp' ); ?>
							</p>
						</div>
					</div>

					<ul class="mydd-addon-card__features">
						<li><?php esc_html_e( 'Automated status updates via WhatsApp', 'woo-order-on-whatsapp' ); ?></li>
						<li><?php esc_html_e( 'Official WhatsApp API integration', 'woo-order-on-whatsapp' ); ?></li>
						<li><?php esc_html_e( 'Fixed pricing, no hidden costs', 'woo-order-on-whatsapp' ); ?></li>
					</ul>

					<div class="mydd-addon-card__footer">
						<a href="https://services.myddelivery.com/signup?utm_source=woo-order-on-whatsapp&utm_medium=wp-admin&utm_campaign=myd-notifications&utm_content=dashboard-card" target="_blank" class="mydd-admin-button"><?php esc_html_e( 'See Plans', 'woo-order-on-whatsapp' ); ?></a>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( \current_user_can( 'manage_options' ) ) : ?>
				<div class="mydd-admin-card">
					<?php echo \WPFeatureLoop\Client::getInstance('cmljj016h000004l4i9gn0pkd')->renderWidget(); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>

<script>
(function () {
	function submitHandler(event) {
		event.preventDefault();
		var container = event.target.closest('.newsletter-form-container');
		var form = container.querySelector('.newsletter-form');
		var formInput = container.querySelector('.newsletter-form-input');
		var success = container.querySelector('.newsletter-success');
		var errorContainer = container.querySelector('.newsletter-error');
		var errorMessage = container.querySelector('.newsletter-error-message');
		var backButton = container.querySelector('.newsletter-back-button');
		var submitButton = container.querySelector('.newsletter-form-button');
		var loadingButton = container.querySelector('.newsletter-loading-button');

		function rateLimit() {
			errorContainer.classList.add('is-visible');
			errorMessage.innerText = '<?php echo esc_js( __( 'Too many signups, please try again in a little while.', 'woo-order-on-whatsapp' ) ); ?>';
			submitButton.classList.add('is-hidden');
			formInput.classList.add('is-hidden');
			backButton.classList.add('is-visible');
		}

		var timestamp = new Date().valueOf();
		var previousTimestamp = localStorage.getItem('loops-form-timestamp');
		if (previousTimestamp && Number(previousTimestamp) + 60000 > timestamp) {
			rateLimit();
			return;
		}
		localStorage.setItem('loops-form-timestamp', timestamp);

		submitButton.classList.add('is-hidden');
		loadingButton.classList.add('is-visible');

		var formBody = 'userGroup=dashboard-woo-order-on-whatsapp&mailingLists=&email=' + encodeURIComponent(formInput.value);

		fetch(event.target.action, {
			method: 'POST',
			body: formBody,
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		})
			.then(function (res) { return [res.ok, res.json(), res]; })
			.then(function (parts) {
				var ok = parts[0], dataPromise = parts[1], res = parts[2];
				if (ok) {
					success.classList.add('is-visible');
					form.reset();
				} else {
					dataPromise.then(function (data) {
						errorContainer.classList.add('is-visible');
						errorMessage.innerText = data.message ? data.message : res.statusText;
					});
				}
			})
			.catch(function (error) {
				if (error.message === 'Failed to fetch') {
					rateLimit();
					return;
				}
				errorContainer.classList.add('is-visible');
				if (error.message) errorMessage.innerText = error.message;
				localStorage.setItem('loops-form-timestamp', '');
			})
			.finally(function () {
				formInput.classList.add('is-hidden');
				loadingButton.classList.remove('is-visible');
				backButton.classList.add('is-visible');
			});
	}

	function resetFormHandler(event) {
		var container = event.target.closest('.newsletter-form-container');
		var formInput = container.querySelector('.newsletter-form-input');
		var success = container.querySelector('.newsletter-success');
		var errorContainer = container.querySelector('.newsletter-error');
		var errorMessage = container.querySelector('.newsletter-error-message');
		var backButton = container.querySelector('.newsletter-back-button');
		var submitButton = container.querySelector('.newsletter-form-button');

		success.classList.remove('is-visible');
		errorContainer.classList.remove('is-visible');
		errorMessage.innerText = '<?php echo esc_js( __( 'Oops! Something went wrong, please try again.', 'woo-order-on-whatsapp' ) ); ?>';
		backButton.classList.remove('is-visible');
		formInput.classList.remove('is-hidden');
		submitButton.classList.remove('is-hidden');
	}

	var formContainers = document.getElementsByClassName('newsletter-form-container');
	for (var i = 0; i < formContainers.length; i++) {
		var formContainer = formContainers[i];
		if (formContainer.classList.contains('newsletter-handlers-added')) continue;
		formContainer.querySelector('.newsletter-form').addEventListener('submit', submitHandler);
		formContainer.querySelector('.newsletter-back-button').addEventListener('click', resetFormHandler);
		formContainer.classList.add('newsletter-handlers-added');
	}
})();
</script>
