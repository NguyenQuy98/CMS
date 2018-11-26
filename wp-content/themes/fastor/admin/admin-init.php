<?php
// Load the TGM init if it exists
if ( file_exists( get_template_directory() . '/admin/tgm/tgm-init.php' ) ) {
    require_once get_template_directory() . '/admin/tgm/tgm-init.php';
}
// Load the theme/plugin options
if ( file_exists( get_template_directory() . '/admin/options-init.php' ) ) {
    require_once get_template_directory() . '/admin/options-init.php';
}

class Fastor_Admin {
    public function __construct() {
       add_action( 'admin_init', array( $this, 'admin_init' ) );
       // add_action( 'wp_before_admin_bar_render', array( $this, 'add_wp_toolbar_menu' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    public function add_wp_toolbar_menu() {
        if ( current_user_can( 'edit_theme_options' ) ) {
            $fastor_parent_menu_title = 'Fastor';

            $this->add_wp_toolbar_menu_item( $fastor_parent_menu_title, false, admin_url( 'admin.php?page=fastor' ), array( 'class' => 'fastor-menu' ), 'fastor' );
            $this->add_wp_toolbar_menu_item( esc_html__( 'System Status', 'fastor' ), 'fastor', admin_url( 'admin.php?page=fastor-system' ) );
            $this->add_wp_toolbar_menu_item( esc_html__( 'Plugins', 'fastor' ), 'fastor', admin_url( 'admin.php?page=fastor-plugins' ) );
            $this->add_wp_toolbar_menu_item( esc_html__( 'Install Demos', 'fastor' ), 'fastor', admin_url( 'admin.php?page=fastor-demos' ) );
            if(fastor_is_plugin_active( 'redux-framework/redux-framework.php' )){
                $this->add_wp_toolbar_menu_item( esc_html__( 'Theme Options', 'fastor' ), 'fastor', admin_url( 'admin.php?page=fastor_options' ) );
            }
        }
    }

