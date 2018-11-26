<?php

// Products Shortcode

add_shortcode("sw_bestseller_products", "fastor_shortcode_bestseller_products");
add_shortcode("sw_featured_products", "fastor_shortcode_featured_products");
add_shortcode("sw_sale_products", "fastor_shortcode_sale_products");
add_shortcode("sw_latest_products", "fastor_shortcode_latest_products");

function fastor_shortcode_bestseller_products($attr, $content = null) {

    global $fastor_settings;

    extract(shortcode_atts(array(
        "title" => '',
        'limit' => '4',
        'cols' => '1',
        'itemsperpage' => '4',
        'cats' => '',
        'view' => 'grid',
        'in_tabs' => 'no',
        'orderby' => 'date',
        'order' => 'desc',
        'class' => ''
    ), $attr));

    $class_extra = $class;

    ob_start();
    ?>

    <?php
    /**
     * Check if WooCommerce is active
     **/
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        ?>

        <?php
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'no_found_rows' => 1,
            'posts_per_page' => $limit,
            'meta_key'            => 'total_sales',
            'orderby'             => 'meta_value_num',
        );

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',

            ),
//            array(
//                'taxonomy' => 'product_visibility',
//                'field'    => 'name',
//                'terms'    => 'outofstock',
//                'operator' => 'NOT IN',
//            )
        );

        if ($cats) {
            $cats = explode(',', $cats);
            $args['tax_query'][] =
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $cats,

                );
        }

        $products = new WP_Query( $args );

        global $fastor_product_slider;

        if ($view == 'slider')
            $carousel = true;
        else
            $carousel = false;

        $fastor_product_bestseller_id =  rand();

        $class = 3;
        $all = $cols*$itemsperpage;
        $row = $itemsperpage;

        if($itemsperpage == 1) $class = 12;
        if($itemsperpage == 2) $class = 6;
        if($itemsperpage == 3) $class = 4;
        if($itemsperpage == 4) $class = 3;
        if($itemsperpage == 5) $class = 25;
        if($itemsperpage == 6) $class = 2;

        if($view != 'menu'):?>
            <?php if($in_tabs != 'yes'):?>
                <div class="box clearfix box-with-products box-no-advanced <?php if($carousel) { echo 'with-scroll';  } ?> <?php echo $class_extra ?>">
            <?php endif; ?>
            <?php
            if ( $products->have_posts() ) : ?>

                <?php if($carousel):?>
                <!-- Carousel nav -->
                <a class="next next-button" href="#myCarousel<?php echo esc_html($fastor_product_bestseller_id); ?>" id="myCarousel<?php echo esc_html($fastor_product_bestseller_id); ?>_next"><span></span></a>
                <a class="prev prev-button" href="#myCarousel<?php echo esc_html($fastor_product_bestseller_id); ?>" id="myCarousel<?php echo esc_html($fastor_product_bestseller_id); ?>_prev"><span></span></a>

                <script type="text/javascript">
                    (function($) {
                        $(document).ready(function() {
                            var owl<?php echo esc_html($fastor_product_bestseller_id); ?> = $("#myCarousel<?php echo esc_html($fastor_product_bestseller_id); ?> .carousel-inner");

                            $("#myCarousel<?php echo esc_html($fastor_product_bestseller_id); ?> .product-grid > .row").find('.col-xs-6').each(function(){
                                if($(this).text().trim() == 'undefined'){
                                    $(this).remove();
                                }
                            })

                            $("#myCarousel<?php echo esc_html($fastor_product_bestseller_id); ?>_next").click(function(){
                                owl<?php echo esc_html($fastor_product_bestseller_id); ?>.trigger('owl.next');
                                return false;
                            })
                            $("#myCarousel<?php echo esc_html($fastor_product_bestseller_id); ?>_prev").click(function(){
                                owl<?php echo esc_html($fastor_product_bestseller_id); ?>.trigger('owl.prev');
                                return false;
                            });

                            owl<?php echo esc_html($fastor_product_bestseller_id); ?>.owlCarousel({
                                slideSpeed : 500,
                                singleItem:true
                            });
                        });
                    })(jQuery)
                </script>

            <?php endif; ?>

            <?php if($title):?>
                <div class="box-heading"> <?php echo esc_html($title); ?></div>
                <div class="strip-line"></div>
                <div class="clear"></div>
            <?php endif; ?>
            <?php if($in_tabs != 'yes'):?>
                <div class="box-content products <?php echo $class_extra ?>">
                    <?php endif; ?>
                    <div class="box-product">
                        <div id="myCarousel<?php echo esc_html($fastor_product_bestseller_id); ?>" <?php if($carousel != 0) { ?>class="carousel slide"<?php } ?>>
                            <!-- Carousel items2 -->
                            <div class="carousel-inner">
                                <?php $i = 0; $row_fluid = 0; $item = 0; ?>
                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                    <?php $row_fluid++; ?>
                                    <?php if($i == 0) {
                                        $item++;
                                        echo '<div class="active item"><div class="product-grid"><div class="row">';
                                    } ?>
                                    <?php
                                    $r = $row_fluid-floor($row_fluid/$all)*$all;
                                    if($row_fluid > $all && $r == 1) {
                                        if($carousel) {
                                            echo '</div></div></div><div class="item"><div class="product-grid"><div class="row">';
                                            $item++;
                                        } else {
                                            echo '</div><div class="row">';
                                        }
                                    } else {
                                        $r = $row_fluid-floor($row_fluid/$row)*$row;
                                        if($row_fluid > $row && $r == 1) {
                                            echo '</div><div class="row">';
                                        }
                                    } ?>

                                    <div class="col-sm-<?php echo esc_html($class); ?> col-xs-6 <?php if($class == 2) { echo 'col-md-25 col-lg-2 col-sm-3 '; } if($class == 2 && $r == 0) { echo 'hidden-md hidden-sm'; } if($class == 2 && $r == 5) { echo 'hidden-sm'; } ?> <?php if($class == 25) { echo 'col-md-25 col-lg-25 col-sm-3 '; } if($class == 25 && $r == 0) { echo 'hidden-sm'; } ?>">
                                        <?php wc_get_template_part( 'content', 'product' ); ?>
                                    </div>
                                    <?php $i++; ?>

                                <?php endwhile; // end of the loop. ?>
                                <?php if($i > 0) { echo '</div></div></div>'; } ?>
                                <?php woocommerce_product_loop_end(false); ?>

                            </div>
                        </div>
                    </div>
                    <?php if($in_tabs != 'yes'):?>
                </div>
            <?php endif; ?>

            <?php else : ?>

                <div class="shortcode shortcode-products <?php echo esc_html($class) ?> ">
                    <div class="box-heading"> <?php echo esc_html($title); ?></div>
                    <div class="strip-line"></div>
                    <div class="clear"></div>
                    <p><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
                </div>


            <?php endif; ?>
            <?php if($in_tabs != 'yes'):?>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <div class="products-carousel-overflow clearfix <?php echo $class_extra ?>">
                <?php
                if ( $products->have_posts() ) : ?>

                    <div class="next next-button" id="<?php echo esc_html($fastor_product_bestseller_id); ?>"><span></span></div>
                    <div class="prev prev-button" id="<?php echo esc_html($fastor_product_bestseller_id); ?>"><span></span></div>

                    <div class="box-heading"> <?php echo esc_html($title); ?></div>
                    <div class="strip-line"></div>
                    <div class="clear"></div>
                    <div class="products-carousel owl-carousel" id="productsCarousel<?php echo esc_html($fastor_product_bestseller_id); ?>">

                        <?php woocommerce_product_loop_start(false); ?>

                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                            <div class="item">
                                <?php wc_get_template_part( 'content', 'product' ); ?>
                            </div>
                            <?php $i++; ?>

                        <?php endwhile; // end of the loop. ?>
                        <?php woocommerce_product_loop_end(false); ?>

                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $(document).ready(function() {
                                var owl<?php echo esc_html($fastor_product_bestseller_id); ?> = $("#productsCarousel<?php echo esc_html($fastor_product_bestseller_id); ?>");

                                $("#productsCarousel<?php echo esc_html($fastor_product_bestseller_id); ?>_next").click(function(){
                                    owl<?php echo esc_html($fastor_product_bestseller_id); ?>.trigger('owl.next');
                                    return false;
                                });

                                $("#productsCarousel<?php echo esc_html($fastor_product_bestseller_id); ?>_prev").click(function(){
                                    owl<?php echo esc_html($fastor_product_bestseller_id); ?>.trigger('owl.prev');
                                    return false;
                                });

                                owl<?php echo esc_html($fastor_product_bestseller_id); ?>.owlCarousel({
                                    itemsCustom : [
                                        [0, <?php echo 1; ?>],
                                        [450, <?php echo 2; ?>],
                                        [768, <?php echo 3; ?>],
                                        [1200, <?php echo esc_html($itemsperpage); ?>]
                                    ],
                                });
                            });
                        })(jQuery)
                    </script>

                <?php else : ?>

                    <div class="shortcode shortcode-products <?php echo esc_html($class) ?> ">
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                        <div class="clear"></div>
                        <p><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
                    </div>


                <?php endif; ?>
            </div>
        <?php endif;

        wp_reset_postdata();
    }
    $str = ob_get_contents();
    ob_end_clean();
    return $str;
}

