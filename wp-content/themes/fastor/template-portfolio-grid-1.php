<?php get_header();
/**
 * Template Name: Portfolio Grid 2 Column Template
 */
$fastor_options = fastor_get_options();
$fastor_args = array( 'post_type' => 'portfolio' , 'posts_per_page' => $fastor_options['portfolio-limit'] );
$fastor_query = new WP_Query( $fastor_args );
$fastor_counter = 0;
if( $fastor_query->have_posts() ) : ?>
    <!-- Main content start -->
    <div id="template-portfolio" <?php post_class(); ?> data-portfolio-template="portfolio-grid-1">
        <?php get_template_part( 'template-parts/portfolio-filter' ); ?>
        <div class="portfolio-list-wrapper masonry-wrapper template-portfolio-grid-1">
            <?php while( $fastor_query->have_posts() ) : $fastor_query->the_post(); ?>
                <?php

                $fastor_counter++;
                $fastor_category = get_the_terms( $post->ID , 'portfolio-category' );
                $fastor_terms = '';
                for( $fastor_count = 0 ; $fastor_count < count( $fastor_category ) ; $fastor_count++ ) {
                    $fastor_terms .= esc_attr( $fastor_category[ $fastor_count ]->slug ) . ' ';
                }
                ?>
                <div class="portfolio-item masonry-item <?php echo esc_attr( $fastor_terms ); ?> wrapper-padding" style="background-image: url('<?php echo get_the_post_thumbnail_url( $post->ID , 'large' ); ?>')">
                    <a href="<?php the_permalink(); ?>">
                        <div class="hover-plus">
                            <span class="icon_plus"></span>
                        </div>

                        <div class="hover-text">
                            <h5 class="portfolio-title">
                                <?php the_title(); ?>
                            </h5>
                            <div class="portfolio-cats">
                                <?php
                                for( $fastor_count = 0 ; $fastor_count < count( $fastor_category ) ; $fastor_count++ ) {
                                    if( $fastor_count != ( count( $fastor_category ) - 1 ) ) {
                                        ?>
                                        <span>
                                                <?php echo esc_attr( $fastor_category[ $fastor_count ]->name ) . ', '; ?></span>
                                    <?php } else { ?>
                                        <span>
                                                <?php echo esc_attr( $fastor_category[ $fastor_count ]->name ); ?></span>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile;
            wp_reset_postdata();
            ?>
        </div>
        <?php
        get_template_part( 'template-parts/load-more' );
        ?>
    </div>
    <?php
endif;
get_footer(); ?>
