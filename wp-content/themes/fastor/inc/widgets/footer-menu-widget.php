<?php
add_action('widgets_init', 'fastor_footer_menu_load_widgets');

function fastor_footer_menu_load_widgets() {
    register_widget('Fastor_Footer_Menu_Widget');
}

class Fastor_Footer_Menu_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'description' => esc_html__('Add a footer menu to your footer.', 'fastor') );
        parent::__construct( 'footer_menu', esc_html__('Fastor: Footer Menu', 'fastor'), $widget_ops );
    }

    public function widget($args, $instance) {
        // Get menu
        $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

        if ( !$nav_menu )
            return;

        /** This filter is documented in wp-includes/default-widgets.php */
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo $args['before_widget'];

        if ( !empty($instance['title']) )
            echo $args['before_title'] . $instance['title'] . '<span class="toggle"></span>' . $args['after_title'];


        wp_nav_menu( array(
            'menu' => $nav_menu,
            'container' => '',
            'menu_class' => '',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'fallback_cb' => false,
        ) );


        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        if ( ! empty( $new_instance['title'] ) ) {
            $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
        }
        if ( ! empty( $new_instance['nav_menu'] ) ) {
            $instance['nav_menu'] = (int) $new_instance['nav_menu'];
        }
        return $instance;
    }

    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

        // Get menus
        $menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );

        // If no menus exists, direct the user to go and create some.
        if ( !$menus ) {
            echo '<p>'. sprintf( esc_html__('No menus have been created yet. <a href="%s">Create some</a>.', 'fastor'), esc_url(admin_url('nav-menus.php') )) .'</p>';
            return;
        }
        ?>
        <p>
            <label for="<?php echo esc_html($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'fastor') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_html($this->get_field_id('title')); ?>" name="<?php echo esc_html($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_html($this->get_field_id('nav_menu')); ?>"><?php esc_html_e('Select Menu:', 'fastor'); ?></label>
            <select id="<?php echo esc_html($this->get_field_id('nav_menu')); ?>" name="<?php echo esc_html($this->get_field_name('nav_menu')); ?>">
                <option value="0"><?php esc_html_e( '&mdash; Select &mdash;', 'fastor' ) ?></option>
                <?php
                foreach ( $menus as $menu ) {
                    echo '<option value="' . $menu->term_id . '"'
                        . selected( $nav_menu, $menu->term_id, false )
                        . '>'. esc_html( $menu->name ) . '</option>';
                }
                ?>
            </select>
        </p>
    <?php
    }
}
?>
