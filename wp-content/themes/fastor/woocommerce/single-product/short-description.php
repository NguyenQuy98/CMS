<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
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
	exit; // Exit if accessed directly
}

$post = fastor_get_post();

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( ! $short_description ) {
	return;
}

?>

<div class="woocommerce-product-details__short-description description std">

	<?php if(fastor_is_plugin_active('woocommerce-brands/woocommerce-brands.php')): ?>
		<?php echo '<div class="product-brand">' . do_shortcode('[product_brand  height="60px" class="alignright"]') . '</div>';?>
	<?php endif; ?>

	<?php echo $short_description; // WPCS: XSS ok. ?>
</div>