    public function add_wp_toolbar_menu_item( $title, $parent = false, $href = '', $custom_meta = array(), $custom_id = '' ) {
        global $wp_admin_bar;
        if ( current_user_can( 'edit_theme_options' ) ) {
            if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
                return;
            }
            // Set custom ID
            if ( $custom_id ) {
                $id = $custom_id;
            } else { // Generate ID based on $title
                $id = strtolower( str_replace( ' ', '-', $title ) );
            }
            // links from the current host will open in the current window
            $meta = strpos( $href, site_url() ) !== false ? array() : array( 'target' => '_blank' ); // external links open in new tab/window
            $meta = array_merge( $meta, $custom_meta );
            $wp_admin_bar->add_node( array(
                'parent' => $parent,
                'id'     => $id,
                'title'  => $title,
                'href'   => $href,
                'meta'   => $meta,
            ) );
        }
    }


    public function admin_init() {


        // Load the TGM init if it exists
        if ( file_exists( get_template_directory() . '/admin/tgm/tgm-init.php' ) ) {
            require_once get_template_directory() . '/admin/tgm/tgm-init.php';
        }
        // Load the theme/plugin options
        if ( file_exists( get_template_directory() . '/admin/options-init.php' ) ) {
            require_once get_template_directory() . '/admin/options-init.php';
        }

        if ( current_user_can( 'edit_theme_options' ) ) {

            if ( isset( $_GET['fastor-deactivate'] ) && 'deactivate-plugin' == $_GET['fastor-deactivate'] ) {

                check_admin_referer( 'fastor-deactivate', 'fastor-deactivate-nonce' );

                $plugins = TGM_Plugin_Activation::$instance->plugins;


                foreach ( $plugins as $plugin ) {

                    if ( $plugin['slug'] == $_GET['plugin'] ) {

                        deactivate_plugins( $plugin['file_path'] );

                    }
                }


            } if ( isset( $_GET['fastor-activate'] ) && 'activate-plugin' == $_GET['fastor-activate'] ) {

                check_admin_referer( 'fastor-activate', 'fastor-activate-nonce' );


                $plugins = TGM_Plugin_Activation::$instance->plugins;


                foreach ( $plugins as $plugin ) {
                    if ( isset( $_GET['plugin'] ) && $plugin['slug'] == $_GET['plugin'] ) {

                        activate_plugin( $plugin['file_path'] );

                        wp_redirect( admin_url( 'admin.php?page=fastor-plugins' ) );

                        exit;
                    }

                }
            }
        }

        

    }


    public function admin_menu(){
        if ( current_user_can( 'edit_theme_options' ) ) {
            $add_page = str_replace('X', '_', 'addXmenuXpage');
            $add_subpage = str_replace('X', '_', 'addXsubmenuXpage');

            $welcome_screen = $add_page( 'Fastor', 'Fastor', 'administrator', 'fastor', array( $this, 'welcome_screen' ), 'dashicons-screenoptions');
            $welcome       = $add_subpage( 'fastor', esc_html__( 'Welcome', 'fastor' ), esc_html__( 'Welcome', 'fastor' ), 'administrator', 'fastor', array( $this, 'welcome_screen' ) );
            $system_status = $add_subpage( 'fastor', esc_html__( 'System Status', 'fastor' ), esc_html__( 'System Status', 'fastor' ), 'administrator', 'fastor-system', array( $this, 'system_tab' ) );
            $plugins       = $add_subpage( 'fastor', esc_html__( 'Plugins', 'fastor' ), esc_html__( 'Plugins', 'fastor' ), 'administrator', 'fastor-plugins', array( $this, 'plugins_tab' ) );
            $demos         = $add_subpage( 'fastor', esc_html__( 'Install Demos', 'fastor' ), esc_html__( 'Install Demos', 'fastor' ), 'administrator', 'fastor-demos', array( $this, 'demos_tab' ) );

            if(fastor_is_plugin_active( 'redux-framework/redux-framework.php' )){
                $theme_options = $add_subpage( 'fastor', esc_html__( 'Theme Options', 'fastor' ), esc_html__( 'Theme Options', 'fastor' ), 'administrator', 'admin.php?page=fastor_options' );
            }
        }
    }

    public function welcome_screen() {
        require_once( get_template_directory().'/admin/admin_pages/welcome.php' );
    }

    public function system_tab() {
        require_once( get_template_directory().'/admin/admin_pages/system-status.php' );
    }

    public function demos_tab() {
        require_once( get_template_directory().'/admin/admin_pages/install-demos.php' );
    }

    public function plugins_tab() {
        require_once( get_template_directory().'/admin/admin_pages/fastor-plugins.php' );
    }

    public function plugin_link( $item ) {
        $installed_plugins = get_plugins();
        $item['sanitized_plugin'] = $item['name'];
        $actions = array();
        // We have a repo plugin
        if ( ! $item['version'] ) {
            $item['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $item['slug'] );
        }
        /** We need to display the 'Install' hover link */
        if ( ! isset( $installed_plugins[$item['file_path']] ) ) {
            $actions = array(
                'install' => sprintf(
                    '<a href="%1$s" class="button button-primary" title="Install %2$s">Install</a>',
                    esc_url( wp_nonce_url(
                        add_query_arg(
                            array(
                                'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
                                'plugin'        => urlencode( $item['slug'] ),
                                'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
                                'plugin_source' => urlencode( $item['source'] ),
                                'tgmpa-install' => 'install-plugin',
                                'return_url'    => 'fastor-plugins',
                            ),
                            TGM_Plugin_Activation::$instance->get_tgmpa_url()
                        ),
                        'tgmpa-install',
                        'tgmpa-nonce'
                    ) ),
                    $item['sanitized_plugin']
                ),
            );
        }
        /** We need to display the 'Activate' hover link */
        elseif ( is_plugin_inactive( $item['file_path'] ) ) {
            $actions = array(
                'activate' => sprintf(
                    '<a href="%1$s" class="button button-primary" title="Activate %2$s">Activate</a>',
                    esc_url( add_query_arg(
                        array(
                            'plugin'               => urlencode( $item['slug'] ),
                            'plugin_name'          => urlencode( $item['sanitized_plugin'] ),
                            'plugin_source'        => urlencode( $item['source'] ),
                            'fastor-activate'       => 'activate-plugin',
                            'fastor-activate-nonce' => wp_create_nonce( 'fastor-activate' ),
                        ),
                        admin_url( 'admin.php?page=fastor-plugins' )
                    ) ),
                    $item['sanitized_plugin']
                ),
            );
        }
        /** We need to display the 'Update' hover link */
        elseif ( version_compare( $installed_plugins[$item['file_path']]['Version'], $item['version'], '<' ) ) {
            $actions = array(
                'update' => sprintf(
                    '<a href="%1$s" class="button button-primary" title="Install %2$s">Update</a>',
                    wp_nonce_url(
                        add_query_arg(
                            array(
                                'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
                                'plugin'        => urlencode( $item['slug'] ),
                                'tgmpa-update'  => 'update-plugin',
                                'plugin_source' => urlencode( $item['source'] ),
                                'version'       => urlencode( $item['version'] ),
                                'return_url'    => 'fastor-plugins',
                            ),
                            TGM_Plugin_Activation::$instance->get_tgmpa_url()
                        ),
                        'tgmpa-update',
                        'tgmpa-nonce'
                    ),
                    $item['sanitized_plugin']
                ),
            );
        } elseif ( is_plugin_active( $item['file_path'] ) ) {
            $actions = array(
                'deactivate' => sprintf(
                    '<a href="%1$s" class="button button-primary" title="Deactivate %2$s">Deactivate</a>',
                    esc_url( add_query_arg(
                        array(
                            'plugin'                 => urlencode( $item['slug'] ),
                            'plugin_name'            => urlencode( $item['sanitized_plugin'] ),
                            'plugin_source'          => urlencode( $item['source'] ),
                            'fastor-deactivate'       => 'deactivate-plugin',
                            'fastor-deactivate-nonce' => wp_create_nonce( 'fastor-deactivate' ),
                        ),
                        admin_url( 'admin.php?page=fastor-plugins' )
                    ) ),
                    $item['sanitized_plugin']
                ),
            );
        }
        return $actions;
    }

    public function let_to_num( $size ) {
        $l   = substr( $size, -1 );
        $ret = substr( $size, 0, -1 );
        switch ( strtoupper( $l ) ) {
            case 'P':
                $ret *= 1024;
            case 'T':
                $ret *= 1024;
            case 'G':
                $ret *= 1024;
            case 'M':
                $ret *= 1024;
            case 'K':
                $ret *= 1024;
        }
        return $ret;
    }


}

new Fastor_Admin();