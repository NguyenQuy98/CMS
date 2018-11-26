<?php
/**
 * Loop Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/rating.php.
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
    exit; // Exit if accessed directly
}
$fastor_options = fastor_get_options();
$product = fastor_get_product();
global $woocommerce;


if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
    return;

$rating = $product->get_average_rating();
$review_count = $woocommerce->version < 2.3 ? $product->get_rating_count() : $product->get_review_count();
$count = 0;
if ( $rating_html = wc_get_rating_html( $product->get_average_rating() ) && $fastor_options['product-rating-status'] ) : ?>
    <div class="rating rating-reviews">
        <i class="star" data-value="<?php echo esc_attr($rating) ?>" data-toggle="tooltip" data-title="<?php echo $rating ?>">
            <?php
            for ($i = 0; $i < (int)$rating; $i++) {
                $count++;
                echo '<i class="fa fa-star active"></i>';
            }
            for ($i = $count; $i < 5; $i++) {
                $count++;
                echo '<i class="fa fa-star"></i>';
            } ?>
        </i>
    </div>
<?php endif; ?>
