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

    <?php if($fastor_options['blog-article_list_template'] != 'fastor'): ?>
        <div class="posts posts-wrap <?php echo esc_attr($wrap_class) ?> <?php echo esc_attr($fastor_options['blog-article_list_template']); ?> <?php if($fastor_options['blog-article_list_template'] == 'grid' || $fastor_options['blog-article_list_template'] == 'grid_3_columns'): ?> posts-grid <?php endif; ?> <?php if($fastor_options['blog-article_list_template'] == 'grid_3_columns'): ?> posts-3-columns-grid <?php endif; ?> clearfix">

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

                            <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <ul class="meta">

                                <li>
                                    <?php
                                    $date_format = get_option( 'date_format' );
                                    echo get_the_time($date_format, get_the_ID());
                                    ?>
                                </li>
                                <?php if(get_the_author_posts_link()):?>
                                    <li class="post-author">
                                        <?php echo esc_html__('By', 'fastor'); ?> <span><?php the_author_posts_link(); ?></span>
                                    </li>
                                <?php endif; ?>
                                <?php if(has_category()):?>
                                <li class="post-categories">
                                    <?php echo esc_html__( 'In', 'fastor' ); ?>: <?php the_category('&nbsp;'); ?>
                                </li>
                                <?php endif; ?>
                            </ul>

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
        <div class="posts <?php echo esc_attr($wrap_class) ?>">
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
                $classes = '  postWrapper post ';
                ?>

                <div <?php post_class($post_class . $classes); ?>>
                    <?php if(get_the_post_thumbnail_url()):?>
                        <div class="post-media">
                            <?php the_post_thumbnail(); ?>
                        </div><!-- .post-thumbnail -->
                    <?php endif; ?>

                    <div class="title-blog"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></div>
                    <div class="postDetails">
                        <?php printf( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'fastor' ), number_format_i18n( get_comments_number() ) )?>
                        <?php if(get_the_author_posts_link()):?>
                            <span class="post-author">
                                | <?php echo esc_html__('By', 'fastor'); ?> <span><?php the_author_posts_link(); ?></span>
                            </span>
                        <?php endif; ?>
                        <div class="create-time"><?php echo get_the_time('d/m/Y G:i', get_the_ID()); ?></div>
                    </div>
                    <div class="postContent"><?php echo fastor_excerpt( ); ?></div>
                    <div class="bookmark-blog"></div>
                    <div class="readmore"><a class="readmore-post" href="<?php the_permalink(); ?>"><span><?php esc_html__( 'Read more', 'fastor' ) ?></span></a></div>
                </div>
                <?php
                $prev_post_timestamp = $post_timestamp;
                $prev_post_month = $post_month;
                $post_count++;
            endwhile; ?>
        </div>
    <?php endif; ?>

    <?php fastor_pagination($pages = '', $range = 2); ?>
    <?php wp_reset_postdata(); ?>


<?php else : ?>

    <?php get_template_part( 'template-parts/content', 'none' ); ?>

<?php endif; ?>

<?php get_footer() ?>


