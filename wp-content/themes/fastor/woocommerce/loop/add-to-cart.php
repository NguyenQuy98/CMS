<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
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
$wishlist = (in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && $fastor_options['product-addtowishlist-status']);
$compare = (class_exists( 'YITH_Woocompare_Frontend' ) && $fastor_options['product-addtocompare-status']);

if ( $wishlist || $compare || $fastor_options['product-addtocart-status']) : ?>
    <div class="only-hover">
        <?php
        $all_features = $wishlist && $compare && $fastor_options['product-addtocart-status'] && $fastor_options['product-addtocart-status'];
        ?>
        <?php if ( $wishlist || $compare || $fastor_options['product-addtocart-status'] || $fastor_options['product-addtocart-status']) : ?>
        <ul <?php echo $all_features ? 'class="shrinked"' : ''?>>

            <?php if ($fastor_options['product-addtocart-status']) {
                echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                    sprintf( '<li>
                                <a href="%s" rel="nofollow" data-quantity="%s" class="cart-links %s product_type_%s"  %s>
                                    <div class="add-to-cart-label" data-toggle="tooltip" data-original-title="%s">
                                    <i class="fa fa-shopping-cart"></i>
                                    </div>
                                </a>
                                </li>',
                        esc_url( $product->add_to_cart_url() ),
                        esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                        ($product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button ' : '')
                        . ($product->is_type('variable') ? '' : 'ajax_add_to_cart'),
                        esc_attr( $product->get_type() ),
                        isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                        esc_html( $product->add_to_cart_text() )
                    ),
                    $product, $args );
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
            if ( $compare && !$flag ) {
                global $yith_woocompare;
                echo '<li>';
                $yith_woocompare->obj->add_compare_link(false, array('button_or_link' => 'link', 'button_text' => '<div class="compare-label" data-toggle="tooltip" data-placement="top"  data-original-title="'. esc_html__('Add to compare', 'fastor').'"><i class="fa fa-refresh" aria-hidden="true"></i></div>'));
                echo '</li>';
            }


        ?></ul><?php
        endif;



        ?>

    </div>
<?php endif; ?>