function fastor_shortcode_featured_products($attr, $content = null) {

    global $fastor_settings;

    extract(shortcode_atts(array(
        "title" => '',
        'limit' => '4',
        'cols' => '1',
        'itemsperpage' => '4',
        'cats' => '',
        'view' => 'grid',
        'in_tabs' => 'no',
        'orderby' => 'date',
        'order' => 'desc',
        'class' => ''
    ), $attr));

    $class_extra = $class;

    ob_start();
    ?>

    <?php
    /**
     * Check if WooCommerce is active
     **/
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        ?>

        <?php
        $args = array(
            'post_status' => 'publish',
            'post_type' => 'product',
            'no_found_rows' => 1,
            'posts_per_page' => $limit,
            'order' => $order == 'asc' ? 'asc' : 'desc',
        );

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',

            ),
//            array(
//                'taxonomy' => 'product_visibility',
//                'field'    => 'name',
//                'terms'    => 'outofstock',
//                'operator' => 'NOT IN',
//            ),
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN'
            )
        );

        if ($cats) {
            $cats = explode(',', $cats);
            $args['tax_query'][] =
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $cats,

                );
        }

        $products = new WP_Query( $args );

        global $fastor_product_slider;

        if ($view == 'slider')
            $carousel = true;
        else
            $carousel = false;

        $fastor_product_featured_id = rand();

        $class = 3;
        $all = $cols*$itemsperpage;
        $row = $itemsperpage;

        if($itemsperpage == 1) $class = 12;
        if($itemsperpage == 2) $class = 6;
        if($itemsperpage == 3) $class = 4;
        if($itemsperpage == 4) $class = 3;
        if($itemsperpage == 5) $class = 25;
        if($itemsperpage == 6) $class = 2;

        if($view != 'menu'):?>
            <?php if($in_tabs != 'yes'):?>
                <div class="box clearfix box-with-products box-no-advanced <?php if($carousel) { echo 'with-scroll';  } ?> <?php echo $class_extra ?>">
            <?php endif; ?>
            <?php
            if ( $products->have_posts() ) : ?>

                <?php if($carousel):?>
                <!-- Carousel nav -->
                <a class="next next-button" href="#myCarousel<?php echo esc_html($fastor_product_featured_id); ?>" id="myCarousel<?php echo esc_html($fastor_product_featured_id); ?>_next"><span></span></a>
                <a class="prev prev-button" href="#myCarousel<?php echo esc_html($fastor_product_featured_id); ?>" id="myCarousel<?php echo esc_html($fastor_product_featured_id); ?>_prev"><span></span></a>

                <script type="text/javascript">
                    (function($) {
                        $(document).ready(function() {
                            var owl<?php echo esc_html($fastor_product_featured_id); ?> = $("#myCarousel<?php echo esc_html($fastor_product_featured_id); ?> .carousel-inner");

                            $("#myCarousel<?php echo esc_html($fastor_product_featured_id); ?> .product-grid > .row").find('.col-xs-6').each(function(){
                                if($(this).text().trim() == 'undefined'){
                                    $(this).remove();
                                }
                            })


                            $("#myCarousel<?php echo esc_html($fastor_product_featured_id); ?>_next").click(function(){
                                owl<?php echo esc_html($fastor_product_featured_id); ?>.trigger('owl.next');
                                return false;
                            })
                            $("#myCarousel<?php echo esc_html($fastor_product_featured_id); ?>_prev").click(function(){
                                owl<?php echo esc_html($fastor_product_featured_id); ?>.trigger('owl.prev');
                                return false;
                            });

                            owl<?php echo esc_html($fastor_product_featured_id); ?>.owlCarousel({
                                slideSpeed : 500,
                                singleItem:true
                            });
                        });
                    })(jQuery)
                </script>

            <?php endif; ?>

            <?php if($title):?>
                <div class="box-heading"> <?php echo esc_html($title); ?></div>
                <div class="strip-line"></div>
                <div class="clear"></div>
            <?php endif; ?>
            <?php if($in_tabs != 'yes'):?>
                <div class="box-content products <?php echo $class_extra ?>">
                    <?php endif; ?>
                    <div class="box-product">
                        <div id="myCarousel<?php echo esc_html($fastor_product_featured_id); ?>" <?php if($carousel != 0) { ?>class="carousel slide"<?php } ?>>
                            <!-- Carousel items2 -->
                            <div class="carousel-inner">
                                <?php $i = 0; $row_fluid = 0; $item = 0; ?>
                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                    <?php $row_fluid++; ?>
                                    <?php if($i == 0) {
                                        $item++;
                                        echo '<div class="active item"><div class="product-grid"><div class="row">';
                                    } ?>
                                    <?php
                                    $r = $row_fluid-floor($row_fluid/$all)*$all;
                                    if($row_fluid > $all && $r == 1) {
                                        if($carousel) {
                                            echo '</div></div></div><div class="item"><div class="product-grid"><div class="row">';
                                            $item++;
                                        } else {
                                            echo '</div><div class="row">';
                                        }
                                    } else {
                                        $r = $row_fluid-floor($row_fluid/$row)*$row;
                                        if($row_fluid > $row && $r == 1) {
                                            echo '</div><div class="row">';
                                        }
                                    } ?>

                                    <div class="col-sm-<?php echo esc_html($class); ?> col-xs-6 <?php if($class == 2) { echo 'col-md-25 col-lg-2 col-sm-3 '; } if($class == 2 && $r == 0) { echo 'hidden-md hidden-sm'; } if($class == 2 && $r == 5) { echo 'hidden-sm'; } ?> <?php if($class == 25) { echo 'col-md-25 col-lg-25 col-sm-3 '; } if($class == 25 && $r == 0) { echo 'hidden-sm'; } ?>">
                                        <?php wc_get_template_part( 'content', 'product' ); ?>
                                    </div>
                                    <?php $i++; ?>

                                <?php endwhile; // end of the loop. ?>
                                <?php if($i > 0) { echo '</div></div></div>'; } ?>
                                <?php woocommerce_product_loop_end(false); ?>

                            </div>
                        </div>
                    </div>
                    <?php if($in_tabs != 'yes'):?>
                </div>
            <?php endif; ?>

            <?php else : ?>

                <div class="shortcode shortcode-products <?php echo esc_html($class) ?> ">
                    <div class="box-heading"> <?php echo esc_html($title); ?></div>
                    <div class="strip-line"></div>
                    <div class="clear"></div>
                    <p><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
                </div>


            <?php endif; ?>
            <?php if($in_tabs != 'yes'):?>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <div class="products-carousel-overflow clearfix <?php echo $class_extra ?>">
                <?php
                if ( $products->have_posts() ) : ?>

                    <div class="next next-button" id="productsCarousel<?php echo esc_html($fastor_product_featured_id); ?>_next"><span></span></div>
                    <div class="prev prev-button" id="productsCarousel<?php echo esc_html($fastor_product_featured_id); ?>_prev"><span></span></div>

                    <div class="box-heading"> <?php echo esc_html($title); ?></div>
                    <div class="strip-line"></div>
                    <div class="clear"></div>
                    <div class="products-carousel owl-carousel" id="productsCarousel<?php echo esc_html($fastor_product_featured_id); ?>">

                        <?php woocommerce_product_loop_start(false); ?>
                        <?php $i = 0; ?>
                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                            <div class="item">
                                <?php wc_get_template_part( 'content', 'product' ); ?>
                            </div>
                            <?php $i++; ?>

                        <?php endwhile; // end of the loop. ?>
                        <?php woocommerce_product_loop_end(false); ?>

                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $(document).ready(function() {
                                var owl<?php echo esc_html($fastor_product_featured_id); ?> = $("#productsCarousel<?php echo esc_html($fastor_product_featured_id); ?>");

                                $("#productsCarousel<?php echo esc_html($fastor_product_featured_id); ?>_next").click(function(){
                                    owl<?php echo esc_html($fastor_product_featured_id); ?>.trigger('owl.next');
                                    return false;
                                });

                                $("#productsCarousel<?php echo esc_html($fastor_product_featured_id); ?>_prev").click(function(){
                                    owl<?php echo esc_html($fastor_product_featured_id); ?>.trigger('owl.prev');
                                    return false;
                                });

                                owl<?php echo esc_html($fastor_product_featured_id); ?>.owlCarousel({
                                    itemsCustom : [
                                        [0, <?php echo 1; ?>],
                                        [450, <?php echo 2; ?>],
                                        [768, <?php echo 3; ?>],
                                        [1200, <?php echo esc_html($itemsperpage); ?>]
                                    ],
                                });
                            });
                        })(jQuery)
                    </script>

                <?php else : ?>

                    <div class="shortcode shortcode-products <?php echo esc_html($class) ?> ">
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                        <div class="clear"></div>
                        <p><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
                    </div>


                <?php endif; ?>
            </div>
        <?php endif;

        wp_reset_postdata();
    }
    $str = ob_get_contents();
    ob_end_clean();
    return $str;
}

