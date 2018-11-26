<?php
add_action('widgets_init', 'fastor_product_categories_load_widgets');

function fastor_product_categories_load_widgets() {
  if ( class_exists( 'WC_Widget_Product_Categories' ) ) {
    unregister_widget( 'WC_Widget_Product_Categories' );
    register_widget( 'Fastor_WC_Widget_Product_Categories' );
  }
}


class Fastor_WC_Widget_Product_Categories extends WC_Widget_Product_Categories {
    
    
    public function widget( $args, $instance ) {
        $fastor_options = fastor_get_options();
        $extra_class = '';
        if($fastor_options['advanced-settings-header-categorybox-style'] == 2){
            $extra_class = 'category-box-type-2 category-box-type-3';
        }
        if($fastor_options['advanced-settings-header-categorybox-style'] == 3){
            $extra_class = 'category-box-type-2 category-box-type-4';
        }
        if($fastor_options['advanced-settings-header-categorybox-style'] == 1){
            $extra_class = 'category-box-type-2';
        }
        $args['before_widget'] = '<div class="widget box box-with-categories box-no-advanced '.$extra_class.'"> <div class="box-heading">';
        $args['after_title'] = '
        </div><div class="strip-line"></div>
        <div class="box-content box-category">
        ';
        parent::widget($args, $instance);
    }
	
}
?>
