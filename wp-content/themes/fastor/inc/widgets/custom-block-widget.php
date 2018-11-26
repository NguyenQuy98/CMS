<?php
add_action('widgets_init', 'fastor_custom_block_load_widgets');

function fastor_custom_block_load_widgets() {
    register_widget('Fastor_Custom_Block_Widget');
}

class Fastor_Custom_Block_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'description' => esc_html__('Add a custom block menu to your site.', 'fastor') );
        parent::__construct( 'custom_block', esc_html__('Fastor: Custom Block', 'fastor'), $widget_ops );
    }

    public function widget($args, $instance) {
        // Get menu
        $custom_block = ! empty( $instance['custom_block'] ) ? $instance['custom_block']: false;

        if ( !$custom_block )
            return;


        echo do_shortcode('[custom_block name="'.$custom_block.'"]') ;
        
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        if ( ! empty( $new_instance['title'] ) ) {
            $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
        }
        if ( ! empty( $new_instance['custom_block'] ) ) {
            $instance['custom_block'] =  $new_instance['custom_block'];
        }
        return $instance;
    }

    public function form( $instance ) {
        $custom_block_selected = isset( $instance['custom_block'] ) ? $instance['custom_block'] : '';
        $custom_blocks = array();
        $type = 'custom_block';
        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'caller_get_posts'=> 1
        );

        $my_query = null;
        $my_query = new WP_Query($args);
        if(! $my_query->have_posts() ) {
            // If no custom blocks exists, direct the user to go and create some.
            echo '<p>'. sprintf( esc_html__('No custom blocks have been created yet.', 'fastor') ) .'</p>';
            return;
        }
        
              
        while ($my_query->have_posts()){
            $my_query->the_post(); 
            $custom_blocks[] = the_title('', '', false);
        }
        wp_reset_postdata();  // Restore global post data stomped by the_post().
        
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('custom_block')); ?>"><?php esc_html_e('Select Custom Block:', 'fastor'); ?></label>
            <select id="<?php echo esc_attr($this->get_field_id('custom_block')); ?>" name="<?php echo esc_attr($this->get_field_name('custom_block')); ?>">
                <option value="0"><?php esc_html_e( '&mdash; Select &mdash;', 'fastor' ) ?></option>
                <?php
              
                  foreach ($custom_blocks as $custom_block): ?>
                    <option value="<?php echo esc_attr($custom_block) ?>" <?php echo selected( $custom_block_selected, $custom_block, false ) ?>><?php echo esc_html($custom_block); ?></option>
                    <?php
                  endforeach;
                ?>
            </select>
        </p>
    <?php
    }
}
?>
