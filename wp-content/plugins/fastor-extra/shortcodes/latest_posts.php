<?php
  
// Custom Block
add_shortcode('latest_posts', 'fastor_shortcode_latest_posts');

function fastor_shortcode_latest_posts($atts, $content = null) {
    
    extract(shortcode_atts(array(
        'title' => '',
        'limit' => 3,
        'layout_type' => 'default',
        'class' => '',
    ), $atts));
    

    
    ob_start();

    $title = ( ! empty( $title ) ) ? $title : __( 'Recent Posts', 'fastor' );

    $r = new WP_Query( apply_filters( 'widget_posts_args', array(
        'posts_per_page'      => $limit,
        'no_found_rows'       => true,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true
    ) ) );


    if ($r->have_posts()) :

        if($layout_type == 'default'):?>
        <div class="box blog-style box-no-advanced">
            <div class="box-heading"><?php echo $title; ?></div>
            <div class="strip-line"></div>
            <div class="box-content">
                    <div id="fastor_blog_home_page" class="owl_carousel">
                        <?php while ( $r->have_posts() ) : $r->the_post();?>
                            <div class="item">
                                <div class="blog-item">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'medium_large'); ?>
                                    </a>

                                    <div class="main-post">
                                        <h3 class="title-post"><a href="<?php the_permalink(); ?>"><?php echo get_the_title() ? the_title() : the_ID(); ?></a></h3>
                                        <span class="main-post-inner">
                                   <span class="date-post"><i aria-hidden="true" class="icon_table"></i> <?php echo get_the_date(); ?></span>
                                   <span class="comment-post"><i aria-hidden="true" class="icon_comment_alt"></i> <?php printf( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'textdomain' ), number_format_i18n( get_comments_number() ) )?></span>
                              </span>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
            </div>
        </div>

        <script type="text/javascript">
            (function($) {
                $(document).ready(function() {
                    $("#fastor_blog_home_page").owlCarousel({
                        items : 3,
                        itemsCustom : false,
                        itemsDesktop : [1199,3],
                        itemsDesktopSmall : [991,2],
                        itemsTablet: [768,2],
                        itemsTabletSmall: false,
                        itemsMobile : [479,1],
                        <?php if(is_rtl()): ?>
                        direction: 'rtl'
                        <?php endif; ?>
                    });
                });
            })(jQuery)
        </script>


        <?php endif; ?>


        <?php if($layout_type == 'home_page'):?>
        <div class="box blog-module box-no-advanced">
            <div class="box-heading"><?php echo $title; ?></div>
            <div class="strip-line"></div>
            <div class="box-content">
                <div id="fastor_blog_home_page" class="news v1 row">
                    <?php while ( $r->have_posts() ) : $r->the_post();?>
                        <div class="col-sm-3 col-xs-6">
                            <div class="media">
                                <?php if ( has_post_thumbnail() ): ?>
                                    <div  class="thumb-holder">
                                        <?php the_post_thumbnail( 'fastor_blog_home_page_thumb'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="media-body" onclick="window.location.href = '<?php the_permalink(); ?>'">
                                    <?php $tags_list = get_the_tag_list( '', esc_html__( '', 'fastor' ) );
                                    if ( $tags_list ) {
                                        echo '<div class="tags">';
                                        printf( '<span class="tags-links">' . esc_html__( '%1$s', 'fastor' ) . '</span>', $tags_list ); // WPCS: XSS OK.
                                        echo '</div>';
                                    }
                                    ?>

                                    <div class="bottom">
                                        <div class="date-published"><?php echo get_the_date(); ?></div>
                                        <h5><?php echo get_the_title() ? the_title() : the_ID(); ?></h5>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <?php endif; ?>


        <?php if ($layout_type == 'home_page_wine'): ?>

        <div class="box blog-module box-with-products box-no-advanced">
            <div class="box-heading"><?php echo $title; ?></div>
            <div class="clear"></div>
            <div class="box-content">
                    <div class="wine-news row">
                        <?php while ( $r->have_posts() ) : $r->the_post();?>
                            <div class="col-sm-4 col-xs-12">
                                <div class="media clearfix">
                                    <div class="media-body">
                                        <div class="bottom">
                                            <div class="date-published"><?php echo get_the_date(); ?></div>
                                            <div class="post-title"><a href="<?php the_permalink(); ?>"><?php echo get_the_title() ? the_title() : the_ID(); ?></a></div>
                                            <div class="post-description">
                                                <?php the_excerpt() ?>
                                            </div>
                                            <a href="<?php the_permalink(); ?>" class="button-more"><?php echo __( 'Read more', 'fastor' ) ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($layout_type == 'home_page_cosmetics'): ?>

        <div class="box blog-module box-with-products box-no-advanced">
            <div class="box-heading"><?php echo $title; ?></div>
            <div class="strip-line"></div>
            <div class="box-content">
                <div class="cosmetics-news row">
                    <?php while ( $r->have_posts() ) : $r->the_post();?>
                        <div class="col-sm-6 col-xs-12">
                            <div class="media clearfix">
                                    <div  class="thumb-holder">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'fastor_blog_home_page_cosmetics_thumb'); ?>
                                        </a>
                                    </div>

                                <div class="media-body">
                                    <?php $tags_list = get_the_tag_list( '', esc_html__( '', 'fastor' ) ); ?>
                                    <?php if ( $tags_list ):?>
                                        <div class="tags">
                                        <?php printf( esc_html__( '%1$s', 'fastor' ) , $tags_list ); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="bottom">
                                        <div class="date-published"><?php echo get_the_date(); ?></div>
                                        <h5><a href="<?php the_permalink(); ?>"><?php echo get_the_title() ? the_title() : the_ID(); ?></a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($layout_type == 'home_page_cameras'): ?>

        <div class="box blog-module box-with-products box-no-advanced">
            <div class="box-heading"><?php echo $title; ?></div>
            <div class="strip-line"></div>
            <div class="box-content">
                <div class="cameras-news row">
                    <?php while ( $r->have_posts() ) : $r->the_post();?>
                        <div class="col-sm-6 col-xs-12">
                            <div class="media clearfix">
                                    <div  class="thumb-holder">
                                        <?php $tags_list = get_the_tag_list( '', esc_html__( '', 'fastor' ) ); ?>
                                        <?php if ( $tags_list ):?>
                                            <div class="tags">
                                                <?php printf( esc_html__( '%1$s', 'fastor' ) , $tags_list ); ?>
                                            </div>
                                        <?php endif; ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'fastor_blog_home_page_cameras_thumb'); ?>
                                        </a>
                                    </div>

                                <div class="media-body">

                                    <div class="bottom">
                                        <div class="date-published"><?php echo get_the_date(); ?></div>
                                        <div class="post-title">
                                            <a href="<?php the_permalink(); ?>"><?php echo get_the_title() ? the_title() : the_ID(); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($layout_type == 'home_page_medic'): ?>

        <div class="box blog-module box-with-products box-no-advanced">
            <div class="box-heading"><?php echo $title; ?></div>
            <div class="clear"></div>
            <div class="box-content">
                <div class="medic-news row">
                    <?php while ( $r->have_posts() ) : $r->the_post();?>
                        <div class="col-sm-6 col-xs-12">
                            <div class="media clearfix">

                                <div  class="thumb-holder">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'fastor_blog_home_page_thumb'); ?>
                                    </a>
                                </div>

                                <div class="media-body">
                                    <div class="bottom">
                                        <div class="date-published"><?php echo get_the_date(); ?></div>
                                        <h5><a href="<?php the_permalink(); ?>"><?php echo get_the_title() ? the_title() : the_ID(); ?></a></h5>
                                        <div class="post-description">
                                            <?php the_excerpt() ?>
                                        </div>
                                        <a href="<?php the_permalink(); ?>" class="button"><?php echo __( 'Read more', 'fastor' ) ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($layout_type == 'footer_list'): ?>

                <h2 class="title"><span><?php echo $title; ?></span></h2>
                <ul>
                    <?php while ( $r->have_posts() ) : $r->the_post();?>
                        <li class="news-item">
                           <a href="<?php the_permalink(); ?>"><?php echo get_the_title() ? the_title() : the_ID(); ?></a>
                        </li>
                    <?php endwhile; ?>
                </ul>
        <?php endif; ?>

        <?php

        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

    endif;

    $str = ob_get_contents();
    ob_end_clean();
    
    return $str;
}

// Register Shortcodes in Visual Composer Editor
if (function_exists('vc_set_as_theme')) {

    function fastor_vc_shortcode_latest_posts() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => "Latest posts",
            "base" => "latest_posts",
            "category" => "Fastor",
            "icon" => $vc_icon,
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => "Title",
                    "param_name" => "title"
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Limit",
                    "param_name" => "limit"
                ),
                array(
                    "type" => "posts_layout_type",
                    "heading" => "Layout type",
                    "param_name" => "layout_type",
                    "value" => "default",
                ),

                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodes' ) ) {
            class WPBakeryShortCode_Custom_Block extends WPBakeryShortCodes {
            }
        }
    }
}

