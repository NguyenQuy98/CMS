<?php

class FastorPortfolioLoader {

    public $fastor_template_name;

    public $fastor_start_point;

    public $fastor_options;

    public $fastor_limit;

    public $fastor_cat;

    public function __construct($fastor_options, $fastor_template_name , $fastor_start_point = 1, $fastor_limit = 6, $fastor_cat = '') {
        $this->fastor_options = $fastor_options;
        $this->fastor_template_name = $fastor_template_name;
        if(!$fastor_limit){
            $fastor_limit = $this->fastor_options['portfolio-limit'] ? $this->fastor_options['portfolio-limit'] : 6;
        }
        $this->fastor_limit = $fastor_limit;
        $this->fastor_start_point = $fastor_start_point * $fastor_limit;
        $this->fastor_cat = $fastor_cat;


    }

    public function load_content() {
        $fastor_args = array(
            'post_type' => 'portfolio' ,
            'posts_per_page' => $this->fastor_limit,
            'taxonomy' => 'portfolio-category',
            'offset' => $this->fastor_start_point );

        if($this->fastor_cat){
            $fastor_args['term'] = $this->fastor_cat;
        }

        $fastor_query = new WP_Query( $fastor_args );

        if( $fastor_query->have_posts() ) {
            ?>
            <div class="cbp-loadMore-block">
            <?php
            if( $this->fastor_template_name == 'portfolio-grid-1' ) {
                $fastor_counter = 0;
                while ($fastor_query->have_posts()) : $fastor_query->the_post(); ?>
                    <?php

                    $fastor_counter++;
                    $fastor_category = get_the_terms($post->ID, 'portfolio-category');
                    $fastor_terms = '';
                    for ($fastor_count = 0; $fastor_count < count($fastor_category); $fastor_count++) {
                        $fastor_terms .= esc_attr($fastor_category[$fastor_count]->slug) . ' ';
                    }
                    ?>
                    <div class="portfolio-item masonry-item <?php echo esc_attr($fastor_terms); ?> wrapper-padding"
                         style="background-image: url('<?php echo get_the_post_thumbnail_url($post->ID, 'large'); ?>')">
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
                                    for ($fastor_count = 0; $fastor_count < count($fastor_category); $fastor_count++) {
                                        if ($fastor_count != (count($fastor_category) - 1)) {
                                            ?>
                                            <span>
                                                <?php echo esc_attr($fastor_category[$fastor_count]->name) . ', '; ?></span>
                                        <?php } else { ?>
                                            <span>
                                                <?php echo esc_attr($fastor_category[$fastor_count]->name); ?></span>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile;
            } elseif( $this->fastor_template_name == 'portfolio-grid-2' ) {
                $fastor_counter = 0;
                while( $fastor_query->have_posts() ) : $fastor_query->the_post(); ?>
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
            } else if( $this->fastor_template_name == 'portfolio-masonry-1' ) {
                $fastor_counter = 0;
                 while( $fastor_query->have_posts() ) : $fastor_query->the_post(); ?>
                    <?php

                    $fastor_counter++;
                    $fastor_category = get_the_terms( $post->ID , 'portfolio-category' );
                    $fastor_terms = '';
                    for( $fastor_count = 0 ; $fastor_count < count( $fastor_category ) ; $fastor_count++ ) {
                        $fastor_terms .= esc_attr( $fastor_category[ $fastor_count ]->slug ) . ' ';
                    }
                    ?>
                    <div class="masonry-item portfolio-item <?php echo esc_attr( $fastor_terms ); ?> wrapper-padding">
                        <a href="<?php the_permalink(); ?>">
                            <div class="hover-plus">
                                <span class="icon_plus"></span>
                            </div>
                            <img
                                src="<?php echo get_the_post_thumbnail_url( $post->ID , 'large' ); ?>"
                                alt=""
                                "/>
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
            } else if( $this->fastor_template_name == 'portfolio-masonry-2' ) {
            $fastor_counter = 0;
            while( $fastor_query->have_posts() ) : $fastor_query->the_post(); ?>
            <?php

            $fastor_counter++;
            $fastor_category = get_the_terms( $post->ID , 'portfolio-category' );
            $fastor_terms = '';
            for( $fastor_count = 0 ; $fastor_count < count( $fastor_category ) ; $fastor_count++ ) {
                $fastor_terms .= esc_attr( $fastor_category[ $fastor_count ]->slug ) . ' ';
            }
            ?>
            <div class="masonry-item portfolio-item <?php echo esc_attr( $fastor_terms ); ?> wrapper-padding">
                <a href="<?php the_permalink(); ?>">
                    <div class="hover-plus">
                        <span class="icon_plus"></span>
                    </div>
                    <img
                        src="<?php echo get_the_post_thumbnail_url( $post->ID , 'large' ); ?>"
                        alt=""
                    "/>
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
            } else if( $this->fastor_template_name == 'portfolio-category-1' ) {

                while ($fastor_query->have_posts()) : $fastor_query->the_post();
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
                                <div
                                    class="<?php echo esc_attr($fastor_relative) . ' ' . esc_attr($fastor_hoverParentClass) . ' ' . esc_attr($fastor_overflow); ?>">
                                    <?php if( $fastor_options[ 'w-portfolio-hover-style' ] == 5 || $fastor_options[ 'w-portfolio-hover-style' ] == 7 || $fastor_options[ 'w-portfolio-hover-style' ] == 9 ) { ?>
                                        <div class="<?php echo esc_attr($fastor_imageStyle); ?> image-height">
                                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'fastor_image_770x570' ); ?></a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="image-height">
                                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'fastor_image_770x570' ); ?></a>
                                        </div>
                                    <?php }  ?>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php $fastor_counter++; endwhile; ?>

            <?php } ?>

            </div>
        <?php
        wp_reset_postdata();
        }
    }
}