function fastor_shortcode_sale_products($attr, $content = null) {

    global $fastor_settings;

    extract(shortcode_atts(array(
        "title" => '',
        'limit' => '4',
        'cols' => '1',
        'itemsperpage' => '4',
        'cats' => '',
        'view' => 'grid',
        'in_tabs' => 'no',
        'orderby' => 'date',
        'order' => 'desc',
        'class' => ''
    ), $attr));

    $class_extra = $class;

    ob_start();
    ?>

    <?php
    /**
     * Check if WooCommerce is active
     **/
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        ?>

        <?php

        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'no_found_rows' => 1,
            'posts_per_page' => $limit,
            'order' => $order == 'asc' ? 'asc' : 'desc'
        );

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',

            ),
//            array(
//                'taxonomy' => 'product_visibility',
//                'field'    => 'name',
//                'terms'    => 'outofstock',
//                'operator' => 'NOT IN',
//            )
        );

        if ($cats) {
            $cats = explode(',', $cats);
            $args['tax_query'][] =
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $cats,

                );
        }


        $product_ids_on_sale = wc_get_product_ids_on_sale();
        $product_ids_on_sale[] = 0;
        $args['post__in'] = $product_ids_on_sale;

        switch ( $orderby ) {
            case 'price' :
                $args['meta_key'] = '_price';
                $args['orderby']  = 'meta_value_num';
                break;
            case 'rand' :
                $args['orderby']  = 'rand';
                break;
            case 'sales' :
                $args['meta_key'] = 'total_sales';
                $args['orderby']  = 'meta_value_num';
                break;
            default :
                $args['orderby']  = 'date';
        }



        if ($view == 'slider')
            $carousel = true;
        else
            $carousel = false;


        $products = new WP_Query( $args );

        $fastor_product_sale_id =  rand();

        $class = 3;
        $all = $cols*$itemsperpage;
        $row = $itemsperpage;

        if($itemsperpage == 1) $class = 12;
        if($itemsperpage == 2) $class = 6;
        if($itemsperpage == 3) $class = 4;
        if($itemsperpage == 4) $class = 3;
        if($itemsperpage == 5) $class = 25;
        if($itemsperpage == 6) $class = 2;

        if($view != 'menu'):?>
            <?php if($in_tabs != 'yes'):?>
                <div class="box clearfix box-with-products box-no-advanced <?php if($carousel) { echo 'with-scroll';  } ?> <?php echo $class_extra ?>">
            <?php endif; ?>
            <?php
            if ( $products->have_posts() ) : ?>

                <?php if($carousel):?>
                <!-- Carousel nav -->
                <a class="next next-button" href="#myCarousel<?php echo esc_html($fastor_product_sale_id); ?>" id="myCarousel<?php echo esc_html($fastor_product_sale_id); ?>_next"><span></span></a>
                <a class="prev prev-button" href="#myCarousel<?php echo esc_html($fastor_product_sale_id); ?>" id="myCarousel<?php echo esc_html($fastor_product_sale_id); ?>_prev"><span></span></a>

                <script type="text/javascript">
                    (function($) {
                        $(document).ready(function() {
                            var owl<?php echo esc_html($fastor_product_sale_id); ?> = $("#myCarousel<?php echo esc_html($fastor_product_sale_id); ?> .carousel-inner");

                            $("#myCarousel<?php echo esc_html($fastor_product_sale_id); ?> .product-grid > .row").find('.col-xs-6').each(function(){
                                if($(this).text().trim() == 'undefined'){
                                    $(this).remove();
                                }
                            })

                            $("#myCarousel<?php echo esc_html($fastor_product_sale_id); ?>_next").click(function(){
                                owl<?php echo esc_html($fastor_product_sale_id); ?>.trigger('owl.next');
                                return false;
                            })
                            $("#myCarousel<?php echo esc_html($fastor_product_sale_id); ?>_prev").click(function(){
                                owl<?php echo esc_html($fastor_product_sale_id); ?>.trigger('owl.prev');
                                return false;
                            });

                            owl<?php echo esc_html($fastor_product_sale_id); ?>.owlCarousel({
                                slideSpeed : 500,
                                singleItem:true
                            });
                        });
                    })(jQuery)
                </script>

            <?php endif; ?>

            <?php if($title):?>
                <div class="box-heading"> <?php echo esc_html($title); ?></div>
                <div class="strip-line"></div>
                <div class="clear"></div>
            <?php endif; ?>
            <?php if($in_tabs != 'yes'):?>
                <div class="box-content products <?php echo $class_extra ?>">
                    <?php endif; ?>
                    <div class="box-product">
                        <div id="myCarousel<?php echo esc_html($fastor_product_sale_id); ?>" <?php if($carousel != 0) { ?>class="carousel slide"<?php } ?>>
                            <!-- Carousel items2 -->
                            <div class="carousel-inner">
                                <?php $i = 0; $row_fluid = 0; $item = 0; ?>
                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                    <?php $row_fluid++; ?>
                                    <?php if($i == 0) {
                                        $item++;
                                        echo '<div class="active item"><div class="product-grid"><div class="row">';
                                    } ?>
                                    <?php
                                    $r = $row_fluid-floor($row_fluid/$all)*$all;
                                    if($row_fluid > $all && $r == 1) {
                                        if($carousel) {
                                            echo '</div></div></div><div class="item"><div class="product-grid"><div class="row">';
                                            $item++;
                                        } else {
                                            echo '</div><div class="row">';
                                        }
                                    } else {
                                        $r = $row_fluid-floor($row_fluid/$row)*$row;
                                        if($row_fluid > $row && $r == 1) {
                                            echo '</div><div class="row">';
                                        }
                                    } ?>

                                    <div class="col-sm-<?php echo esc_html($class); ?> col-xs-6 <?php if($class == 2) { echo 'col-md-25 col-lg-2 col-sm-3 '; } if($class == 2 && $r == 0) { echo 'hidden-md hidden-sm'; } if($class == 2 && $r == 5) { echo 'hidden-sm'; } ?> <?php if($class == 25) { echo 'col-md-25 col-lg-25 col-sm-3 '; } if($class == 25 && $r == 0) { echo 'hidden-sm'; } ?>">
                                        <?php wc_get_template_part( 'content', 'product' ); ?>
                                    </div>
                                    <?php $i++; ?>

                                <?php endwhile; // end of the loop. ?>
                                <?php if($i > 0) { echo '</div></div></div>'; } ?>
                                <?php woocommerce_product_loop_end(false); ?>

                            </div>
                        </div>
                    </div>
                    <?php if($in_tabs != 'yes'):?>
                </div>
            <?php endif; ?>

            <?php else : ?>

                <div class="shortcode shortcode-products <?php echo esc_html($class) ?> ">
                    <div class="box-heading"> <?php echo esc_html($title); ?></div>
                    <div class="strip-line"></div>
                    <div class="clear"></div>
                    <p><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
                </div>


            <?php endif; ?>
            <?php if($in_tabs != 'yes'):?>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <div class="products-carousel-overflow clearfix <?php echo $class_extra ?>">
                <?php
                if ( $products->have_posts() ) : ?>

                    <div class="next next-button" id="<?php echo esc_html($fastor_product_sale_id); ?>"><span></span></div>
                    <div class="prev prev-button" id="<?php echo esc_html($fastor_product_sale_id); ?>"><span></span></div>

                    <div class="box-heading"> <?php echo esc_html($title); ?></div>
                    <div class="strip-line"></div>
                    <div class="clear"></div>
                    <div class="products-carousel owl-carousel" id="productsCarousel<?php echo esc_html($fastor_product_sale_id); ?>">

                        <?php woocommerce_product_loop_start(false); ?>

                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                            <div class="item">
                                <?php wc_get_template_part( 'content', 'product' ); ?>
                            </div>
                            <?php $i++; ?>

                        <?php endwhile; // end of the loop. ?>
                        <?php woocommerce_product_loop_end(false); ?>

                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $(document).ready(function() {
                                var owl<?php echo esc_html($fastor_product_sale_id); ?> = $("#productsCarousel<?php echo esc_html($fastor_product_sale_id); ?>");

                                $("#productsCarousel<?php echo esc_html($fastor_product_sale_id); ?>_next").click(function(){
                                    owl<?php echo esc_html($fastor_product_sale_id); ?>.trigger('owl.next');
                                    return false;
                                });

                                $("#productsCarousel<?php echo esc_html($fastor_product_sale_id); ?>_prev").click(function(){
                                    owl<?php echo esc_html($fastor_product_sale_id); ?>.trigger('owl.prev');
                                    return false;
                                });

                                owl<?php echo esc_html($fastor_product_sale_id); ?>.owlCarousel({
                                    itemsCustom : [
                                        [0, <?php echo 1; ?>],
                                        [450, <?php echo 2; ?>],
                                        [768, <?php echo 3; ?>],
                                        [1200, <?php echo esc_html($itemsperpage); ?>]
                                    ],
                                });
                            });
                        })(jQuery)
                    </script>

                <?php else : ?>

                    <div class="shortcode shortcode-products <?php echo esc_html($class) ?> ">
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                        <div class="clear"></div>
                        <p><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
                    </div>


                <?php endif; ?>
            </div>
        <?php endif;

        wp_reset_postdata();
    }
    $str = ob_get_contents();
    ob_end_clean();
    return $str;
}

