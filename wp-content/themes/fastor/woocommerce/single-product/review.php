<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$rating   = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

?>
<div itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="review-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

			<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) : ?>

				<?php
                $rating = get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true );
                ?>
                <div class="star-rating rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" ><meta content="<?php echo $rating; ?>" itemprop="ratingValue" />
                    <span class="star" data-value="<?php echo esc_attr($rating) ?>" data-toggle="tooltip" data-title="<?php echo $rating ?>">
                        <?php 
                        $count = 0;
                        for ($i = 0; $i < (int)$rating; $i++) {
                            $count++;
                            echo '<i class="fa fa-star active"></i>';
                        }
                        for ($i = $count; $i < 5; $i++) {
                            $count++;
                            echo '<i class="fa fa-star"></i>';
                        } ?>
                    </span>
                </div>

			<?php endif; ?>

			<?php do_action( 'woocommerce_review_before_comment_meta', $comment ); ?>

			<?php if ( $comment->comment_approved == '0' ) : ?>

				<p class="meta"><em><?php esc_html_e( 'Your comment is awaiting approval', 'fastor' ); ?></em></p>

			<?php else : ?>

				<div class="meta">
                    <div class="author" itemprop="author"><strong><?php comment_author(); ?></strong></div> <?php

						if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' )
							if ( $verified )
								echo '<em class="verified">(' . esc_html__( 'verified owner', 'fastor' ) . ')</em> ';

					?>&ndash; <time itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php echo get_comment_date( wc_date_format() ); ?></time>:
				</div>

			<?php endif; ?>

			<?php do_action( 'woocommerce_review_before_comment_text', $comment ); ?>

				<div itemprop="description" class="text">		
                    <div class="avatar-wrapper">
                        <?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '' ); ?>
                    </div>
                    <div class="comment-content">
                        <?php comment_text(); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

			<?php do_action( 'woocommerce_review_after_comment_text', $comment ); ?>

    </div>
</div>
