<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$product = fastor_get_product();
$woocommerce_loop = fastor_get_woocommerce_loop();
$fastor_options = fastor_get_options();


if ( $cross_sells ) : ?>
    <?php
    $class = 3;
    $id = rand(0, 5000)*rand(0, 5000);
    $all = count($cross_sells);
    $row = 4;

    if($fastor_options['product-per-pow'] == 6) { $class = 2; }
    if($fastor_options['product-per-pow'] == 5) { $class = 25; }
    if($fastor_options['product-per-pow'] == 3) { $class = 4; }

    if($fastor_options['product-per-pow'] > 1) {
        $row = esc_html($fastor_options['product-per-pow']);
    }
    ?>
    <div class="clearfix"></div>
    <div class="box clearfix">
        <?php if($fastor_options['productpage-related-status']) { ?>
            <!-- Carousel nav -->
            <a class="next" href="#myCarousel<?php echo esc_attr($id); ?>" id="myCarousel<?php echo esc_attr($id); ?>_next"><span></span></a>
            <a class="prev" href="#myCarousel<?php echo esc_attr($id); ?>" id="myCarousel<?php echo esc_attr($id); ?>_prev"><span></span></a>
        <?php } ?>

        <div class="box-heading"><?php esc_html_e( 'You may be interested in&hellip;', 'fastor' ) ?></div>
        <div class="strip-line"></div>
        <div class="box-content products related-products">
            <div class="box-product">
                <div id="myCarousel<?php echo esc_attr($id); ?>" <?php if($fastor_options['productpage-related-status']) { ?>class="carousel slide"<?php } ?>>
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        <?php

                        $i = 0;
                        $row_fluid = 0;
                        $item = 0;
                        woocommerce_product_loop_start(false);

                        foreach ( $cross_sells as $cross_sell ):

                            $post_object = get_post( $cross_sell->get_id() );

                            setup_postdata( $GLOBALS['post'] =& $post_object );

                            $row_fluid++; ?>
                            <?php if($i == 0) {
                            $item++;
                            echo '<div class="active item"><div class="product-grid"><div class="row">'; } ?>
                            <?php
                            $r = $row_fluid-floor($row_fluid/$all)*$all;
                            if($row_fluid > $all && $r == 1) {
                                if($fastor_options['productpage-related-status']) {
                                    echo '</div></div></div><div class="item"><div class="product-grid"><div class="row">';
                                    $item++;

                                } else {
                                    echo '</div><div class="row">';

                                }
                            } else {
                                $r = $row_fluid-floor($row_fluid/$row)*$row;
                                if($row_fluid>$row && $r == 1) {
                                    echo '</div><div class="row">';
                                }
                            } ?>
                            <div class="col-sm-<?php echo esc_attr($class); ?> col-xs-6">
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

    <?php if($fastor_options['productpage-related-status']) { ?>
        <script>
            (function($) {
                $(document).ready(function() {
                    var owl<?php echo esc_attr($id); ?> = $(".box #myCarousel<?php echo esc_attr($id); ?> .carousel-inner");

                    $("#myCarousel<?php echo esc_attr($id); ?>_next").click(function(){
                        owl<?php echo esc_attr($id); ?>.trigger('owl.next');
                        return false;
                    })
                    $("#myCarousel<?php echo esc_attr($id); ?>_prev").click(function(){
                        owl<?php echo esc_attr($id); ?>.trigger('owl.prev');
                        return false;
                    });

                    owl<?php echo esc_attr($id); ?>.owlCarousel({
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