function fastor_shortcode_latest_products($attr, $content = null) {

    global $fastor_settings;

    extract(shortcode_atts(array(
        "title" => '',
        'limit' => '4',
        'cols' => '1',
        'itemsperpage' => '4',
        'cats' => '',
        'view' => 'grid',
        'in_tabs' => 'no',
        'orderby' => 'date',
        'order' => 'desc',
        'class' => ''
    ), $attr));

    $class_extra = $class;

    ob_start();
    ?>

    <?php
    /**
     * Check if WooCommerce is active
     **/
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        ?>

        <?php
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'no_found_rows' => 1,
            'posts_per_page' => $limit,
            'orderby' => 'date ID',
            'order' => 'DESC'
        );

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',

            ),
//            array(
//                'taxonomy' => 'product_visibility',
//                'field'    => 'name',
//                'terms'    => 'outofstock',
//                'operator' => 'NOT IN',
//            )
        );

        if ($cats) {
            $cats = explode(',', $cats);
            $args['tax_query'][] =
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $cats,

                );
        }

        $products = new WP_Query( $args );

        $fastor_product_latest_id = rand();

        $class = 3;
        $all = $cols*$itemsperpage;
        $row = $itemsperpage;
        $carousel = $view == 'slider' ? true : false;

        if($itemsperpage == 1) $class = 12;
        if($itemsperpage == 2) $class = 6;
        if($itemsperpage == 3) $class = 4;
        if($itemsperpage == 4) $class = 3;
        if($itemsperpage == 5) $class = 25;
        if($itemsperpage == 6) $class = 2;

        if($view != 'menu'):?>

            <?php if($in_tabs != 'yes'):?>
                <div class="box clearfix box-with-products box-no-advanced <?php if($carousel) { echo 'with-scroll';  } ?> <?php echo $class_extra ?>">
            <?php endif; ?>
            <?php
            if ( $products->have_posts() ) : ?>

                <?php if($carousel):?>
                <!-- Carousel nav -->
                <a class="next next-button" href="#myCarousel<?php echo esc_html($fastor_product_latest_id); ?>" id="myCarousel<?php echo esc_html($fastor_product_latest_id); ?>_next"><span></span></a>
                <a class="prev prev-button" href="#myCarousel<?php echo esc_html($fastor_product_latest_id); ?>" id="myCarousel<?php echo esc_html($fastor_product_latest_id); ?>_prev"><span></span></a>

                <script type="text/javascript">
                    (function($) {
                        $(document).ready(function() {
                            var owl<?php echo esc_html($fastor_product_latest_id); ?> = $("#myCarousel<?php echo esc_html($fastor_product_latest_id); ?> .carousel-inner");

                            $("#myCarousel<?php echo esc_html($fastor_product_latest_id); ?> .product-grid > .row").find('.col-xs-6').each(function(){
                                if($(this).text().trim() == 'undefined'){
                                    $(this).remove();
                                }
                            })

                            $("#myCarousel<?php echo esc_html($fastor_product_latest_id); ?>_next").click(function(){
                                owl<?php echo esc_html($fastor_product_latest_id); ?>.trigger('owl.next');
                                return false;
                            })
                            $("#myCarousel<?php echo esc_html($fastor_product_latest_id); ?>_prev").click(function(){
                                owl<?php echo esc_html($fastor_product_latest_id); ?>.trigger('owl.prev');
                                return false;
                            });

                            owl<?php echo esc_html($fastor_product_latest_id); ?>.owlCarousel({
                                slideSpeed : 500,
                                singleItem: true
                            });
                        });
                    })(jQuery)
                </script>

            <?php endif; ?>

            <?php if($title):?>
                <div class="box-heading"> <?php echo esc_html($title); ?></div>
                <div class="strip-line"></div>
                <div class="clear"></div>
            <?php endif; ?>
            <?php if($in_tabs != 'yes'):?>
                <div class="box-content products <?php echo $class_extra ?>">
                    <?php endif; ?>
                    <div class="box-product">
                        <div id="myCarousel<?php echo esc_html($fastor_product_latest_id); ?>" <?php if($carousel != 0) { ?>class="carousel slide"<?php } ?>>
                            <!-- Carousel items2 -->
                            <div class="carousel-inner">
                                <?php $i = 0; $row_fluid = 0; $item = 0; ?>
                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                    <?php $row_fluid++; ?>
                                    <?php if($i == 0) {
                                        $item++;
                                        echo '<div class="active item"><div class="product-grid"><div class="row">';
                                    } ?>
                                    <?php
                                    $r = $row_fluid-floor($row_fluid/$all)*$all;
                                    if($row_fluid > $all && $r == 1) {
                                        if($carousel) {
                                            echo '</div></div></div><div class="item"><div class="product-grid"><div class="row">';
                                            $item++;
                                        } else {
                                            echo '</div><div class="row">';
                                        }
                                    } else {
                                        $r = $row_fluid-floor($row_fluid/$row)*$row;
                                        if($row_fluid > $row && $r == 1) {
                                            echo '</div><div class="row">';
                                        }
                                    } ?>

                                    <div class="col-sm-<?php echo esc_html($class); ?> col-xs-6 <?php if($class == 2) { echo 'col-md-25 col-lg-2 col-sm-3 '; } if($class == 2 && $r == 0) { echo 'hidden-md hidden-sm'; } if($class == 2 && $r == 5) { echo 'hidden-sm'; } ?> <?php if($class == 25) { echo 'col-md-25 col-lg-25 col-sm-3 '; } if($class == 25 && $r == 0) { echo 'hidden-sm'; } ?>">
                                        <?php wc_get_template_part( 'content', 'product' ); ?>
                                    </div>
                                    <?php $i++; ?>

                                <?php endwhile; // end of the loop. ?>
                                <?php if($i > 0) { echo '</div></div></div>'; } ?>
                                <?php woocommerce_product_loop_end(false); ?>

                            </div>
                        </div>
                    </div>
                    <?php if($in_tabs != 'yes'):?>
                </div>
            <?php endif; ?>

            <?php else : ?>

                <div class="shortcode shortcode-products <?php echo esc_html($class) ?> ">
                    <div class="box-heading"> <?php echo esc_html($title); ?></div>
                    <div class="strip-line"></div>
                    <div class="clear"></div>
                    <p><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
                </div>


            <?php endif; ?>

            <?php if($in_tabs != 'yes'):?>
                </div>
            <?php endif; ?>


        <?php else: ?>

            <div class="products-carousel-overflow clearfix <?php echo $class_extra ?>">
                <?php
                if ( $products->have_posts() ) : ?>

                    <div class="next next-button" id="<?php echo esc_html($fastor_product_latest_id); ?>"><span></span></div>
                    <div class="prev prev-button" id="<?php echo esc_html($fastor_product_latest_id); ?>"><span></span></div>

                    <div class="box-heading"> <?php echo esc_html($title); ?></div>
                    <div class="strip-line"></div>
                    <div class="clear"></div>
                    <div class="products-carousel owl-carousel" id="productsCarousel<?php echo esc_html($fastor_product_latest_id); ?>">

                        <?php woocommerce_product_loop_start(false); ?>

                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                            <div class="item">
                                <?php wc_get_template_part( 'content', 'product' ); ?>
                            </div>
                            <?php $i++; ?>

                        <?php endwhile; // end of the loop. ?>
                        <?php woocommerce_product_loop_end(false); ?>

                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $(document).ready(function() {
                                var owl<?php echo esc_html($fastor_product_latest_id); ?> = $("#productsCarousel<?php echo esc_html($fastor_product_latest_id); ?>");

                                $("#productsCarousel<?php echo esc_html($fastor_product_latest_id); ?>_next").click(function(){
                                    owl<?php echo esc_html($fastor_product_latest_id); ?>.trigger('owl.next');
                                    return false;
                                });

                                $("#productsCarousel<?php echo esc_html($fastor_product_latest_id); ?>_prev").click(function(){
                                    owl<?php echo esc_html($fastor_product_latest_id); ?>.trigger('owl.prev');
                                    return false;
                                });

                                owl<?php echo esc_html($fastor_product_latest_id); ?>.owlCarousel({
                                    itemsCustom : [
                                        [0, <?php echo 1; ?>],
                                        [450, <?php echo 2; ?>],
                                        [768, <?php echo 3; ?>],
                                        [1200, <?php echo esc_html($itemsperpage); ?>]
                                    ],
                                });
                            });
                        })(jQuery)
                    </script>

                <?php else : ?>

                    <div class="shortcode shortcode-products <?php echo esc_html($class) ?> ">
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                        <div class="clear"></div>
                        <p><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
                    </div>


                <?php endif; ?>
            </div>
        <?php endif;

        wp_reset_postdata();
    }
    $str = ob_get_contents();
    ob_end_clean();
    return $str;
}

