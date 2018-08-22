<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to visual-composer-starter/woocommerce/single-product/meta.php.
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
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'visual-composer-starter' ); ?>
			<span class="sku">
				<?php
				// @codingStandardsIgnoreLine
				echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'visual-composer-starter' );
				?>
			</span>
		</span>

	<?php endif; ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
