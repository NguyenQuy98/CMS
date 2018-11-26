<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$product = fastor_get_product();
$fastor_options = fastor_get_options();

if(!trim($product->get_price_html())){
	return;
}

?>
<div class="price">
	<?php
	if($fastor_options['product-countdown-status'] == '1'){
		$sales_price_to = get_post_meta($product->get_id(), '_sale_price_dates_to', true);
		if( $sales_price_to != "" ){
			echo '<h3>'.esc_html__('Limited time offer', 'fastor').'</h3><div data-date-end="'.$sales_price_to.'" class="product-price-countdown clearfix">
			</div>';
		}
	}
	?>
	<?php echo $product->get_price_html(); ?>
</div>
