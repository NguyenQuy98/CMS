<?php get_header() ?>

<?php
$fastor_options = fastor_get_options();

?>


<?php wp_reset_postdata(); ?>
<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>

<?php if (have_posts()) : the_post(); ?>
<?php
$slideshow_type = get_post_meta($post->ID, 'slideshow_type', true);
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?> class="post">
    <div class="post-entry">
        <?php if(get_the_post_thumbnail_url()):?>
        <div class="post-media">
            <?php the_post_thumbnail(); ?>
        </div>
        <?php endif; ?>

        <div class="post-content clearfix">

            <?php the_content(); ?>

            <?php wp_link_pages(array(
                'before'    =>  '<div class="pagination-post text-center">',
                'after'     =>  '</div>',
                'link_before'   =>  '<span>',
                'link_after'    =>  '</span>'
            )); ?>
        </div>
        <ul class="meta">
            <?php if(get_the_author_link()):?>
                <li><?php echo esc_html__('By', 'fastor'); ?> <?php the_author_posts_link(); ?></li>
            <?php endif; ?>
            <li>
                <span class="month">
                    <?php echo get_the_time('M', get_the_ID()); ?>
                </span>
                <span class="day">
                    <?php echo get_the_time('d', get_the_ID()); ?>
                </span>
                <span class="day">
                    <?php echo get_the_time('Y', get_the_ID()); ?>
                </span>
            </li>
            <li class="post-categories">
                <span><?php echo esc_html__( 'Category', 'fastor' ); ?>:</span> <?php the_category(',&nbsp;'); ?>
            </li>
            <li><?php comments_popup_link(esc_html__('0 Comments', 'fastor'), esc_html__('1 Comment', 'fastor'), '% '.esc_html__('Comments', 'fastor')); ?></li>
        </ul>


        <?php $tags_list = get_the_tag_list( ' ', esc_html__( ' ', 'fastor' ) );
        if ( $tags_list ) {
            echo '<div class="tags" style="padding-bottom: 20px">';
            printf( esc_html__( '%1$s ', 'fastor' ), $tags_list ); // WPCS: XSS OK.
            echo '</div>';
        }
        ?>

         <?php if(the_author_meta("description") != ''): ?>
        <div class="blog-post-author">
            <div class="media">
                <a href="#" class="photo">
                     <?php echo get_avatar(get_the_author_meta('email'), '145'); ?>
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo esc_html__('About the Author:', 'fastor'); ?> <?php the_author_posts_link(); ?></h4>
                    <div class="desc"><?php the_author_meta("description"); ?></div>
                </div>
            </div>
        </div>
         <?php endif; ?>

        <?php
            wp_reset_postdata();
            comments_template();
        ?>
    </div>


</div>

<?php endif; ?>

<?php get_footer() ?>
