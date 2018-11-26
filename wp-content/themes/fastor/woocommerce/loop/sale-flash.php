<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$product = fastor_get_product();
$post = fastor_get_post();
$fastor_options = fastor_get_options();

?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php echo apply_filters( 'woocommerce_sale_flash', '<div class="sale-badge">' . esc_html__( 'Sale!', 'fastor' ) . '</div>', $post, $product ); ?>

<?php endif; ?>




<?php if(isset($fastor_options['product-new-badge-status']) && $fastor_options['product-new-badge-status']): ?>
	<?php
	$days = 7;
	if(isset($fastor_options['product-new-badge-time'])){
		$days = intval($fastor_options['product-new-badge-time']);
	}
	$default_new_offset = time() - 60*60*24*$days; // 1 week ago
	?>
	<?php if ( $product->get_date_created()->getTimestamp() > $default_new_offset) : ?>
		<?php echo '<div class="new-badge">' . esc_html__( 'New', 'fastor' ) . '</div>'; ?>
	<?php endif; ?>
<?php endif; ?>
