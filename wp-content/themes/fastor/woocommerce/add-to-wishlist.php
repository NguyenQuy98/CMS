<?php
/**
 * Add to wishlist template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

$product = fastor_get_product();
?>

<?php yith_wcwl_get_template( 'add-to-wishlist-' . $template_part . '.php', $atts ); ?>


