<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to visual-composer-starter/woocommerce/order/order-details.php.
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
 * @version 3.5.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$order = wc_get_order( $order_id );
if ( ! $order ) {
	return;
}

$order_items = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array(
	'completed',
	'processing',
) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads = $order->get_downloadable_items();
$show_downloads = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template( 'order/order-downloads.php', array(
		'downloads' => $downloads,
		'show_title' => true,
	) );
}
?>
	<section class="woocommerce-order-details">
		<div class="vct-order-container">
			<h3 class="woocommerce-order-details__title"><?php esc_html_e( 'Order details', 'visual-composer-starter' ); ?></h3>

			<ul class="vct-order-details-container">

				<li class="vct-order-detail">
					<span><?php esc_html_e( 'Order number:', 'visual-composer-starter' ); ?></span>
					<span><?php echo esc_html( $order->get_order_number() ); ?></span>
				</li>
				<li class="vct-order-detail">
					<span><?php esc_html_e( 'Date:', 'visual-composer-starter' ); ?></span>
					<span>
						<?php
						// @codingStandardsIgnoreLine
						echo wc_format_datetime( $order->get_date_created() );
						?>
					</span>
				</li>
				<?php
				do_action( 'woocommerce_order_details_before_order_table_items', $order );

				foreach ( $order_items as $item_id => $item ) {
					$product = $item->get_product();

					wc_get_template( 'order/order-details-item.php', array(
						'order' => $order,
						'item_id' => $item_id,
						'item' => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note' => $product ? $product->get_purchase_note() : '',
						'product' => $product,
					) );
				}

				do_action( 'woocommerce_order_details_after_order_table_items', $order );
				?>

				<?php
				foreach ( $order->get_order_item_totals() as $key => $total ) {
					?>
					<li class="vct-order-detail">
						<span>
							<?php
							// @codingStandardsIgnoreLine
							echo $total['label'];
							?>
						</span>
						<span>
							<?php
							// @codingStandardsIgnoreLine
							echo $total['value'];
							?>
						</span>
					</li>
					<?php
				}
				?>
				<?php if ( $order->get_customer_note() ) : ?>
					<li class="vct-order-detail">
						<span><?php esc_html_e( 'Note:', 'visual-composer-starter' ); ?></span>
						<span>
							<?php
							// @codingStandardsIgnoreLine
							echo wptexturize( $order->get_customer_note() );
							?>
						</span>
					</li>
				<?php endif; ?>
			</ul>
			<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
		</div>
	</section>

<?php
if ( $show_customer_details ) {
	wc_get_template( 'order/order-details-customer.php', array(
		'order' => $order,
		'order_id' => $order_id,
	) );
}
