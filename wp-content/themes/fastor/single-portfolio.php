<?php
get_header();

$fastor_optionValues = get_option( 'fastor' );
// Header type not default
 ?>
    <section class="portfolio-page">
        <?php
        $fastor_portfolioStyle = esc_attr( get_post_meta( $post->ID , 'w-single-portfolio-style' , true ) );

            while( have_posts() ) : the_post();
                // Previous/next post navigation.
                the_post_navigation( array( 'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( '' , 'fastor' ) . '</span> ' . '<span class="screen-reader-text">' . esc_html__( 'Next' , 'fastor' ) . '</span> ' . '<i class="fa fa-chevron-right"></i>' , 'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( '' , 'fastor' ) . '</span> ' . '<i class="fa fa-chevron-left"></i>' . '<span class="screen-reader-text">' . esc_html__( 'Previous' , 'fastor' ) . '</span> ' ,

                ) );
                get_template_part( 'template-parts/portfolio-single/content-portfolio-style-' . $fastor_portfolioStyle );

            endwhile;
            ?>
    </section>
<?php get_footer();
