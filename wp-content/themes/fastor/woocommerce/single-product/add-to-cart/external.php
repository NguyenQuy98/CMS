<?php
/**
 * External product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/external.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$fastor_options = fastor_get_options();
$product = fastor_get_product();
?>


<div class="cart">

	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<form action="<?php echo esc_url( $product_url ); ?>" method="get">
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
		<div class="add-to-cart clearfix">

			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
			<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $button_text ); ?></button>
			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

			<div class="clearfix"></div>
			<?php if($fastor_options['block-product-enquire-status']): ?>
				<a class="button btn-default button-product-question" id="product-enquiry-button" data-product-name="<?php echo $product->get_title() ?>">
					<img src="<?php echo get_template_directory_uri() ?>/img/icon-ask.png" align="left" class="icon-enquiry" alt="Icon">
					<span class="text-enquiry"><?php echo esc_html__('Ask about this product', 'fastor') ?></span>

				</a>
			<?php endif; ?>
		</div>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>


	<?php
	$wishlist = (in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && $fastor_options['product-addtowishlist-status']);
	$compare = (class_exists( 'YITH_Woocompare_Frontend' ) && $fastor_options['product-addtocompare-status']);
	if ( $wishlist || $compare) {?>
		<div class="links clearfix <?php echo $wishlist ? '' : 'no-wishlist'?> <?php echo $compare ? '' : 'no-compare'?>">
			<?php
			//Add Wishlist
			if ($wishlist) {
				echo
					'<div class="wishlist">
								' . do_shortcode('[yith_wcwl_add_to_wishlist icon="" label="'.esc_html__('Add to wishlist', 'fastor').'"]') . '
						   </div>';
			}

			// Add Compare
			if ($compare) {
				$yith_woocompare = fastor_get_yith_woocompare();
				$yith_woocompare->obj->add_compare_link(false, array('button_or_link' => 'link', 'button_text' => esc_html__('Add to compare', 'fastor')));
			}?>
		</div>
		<?php
	}?>
</div>

