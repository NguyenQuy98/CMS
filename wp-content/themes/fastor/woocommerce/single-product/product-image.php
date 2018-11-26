<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 3.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$product = fastor_get_product();
$post = fastor_get_post();
$woocommerce = fastor_get_woocommerce();
$fastor_options = fastor_get_options();

$attachment_ids = $product->get_gallery_image_ids();


$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
//    'woocommerce-product-gallery--columns-' . absint( $columns ),
    'images',
) );
?>

<?php $image_grid = 6;

if ($fastor_options['productpage-image-size'] == 1) {
    $image_grid = 4;
}

if ($fastor_options['productpage-image-size'] == 3) {
    $image_grid = 8;
}
?>
<div class="col-sm-<?php echo $image_grid; ?> images  woocommerce-product-gallery__wrapper">
    <?php $product_block_image_top = get_post_meta(get_the_id(), 'product_block_image_top', true); ?>
    <?php if ($product_block_image_top != '' && is_product()): ?>
        <?php echo do_shortcode('[custom_block name="'.$product_block_image_top.'"]') ?>
    <?php endif; ?>

    <div class="product-image <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>"
         data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">


        <?php
        // Load sale  badges
        echo wc_get_template_part('single-product/sale-flash');
        ?>


        <figure class="woocommerce-product-gallery__wrapper">
            <?php
            if ( has_post_thumbnail() ) {
                $html  = wc_get_gallery_image_html( $post_thumbnail_id, true );
            } else {
                $html  = '<div class="woocommerce-product-gallery__image--placeholder ">';
                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
                $html .= '</div>';
            }

            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );

            do_action( 'woocommerce_product_thumbnails' );
            ?>
        </figure>
    </div>

    <?php $product_block_image_bottom = get_post_meta(get_the_id(), 'product_block_image_bottom', true); ?>
    <?php if ($product_block_image_bottom != '' && is_product()): ?>
        <?php echo do_shortcode('[custom_block name="'.$product_block_image_bottom.'"]') ?>
    <?php endif; ?>

</div>


