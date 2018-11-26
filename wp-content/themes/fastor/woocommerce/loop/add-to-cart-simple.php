<?php
/**
 * Loop Add to Cart Simple
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart-simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$fastor_options = fastor_get_options();

$flag = true;
if (!isset($product)) {
    $flag = false;
    $product = fastor_get_product();
}

$class = '';

if ($fastor_options['product-addtocart-status']) : ?>
    <?php
    if ($fastor_options['product-addtocart-status']) {
        echo apply_filters( 'woocommerce_loop_add_to_cart_link',
        sprintf( '
        <a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" 
           class="button btn-default cart-links %s product_type_%s"  >
           %s
        </a>
        ',
        esc_url( $product->add_to_cart_url() ),
        esc_attr( $product->get_id() ),
        esc_attr( $product->get_sku() ),
        esc_attr( isset( $quantity ) ? $quantity : 1 ),
        ($product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button ' : '')
        . ($product->is_type('variable') ? '' : 'ajax_add_to_cart'),
        esc_attr( $product->get_type() ),
        esc_html( $product->add_to_cart_text() ),
        esc_html( $product->add_to_cart_text() )
        ),
        $product );
    }
    ?>

<?php endif; ?>
