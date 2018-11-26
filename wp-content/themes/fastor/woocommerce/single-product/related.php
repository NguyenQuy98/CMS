<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
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

$woocommerce_loop = fastor_get_woocommerce_loop();
$product = fastor_get_product();
$fastor_options = fastor_get_options();

if ( $related_products ) : ?>
    <?php
    $class = 3;
    $id = rand(0, 5000)*rand(0, 5000);
    $all = count($related_products);
    $row = 4;


    if($fastor_options['product-per-pow'] == 6) { $class = 2; }
    if($fastor_options['product-per-pow'] == 5) { $class = 25; }
    if($fastor_options['product-per-pow'] == 3) { $class = 4; }

    if($fastor_options['product-per-pow'] > 1) {
        $row = esc_attr($fastor_options['product-per-pow']);
    }
    ?>
    <?php if($fastor_options['productpage-related-status']) { ?>
    <div class="box clearfix box-with-products box-no-advanced with-scroll">
            <!-- Carousel nav -->
            <a class="next" href="#myCarousel<?php echo $id; ?>" id="myCarousel<?php echo $id; ?>_next"><span></span></a>
            <a class="prev" href="#myCarousel<?php echo $id; ?>" id="myCarousel<?php echo $id; ?>_prev"><span></span></a>

        <div class="box-heading"><?php esc_html_e( 'Related Products', 'fastor' ); ?></div>
        <div class="strip-line"></div>
        <div class="box-content products related-products">
            <div class="box-product">
                <div id="myCarousel<?php echo $id; ?>" class="carousel slide">
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        <?php
                        $i = 0;
                        $row_fluid = 0;
                        $item = 0;
                        woocommerce_product_loop_start(false);

                        foreach ( $related_products as $related_product ) :

                            $post_object = get_post( $related_product->get_id() );

                            setup_postdata( $GLOBALS['post'] =& $post_object );

                            $row_fluid++; ?>
                            <?php if($i == 0) {
                            $item++;
                            echo '<div class="active item"><div class="product-grid"><div class="row">'; } ?>
                            <?php
                            $r = $row_fluid-floor($row_fluid/$all)*$all;
                            if($row_fluid > $all && $r == 1) {
                                echo '</div></div></div><div class="item"><div class="product-grid"><div class="row">';
                                $item++;

                            } else {
                                $r = $row_fluid-floor($row_fluid/$row)*$row;
                                if($row_fluid>$row && $r == 1) {
                                    echo '</div><div class="row">';
                                }
                            } ?>
                            <div class="col-sm-<?php echo $class; ?> col-xs-6">
                                <?php wc_get_template_part( 'content', 'product' ); ?>
                            </div>
                            <?php $i++;  endforeach; ?>
                        <?php if($i > 0) { echo '</div></div></div>'; } ?>
                        <?php woocommerce_product_loop_end(false); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>


    <?php if($fastor_options['productpage-related-status']) { ?>
        <script>
            (function($) {
                $(document).ready(function() {
                var owl<?php echo $id; ?> = $(".box #myCarousel<?php echo $id; ?> .carousel-inner");

                $("#myCarousel<?php echo $id; ?>_next").click(function(){
                    owl<?php echo $id; ?>.trigger('owl.next');
                    return false;
                })
                $("#myCarousel<?php echo $id; ?>_prev").click(function(){
                    owl<?php echo $id; ?>.trigger('owl.prev');
                    return false;
                });

               owl<?php echo $id; ?>.owlCarousel({
                     slideSpeed : 500,
                     singleItem:true,
                   <?php if(is_rtl()): ?>
                   direction: 'rtl'
                   <?php endif; ?>
                });
                 var itemCount = $(".box #myCarousel<?php echo $id; ?> .item").length;
                 if(itemCount == 1) {
                     $("#myCarousel<?php echo $id; ?>_prev").hide();
                     $("#myCarousel<?php echo $id; ?>_next").hide();
                 }

             });
        })(jQuery)
    </script>
    <?php } ?>

<?php endif;


wp_reset_postdata();
