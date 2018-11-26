<?php

$fastor_options = fastor_get_options();

$fastor_counter = 1;

if( have_posts() ) : ?>

    <!-- Main content start -->
    <div class="portfolio-category">
        <div id="template-portfolio" <?php post_class(); ?>
             data-portfolio-template="portfolio-category-1"
             data-portfolio-category="<?php echo get_queried_object()->slug; ?>"
             data-portfolio-limit="<?php echo get_option( 'posts_per_page' ) ?>">
            <div class="container wl-row4">
                <div class="row portfolio-category-list-wrapper">
                        <?php
                        while( have_posts() ) : the_post();
                            $fastor_category = get_the_terms( $post->ID , 'portfolio-category' );
                            $fastor_terms = '';
                            for( $fastor_count = 0 ; $fastor_count < count( $fastor_category ) ; $fastor_count++ ) {
                                $fastor_terms .= $fastor_category[ $fastor_count ]->slug . ' ';
                            }
                            ?>
                            <div class="portfolio-item <?php echo esc_attr($fastor_terms); ?> <?php if( $fastor_counter % 2 == 0 ) {
                                echo 'inverse';
                            } ?>">
                                <div class="wl-nomalmargin-bottom column-2">
                                    <div
                                        class="col-md-4 col-sm-6 col-xs-12 wl-sibling-hover-1 <?php if( $fastor_counter % 2 == 0 ) {
                                            echo 'pull-right';
                                        } ?>">
                                        <div class="wl-height1 wl-full-width">
                                            <?php if( $fastor_counter % 2 != 0 ) { ?>
                                                <div class="style-6-left-text">
                                                    <a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5>
                                                    </a>
                                                    <div class="wl-regular-text">
                                                        <div class="portfolio-excerpt">
                                                            <?php echo $post->post_excerpt ?>
                                                        </div>
                                                        <div class="portfolio-cats">
                                                            <?php
                                                            for( $fastor_count = 0 ; $fastor_count < count( $fastor_category ) ; $fastor_count++ ) {
                                                                if( $fastor_count != ( count( $fastor_category ) - 1 ) ) {
                                                                    ?>
                                                                    <a href="<?php echo get_term_link( $fastor_category[ $fastor_count ]->term_id , 'portfolio-category' ) ?>">
                                                                        <?php echo esc_attr($fastor_category[ $fastor_count ]->name) . ', '; ?></a>
                                                                <?php } else { ?>
                                                                    <a href="<?php echo get_term_link( $fastor_category[ $fastor_count ]->term_id , 'portfolio-category' ) ?>">
                                                                        <?php echo esc_attr($fastor_category[ $fastor_count ]->name); ?></a>
                                                                <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="icon-more left hidden-xs">
                                                    <a href="<?php the_permalink(); ?>" data-icon=&#x24;></a>
                                                </div>
                                            <?php } else { ?>

                                                <div class="style-6-left-text text-right">
                                                    <a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5>
                                                    </a>
                                                    <div class="wl-regular-text">
                                                        <div class="portfolio-excerpt">
                                                            <?php echo $post->post_excerpt ?>
                                                        </div>
                                                        <div class="portfolio-cats">
                                                            <?php
                                                            for( $fastor_count = 0 ; $fastor_count < count( $fastor_category ) ; $fastor_count++ ) {
                                                                if( $fastor_count != ( count( $fastor_category ) - 1 ) ) {
                                                                    ?>
                                                                    <a href="<?php echo get_term_link( $fastor_category[ $fastor_count ]->term_id , 'portfolio-category' ); ?>">
                                                                        <?php echo esc_attr($fastor_category[ $fastor_count ]->name) . ', '; ?></a>
                                                                <?php } else { ?>
                                                                    <a href="<?php echo get_term_link( $fastor_category[ $fastor_count ]->term_id , 'portfolio-category' ); ?>">
                                                                        <?php echo esc_attr($fastor_category[ $fastor_count ]->name); ?></a>
                                                                <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="icon-more right hidden-xs">
                                                    <a href="<?php the_permalink(); ?>" data-icon=&#x23;></a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-6 col-xs-12 wl-sibling-hover-2">
                                        <div>
                                                <div class="image-height">
                                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'fastor_image_770x570' ); ?></a>
                                                </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php $fastor_counter++; endwhile; ?>
                </div>
                <?php

                get_template_part( 'template-parts/load-more' );

                ?>

            </div>
        </div>
    </div>
<?php endif; ?>
