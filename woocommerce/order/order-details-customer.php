<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to visual-composer-starter/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="woocommerce-customer-details">
	<h2 class="woocommerce-column__title"><?php esc_html_e( 'Billing address', 'visual-composer-starter' ); ?></h2>


	<ul class="vct-billing-details-container">

		<?php if ( $order->get_billing_first_name() || $order->get_billing_last_name() ) : ?>
			<li class="vct-billing-detail">
				<span><?php esc_html_e( 'Name, Surname', 'visual-composer-starter' ); ?></span>
				<span><?php echo esc_html( $order->get_billing_first_name() ); ?><?php echo esc_html( $order->get_billing_last_name() ); ?></span>
			</li>
		<?php endif; ?>
		<?php if ( $order->get_billing_phone() ) : ?>
			<li class="vct-billing-detail">
				<span><?php esc_html_e( 'Phone', 'visual-composer-starter' ); ?></span>
				<span><?php echo esc_html( $order->get_billing_phone() ); ?></span>
			</li>
		<?php endif; ?>
		<?php if ( $order->get_billing_email() ) : ?>
			<li class="vct-billing-detail">
				<span><?php esc_html_e( 'E-mail', 'visual-composer-starter' ); ?></span>
				<span><?php echo esc_html( $order->get_billing_email() ); ?></span>
			</li>
		<?php endif; ?>
		<?php if ( $order->get_billing_company() ) : ?>
			<li class="vct-billing-detail">
				<span><?php esc_html_e( 'Company', 'visual-composer-starter' ); ?></span>
				<span><?php echo esc_html( $order->get_billing_company() ); ?></span>
			</li>
		<?php endif; ?>
		<?php if ( $order->get_billing_country() ) : ?>
			<li class="vct-billing-detail">
				<span><?php esc_html_e( 'Country', 'visual-composer-starter' ); ?></span>
				<span><?php echo esc_html( $order->get_billing_country() ); ?></span>
			</li>
		<?php endif; ?>
		<?php if ( $order->get_billing_city() || $order->get_billing_address_1() || $order->billing_address_2() ) : ?>
			<li class="vct-billing-detail">
				<span><?php esc_html_e( 'Address', 'visual-composer-starter' ); ?></span>
				<span>
					<?php
					if ( $order->get_billing_address_1() ) {
						echo esc_html( $order->get_billing_address_1() );
						if ( $order->get_billing_address_2() ) {
							echo ' - ' . esc_html( $order->get_billing_address_2() );
						}
						echo ', ';
					}

					if ( $order->get_billing_city() ) {
						echo esc_html( $order->get_billing_city() . ', ' );
					}

					if ( $order->get_billing_state() ) {
						echo esc_html( $order->get_billing_state() );
					}
					?>
			</li>
		<?php endif; ?>

		<?php if ( $order->get_billing_postcode() ) : ?>
			<li class="vct-billing-detail">
				<span><?php esc_html_e( 'Postal Code', 'visual-composer-starter' ); ?></span>
				<span><?php echo esc_html( $order->get_billing_postcode() ); ?></span>
			</li>
		<?php endif; ?>
	</ul>
</section>
