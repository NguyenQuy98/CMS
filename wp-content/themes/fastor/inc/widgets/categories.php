<?php
add_action('widgets_init', 'fastor_categories_load_widgets');

function fastor_categories_load_widgets() {
  if ( class_exists( 'WP_Widget_Categories' ) ) {
    register_widget( 'Fastor_WP_Widget_Categories' );
  }
}


class Fastor_WP_Widget_Categories extends WP_Widget_Categories {
    
    
    public function widget( $args, $instance ) {

        $args['before_widget'] = '<div class="widget box box-with-categories category-box-type-2 blog-module"> <div class="box-heading">';
        $args['after_title'] = '
        </div><div class="strip-line"></div>
        <div class="box-content box-category">
        ';
        parent::widget($args, $instance);
    }
	
}
?>
