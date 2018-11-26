<?php
add_action('widgets_init', 'fastor_product_recently_viewed_widgets');

function fastor_product_recently_viewed_widgets() {
  if ( class_exists( 'WC_Widget_Recently_Viewed' ) ) {
    unregister_widget( 'WC_Widget_Recently_Viewed' );
    register_widget( 'Fastor_WC_Widget_Recently_Viewed' );
  }
}


class Fastor_WC_Widget_Recently_Viewed extends WC_Widget_Recently_Viewed {


	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {

		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
		$viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

		if ( empty( $viewed_products ) ) {
			return;
		}

		ob_start();

		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];

	    $query_args = array( 'posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product', 'post__in' => $viewed_products, 'orderby' => 'rand' );

		$query_args['meta_query']   = array();
	    $query_args['meta_query'][] = WC()->query->stock_status_meta_query();
	    $query_args['meta_query']   = array_filter( $query_args['meta_query'] );

		$r = new WP_Query( $query_args );

		if ( $r->have_posts() ) {

			$this->widget_start( $args, $instance );

			echo '<div class="product_list_widget products"><div class="box-product"><div class="product-grid">';

			while ( $r->have_posts() ) {
				$r->the_post();
				wc_get_template( 'content-widget-product.php', array( 'show_rating' => true ) );
			}

			echo '</div></div></div>';

			$this->widget_end( $args );
		}

		wp_reset_postdata();

		$content = ob_get_clean();

		echo $content;
	}
}
?>
