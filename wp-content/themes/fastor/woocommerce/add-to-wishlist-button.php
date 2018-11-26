<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

$product = fastor_get_product();
?>
<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) )?>" data-product-id="<?php echo esc_attr($product_id) ?>" data-product-type="<?php echo esc_attr($product_type)?>" class="<?php echo esc_attr($link_classes) ?> link-compare"
   <?php if(trim($label) == ""): ?>
       data-toggle="tooltip" data-placement="top"  data-original-title="<?php echo esc_html__('Add to wishlist', 'fastor') ?>"
   <?php endif; ?>>
    <span aria-hidden="true"><?php echo $icon ?> </span>
    <?php echo $label ?>
</a>
