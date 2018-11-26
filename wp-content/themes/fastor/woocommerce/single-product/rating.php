<?php
/**
 * Single Product Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$product = fastor_get_product();
$fastor_options = fastor_get_options();
global $woocommerce;

?>



<?php

if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
    ?>

    <?php if($fastor_options['productpage-socialshare-status'] && fastor_is_plugin_active('woocommerce-social-media-share-buttons/index.php')): ?>
        <?php echo do_shortcode( '[woocommerce_social_media_share_buttons]' ); ?>
    <?php endif; ?>
    <?php

    return;
}

$rating = $product->get_average_rating();
$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();
$count = 0;

if ( $rating_count > 0 ) : ?>
    <div class="review">
        <div class="rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
            <meta content="<?php echo $rating; ?>" itemprop="ratingValue" />
            <meta content="<?php echo $rating_count; ?>" itemprop="ratingCount" />
            <meta content="<?php echo $review_count; ?>" itemprop="reviewCount" />
            <meta content="5" itemprop="bestRating" />
            <span class="star" data-value="<?php echo esc_attr($rating) ?>" data-toggle="tooltip" data-title="<?php echo $rating ?>">
            <?php
            for ($i = 0; $i < (int)$rating; $i++) {
                $count++;
                echo '<i class="fa fa-star  active"></i>';
            }
            for ($i = $count; $i < 5; $i++) {
                $count++;
                echo '<i class="fa fa-star"></i>';
            } ?>
        </span>
            <?php if ( comments_open() ) : ?><a href="#reviews" class="woocommerce-review-link" rel="nofollow" onclick="$('a[href=\'#tab-reviews\']').trigger('click'); $('html, body').animate({scrollTop:$('#tab-reviews').offset().top}, '500', 'swing');">(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'fastor' ), '<span itemprop="reviewCount" class="count">' . $review_count . '</span>' ); ?>)</a><?php endif ?>
        </div>

        <?php if($fastor_options['productpage-socialshare-status'] && fastor_is_plugin_active('woocommerce-social-media-share-buttons/index.php')): ?>
            <?php echo do_shortcode( '[woocommerce_social_media_share_buttons]' ); ?>
        <?php endif; ?>


    </div>

<?php endif; ?>

