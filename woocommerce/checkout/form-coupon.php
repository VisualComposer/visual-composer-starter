<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to visual-composer-starter/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() || ! empty( WC()->cart->applied_coupons ) ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">

	<p class="form-row form-row-first">
		<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'visual-composer-starter' ); ?>" id="coupon_code" value="" />
	</p>

	<p class="form-row form-row-last">
		<button id="vct-submit-coupon" type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'visual-composer-starter' ); ?>"><?php esc_html_e( 'Apply coupon', 'visual-composer-starter' ); ?></button>
	</p>

	<div class="clear"></div>
</form>
