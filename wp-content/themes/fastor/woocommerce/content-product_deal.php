<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$product = fastor_get_product();
$woocommerce_loop = fastor_get_woocommerce_loop();
$fastor_options = fastor_get_options();

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div class="product clearfix <?php if($fastor_options['product-hover-status']) { echo 'product-hover'; } ?>">

    <div class="left">

	    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

    </div>
    <div class="right">


	<?php
	/**
    * woocommerce_before_shop_loop_item_title hook
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );
    ?>

    <div class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

    <?php

    do_action('fastor_today_deals_woocommerce_after_shop_loop_item');

    ?>

    </div>
</div>

