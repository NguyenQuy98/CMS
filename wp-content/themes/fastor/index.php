<?php get_header() ?>

<?php if ( have_posts() ) : ?>

    <?php
    $fastor_options = fastor_get_options();

    $post_layout = esc_attr($fastor_options['layout-type-single-post']);
    $blog_layout = esc_attr($fastor_options['layout-type-blog']);

    $post_layout = (isset($_GET['layout-type-single-post'])) ? esc_attr($_GET['layout-type-single-post']) : $post_layout;
    $blog_layout = (isset($_GET['layout-type-blog'])) ? esc_attr($_GET['layout-type-blog']) : $blog_layout;

    $wrap_class = '';
    $post_class = 'post';

    if($fastor_options['blog-article_list_template'] == 'grid_3_columns'){
        $post_class .= ' post-with-3-columns ';
    }

    ?>


        <?php if($fastor_options['blog-article_list_template'] != 'featured_grid_3_columns'): ?>

        <div class="posts posts-wrap
                            <?php echo esc_attr($wrap_class) ?> <?php echo esc_attr($fastor_options['blog-article_list_template']); ?>
                            <?php if($fastor_options['blog-article_list_template'] == 'grid' || $fastor_options['blog-article_list_template'] == 'grid_3_columns'): ?> posts-grid <?php endif; ?>
                            <?php if($fastor_options['blog-article_list_template'] == 'grid_3_columns'): ?> posts-3-columns-grid <?php endif; ?>
                             clearfix">





            <?php
            $post_count = 1;
            $prev_post_timestamp = null;
            $prev_post_month = null;
            $first_timeline_loop = false;
            while (have_posts()) : the_post();
                $post_timestamp = strtotime($post->post_date);
                $post_month = date('n', $post_timestamp);
                $post_year = get_the_date('o');
                $current_date = get_the_date('o-n');
                $slideshow_type = get_post_meta($post->ID, 'slideshow_type', true);
                $classes = ' post-item';
                ?>

                <?php if ($post_layout == 'grid') : ?>
                    <?php
                    if (($blog_layout == 'left-sidebar' || $blog_layout == 'right-sidebar'))
                        $classes .= ' col-md-6 col-sm-12';
                    else
                        $classes .= ' col-md-4 col-sm-6 col-xs-12';
                    ?>
                <?php endif; ?>

                <?php if ($post_layout == 'timeline') : ?>
                    <?php
                    if (($blog_layout == 'left-sidebar' || $blog_layout == 'right-sidebar'))
                        $classes .= ' col-md-6 col-sm-12'.($post_count % 2 == 1?' align-left':' align-right');
                    else
                        $classes .= ' col-sm-6 col-xs-12'.($post_count % 2 == 1?' align-left':' align-right');
                    ?>
                <?php endif; ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class($post_class . $classes . ' clearfix'); ?>>
                    <div class="post-content">

                        <?php if(get_the_post_thumbnail_url()):?>
                            <div class="post-media">
                                <?php the_post_thumbnail(); ?>
                            </div><!-- .post-thumbnail -->
                        <?php endif; ?>

                        <div class="post-text">
                            <?php $tags_list = get_the_tag_list( '', esc_html__( '', 'fastor' ) );
                            if ( $tags_list ) {
                                echo '<div class="tags">';
                                printf( '<span class="tags-links">' . esc_html__( '%1$s', 'fastor' ) . '</span>', $tags_list ); // WPCS: XSS OK.
                                echo '</div>';
                            }

                            ?>
                            <div class="date-published"><?php echo get_the_date(); ?></div>

                            <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>



                            <div class="post-description">
                                <?php
                                echo fastor_excerpt( );
                                ?>
                            </div>
                        </div>

                    </div>

                </div>

                <?php
                $prev_post_timestamp = $post_timestamp;
                $prev_post_month = $post_month;
                $post_count++;
            endwhile;
            ?>
        </div>

    <?php else: ?>

        <div class="posts posts-wrap
                                <?php echo esc_attr($wrap_class) ?> <?php echo esc_attr($fastor_options['blog-article_list_template']); ?>
                                 news v1 row clearfix">


            <?php
            $post_count = 1;
            $prev_post_timestamp = null;
            $prev_post_month = null;
            $first_timeline_loop = false;

            while (have_posts()) : the_post();
            $post_timestamp = strtotime($post->post_date);
            $post_month = date('n', $post_timestamp);
            $post_year = get_the_date('o');
            $current_date = get_the_date('o-n');
            $slideshow_type = get_post_meta($post->ID, 'slideshow_type', true);
            $classes = ' post-item';

            if($post_count == 1): ?>
            <div class="big-news post">
                <div class="post-content" onclick="window.location.href = '<?php the_permalink(); ?>'">
                    <?php if(get_the_post_thumbnail_url()):?>
                        <div class="post-media">
                            <?php the_post_thumbnail( 'full'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="right">
                        <div class="overflow">

                            <?php $tags_list = get_the_tag_list( '', esc_html__( '', 'fastor' ) );
                            if ( $tags_list ) {
                                echo '<div class="tags">';
                                printf( '<span class="tags-links">' . esc_html__( '%1$s', 'fastor' ) . '</span>', $tags_list ); // WPCS: XSS OK.
                                echo '</div>';
                            }

                            ?>
                            <div class="date-published"><?php echo get_the_date(); ?></div>

                            <h2 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <div class="post-description">
                                <?php
                                echo fastor_excerpt( );
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        <?php if(wp_count_posts()->publish > 1): ?>
            <div class="news v1 clearfix">
                <?php endif; ?>

                <?php else: ?>


                    <?php if ($post_layout == 'timeline') : ?>
                        <?php
                        if (($blog_layout == 'left-sidebar' || $blog_layout == 'right-sidebar'))
                            $classes .= ' col-md-6 col-sm-12'.($post_count % 2 == 1?' align-left':' align-right');
                        else
                            $classes .= ' col-sm-6 col-xs-12'.($post_count % 2 == 1?' align-left':' align-right');
                        ?>
                    <?php endif; ?>
                    <div class="col-sm-4 col-xs-6">
                        <div id="post-<?php the_ID(); ?>" <?php post_class($post_class . $classes . ' clearfix'); ?>>
                            <div class="media">

                                <?php if(get_the_post_thumbnail_url()):?>
                                    <div  class="thumb-holder">
                                        <?php the_post_thumbnail( 'fastor_blog_home_page_thumb'); ?>
                                    </div><!-- .post-thumbnail -->
                                <?php endif; ?>

                                <div class="media-body" onclick="window.location.href = '<?php the_permalink(); ?>'">
                                    <?php $tags_list = get_the_tag_list( '', esc_html__( '', 'fastor' ) );
                                    if ( $tags_list ) {
                                        echo '<div class="tags">';
                                        printf( esc_html__( '%1$s', 'fastor' ), $tags_list ); // WPCS: XSS OK.
                                        echo '</div>';
                                    } ?>

                                    <div class="bottom">
                                        <div class="date-published"><?php echo get_the_date(); ?></div>
                                        <h5><?php the_title() ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

                <?php
                $prev_post_timestamp = $post_timestamp;
                $prev_post_month = $post_month;
                $post_count++;
                endwhile;

                ?>
                <?php if(wp_count_posts()->publish > 1): ?>
            </div>
        <?php endif; ?>
        </div>

    <?php endif; ?>


    <?php fastor_pagination($pages = '', $range = 2); ?>
    <?php wp_reset_postdata(); ?>


<?php endif; ?>

<?php get_footer() ?>

