<?php
add_action('widgets_init', 'fastor_sidebar_menu_load_widgets');

function fastor_sidebar_menu_load_widgets() {
    register_widget('Fastor_Sidebar_Menu_Widget');
}

class Fastor_Sidebar_Menu_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'description' => esc_html__('Add a sidebar menu to your sidebar.', 'fastor') );
        parent::__construct( 'sidebar_menu', esc_html__('Fastor: Sidebar Menu', 'fastor'), $widget_ops );
    }

    public function widget($args, $instance) {
        // Get menu
        $fastor_options = fastor_get_options();
        $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

        if ( !$nav_menu )
            return;

        /** This filter is documented in wp-includes/default-widgets.php */
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : esc_html($instance['title']), $instance, $this->id_base );

        ?>
        <div class="container-megamenu container vertical">
            <div id="menuHeading">
                <div class="megamenuToogle-wrapper">
                    <div class="megamenuToogle-pattern">
                        <div class="container"> <?php echo esc_html($instance['title']) ?></div>
                    </div>
                </div>
            </div>

            <div class="megamenu-wrapper">
                <div class="megamenu-pattern">
                    <div class="container">

                    <?php
                    wp_nav_menu(array(
                        'menu_class' => 'megamenu ' . esc_html($fastor_options['menu-animation-type']),
                        'menu' => $nav_menu,
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'fallback_cb' => false,
                        'walker' => new fastor_main_menuwalker()
                    ));
                    ?>
                    </div>
                </div>
            </div>
        </div>
    <?php


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
            echo '<p>'. sprintf( esc_html__('No menus have been created yet. <a href="%s">Create some</a>.', 'fastor'), esc_url(admin_url('nav-menus.php')) ) .'</p>';
            return;
        }
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'fastor') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('nav_menu')); ?>"><?php esc_html_e('Select Menu:', 'fastor'); ?></label>
            <select id="<?php echo esc_attr($this->get_field_id('nav_menu')); ?>" name="<?php echo esc_attr($this->get_field_name('nav_menu')); ?>">
                <option value="0"><?php esc_html_e( '&mdash; Select &mdash;', 'fastor' ) ?></option>
                <?php
                foreach ( $menus as $menu ) {
                    echo '<option value="' . esc_attr($menu->term_id) . '"'
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
