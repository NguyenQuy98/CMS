<?php

/**
 * TGM Init Class
 */
include_once ('class-tgm-plugin-activation.php');

function fastor_register_required_plugins() {
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        
        
        array(
            'name'                     => esc_html__('Redux Framework', 'fastor'),
            'slug'                     => 'redux-framework',
            'required'                 => true,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/redux_framework.png'
        ),

        array(
            'name'			           => esc_html__('WPBakery Visual Composer', 'fastor'),
            'slug'			           => 'js_composer',
            'source'			       => 'http://cleventhemes.net/fastor/woocommerce/plugins/js_composer.zip',
            'required'			       => true,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/visual_composer.png'
        ),

        array(
            'name'                     => esc_html__('Easy Bootstrap Shortcodes', 'fastor'),
            'slug'                     => 'easy-bootstrap-shortcodes',
            'required'                 => true,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/easy_bootstrap_shortcodes.png'
        ),

        array(
            'name'                     => esc_html__('Slider Revolution', 'fastor'),
            'slug'                     => 'revslider',
            'source'                   => 'http://cleventhemes.net/fastor/woocommerce/plugins/revslider.zip',
            'required'                 => false,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/revolution_slider.png',
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url' => '', // If set, overrides default API URL and points to an external URL
        ),


        array(
            'name'                     => esc_html__('Fastor Extra', 'fastor'),
            'slug'                     => 'fastor-extra',
            'source'			    => 'http://cleventhemes.net/fastor/woocommerce/plugins/fastor-extra.zip',
            'required'                 => true,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/fastor_extra.png',
            'version'                   => '2.0.0'
        ),


        array(
            'name'                     => esc_html__('Subscribe2', 'fastor'),
            'slug'                     => 'subscribe2',
            'required'                 => false,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/subscribe2.png',
        ),
        array(
            'name'                     => esc_html__('Contact Form 7', 'fastor'),
            'slug'                     => 'contact-form-7',
            'required'                 => false,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/contact_form_7.png'
        ),

        array(
            'name'                     => esc_html__('WooCoomerce Social Media Share Buttons ', 'fastor'),
            'slug'                     => 'woocommerce-social-media-share-buttons',
            'required'                 => false,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/social_media_share_buttons.png'

        ),
        array(
            'name'                     => esc_html__('WooCommerce', 'fastor'),
            'slug'                     => 'woocommerce',
            'required'                 => true,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/woocommerce.png'
        ),
        array(
            'name'                     => esc_html__('Yith WooCommerce Wishlist', 'fastor'),
            'slug'                     => 'yith-woocommerce-wishlist',
            'required'                 => false,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/yith_wishlist.png'
        ),
        array(
            'name'                     => esc_html__('Yith WooCommerce Compare', 'fastor'),
            'slug'                     => 'yith-woocommerce-compare',
            'required'                 => false,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/yith_compare.png'
        ),
        array(
            'name'                     => esc_html__('YITH WooCommerce Ajax Product Filter', 'fastor'),
            'slug'                     => 'yith-woocommerce-ajax-navigation',
            'required'                 => false,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/yith_ajax_product_filter.png'
        ),
        array(
            'name'                     => 'Variation Swatches',
            'slug'                     => 'woo-variation-swatches',
            'required'                 => false,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/woo_variation_swatches.png'
        ),
        array(
            'name'                     => 'Instagram Feed',
            'slug'                     => 'instagram-feed',
            'required'                 => false,
            'image_url'                => get_template_directory_uri().'/inc/plugins/images/instagram_feed.png'
        ),
//        array(
//            'name'                     => 'Regenerate Thumbnails',
//            'slug'                     => 'regenerate-thumbnails',
//            'required'                 => false,
//            'image_url'                => get_template_directory_uri().'/inc/plugins/images/regenerate_thumbnails.png'
//        ),
        
    );


    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'               => 'fastor',             // Text domain - likely want to be the same as your theme.
        'default_path'         => '',                             // Default absolute path to pre-packaged plugins
        'menu'                 => 'install-required-plugins',     // Menu slug
        'has_notices'          => true,                           // Show admin notices or not
        'is_automatic'        => false,                           // Automatically activate plugins after installation or not
        'message'             => '',                            // Message to output right before the plugins table
        'strings'              => array(
            'page_title'                                   => esc_html__( 'Install Required Plugins', 'fastor' ),
            'menu_title'                                   => esc_html__( 'Install Plugins', 'fastor' ),
            'installing'                                   => esc_html__( 'Installing Plugin: %s', 'fastor' ), // %1$s = plugin name
            'oops'                                         => esc_html__( 'Something went wrong with the plugin API.', 'fastor' ),
            'notice_can_install_required'                 => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'fastor' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'fastor' ), // %1$s = plugin name(s)
            'notice_cannot_install'                      => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'fastor' ), // %1$s = plugin name(s)
            'notice_can_activate_required'                => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'fastor' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'            => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'fastor' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                     => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'fastor' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                         => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'fastor' ), // %1$s = plugin name(s)
            'notice_cannot_update'                         => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'fastor'  ), // %1$s = plugin name(s)
            'install_link'                                   => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'fastor' ),
            'activate_link'                               => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'fastor' ),
            'return'                                       => esc_html__( 'Return to Required Plugins Installer', 'fastor' ),
            'plugin_activated'                             => esc_html__( 'Plugin activated successfully.', 'fastor' ),
            'complete'                                     => esc_html__( 'All plugins installed and activated successfully. %s', 'fastor' ), // %1$s = dashboard link
            'nag_type'                                    => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );

    tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'fastor_register_required_plugins' );