// Register Shortcodes in Visual Composer Editor
if (function_exists('vc_set_as_theme')) {

    function fastor_vc_shortcode_sw_bestseller_products() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => "Bestseller Products",
            "base" => "sw_bestseller_products",
            "category" => "Fastor",
            "icon" => $vc_icon,
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => "Title",
                    "param_name" => "title",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Limit",
                    "param_name" => "limit",
                    "value" => "4",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Max rows",
                    "param_name" => "cols",
                    "value" => "1",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Items in a row",
                    "param_name" => "itemsperpage",
                    "value" => "1",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Category IDs",
                    "param_name" => "cats",
                    "value" => "",
                    "admin_label" => true
                ),
                array(
                    "type" => "view_mode",
                    "heading" => "View Mode",
                    "param_name" => "view",
                    "value" => "grid",
                    "admin_label" => true
                ),
                array(
                    "type" => "yes_no",
                    "heading" => "In tabs wrapped",
                    "param_name" => "in_tabs",
                    "value" => 'no'
                ),
                array(
                    "type" => "orderby",
                    "heading" => "Order By",
                    "param_name" => "orderby"
                ),
                array(
                    "type" => "order",
                    "heading" => "Order",
                    "param_name" => "order"
                ),
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodes' ) ) {
            class WPBakeryShortCode_Sw_Bestseller_Products extends WPBakeryShortCodes {
            }
        }
    }

    function fastor_vc_shortcode_sw_featured_products() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => "Featured Products",
            "base" => "sw_featured_products",
            "category" => "Fastor",
            "icon" => $vc_icon,
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => "Title",
                    "param_name" => "title",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Limit",
                    "param_name" => "limit",
                    "value" => "4",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Max rows",
                    "param_name" => "cols",
                    "value" => "1",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Items in a row",
                    "param_name" => "itemsperpage",
                    "value" => "1",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Category IDs",
                    "param_name" => "cats",
                    "value" => "",
                    "admin_label" => true
                ),
                array(
                    "type" => "view_mode",
                    "heading" => "View Mode",
                    "param_name" => "view",
                    "value" => "grid",
                    "admin_label" => true
                ),
                array(
                    "type" => "yes_no",
                    "heading" => "In tabs wrapped",
                    "param_name" => "in_tabs",
                    "value" => 'no'
                ),
                array(
                    "type" => "orderby",
                    "heading" => "Order By",
                    "param_name" => "orderby"
                ),
                array(
                    "type" => "order",
                    "heading" => "Order",
                    "param_name" => "order"
                ),
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodes' ) ) {
            class WPBakeryShortCode_Sw_Featured_Products extends WPBakeryShortCodes {
            }
        }
    }

    function fastor_vc_shortcode_sw_sale_products() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => "Sale Products",
            "base" => "sw_sale_products",
            "category" => "Fastor",
            "icon" => $vc_icon,
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => "Title",
                    "param_name" => "title",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Limit",
                    "param_name" => "limit",
                    "value" => "4",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Max rows",
                    "param_name" => "cols",
                    "value" => "1",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Items in a row",
                    "param_name" => "itemsperpage",
                    "value" => "1",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Category IDs",
                    "param_name" => "cats",
                    "value" => "",
                    "admin_label" => true
                ),
                array(
                    "type" => "view_mode",
                    "heading" => "View Mode",
                    "param_name" => "view",
                    "value" => "grid",
                    "admin_label" => true
                ),
                array(
                    "type" => "yes_no",
                    "heading" => "In tabs wrapped",
                    "param_name" => "in_tabs",
                    "value" => 'no'
                ),
                array(
                    "type" => "orderby",
                    "heading" => "Order By",
                    "param_name" => "orderby"
                ),
                array(
                    "type" => "order",
                    "heading" => "Order",
                    "param_name" => "order"
                ),
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodes' ) ) {
            class WPBakeryShortCode_Sw_Sale_Products extends WPBakeryShortCodes {
            }
        }
    }

    function fastor_vc_shortcode_sw_latest_products() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => "Latest Products",
            "base" => "sw_latest_products",
            "category" => "Fastor",
            "icon" => $vc_icon,
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => "Title",
                    "param_name" => "title",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Limit",
                    "param_name" => "limit",
                    "value" => "4",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Max rows",
                    "param_name" => "cols",
                    "value" => "1",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Items in a row",
                    "param_name" => "itemsperpage",
                    "value" => "1",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Category IDs",
                    "param_name" => "cats",
                    "value" => "",
                    "admin_label" => true
                ),
                array(
                    "type" => "view_mode",
                    "heading" => "View Mode",
                    "param_name" => "view",
                    "value" => "grid",
                    "admin_label" => true
                ),
                array(
                    "type" => "yes_no",
                    "heading" => "In tabs wrapped",
                    "param_name" => "in_tabs",
                    "value" => 'no'
                ),
                array(
                    "type" => "orderby",
                    "heading" => "Order By",
                    "param_name" => "orderby"
                ),
                array(
                    "type" => "order",
                    "heading" => "Order",
                    "param_name" => "order"
                ),
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodes' ) ) {
            class WPBakeryShortCode_Sw_Latest_Products extends WPBakeryShortCodes {
            }
        }
    }
}
