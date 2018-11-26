<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fastor
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'fastor', array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fastor' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php fastor_entry_footer(); ?>

</article><!-- #post-## -->
