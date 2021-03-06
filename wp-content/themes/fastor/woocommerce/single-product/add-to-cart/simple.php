<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$product = fastor_get_product();
$fastor_options = fastor_get_options();

if ( ! $product->is_purchasable() ) {
    return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

?>

<?php $product_block_over_add_to_cart = get_post_meta(get_the_id(), 'product_block_over_add_to_cart', true); ?>
<?php if ($product_block_over_add_to_cart != '' && is_product()): ?>
    <?php echo do_shortcode('[custom_block name="'.$product_block_over_add_to_cart.'"]') ?>
<?php endif; ?>


<?php if ( ! $product->is_purchasable() || !$product->is_in_stock()) {
?>
    <?php if($fastor_options['block-product-enquire-status']): ?>
        <div class="product-enquire no-purchasable">
            <a class="button btn-default button-product-question no-purchasable" id="product-enquiry-button" data-product-name="<?php echo $product->get_title() ?>">
                <img src="<?php echo get_template_directory_uri() ?>/img/icon-ask.png" align="left" class="icon-enquiry" alt="Icon">
                <span class="text-enquiry"><?php echo esc_html__('Ask about this product', 'fastor') ?></span>

            </a>
        </div>
    <?php endif; ?>
    <?php
    return;
} ?>


<div class="product">
	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

    <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
	 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
        <div class="add-to-cart clearfix">
            <?php

            do_action( 'woocommerce_before_add_to_cart_quantity' );
            ?>
            <?php if ( ! $product->is_sold_individually() ) : ?>
                <p><?php echo esc_html__( 'Qty', 'fastor' ); ?></p>
            <?php endif; ?>
            <div class="quantity">
            <?php
                if ( ! $product->is_sold_individually() ) {
                    woocommerce_quantity_input( array(
                        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                        'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                        'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                    ) );

                }

            ?>
            </div>
            <?php

            do_action( 'woocommerce_after_add_to_cart_quantity' );
            ?>
            <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />

            <button id="button-cart" type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
            <div class="clearfix"></div>
            <?php if($fastor_options['block-product-enquire-status']): ?>
                <a class="button btn-default button-product-question" id="product-enquiry-button" data-product-name="<?php echo $product->get_title() ?>">
                    <img src="<?php echo get_template_directory_uri() ?>/img/icon-ask.png" align="left" class="icon-enquiry" alt="Icon">
                    <span class="text-enquiry"><?php echo esc_html__('Ask about this product', 'fastor') ?></span>

                </a>
            <?php endif; ?>
        </div>
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>


		<?php
		$wishlist = (in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && $fastor_options['product-addtowishlist-status']);
		$compare = (class_exists( 'YITH_Woocompare_Frontend' ) && $fastor_options['product-addtocompare-status']);
		if ( $wishlist || $compare) {?>
			<div class="links clearfix <?php echo $wishlist ? '' : 'no-wishlist'?> <?php echo $compare ? '' : 'no-compare'?>">
				<?php
				 //Add Wishlist
				if ($wishlist) {
					echo do_shortcode('[yith_wcwl_add_to_wishlist icon="" label="'.esc_html__('Add to wishlist', 'fastor').'"]') ;
				}

				// Add Compare
				if ($compare) {
					$yith_woocompare = fastor_get_yith_woocompare();
					$yith_woocompare->obj->add_compare_link(false, array('button_or_link' => 'link', 'button_text' => esc_html__('Add to compare', 'fastor')));
				}?>
            </div>
		<?php
		}?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
</div>


