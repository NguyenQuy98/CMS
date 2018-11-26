<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fastor
 */

?>

<section class="no-results not-found">

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p style="padding-top: 30px"><?php printf( wp_kses( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'fastor', array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p style="padding-top: 30px"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fastor' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p style="padding-top: 30px"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fastor' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
