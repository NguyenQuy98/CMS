<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package Fastor
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function fastor_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'fastor_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function fastor_jetpack_setup
add_action( 'after_setup_theme', 'fastor_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function fastor_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function fastor_infinite_scroll_render
