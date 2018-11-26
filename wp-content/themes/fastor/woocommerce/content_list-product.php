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
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

//$product = fastor_get_product();
$woocommerce_loop = fastor_get_woocommerce_loop();
$fastor_options = fastor_get_options();
$product = fastor_get_product();

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
    $woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
    $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
    return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
    $classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
    $classes[] = 'last';
}


?>

<div class="image col-sm-3">
    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
</div>

<div class="name-actions col-sm-4">
    <?php
    /**
     * woocommerce_before_shop_loop_item_title hook
     *
     * @hooked woocommerce_show_product_loop_sale_flash - 10
     */
    do_action( 'woocommerce_before_shop_loop_item_title' );
    ?>
    <div class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>


    <?php

    /**
     * woocommerce_after_shop_loop_item hook
     *
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    do_action( 'woocommerce_after_shop_loop_item' );


    $flag = true;
    if (!isset($product)) {
        $flag = false;
        $product = fastor_get_product();
    }

    $class = '';
    $wishlist = (in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && $fastor_options['product-addtowishlist-status']);
    $compare = (class_exists( 'YITH_Woocompare_Frontend' ) && $fastor_options['product-addtocompare-status']);

    $all_features = $wishlist && $compare && $fastor_options['product-addtocart-status'] && $fastor_options['product-addtocart-status'];

    if ( $wishlist || $compare || $fastor_options['product-addtocart-status'] || $fastor_options['product-addtocart-status']) : ?>
        <ul <?php echo $all_features ? 'class="shrinked"' : ''?>>

        <?php if ($fastor_options['product-addtocart-status']) {
            echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                sprintf( '<li>
                                <a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="cart-links %s product_type_%s"  >
                                    <div class="add-to-cart-label" data-toggle="tooltip" data-original-title="%s">
                                    <i class="fa fa-shopping-cart"></i>
                                    </div>
                                </a>
                                </li>',
                    esc_url( $product->add_to_cart_url() ),
                    esc_attr( $product->get_id() ),
                    esc_attr( $product->get_sku() ),
                    esc_attr( isset( $quantity ) ? $quantity : 1 ),
                    ($product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button ' : '') . ($product->get_type() == 'variable' ? '' : 'ajax_add_to_cart'),
                    esc_attr( $product->get_type() ),
                    esc_html( $product->add_to_cart_text() ),
                    esc_html( $product->add_to_cart_text() )
                ),
                $product );
        }

        if ($fastor_options['product-quickview-status']) : ?>
            <li class="quickview">
                <a href="<?php echo esc_url(admin_url( 'admin-ajax.php?action=fastor_product_quickview&context=frontend&pid=' )) ?><?php echo the_ID() ?>" data-toggle="tooltip" data-original-title="<?php echo esc_html__('Quickview', 'fastor') ?>"><i class="fa fa-search"></i></a>
            </li>
        <?php endif;

        // Add Wishlist
        if ( $wishlist ) {
            echo '<li> '.do_shortcode('[yith_wcwl_add_to_wishlist icon="fa fa-heart" label=""]').'</li>';
        }


        // Add Compare
        if ( $compare) {
            global $yith_woocompare;
            echo '<li>';
            $yith_woocompare->obj->add_compare_link(false, array('button_or_link' => 'link', 'button_text' => '<div class="compare-label" data-toggle="tooltip" data-placement="top"  data-original-title="'. esc_html__('Add to compare', 'fastor').'"><i class="fa fa-refresh" aria-hidden="true"></i></div>'));
            echo '</li>';
        }


        ?></ul>
    <?php endif; ?>

</div>

<div class="desc col-sm-5">
    <?php
    /**
     * woocommerce_before_shop_loop_item_title hook
     *
     * @hooked woocommerce_show_product_loop_sale_flash - 10
     */
    do_action( 'woocommerce_after_shop_loop_item_title' );
    ?>
</div>


