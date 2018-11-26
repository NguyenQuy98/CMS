<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */
$product = fastor_get_product();

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews">
	<div id="review">
		<h2><?php
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) )
				printf( _n( '%s review for %s', '%s reviews for %s', $count, 'fastor' ), $count, get_the_title() );
			else
				esc_html_e( 'Reviews', 'fastor' );
		?></h2>

		<?php if ( have_comments() ) : ?>

			<div class="review-list">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</div>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'fastor' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

		<div id="review_form_wrapper">
			<div id="form-review">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'fastor' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'fastor' ), get_the_title() ),
						'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'fastor' ),
                        'title_reply_before'   => '<h2 id="reply-title" class="comment-reply-title">',
                        'title_reply_after'   => '</h2>',
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<div class="form-group required comment-form-author" style="margin-bottom: 0; margin-top: -10px"><div class="col-xs-12 col-sm-6">' . '<label class="control-label" for="author">' . esc_html__( 'Name', 'fastor' ) . '</label> ' .
							            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" class="form-control" /></div></div>',
							'email'  => '<div class="form-group required comment-form-email"><div class="col-xs-12 col-sm-6"><label class="control-label" for="email">' . esc_html__( 'Email', 'fastor' ) . '</label> ' .
							            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" class="form-control" /></div></div>',
                        ),
						'label_submit'  => esc_html__( 'Submit', 'fastor' ),
						'class_submit'  => 'btn btn-primary',
                        'submit_field'  => '<div class="form-submit  pull-right">%1$s %2$s</div><div class="clearfix"></div>',
						'logged_in_as'  => '',
						'comment_field' => ''
					);

					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( esc_html__( 'You must be <a href="%s">logged in</a> to post a review.', 'fastor' ), esc_url( $account_page_url ) ) . '</p>';
					}

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '
                                <div class="form-group required comment-form-comment">
                                <div class="col-sm-12">
                                    <label class="control-label" for="rating">' . esc_html__( 'Your Rating', 'fastor' ) .'</label>
                                    <div class="rating set-rating">
                                        <i class="fa fa-star" data-value="1"></i>
                                        <i class="fa fa-star" data-value="2"></i>
                                        <i class="fa fa-star" data-value="3"></i>
                                        <i class="fa fa-star" data-value="4"></i>
                                        <i class="fa fa-star" data-value="5"></i>
                                    </div>

                                    <div class="hidden">
                                      <input type="radio" name="rating" value="1" />
                                      &nbsp;
                                      <input type="radio" name="rating" value="2" />
                                      &nbsp;
                                      <input type="radio" name="rating" value="3" />
                                      &nbsp;
                                      <input type="radio" name="rating" value="4" />
                                      &nbsp;
                                      <input type="radio" name="rating" value="5" />
                                    </div>
                                </div>
						</div>';
					}

					$comment_form['comment_field'] .= '<div class="form-group required comment-form-comment"><div class="col-sm-12"><label class="control-label" for="input-review">' . esc_html__( 'Your Review', 'fastor' ) . '</label><textarea id="input-review" class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea></div></div>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
                <script>
                     (function($) {
                         $(document).ready(function() {
                           $('.set-rating i').hover(function(){
                               var rate = $(this).data('value');
                               var i = 0;
                               $('.set-rating i').each(function(){
                                   i++;
                                   if(i <= rate){
                                       $(this).addClass('active');
                                   }else{
                                       $(this).removeClass('active');
                                   }
                               })
                           })

                           $('.set-rating i').mouseleave(function(){
                               var rate = $('input[name="rating"]:checked').val();
                               rate = parseInt(rate);
                               i = 0;
                                 $('.set-rating i').each(function(){
                                   i++;
                                   if(i <= rate){
                                       $(this).addClass('active');
                                   }else{
                                       $(this).removeClass('active');
                                   }
                                 })
                           })

                           $('.set-rating i').click(function(){
                               $('input[name="rating"]:nth('+ ($(this).data('value')-1) +')').prop('checked', true);
                           });
                         });
                     })(jQuery)
                </script>

			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'fastor' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
