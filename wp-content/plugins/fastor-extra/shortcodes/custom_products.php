<?php

// Products Shortcode

add_shortcode("sw_custom_products", "fastor_shortcode_custom_products");

function fastor_shortcode_custom_products($attr, $content = null) {

    $fastor_options = fastor_get_options();

    extract(shortcode_atts(array(
        "title" => '',
        'limit' => '4',
        'cats' => '',
        'type'  => 'latest',
        'layout' => 'default',
        'orderby' => 'date',
        'order' => 'desc',
        'class' => ''
    ), $attr));


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
            'order' => $order == 'inc' ? 'ASC' : 'DESC',

        );

        if($type == 'bestsellers'){
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value';
        }
        if($type == 'featured'){
            $args['meta_key'] = '_featured';
            $args['meta_value'] = 'yes';
        }
        if($type == 'sale'){

            $product_ids_on_sale = wc_get_product_ids_on_sale();
            $product_ids_on_sale[] = 0;
            $args['post__in'] = $product_ids_on_sale;
        }



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

        if($limit == 1){
            $_SESSION['DYNAMIC_IMAGE_SIZE'] = 'full';
        } ?>

        <?php
        if ( $products->have_posts() ) : ?>

            <?php if($layout == 'default'):?>

                <div class="box box-products">

                    <?php if(trim(esc_html($title))):?>
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php endif; ?>
                    <div class="box-content products">
                        <div class="clearfix" style="clear: both"><div class="advanced-grid-products">

                            <?php woocommerce_product_loop_start(false); ?>

                            <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                                <div class="product clearfix <?php if($fastor_options['product-hover-status']) { echo 'product-hover'; } ?>">
                                        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

                                    <div class="right">

                                        <?php
                                        /**
                                         * woocommerce_before_shop_loop_item_title hook
                                         *
                                         * @hooked woocommerce_show_product_loop_sale_flash - 10
                                         * @hooked woocommerce_template_loop_product_thumbnail - 10
                                         */
                                        do_action( 'woocommerce_before_shop_loop_item_title' );
                                        ?>

                                        <div class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                                        <?php
                                        /**
                                         * woocommerce_after_shop_loop_item hook
                                         *
                                         * @hooked woocommerce_template_loop_add_to_cart - 10
                                         */
                                        do_action( 'woocommerce_after_shop_loop_item' );
                                        ?>
                                    </div>
                                </div>



                            <?php endwhile; // end of the loop. ?>
                            <?php woocommerce_product_loop_end(false); ?>

                        </div>
                    </div>

                </div>
            </div>

            <?php endif; ?>



            <?php if($layout == 'today_deals'):?>
                
                <?php $fastor_product_today_delas_id =  rand(); ?>

                <div class="box today-deals box-no-advanced">
                    <a class="next" href="#myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>" id="myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>_next"><span></span></a>
                    <a class="prev" href="#myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>" id="myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>_prev"><span></span></a>

                    <?php if(trim(esc_html($title))):?>
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php endif; ?>
                    <div class="box-content products" id="myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>">
                        <div class="clearfix" style="clear: both">
                            <div class="today-deals-products owl-carousel">
                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                    <div class="clearfix item">
                                        <?php wc_get_template_part( 'content', 'product_deal' ); ?>
                                    </div>

                                <?php endwhile; // end of the loop. ?>
                                <?php woocommerce_product_loop_end(false); ?>
                            </div>
                        </div>

                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $(document).ready(function() {
                                var owl<?php echo esc_html($fastor_product_today_delas_id); ?> = $("#myCarousel_today_deals_<?php echo esc_html($fastor_product_today_delas_id); ?> .today-deals-products");

                                $("#myCarousel_today_deals_<?php echo esc_html($fastor_product_today_delas_id); ?>_next").click(function(){
                                    owl<?php echo esc_html($fastor_product_today_delas_id); ?>.trigger('owl.next');
                                    return false;
                                });

                                $("#myCarousel_today_deals_<?php echo esc_html($fastor_product_today_delas_id); ?>_prev").click(function(){
                                    owl<?php echo esc_html($fastor_product_today_delas_id); ?>.trigger('owl.prev');
                                    return false;
                                });

                                owl<?php echo esc_html($fastor_product_today_delas_id); ?>.owlCarousel({
                                    slideSpeed : 500,
                                    singleItem:true
                                });
                            });
                        })(jQuery)
                    </script>
                </div>

            <?php endif; ?>

            <?php if($layout == 'shoes3_today_deals'):?>

                <?php $fastor_product_today_delas_id =  rand(); ?>

                <div class="box today-deals-shoes3">
                    <a class="next" href="#myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>" id="myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>_next"><span></span></a>
                    <a class="prev" href="#myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>" id="myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>_prev"><span></span></a>

                    <?php if(trim(esc_html($title))):?>
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php endif; ?>
                    <div class="box-content" id="myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>">
                        <div class="clearfix" style="clear: both">
                            <div class="today-deals-shoes3-products products">
                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                    <div class="clearfix item">
                                        <?php wc_get_template_part( 'content', 'product_deal' ); ?>
                                    </div>

                                <?php endwhile; // end of the loop. ?>
                                <?php woocommerce_product_loop_end(false); ?>
                            </div>
                        </div>

                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $(document).ready(function() {
                                var owl<?php echo esc_html($fastor_product_today_delas_id); ?> = $("#myCarousel_today_deals_<?php echo esc_html($fastor_product_today_delas_id); ?> .today-deals-shoes3-products");

                                $("#myCarousel_today_deals_<?php echo esc_html($fastor_product_today_delas_id); ?>_next").click(function(){
                                    owl<?php echo esc_html($fastor_product_today_delas_id); ?>.trigger('owl.next');
                                    return false;
                                });

                                $("#myCarousel_today_deals_<?php echo esc_html($fastor_product_today_delas_id); ?>_prev").click(function(){
                                    owl<?php echo esc_html($fastor_product_today_delas_id); ?>.trigger('owl.prev');
                                    return false;
                                });

                                owl<?php echo esc_html($fastor_product_today_delas_id); ?>.owlCarousel({
                                    slideSpeed : 500,
                                    singleItem:true
                                });
                            });
                        })(jQuery)
                    </script>
                </div>

            <?php endif; ?>

            <?php if($layout == 'toys2_today_deals'):?>

                <?php $fastor_product_today_delas_id =  rand(); ?>

                <div class="box today-deals-toys2 box-no-advanced">
                    <a class="next" href="#myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>" id="myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>_next"><span></span></a>
                    <a class="prev" href="#myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>" id="myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>_prev"><span></span></a>

                    <?php if(trim(esc_html($title))):?>
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php endif; ?>
                    <div class="box-content" id="myCarousel_today_deals_<?php echo $fastor_product_today_delas_id ?>">
                        <div class="clearfix" style="clear: both">
                            <div class="today-deals-toys2-products products">
                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                    <div class="clearfix item">
                                        <?php wc_get_template_part( 'content', 'product_deal' ); ?>
                                    </div>

                                <?php endwhile; // end of the loop. ?>
                                <?php woocommerce_product_loop_end(false); ?>
                            </div>
                        </div>

                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $(document).ready(function() {
                                var owl<?php echo esc_html($fastor_product_today_delas_id); ?> = $("#myCarousel_today_deals_<?php echo esc_html($fastor_product_today_delas_id); ?> .today-deals-toys2-products");

                                $("#myCarousel_today_deals_<?php echo esc_html($fastor_product_today_delas_id); ?>_next").click(function(){
                                    owl<?php echo esc_html($fastor_product_today_delas_id); ?>.trigger('owl.next');
                                    return false;
                                });

                                $("#myCarousel_today_deals_<?php echo esc_html($fastor_product_today_delas_id); ?>_prev").click(function(){
                                    owl<?php echo esc_html($fastor_product_today_delas_id); ?>.trigger('owl.prev');
                                    return false;
                                });

                                owl<?php echo esc_html($fastor_product_today_delas_id); ?>.owlCarousel({
                                    slideSpeed : 500,
                                    singleItem:true
                                });
                            });
                        })(jQuery)
                    </script>
                </div>

            <?php endif; ?>



            <?php if($layout == 'antique'):?>

                <div class="box antique-products">

                    <?php if(trim(esc_html($title))):?>
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php endif; ?>
                    <div class="box-content products">
                        <div class="clearfix" style="clear: both"><div class="advanced-grid-products">

                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                                    <div class="product clearfix <?php if($fastor_options['product-hover-status']) { echo 'product-hover'; } ?>">
                                        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

                                        <div class="right">

                                            <?php
                                            /**
                                             * woocommerce_before_shop_loop_item_title hook
                                             *
                                             * @hooked woocommerce_show_product_loop_sale_flash - 10
                                             * @hooked woocommerce_template_loop_product_thumbnail - 10
                                             */
                                            do_action( 'woocommerce_before_shop_loop_item_title' );
                                            ?>

                                            <div class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                                            <?php
                                            /**
                                             * woocommerce_after_shop_loop_item hook
                                             *
                                             * @hooked woocommerce_template_loop_add_to_cart - 10
                                             */
                                            do_action( 'woocommerce_after_shop_loop_item' );
                                            ?>
                                        </div>
                                    </div>



                                <?php endwhile; // end of the loop. ?>
                                <?php woocommerce_product_loop_end(false); ?>

                            </div>
                        </div>

                    </div>
                </div>

            <?php endif; ?>


            <?php if($layout == 'computer4'):?>

                <div class="box antique-products computer4-products">

                    <?php if(trim(esc_html($title))):?>
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php endif; ?>
                    <div class="box-content products">
                        <div class="clearfix" style="clear: both"><div class="advanced-grid-products">

                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                                    <div class="product clearfix <?php if($fastor_options['product-hover-status']) { echo 'product-hover'; } ?>">
                                        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

                                        <div class="right">

                                            <?php
                                            /**
                                             * woocommerce_before_shop_loop_item_title hook
                                             *
                                             * @hooked woocommerce_show_product_loop_sale_flash - 10
                                             * @hooked woocommerce_template_loop_product_thumbnail - 10
                                             */
                                            do_action( 'woocommerce_before_shop_loop_item_title' );
                                            ?>

                                            <div class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                                            <?php
                                            /**
                                             * woocommerce_after_shop_loop_item hook
                                             *
                                             * @hooked woocommerce_template_loop_add_to_cart - 10
                                             */
                                            do_action( 'woocommerce_after_shop_loop_item' );
                                            ?>
                                        </div>
                                    </div>



                                <?php endwhile; // end of the loop. ?>
                                <?php woocommerce_product_loop_end(false); ?>

                            </div>
                        </div>

                    </div>
                </div>

            <?php endif; ?>

            <?php if($layout == 'sport'):?>

                <div class="box sport-products">

                    <?php if(trim(esc_html($title))):?>
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php endif; ?>
                    <div class="box-content products">
                        <div class="clearfix" style="clear: both"><div class="advanced-grid-products">

                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                                    <div class="product clearfix <?php if($fastor_options['product-hover-status']) { echo 'product-hover'; } ?>">
                                        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

                                        <div class="right">

                                            <?php
                                            /**
                                             * woocommerce_before_shop_loop_item_title hook
                                             *
                                             * @hooked woocommerce_show_product_loop_sale_flash - 10
                                             * @hooked woocommerce_template_loop_product_thumbnail - 10
                                             */
                                            do_action( 'woocommerce_before_shop_loop_item_title' );
                                            ?>

                                            <div class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                                            <?php
                                            /**
                                             * woocommerce_after_shop_loop_item hook
                                             *
                                             * @hooked woocommerce_template_loop_add_to_cart - 10
                                             */
                                            do_action( 'woocommerce_after_shop_loop_item' );
                                            ?>
                                        </div>
                                    </div>



                                <?php endwhile; // end of the loop. ?>
                                <?php woocommerce_product_loop_end(false); ?>

                            </div>
                        </div>

                    </div>
                </div>

            <?php endif; ?>

            <?php if($layout == 'games_grey'):?>

                <div class="box antique-products games-products grey">

                    <?php if(trim(esc_html($title))):?>
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php endif; ?>
                    <div class="box-content products">
                        <div class="clearfix" style="clear: both"><div class="advanced-grid-products">

                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                                    <div class="product clearfix <?php if($fastor_options['product-hover-status']) { echo 'product-hover'; } ?>">
                                        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

                                        <div class="right">

                                            <?php
                                            /**
                                             * woocommerce_before_shop_loop_item_title hook
                                             *
                                             * @hooked woocommerce_show_product_loop_sale_flash - 10
                                             * @hooked woocommerce_template_loop_product_thumbnail - 10
                                             */
                                            do_action( 'woocommerce_before_shop_loop_item_title' );
                                            ?>

                                            <div class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                                            <?php
                                            /**
                                             * woocommerce_after_shop_loop_item hook
                                             *
                                             * @hooked woocommerce_template_loop_add_to_cart - 10
                                             */
                                            do_action( 'woocommerce_after_shop_loop_item' );
                                            ?>
                                        </div>
                                    </div>



                                <?php endwhile; // end of the loop. ?>
                                <?php woocommerce_product_loop_end(false); ?>

                            </div>
                        </div>

                    </div>
                </div>

            <?php endif; ?>


            <?php if($layout == 'games_green'):?>

                <div class="box antique-products games-products green">

                    <?php if(trim(esc_html($title))):?>
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php endif; ?>
                    <div class="box-content products">
                        <div class="clearfix" style="clear: both"><div class="advanced-grid-products">

                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                                    <div class="product clearfix <?php if($fastor_options['product-hover-status']) { echo 'product-hover'; } ?>">
                                        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

                                        <div class="right">

                                            <?php
                                            /**
                                             * woocommerce_before_shop_loop_item_title hook
                                             *
                                             * @hooked woocommerce_show_product_loop_sale_flash - 10
                                             * @hooked woocommerce_template_loop_product_thumbnail - 10
                                             */
                                            do_action( 'woocommerce_before_shop_loop_item_title' );
                                            ?>

                                            <div class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                                            <?php
                                            /**
                                             * woocommerce_after_shop_loop_item hook
                                             *
                                             * @hooked woocommerce_template_loop_add_to_cart - 10
                                             */
                                            do_action( 'woocommerce_after_shop_loop_item' );
                                            ?>
                                        </div>
                                    </div>



                                <?php endwhile; // end of the loop. ?>
                                <?php woocommerce_product_loop_end(false); ?>

                            </div>
                        </div>

                    </div>
                </div>

            <?php endif; ?>



            <?php if($layout == 'games_orange'):?>

                <div class="box antique-products games-products orange">

                    <?php if(trim(esc_html($title))):?>
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php endif; ?>
                    <div class="box-content products">
                        <div class="clearfix" style="clear: both"><div class="advanced-grid-products">

                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                                    <div class="product clearfix <?php if($fastor_options['product-hover-status']) { echo 'product-hover'; } ?>">
                                        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

                                        <div class="right">

                                            <?php
                                            /**
                                             * woocommerce_before_shop_loop_item_title hook
                                             *
                                             * @hooked woocommerce_show_product_loop_sale_flash - 10
                                             * @hooked woocommerce_template_loop_product_thumbnail - 10
                                             */
                                            do_action( 'woocommerce_before_shop_loop_item_title' );
                                            ?>

                                            <div class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                                            <?php
                                            /**
                                             * woocommerce_after_shop_loop_item hook
                                             *
                                             * @hooked woocommerce_template_loop_add_to_cart - 10
                                             */
                                            do_action( 'woocommerce_after_shop_loop_item' );
                                            ?>
                                        </div>
                                    </div>



                                <?php endwhile; // end of the loop. ?>
                                <?php woocommerce_product_loop_end(false); ?>

                            </div>
                        </div>

                    </div>
                </div>

            <?php endif; ?>


            <?php if($layout == 'fashion2'):?>

                <div class="box fashion2-products">

                    <?php if(trim(esc_html($title))):?>
                        <div class="box-heading"> <?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php endif; ?>
                    <div class="box-content products">
                        <div class="clearfix" style="clear: both"><div class="advanced-grid-products">

                                <?php woocommerce_product_loop_start(false); ?>

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                                    <div class="product clearfix <?php if($fastor_options['product-hover-status']) { echo 'product-hover'; } ?>">
                                        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

                                        <div class="right">

                                            <?php
                                            /**
                                             * woocommerce_before_shop_loop_item_title hook
                                             *
                                             * @hooked woocommerce_show_product_loop_sale_flash - 10
                                             * @hooked woocommerce_template_loop_product_thumbnail - 10
                                             */
                                            do_action( 'woocommerce_before_shop_loop_item_title' );
                                            ?>

                                            <div class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                                            <?php
                                            /**
                                             * woocommerce_after_shop_loop_item hook
                                             *
                                             * @hooked woocommerce_template_loop_add_to_cart - 10
                                             */
                                            do_action( 'woocommerce_after_shop_loop_item' );
                                            ?>
                                        </div>
                                    </div>



                                <?php endwhile; // end of the loop. ?>
                                <?php woocommerce_product_loop_end(false); ?>

                            </div>
                        </div>

                    </div>
                </div>

            <?php endif; ?>


            <?php if($layout == 'architecture'):?>
                <?php

                $class = 3;
                $all = 4;

                if($limit == 1) $class = 12;
                if($limit == 2) $class = 6;
                if($limit == 3) $class = 4;
                if($limit == 4) $class = 3;
                if($limit == 5) $class = 25;
                if($limit == 6) $class = 2;

                ?>

                <div class="box clearfix box-with-products <?php if(trim($title) == ''): ?>without-heading<?php endif; ?>">

                    <?php if($title != ''): ?>
                    <div class="box-heading"> <?php echo esc_html($title); ?></div>
                    <div class="strip-line"></div>
                    <?php endif; ?>

                    <div class="clear"></div>

                    <div class="box-content">
                        <div class="architecture-products">

                            <div class="carousel-inner">
                                <?php
                                $i = 0;
                                $row_fluid = 0;
                                $item = 0;
                                while ( $products->have_posts() ) : $products->the_post(); ?>
                                    <?php $row_fluid++; ?>
                                    <?php if($i == 0) {
                                        $item++; echo '<div class="active item"><div class="row">';
                                    } ?>
                                    <?php

                                    $r=$row_fluid-floor($row_fluid/$all)*$all;
                                    if($row_fluid>$all && $r == 1) {
                                        echo '</div><div class="row">';
                                    } ?>

                                    <div class="col-sm-<?php echo esc_html($class); ?> col-xs-6 <?php if($class == 2) { echo 'col-md-25 col-lg-2 col-sm-3 '; } if($class == 2 && $r == 0) { echo 'hidden-md hidden-sm'; } if($class == 2 && $r == 5) { echo 'hidden-sm'; } ?> <?php if($class == 25) { echo 'col-md-25 col-lg-25 col-sm-3 '; } if($class == 25 && $r == 0) { echo 'hidden-sm'; } ?>">
                                        <?php wc_get_template_part( 'content', 'product' ); ?>
                                    </div>

                                    <?php $i++; endwhile; ?>

                                <?php if($i > 0) { echo '</div></div>'; } ?>
                            </div>

                        </div>

                    </div>
                </div>

            <?php endif; ?>



            <?php if($layout == 'products_grid'):?>

                <?php
                $fastor_products_id =  rand();

                $class = 3;
                $all = 4;

                if($limit == 1) $class = 12;
                if($limit == 2) $class = 6;
                if($limit == 3) $class = 4;
                if($limit == 4) $class = 3;
                if($limit == 5) $class = 25;
                if($limit == 6) $class = 2;

                ?>


                <div class="box clearfix box-with-products <?php if($title == '') { echo 'without-heading'; } ?> <?php echo esc_html($class) ?>">
                    <?php if($title != '') { ?>
                        <div class="box-heading"><?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php } ?>
                    <div class="clear"></div>
                    <div class="box-content products">
                        <div class="box-product">
                            <div id="myCarousel<?php echo $fastor_products_id; ?>">
                                <!-- Carousel items -->
                                <div class="carousel-inner">
                                    <?php
                                    $i = 0;
                                    $row_fluid = 0;
                                    $item = 0;
                                    while ( $products->have_posts() ) : $products->the_post(); ?>
                                        <?php $row_fluid++; ?>
                                        <?php if($i == 0) {
                                            $item++; echo '<div class="active item"><div class="product-grid"><div class="row">';
                                        } ?>
                                        <?php

                                        $r=$row_fluid-floor($row_fluid/$all)*$all;
                                        if($row_fluid>$all && $r == 1) {
                                            echo '</div><div class="row">';
                                        } ?>

                                        <div class="col-sm-<?php echo esc_html($class); ?> col-xs-6 <?php if($class == 2) { echo 'col-md-25 col-lg-2 col-sm-3 '; } if($class == 2 && $r == 0) { echo 'hidden-md hidden-sm'; } if($class == 2 && $r == 5) { echo 'hidden-sm'; } ?> <?php if($class == 25) { echo 'col-md-25 col-lg-25 col-sm-3 '; } if($class == 25 && $r == 0) { echo 'hidden-sm'; } ?>">
                                            <?php wc_get_template_part( 'content', 'product' ); ?>
                                        </div>

                                        <?php $i++; endwhile; ?>

                                    <?php if($i > 0) { echo '</div></div></div>'; } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>


            <?php if($layout == 'products_grid_with_carousel'):?>
                <?php
                $fastor_products_id =  rand();

                $class = 3;
                $all = 4;

                if($limit == 1) $class = 12;
                if($limit == 2) $class = 6;
                if($limit == 3) $class = 4;
                if($limit == 4) $class = 3;
                if($limit == 5) $class = 25;
                if($limit == 6) $class = 2;

                ?>


                <div class="box clearfix box-with-products products-grid-with-carousel <?php if($title == '') { echo 'without-heading-type-2'; } ?> <?php echo esc_html($class) ?>">
                    <?php if($title != '') { ?>
                        <div class="box-heading"><?php echo esc_html($title); ?></div>
                        <div class="strip-line"></div>
                    <?php } ?>
                    <div class="clear"></div>
                    <div class="box-content products">
                        <div class="box-product">
                            <div id="myCarousel<?php echo $fastor_products_id; ?>">
                                <!-- Carousel items -->
                                <div class="owl-carousel">
                                    <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                    <div class="item">
                                        <div class="product-grid">
                                            <?php wc_get_template_part( 'content', 'product' ); ?>
                                        </div>
                                    </div>
                                    <?php $i++; endwhile; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                 <script type="text/javascript">
                (function($) {
                    $(document).ready(function() {

                        $('#myCarousel<?php echo esc_html($fastor_products_id); ?> .owl-carousel').owlCarousel({
                            <?php if(is_rtl()): ?>
                            direction: 'rtl'
                            <?php endif; ?>
                         });
                    });
                 })(jQuery)
                 </script>

            <?php endif; ?>


        <?php else : ?>

            <div class="shortcode shortcode-products <?php echo esc_html($class) ?> ">
                <div class="box-heading"> <?php echo esc_html($title); ?></div>
                <div class="strip-line"></div>
                <div class="clear"></div>
                <p><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
            </div>

        <?php endif; ?>

    <?php

        wp_reset_postdata();
    }

    if($limit == 1){
        unset($_SESSION['DYNAMIC_IMAGE_SIZE']);
    }
    $str = ob_get_contents();
    ob_end_clean();
    return $str;
}

// Register Shortcodes in Visual Composer Editor
if (function_exists('vc_set_as_theme')) {

    function fastor_vc_shortcode_sw_custom_products() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => "Custom Products",
            "base" => "sw_custom_products",
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
                    "heading" => "Category IDs",
                    "param_name" => "cats",
                    "value" => "",
                    "admin_label" => true
                ),
                array(
                    "type" => "products_type",
                    "heading" => "Product type",
                    "param_name" => "type",
                    "value" => "latest",
                    "admin_label" => true
                ),
                array(
                    "type" => "products_layout_type",
                    "heading" => "Layout",
                    "param_name" => "layout",
                    "value" => "default",
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
            class WPBakeryShortCode_Sw_Custom_Products extends WPBakeryShortCodes {
            }
        }
    }

}
