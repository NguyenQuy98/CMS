<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fastor
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="box box-no-advanced comments">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
        <div class="box-heading">
            <?php
            printf( _nx( 'Comment (1)', 'Comments (%1$s)', get_comments_number(), 'comments title', 'fastor' ),
                number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
        </div>
        <div class="strip-line"></div>
        
        <div class="box-content">

            <div class="comments-list">
                <?php
                    wp_list_comments( array(
                        'style'      => 'div',
                        'short_ping'  => true,
                        'avatar_size' => 60,
                        'callback' => 'fastor_comment'
                    ) );
                ?>
            </div><!-- .comment-list -->

            <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'fastor' ); ?></h2>
                <div class="nav-links">

                    <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'fastor' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'fastor' ) ); ?></div>

                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-below -->
            <?php endif; // Check for comment navigation. ?>
        </div>
	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'fastor' ); ?></p>
	<?php endif; ?>
        
        
    <div class="box box-no-advanced leave-reply" id="reply-block">
	<?php comment_form(); ?>
    </div>

</div><!-- #comments -->
