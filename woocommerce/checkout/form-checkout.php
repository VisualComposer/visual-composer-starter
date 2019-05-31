<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to visual-composer-starter/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'visual-composer-starter' ) ) );

	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="vct-main-form-content" id="customer_details">
			<?php do_action( 'woocommerce_checkout_billing' ); ?>
			<?php do_action( 'woocommerce_checkout_shipping' ); ?>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	<div class="vct-side-summary">
		<div class="vct-summary-box">
			<h3 id="order_review_heading"><?php esc_html_e( 'Order summary', 'visual-composer-starter' ); ?></h3>
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
			<?php if ( wc_coupons_enabled() ) { ?>
				<div class="vct-promo">
					<button id="vct-show-promo-form" class="vct-show-promo-form">
						<?php esc_html_e( 'Got promo code?', 'visual-composer-starter' ); ?>
					</button>
					<div class="vct-promo-content" style="display:none;">
						<input type="text" class="input-text " name="vct-promo-code" id="vct-promo-code">
						<button id="vct-apply-promo-code" class="vct-checkout-button"><?php esc_html_e( 'Apply', 'visual-composer-starter' ); ?></button>
					</div>
				</div>
			<?php } ?>
			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>
			<div class="vct-block-overlay"></div>
		</div>
		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
