<?php


    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
 
    // This is your option name where all the Redux data is stored.
    $opt_name = "fastor_options";
    
    $skins = array();

    $fastor_skins = json_decode(get_option('fastor_skins'), true);
    $fastor_skin_active = get_option('fastor_skin_active');

    if($fastor_skins){

        foreach($fastor_skins as $skin){
            $skins[$skin] = $skin;
        }
    }


/**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'opt_name' => 'fastor_options',
        'use_cdn' => TRUE,
        'display_name' => 'Fastor Options',
        'display_version' => '2.0.0',
        'page_title' => 'Fastor Options',
        'update_notice' => FALSE,
        'disable_tracking' => TRUE,
        'admin_bar' => TRUE,

        'templates_path' => get_template_directory() .'/admin/theme_options/redux-framework/templates/panel',
        'allow_sub_menu' => TRUE,
        'page_parent_post_type' => 'your_post_type',
        'menu_type' => 'submenu',
        'menu_title' => 'Fastor Options',
        'page_parent'       => 'themes.php',
        'page_icon'         => 'icon-themes',
        'page_slug'         => 'fastor_options',
        'customizer' => TRUE,
        'default_mark' => '*',
        'hints' => array(
            'icon' => 'el el-question',
            'icon_position' => 'right',
            'icon_size' => 'normal',
            'tip_style' => array(
                'color' => 'light',
            ),
            'tip_position' => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect' => array(
                'show' => array(
                    'duration' => '500',
                    'event' => 'mouseover',
                ),
                'hide' => array(
                    'duration' => '500',
                    'event' => 'mouseleave unfocus',
                ),
            ),
        ),
        'output' => TRUE,
        'output_tag' => TRUE,
        'settings_api' => TRUE,
        'cdn_check_time' => '1440',
        'compiler' => TRUE,
        'page_permissions' => 'edit_theme_options',
        'save_defaults' => TRUE,
        'show_import_export' => TRUE,
        'database' => 'options',
        'transient_time' => '3600',
        'network_sites' => TRUE,
        'dev_mode' => FALSE,
    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.


    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

/*
 * ---> START HELP TABS
 */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__( 'Theme Information 1', 'fastor' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'fastor' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__( 'Theme Information 2', 'fastor' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'fastor' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'fastor' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


 
    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START Fields
  
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'General settings', 'fastor' ),
        'id'               => 'general',
        'desc'             => esc_html__( 'These are really basic fields!', 'fastor' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-icon-cogs'
    ) );
    
    
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Layout', 'fastor' ),
        'id'         => 'general-layout',
        'desc'       => esc_html__( 'Basic options regarding website layout', 'fastor'  ) ,
        'subsection' => true,
        'fields'     => array(

            array(
                'id'       => 'layout-responsive',
                'type'     => 'switch',
                'title'    => esc_html__( 'Responsive', 'fastor' ),
                'subtitle' => esc_html__( 'Responsive website', 'fastor' ),
                'default'  => true,
            ),

            array(
                'id'       => 'layout-page-width',
                'type'     => 'select',
                'title'    => esc_html__( 'Page width', 'fastor' ),
                'subtitle' => esc_html__( 'Set the maximum page width', 'fastor' ),
                'options'  => array(
                    '1' => 'Wide (1220px)',
                    '2' => 'Narrow (980px)',
                    '3' => 'Custom width',
                ),
                'default'  => '1'
            ),

            array(
                'id'       => 'layout-page-width-custom-value',
                'type'     => 'text',
                'title'    => esc_html__( 'Max page width', 'fastor' ),
                'required' => array( 'layout-page-width', '=', 3 )
            ),

            array(
                'id'       => 'layout-spacing_between_columns',
                'type'     => 'select',
                'title'    => esc_html__( 'Spacing between columns', 'fastor' ),
                'subtitle' => esc_html__( 'Set the space between columns', 'fastor' ),
                'options'  => array(
                    '1' => 'Default (30px)',
                    '2' => 'Type 2 (20px)',
                ),
                'default'  => '1'
            ),

            array(
                'id'=>'layout-type',
                'type' => 'image_select',
                'compiler'=>true,
                'title' => 'Main Layout',
                'options' => array(
                    'fullwidth' => array('alt' => 'Full Width', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cr.png')
                ),
                'default' => 'left-sidebar'
           ),
            
            array(
                'id'=>'layout-type',
                'type' => 'image_select',
                'compiler'=>true,
                'title' => 'Main Layout',
                'options' => array(
                    'fullwidth' => array('alt' => 'Full Width', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cr.png')
                ),
                'default' => 'left-sidebar'
            ),
            array(
                'id'=>'layout-type-home',
                'type' => 'image_select',
                'compiler'=>true,
                'title' => 'Homepage layout',
                'options' => array(
                    'fullwidth' => array('alt' => 'Full Width', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cr.png')
                ),
                'default' => 'fullwidth'
            ),
            
            array(
                'id'=>'layout-type-blog',
                'type' => 'image_select',
                'compiler'=>true,
                'title' => 'Blog Layout',
                'options' => array(
                    'fullwidth' => array('alt' => 'Full Width', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cr.png')
                ),
                'default' => 'left-sidebar'
            ),
            
            
            array(
                'id'=>'layout-type-single-post',
                'type' => 'image_select',
                'compiler'=>true,
                'title' => 'Single Post Layout',
                'options' => array(
                    'fullwidth' => array('alt' => 'Full Width', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cr.png')
                ),
                'default' => 'left-sidebar'
            ),

            array(
                'id'=>'layout-type-portfolio',
                'type' => 'image_select',
                'compiler'=>true,
                'title' => 'Portfolio list Layout',
                'options' => array(
                    'fullwidth' => array('alt' => 'Full Width', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cr.png')
                ),
                'default' => 'fullwidth'
            ),


            array(
                'id'=>'layout-type-single-portfolio',
                'type' => 'image_select',
                'compiler'=>true,
                'title' => 'Single Portfolio Layout',
                'options' => array(
                    'fullwidth' => array('alt' => 'Full Width', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cr.png')
                ),
                'default' => 'fullwidth'
            ),

            
             array(
                'id'=>'layout-type-woocategory',
                'type' => 'image_select',
                'compiler'=>true,
                'title' => 'WooCommerce Category Layout',
                'options' => array(
                    'fullwidth' => array('alt' => 'Full Width', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cr.png')
                ),
                'default' => 'left-sidebar'
            ),
            
            array(
                'id'=>'layout-type-wooproduct',
                'type' => 'image_select',
                'compiler'=>true,
                'title' => 'WooCommerce Product Layout',
                'options' => array(
                    'fullwidth' => array('alt' => 'Full Width', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cr.png')
                ),
                'default' => 'fullwidth'
            ),




            array(
                'id'       => 'layout-logotype',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Logotype', 'fastor' ),
                'compiler' => 'true',
                'subtitle' => esc_html__( 'Logotype used in header', 'fastor' ),
            ),
            array(
                'id'       => 'layout-favicon',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Favicon', 'fastor' ),
                'compiler' => 'true',
            ),

            array(
                'id'       => 'layout-breadcrumb-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Breadcrumb background', 'fastor' ),
                'compiler' => 'true',
                'subtitle' => esc_html__( 'background used in breadcrumb', 'fastor' ),
            ),
            array(
                'id'       => 'layout-breadcrumb-background-blog',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Blog breadcrumb background', 'fastor' ),
                'compiler' => 'true',
                'subtitle' => esc_html__( 'background used in breadcrumb', 'fastor' ),
            ),
            array(
                'id'       => 'layout-breadcrumb-background-single-post',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Single post breadcrumb background', 'fastor' ),
                'compiler' => 'true',
                'subtitle' => esc_html__( 'background used in breadcrumb', 'fastor' ),
            ),
            array(
                'id'       => 'layout-breadcrumb-background-portfolio',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Portfolio breadcrumb background', 'fastor' ),
                'compiler' => 'true',
                'subtitle' => esc_html__( 'background used in breadcrumb', 'fastor' ),
            ),
            array(
                'id'       => 'layout-breadcrumb-background-single-portfolio',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Single portfolio breadcrumb background', 'fastor' ),
                'compiler' => 'true',
                'subtitle' => esc_html__( 'background used in breadcrumb', 'fastor' ),
            ),
            array(
                'id'       => 'layout-breadcrumb-background-woocategory',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'WooCategory breadcrumb background', 'fastor' ),
                'compiler' => 'true',
                'subtitle' => esc_html__( 'background used in breadcrumb', 'fastor' ),
            ),
            array(
                'id'       => 'layout-breadcrumb-background-wooproduct',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Product breadcrumb background', 'fastor' ),
                'compiler' => 'true',
                'subtitle' => esc_html__( 'background used in breadcrumb', 'fastor' ),
            ),


            array(
                'id'       => 'layout-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Layout types', 'fastor' ),
                'subtitle' => esc_html__( 'Set layout type for main parts of website', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'layout-main',
                'type'     => 'select',
                'title'    => esc_html__( 'Main layout', 'fastor' ),
                'subtitle' => esc_html__( 'Mainlayout main type', 'fastor' ),
                'options'  => array(
                    '1' => 'Full width',
                    '2' => 'Boxed',
                    '7' => 'Boxed type 2',
                    '3' => 'Boxed with shadow',
                    '4' => 'Boxed without background',
                    '5' => 'Boxed without background type 2',
                    '6' => 'Boxed without background type 3',
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'layout-top-bar',
                'type'     => 'select',
                'title'    => esc_html__( 'Top bar layout', 'fastor' ),
                'subtitle' => esc_html__( 'Top bar layout main type', 'fastor' ),
                'options'  => array(
                    '1' => 'Full width',
                    '2' => 'Boxed',
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'layout-header',
                'type'     => 'select',
                'title'    => esc_html__( 'Header layout', 'fastor' ),
                'subtitle' => esc_html__( 'Header layout main type', 'fastor' ),
                'options'  => array(
                    '1' => 'Full width',
                    '2' => 'Boxed',
                    '3' => 'Boxed type 2',
                    '4' => 'Boxed type 3',
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'layout-slideshow',
                'type'     => 'select',
                'title'    => esc_html__( 'Slideshow layout', 'fastor' ),
                'subtitle' => esc_html__( 'Slideshow layout main type', 'fastor' ),
                'options'  => array(
                    '1' => 'Full width',
                    '2' => 'Boxed',
                    '3' => 'Boxed type 2',
                    '4' => 'Boxed type 3',
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'layout-breadcrumb',
                'type'     => 'select',
                'title'    => esc_html__( 'Breadcrumb layout', 'fastor' ),
                'subtitle' => esc_html__( 'Breadcrumb layout main type', 'fastor' ),
                'options'  => array(
                    '1' => 'Full width',
                    '2' => 'Boxed',
                    '3' => 'Boxed type 2',
                    '4' => 'Boxed type 3',
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'layout-content',
                'type'     => 'select',
                'title'    => esc_html__( 'Content layout', 'fastor' ),
                'subtitle' => esc_html__( 'Content layout main type', 'fastor' ),
                'options'  => array(
                    '1' => 'Full width',
                    '2' => 'Boxed',
                    '3' => 'Boxed type 2',
                    '4' => 'Boxed type 3',
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'layout-custom-footer',
                'type'     => 'select',
                'title'    => esc_html__( 'Custom footer layout', 'fastor' ),
                'subtitle' => esc_html__( 'Custom footer layout main type', 'fastor' ),
                'options'  => array(
                    '1' => 'Full width',
                    '2' => 'Boxed',
                    '3' => 'Boxed type 2',
                    '4' => 'Boxed type 3',
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'layout-footer',
                'type'     => 'select',
                'title'    => esc_html__( 'Footer layout', 'fastor' ),
                'subtitle' => esc_html__( 'Footer layout main type', 'fastor' ),
                'options'  => array(
                    '1' => 'Full width',
                    '2' => 'Boxed',
                    '3' => 'Boxed type 2',
                    '4' => 'Boxed type 3',
                ),
                'default'  => '1'
            ),
            array(
                'id'     => 'layout-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

        )
    ) );

    
    
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Blog', 'fastor' ),
        'id'         => 'general-blog',
        'desc'       => esc_html__( 'Basic options regarding blog layout', 'fastor' ) ,
        'subsection' => true,
        'fields'     => array(

            array(
                'id'       => 'blog-slideshow-type',
                'type'     => 'select',
                'title'    => esc_html__( 'Slider Type', 'fastor' ),
                'options'  => array(
                    'custom_block' => 'Custom Block',
                    'revslider' => 'Revolution Slider',
                ),
                'default'  => 'block'
            ),
            
            array(
                'id'       => 'blog-slideshow-revslider',
                'type'     => 'select',
                'title'    => 'Revolution slider',
                'options'  => fastor_revslider_list(),
                'required' => array( 'blog-slideshow-type', '=', 'revslider' )
            ),
            
            array(
                'id'       => 'blog-slideshow-custom_block',
                'type'     => 'text',
                'title'    => 'Custom Block name',
                'required' => array( 'blog-slideshow-type', '=', 'custom_block' )
            ),
            

            array(
                'id'       => 'blog-article_list_template',
                'type'     => 'select',
                'title'    => esc_html__( 'Article list template', 'fastor' ),
                'options'  => array(
                    'default' => 'Default',
                    'grid' => 'Grid',
                    'grid_3_columns' => 'Grid with 3 columns',
                    'featured_grid_3_columns' => 'Featured + grid with 3 columns',
                ),
                'default'  => 'fastor'
            ),
        )
    ));

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Portfolio', 'fastor' ),
        'id'         => 'general-portfolio',
        'desc'       => esc_html__( 'Basic options regarding portfolio layout', 'fastor' ) ,
        'subsection' => true,
        'fields'     => array(

//            array(
//                'id'       => 'portfolio-slideshow-type',
//                'type'     => 'select',
//                'title'    => esc_html__( 'Slider Type', 'fastor' ),
//                'options'  => array(
//                    'custom_block' => 'Custom Block',
//                    'revslider' => 'Revolution Slider',
//                ),
//                'default'  => 'block'
//            ),
//
//            array(
//                'id'       => 'portfolio-slideshow-revslider',
//                'type'     => 'select',
//                'title'    => 'Revolution slider',
//                'options'  => fastor_revslider_list(),
//                'required' => array( 'portfolio-slideshow-type', '=', 'revslider' )
//            ),
//
//            array(
//                'id'       => 'portfolio-slideshow-custom_block',
//                'type'     => 'text',
//                'title'    => 'Custom Block name',
//                'required' => array( 'portfolio-slideshow-type', '=', 'custom_block' )
//            ),

            array(
                'id'       => 'portfolio-limit',
                'type'     => 'select',
                'title'    => esc_html__( 'Portfolio limit per page', 'fastor' ),
                'options'  => array(
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                    '13' => '13',
                    '14' => '14',
                    '15' => '15',
                    '16' => '16',
                    '17' => '17',
                    '18' => '18',
                    '19' => '19',
                    '20' => '20',
                    '25' => '25',
                    '50' => '50',
                    '100' => '100',
                ),
                'default'  => '6'
            ),

        )
    ));

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Product category', 'fastor' ),
        'id'         => 'general-category',
        'desc'       => esc_html__( 'Basic options regarding product category', 'fastor' ) ,
        'subsection' => true,
        'fields'     => array(
           
            array(
                'id'       => 'category-default-list-grid',
                'type'     => 'select',
                'title'    => esc_html__( 'Default product display', 'fastor' ),
                'options'  => array(
                    '0' => 'List',
                    '1' => 'Grid',
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'category-product-per-page',
                'type'     => 'select',
                'title'    => esc_html__( 'Product per row', 'fastor' ),
                'subtitle' => esc_html__( 'Only for grid display', 'fastor' ),
                'options'  => array(
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ),
                'default'  => '3'
            ),
        )
    ));
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Product', 'fastor' ),
        'id'         => 'general-product',
        'desc'       => esc_html__( 'Basic options regarding product', 'fastor' ) ,
        'subsection' => true,
        'fields'     => array(

            array(
                'id'       => 'product-lazy-load-img',
                'type'     => 'switch',
                'title'    => esc_html__( 'Lazy loading images', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'product-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Sale badge', 'fastor' ),
                'subtitle' => esc_html__( 'Sale badge configuration', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'product-sale-badge-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sale badge', 'fastor' ),
                'subtitle' => esc_html__( 'Display or not the sale badge', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'product-new-badge-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'New badge', 'fastor' ),
                'subtitle' => esc_html__( 'Display or not the new badge', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'product-new-badge-time',
                'type'     => 'text',
                'title'    => esc_html__( 'New badge duration', 'fastor' ),
                'subtitle' => esc_html__( 'Duration product of being new (in days)', 'fastor' ),
                'default'  => 7,
                'required' => array( 'product-new-badge-status', '=', 1 )
            ),
            
            array(
                'id'     => 'product-section-end',
                'type'   => 'section',
                'indent' => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'product-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Product page', 'fastor' ),
                'subtitle' => esc_html__( 'Product page configuration', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'product-breadcrumb',
                'type'     => 'select',
                'title'    => esc_html__( 'Previous/Next product in breadcrumb', 'fastor' ),
                'options'  => array(
                    '0' => 'Disable',
                    '1' => 'With thumbnail',
                    '2' => 'Only button',
                ),
                'default'  => '1'
            ),
//            array(
//                'id'       => 'productpage-image-zoom',
//                'type'     => 'select',
//                'title'    => esc_html__( 'Products image zoom', 'fastor' ),
//                'options'  => array(
//                    '0' => 'Cloud Zoom (Square)',
//                    '3' => 'Cloud Zoom (Round)',
//                    '1' => 'Inner Cloud Zoom',
//                    '2' => 'Default',
//                ),
//                'default'  => '0'
//            ),
            array(
                'id'       => 'productpage-image-size',
                'type'     => 'select',
                'title'    => esc_html__( 'Products image size', 'fastor' ),
                'options'  => array(
                    '1' => 'Small',
                    '2' => 'Medium',
                    '3' => 'Large',
                ),
                'default'  => '2'
            ),
//            array(
//                'id'       => 'productpage-image-additional',
//                'type'     => 'select',
//                'title'    => esc_html__( 'Products image additional', 'fastor' ),
//                'options'  => array(
//                    '1' => 'Bottom',
//                    '2' => 'Left',
//                    '3' => 'Right',
//                ),
//                'default'  => '1'
//            ),

            array(
                'id'       => 'productpage-socialshare-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Product social share', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'productpage-related-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Product related', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'productpage-upsells-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Product upsells', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'     => 'product-section-end',
                'type'   => 'section',
                'indent' => true, // Indent all options below until the next 'section' option is set.
            ),
            
            
            array(
                'id'       => 'product-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Product grid', 'fastor' ),
                'subtitle' => esc_html__( 'Product grid configuration', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'product-per-pow',
                'type'     => 'select',
                'title'    => esc_html__( 'Products per row', 'fastor' ),
                'options'  => array(
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                ),
                'default'  => '4'
            ),
            array(
                'id'       => 'product-image-effect',
                'type'     => 'select',
                'title'    => esc_html__( 'Image effect', 'fastor' ),
                'options'  => array(
                    '0' => 'None',
                    '1' => 'Swap image effect',
                    '2' => 'Zoom image effect',
                ),
                'default'  => '0'
            ),

            array(
                'id'       => 'product-rating-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show rating', 'fastor' ),
                'default'  => true,
            ),

//            array(
//                'id'   => 'product-info-field',
//                'type' => 'info',
//                'indent'    => true,
//                'desc' => esc_html__( 'Elements on product grids.', 'fastor' ),
//            ),
            
            array(
                'id'       => 'product-hover-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show hover product items', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'product-quickview-status',
                'type'     => 'switch',
                'title'    => esc_html__( '- quick view', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'product-countdown-status',
                'type'     => 'switch',
                'title'    => esc_html__( '- special countdown', 'fastor' ),
                'default'  => false,
            ),

            array(
                'id'       => 'product-addtocompare-status',
                'type'     => 'switch',
                'title'    => esc_html__( '- add to compare', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'product-addtowishlist-status',
                'type'     => 'switch',
                'title'    => esc_html__( '- add to wishlist', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'product-addtocart-status',
                'type'     => 'switch',
                'title'    => esc_html__( '- add to cart', 'fastor' ),
                'default'  => true,
            ),

            array(
                'id'     => 'product-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

        )
    ) );
    
    
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Header', 'fastor' ),
        'id'         => 'general-header',
        'desc'       => esc_html__( 'Basic options regarding header', 'fastor' ) ,
        'subsection' => true,
        'fields'     => array(

            array(
                'id'       => 'header-sticky-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sticky header', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable sticky header', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'header-autocomplete-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Quick search auto-suggest:', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable quick search auto-suggest in header:', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'header-show_vertical_menu',
                'type'     => 'switch',
                'title'    => esc_html__( 'Always show vertical megamenu in home page:', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'header-show_vertical_menu_category_page',
                'type'     => 'switch',
                'title'    => esc_html__( 'Always show vertical megamenu in category page:', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'header-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Select type', 'fastor' ),
                'subtitle' => esc_html__( 'Select type of header', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'=>'header-type',
                'type' => 'image_select',
                'compiler'=>true,
                'title' => 'Header types',
                'class' => 'header-type-wrapper',
                'options' => array(
                    '1' => array('title' => '<div class="header_name">Header 1</div>', 'alt' => 'Header I', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_01.jpg'),
                    '2' => array('title' => '<div class="header_name">Header 2</div>', 'alt' => 'Header II', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_02.jpg'),
                    '3' => array('title' => '<div class="header_name">Header 3</div>', 'alt' => 'Header III', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_03.jpg'),
                    '4' => array('title' => '<div class="header_name">Header 4</div>', 'alt' => 'Header IV', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_04.jpg'),
                    '5' => array('title' => '<div class="header_name">Header 5</div>', 'alt' => 'Header V', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_05.jpg'),
                    '6' => array('title' => '<div class="header_name">Header 6</div>', 'alt' => 'Header VI', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_06.jpg'),
                    '7' => array('title' => '<div class="header_name">Header 7</div>', 'alt' => 'Header VII', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_07.jpg'),
                    '8' => array('title' => '<div class="header_name">Header 8</div>', 'alt' => 'Header VIII', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_08.jpg'),
                    '9' => array('title' => '<div class="header_name">Header 9</div>', 'alt' => 'Header IX', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_09.jpg'),
                    '10' => array('title' => '<div class="header_name">Header 10</div>', 'alt' => 'Header X', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_10.jpg'),
                    '11' => array(
                        'title' => '
                        <div class="header_name">
                            <span>Header 11</span>
                            <ul>
                                <li>Barber</li>
                                <li>Computer 3</li>
                                <li>Furniture</li>
                                <li>Natural Cosmetics</li>
                                <li>Wine</li>
                                <li>Skins without Vertical megamenu</li>
                            </ul>
                        </div>
                        ',
                        'alt' => 'Header X1',
                        'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_11.jpg'
                    ),
                    '12' => array(
                        'title' => '
                        <div class="header_name">
                            <span>Header 12</span>
                            <ul>
                                <li>Fashion 3</li>
                                <li>Fashion simple</li>
                                <li>Jewelry</li>
                                <li>Jewelry black</li>
                                <li>Skins without Vertical megamenu</li>
                            </ul>
                        </div>
                        ',
                        'alt' => 'Header XII',
                        'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_12.jpg'
                    ),
                    '13' => array(
                        'title' => '    
                        <div class="header_name">
                            <span>Header 13</span>
                            <ul>
                                <li>medic</li>
                                <li>cosmetics2</li>
                            </ul>
                        </div>
                        ',
                        'alt' => 'Header XIII',
                        'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_13.jpg'
                    ),
                    '15' => array(
                        'title' => '    
                        <div class="header_name">
                            <span>Header 15</span>
                            <ul>
                                <li>Market</li>
                            </ul>
                        </div>
                        ',
                        'alt' => 'Header XV',
                        'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_15.jpg'
                    ),
                    '16' => array(
                        'title' => '    
                        <div class="header_name">
                            <span>Header 16</span>
                            <ul>
                                <li>Material arts</li>
                            </ul>
                        </div>
                        ',
                        'alt' => 'Header XVI',
                        'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_16.jpg'
                    ),
                    '17' => array(
                        'title' => '    
                        <div class="header_name">
                            <span>Header 17</span>
                            <ul>
                                <li>Sport</li>
                            </ul>
                        </div>
                        ',
                        'alt' => 'Header XVII',
                        'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_17.jpg'
                    ),
                    '18' => array(
                        'title' => '    
                        <div class="header_name">
                            <span>Header 18</span>
                            <ul>
                                <li>Exclusive</li>
                            </ul>
                        </div>
                        ',
                        'alt' => 'Header XVIII',
                        'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_18.jpg'
                    ),
                    '19' => array(
                        'title' => '    
                        <div class="header_name">
                            <span>Header 19</span>
                            <ul>
                                <li>Coffe & Tea</li>
                            </ul>
                        </div>
                        ',
                        'alt' => 'Header XIX',
                        'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_19.jpg'
                    ),
                    '21' => array(
                        'title' => '    
                        <div class="header_name">
                            <span>Header 21</span>
                            <ul>
                                <li>Sport winter</li>
                                <li>Skins without Vertical megamenu</li>
                            </ul>
                        </div>
                        ',
                        'alt' => 'Header XX1',
                        'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_21.jpg'
                    ),
                    '23' => array(
                        'title' => '    
                        <div class="header_name">
                            <span>Header 23</span>
                            <ul>
                                 <li>Holidays</li>
                                <li>Carparts 2</li>
                                <li>Skins without Vertical megamenu</li>
                            </ul>
                        </div>
                        ',
                        'alt' => 'Header XX1',
                        'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_23.jpg'
                    ),
                    '24' => array(
                        'title' => '    
                        <div class="header_name">
                            <span>Header 24</span>
                            <ul>
                                <li>Books</li>
                            </ul>
                        </div>
                        ',
                        'alt' => 'Header XXIV',
                        'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_24.jpg'
                    ),
                ),
                'default' => '1'
           ),
            
            array(
                'id'     => 'header-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

        )
    ) );


Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Menu', 'fastor' ),
        'id'         => 'general-menu',
        'desc'       => esc_html__( 'Basic options regarding menu', 'fastor' ) ,
        'subsection' => true,
        'fields'     => array(

            array(
                'id'       => 'menu-animation-type',
                'type'     => 'radio',
                'title'    => esc_html__( 'Aimation type', 'fastor' ),
                'options'  => array(
                    'slide' => 'Slide',
                    'fade' => 'Fade',
                    'shift-up' => 'Shift up',
                    'shift-down' => 'Shift Down',
                    'shift-left' => 'Shift Left',
                    'flipping' => 'Flipping',
                    'none' => 'None'
                ),
                'default'  => 'slide'
            ),
            array(
                'id'       => 'menu-animation-time',
                'type'     => 'text',
                'title'    => esc_html__( 'Animation time', 'fastor' ),
            ),

            array(
                'id'       => 'menu-mobile-type',
                'type'     => 'radio',
                'title'    => esc_html__( 'Mobile type', 'fastor' ),
                'options'  => array(
                    'standard' => 'Standard',
                    'fixed_left' => 'Fixed left',
                ),
                'default'  => 'standard'
            ),


        )
    ) );
    

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Banners hover', 'fastor' ),
        'id'         => 'general-banners',
        'desc'       => esc_html__( 'Basic options regarding menu', 'fastor' ) ,
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'banners-hover-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Banners animation', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable banners animation', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'banners-hover-type',
                'type'     => 'radio',
                'class'     => 'banners-hover-type',
                'title'    => esc_html__( 'Banners animation type', 'fastor' ),
                'options'  => array(
                    "1" => '
                    <div class="banners-effect-1 hover_effect_type">
                            <label>
                                <div class="banners">
                                    <div>
                                        <a href="#" onclick="return false">
                                        <img src="'.get_template_directory_uri() . '/admin/theme_options/img/banner-01.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                            </label>
                        </div>
                    ',
                    "2" => '
                    <div class="banners-effect-2 hover_effect_type">
                            <label>
                                <div class="banners">
                                    <div>
                                        <a href="#" onclick="return false">
                                        <img src="'.get_template_directory_uri() . '/admin/theme_options/img/banner-01.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                            </label>
                        </div>
                    ',
                    "3" => '
                    <div class="banners-effect-3 hover_effect_type">
                            <label>
                                <div class="banners">
                                    <div>
                                        <a href="#" onclick="return false">
                                        <img src="'.get_template_directory_uri() . '/admin/theme_options/img/banner-01.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                            </label>
                        </div>
                    ',
                    "4" => '
                    <div class="banners-effect-4 hover_effect_type">
                            <label>
                                <div class="banners">
                                    <div>
                                        <a href="#" onclick="return false">
                                        <img src="'.get_template_directory_uri() . '/admin/theme_options/img/banner-01.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                            </label>
                        </div>
                    ',
                    "5" => '
                    <div class="banners-effect-5 hover_effect_type">
                            <label>
                                <div class="banners">
                                    <div>
                                        <a href="#" onclick="return false">
                                        <img src="'.get_template_directory_uri() . '/admin/theme_options/img/banner-01.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                            </label>
                        </div>
                    ',
                    "6" => '
                    <div class="banners-effect-6 hover_effect_type">
                            <label>
                                <div class="banners">
                                    <div>
                                        <a href="#" onclick="return false">
                                        <img src="'.get_template_directory_uri() . '/admin/theme_options/img/banner-01.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                            </label>
                        </div>
                    ',
                    "7" => '
                    <div class="banners-effect-7 hover_effect_type">
                            <label>
                                <div class="banners">
                                    <div>
                                        <a href="#" onclick="return false">
                                        <img src="'.get_template_directory_uri() . '/admin/theme_options/img/banner-01.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                            </label>
                        </div>
                    ',
                    "8" => '
                    <div class="banners-effect-8 hover_effect_type">
                            <label>
                                <div class="banners">
                                    <div>
                                        <a href="#" onclick="return false">
                                        <img src="'.get_template_directory_uri() . '/admin/theme_options/img/banner-01.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                            </label>
                        </div>
                    ',
                    "9" => '
                    <div class="banners-effect-9 hover_effect_type">
                            <label>
                                <div class="banners">
                                    <div>
                                        <a href="#" onclick="return false">
                                        <img src="'.get_template_directory_uri() . '/admin/theme_options/img/banner-01.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                            </label>
                        </div>
                    ',
                    "10" => '
                    <div class="banners-effect-10 hover_effect_type">
                            <label>
                                <div class="banners">
                                    <div>
                                        <a href="#" onclick="return false">
                                        <img src="'.get_template_directory_uri() . '/admin/theme_options/img/banner-01.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                            </label>
                        </div>
                    ',

                ),
                'default'  => '0'
            ),


        )
    ) );



    // -> START Design Section
    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Design', 'fastor' ),
        'id'    => 'design',
        'desc'  => esc_html__( '', 'fastor' ),
        'icon'  => 'el el-brush'
    ) );
    
     // -> START Typography
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Fonts', 'fastor' ),
        'id'     => 'design-font',
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'font-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable custom fonts ', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'font-body',
                'type'     => 'typography',
                'title'    => esc_html__( 'Body Font', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '13px',
                    'font-family' => '',
                    'font-weight' => 'Normal',
                ),
                'output' => array(
                    '
                    body,
                    textarea,
                    input[type="text"], 
                    input[type="password"],
                    input[type="datetime"], 
                    input[type="datetime-local"], 
                    input[type="date"], 
                    input[type="month"], 
                    input[type="time"], 
                    input[type="week"], 
                    input[type="number"], 
                    input[type="email"], 
                    input[type="url"], 
                    input[type="search"], 
                    input[type="tel"], 
                    input[type="color"], 
                    .uneditable-input, select,
                    .select2-container--default .select2-selection--single .select2-selection__rendered
                    '
                ),
                'required' => array( 'font-status', '=', 1 )
            ),


            array(
                'id'       => 'font-body-smaller',
                'type'     => 'typography',
                'title'    => esc_html__( 'Body Font Smaller', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '12px',
                    'font-family' => '',
                    'font-weight' => 'Normal',
                ),
                'output'    => array(
                    '
                    .dropdown-menu,
                    body .dropdown-menu > li > a,
                    .top-bar .menu li a,
                    #top .dropdown > a,
                    .product-info .cart .add-to-cart p,
                    .header-notice,
                    .header-type-9 #top #header-center .menu li a,
                    .welcome-text,
                    .header-type-16 #top #header-left .menu li,
                    .product-info .cart .links > a, .product-info .cart .links > div,
                    .product-info .cart .links a
                    '
                ),
                'required' => array( 'font-status', '=', 1 )
            ),

            array(
                'id'       => 'font-categories_bar',
                'type'     => 'typography',
                'title'    => esc_html__( 'Categories bar', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '22px',
                    'font-family' => '',
                    'font-weight' => 'Normal',
                ),
                'output'    => array(
                    '
                    ul.megamenu > li > a strong,
                    .megamenuToogle-wrapper .container
                    '
                ),
                'required' => array( 'font-status', '=', 1 )
            ),


            array(
                'id'       => 'font-categories_submenu_heading',
                'type'     => 'typography',
                'title'    => esc_html__( 'Categories submenu heading', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '20px',
                    'font-family' => '',
                    'font-weight' => 'Normal',
                ),
                'output'    => array(
                    '
                    ul.megamenu li .sub-menu .content .static-menu a.main-menu
                    '
                ),
                'required' => array( 'font-status', '=', 1 )
            ),

            array(
                'id'       => 'font-categories_box_heading',
                'type'     => 'typography',
                'title'    => esc_html__( 'Categories box heading', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '14px',
                    'font-family' => '',
                    'font-weight' => '',
                ),
                'output'    => array(
                    '
                    .box.box-with-categories .box-heading,
                    .vertical .megamenuToogle-wrapper .container
                    '
                ),
                'required' => array( 'font-status', '=', 1 )
            ),
            array(
                'id'       => 'font-categories_box_links',
                'type'     => 'typography',
                'title'    => esc_html__( 'Categories box links', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '',
                    'font-family' => '',
                    'font-weight' => '',
                ),
                'output'    => array(
                    '
                    .box-category ul li > a,
                    .vertical ul.megamenu > li > a strong
                    '
                ),
                'required' => array( 'font-status', '=', 1 )
            ),

            array(
                'id'       => 'font-price',
                'type'     => 'typography',
                'title'    => esc_html__( 'Price', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '36px',
                    'font-family' => '',
                    'font-weight' => 'Normal',
                ),
                'output'    => array(
                    '
                    .product-grid .product .price,
                    .product-list .name-actions > .price,
                    .product-info .price,
                    .product-info .price .price-new,
                    ul.megamenu li .product .price,
                    .advanced-grid-products .product .right .price,
                    #top #cart_block .cart-heading p strong,
                    .cart-total table tr td:last-child,
                    .mini-cart-info td.total,
                    .mini-cart-total td:last-child,
                    .today-deals-products .product .price,
                    .product-info .price .price-old,
                    .architecture-products .product .right .price,
                    .matrialarts-products .matrial-product .right .price,
                    .today-deals-toys2-products .price,
                    .today-deals-petshop2-products .price,
                    .today-deals-shoes3-products .price,
                    .today-deals-computer8-products .price,
                    .today-deals-computer6-products .price,
                    .product-info .price .price-new 
                    '
                ),
                'required' => array( 'font-status', '=', 1 )
            ),
            array(
                'id'       => 'font-price_medium',
                'type'     => 'typography',
                'title'    => esc_html__( 'Price medium', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '24px',
                    'font-family' => '',
                    'font-weight' => 'Normal',
                ),
                'output'    => array(
                    '
                    .product-list .name-actions > .price
                    '
                ),
                'required' => array( 'font-status', '=', 1 )
            ),
            array(
                'id'       => 'font-price_small',
                'type'     => 'typography',
                'title'    => esc_html__( 'Price small', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '13px',
                    'font-family' => '',
                    'font-weight' => 'Normal',
                ),
                'output'    => array(
                    '
                    .product-grid .product .price,
                    .advanced-grid-products .product .right .price,
                    #top #cart_block .cart-heading p strong,
                    .cart-total table tr td:last-child,
                    .mini-cart-info td.total,
                    .mini-cart-total td:last-child,
                    .today-deals-products .product .price,
                    .architecture-products .product .right .price,
                    .matrialarts-products .matrial-product .right .price
                    '
                ),
                'required' => array( 'font-status', '=', 1 )
            ),
            array(
                'id'       => 'font-old_price',
                'type'     => 'typography',
                'title'    => esc_html__( 'Old price', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '13px',
                    'font-family' => '',
                    'font-weight' => 'Normal',
                ),
                'output'    => array(
                    '
                    .price-old,
                    .today-deals-products .product .price .price-old,
                    .architecture-products .product .right .price .price-old 
                    '
                ),
                'required' => array( 'font-status', '=', 1 )
            ),
            array(
                'id'       => 'font-headlines',
                'type'     => 'typography',
                'title'    => esc_html__( 'Headlines', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '18px',
                    'font-family' => '',
                    'font-weight' => 'Normal',
                ),
                'output'    => array(
                    '
                    .box .box-heading,
                    .woocommerce-billing-fields h3,
                    .woocommerce #order_review_heading,
                    .center-column h1,
                    .center-column h2,
                    .center-column h3,
                    .center-column h4,
                    .center-column h5,
                    .center-column h6,
                    .posts .post .post-title,
                    .products-carousel-overflow .box-heading,
                    .htabs a,
                    .product-info .options h2,
                    h3,
                    h4,
                    h6,
                    .product-block .title-block,
                    .filter-product .filter-tabs ul > li > a,
                    .popup h4,
                    .product-info .product-name a,
                    legend 
                    '
                ),
                'required' => array( 'font-status', '=', 1 )
            ),
            array(
                'id'       => 'font-footer_headlines',
                'type'     => 'typography',
                'title'    => esc_html__( 'Footer Headlines', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '20px',
                    'font-family' => '',
                    'font-weight' => 'Normal',
                ),
                'output'    => array(
                    '
                    .footer h4,
                    .footer .box-heading,
                    .custom-footer h4
                    '
                ),
                'required' => array( 'font-status', '=', 1 )

            ),
            array(
                'id'       => 'font-page_name',
                'type'     => 'typography',
                'title'    => esc_html__( 'Page name', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '24px',
                    'font-family' => '',
                    'font-weight' => 'Normal',
                ),
                'output'    => array(
                    '
                    .breadcrumb .container h1
                    '
                ),
                'required' => array( 'font-status', '=', 1 )
            ),
            array(
                'id'       => 'font-button',
                'type'     => 'typography',
                'title'    => esc_html__( 'Button', 'fastor' ),
                'google'   => true,
                'all_styles'    => true,
                'text-transform'    => true,
                'default'  => array(
                    'color'       => '',
                    'font-size'   => '14px',
                    'font-family' => '',
                    'font-weight' => 'Normal',
                ),
                'output'    => array(
                    '
                    .button,
                    .btn,
                    .footer-button,
                    widget_layered_nav_clear ul a
                    '
                ),
                'required' => array( 'font-status', '=', 1 )

            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Colors', 'fastor' ),
        'id'         => 'design-color',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'color-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable custom colors ', 'fastor' ),
                'default'  => false,
            ),



            /* BODY */
            array(
                'id'       => 'color-body-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Body', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-body_font_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        body,
                        .product-filter .list-options select,
                        .blog-article .post .box .box-heading,
                         .center-column.content-with-background .box .box-heading

                    '
                ),
                'title'    => esc_html__( 'Body text ', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-body_font_links',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        a,
                        .product-filter .list-options select,
                        .blog-article .post .box .box-heading
                    '
                ),
                'title'    => esc_html__( 'Body link ', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-body_font_links_hover',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .product-info .radio-type-button2 span.active,
                        .ui-slider-horizontal
                    ',
                    'color'            => '
                        a:hover,
                        .payment_methods .payment_method_paypal a,
                        header.title .edit,
                        div.pagination-results ul li span.current,
                        div.pagination-results ul li.active,
                        .woocommerce .widget_layered_nav ul.yith-wcan-list li.chosen a,
                        .woocommerce-page .widget_layered_nav ul.yith-wcan-list.chosen li a, 
                        .woocommerce .widget_layered_nav ul.yith-wcan-list li.chosen span, 
                        .woocommerce-page .widget_layered_nav ul.yith-wcan-list li.chosen span,
                        .widget_brand_nav ul.wc-brand-list-layered-nav-product_brand li.chosen a,
                        .widget_brand_nav ul.wc-brand-list-layered-nav-product_brand li.chosen .count,
                        .categories-wall .category-wall .more-categories
                    ',
                    'border-color'            => '
                        .product-info .radio-type-button span:hover,
                        .product-info .radio-type-button span.active,
                        .product-info .radio-type-button2 span:hover,
                        .product-info .radio-type-button2 span.active,
                        #main .mfilter-image ul li.mfilter-image-checked
                    '
                ),
                'title'    => esc_html__( 'Body link hover ', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-body_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .standard-body .full-width #mfilter-content-container > span:before,
                        img[src="image/catalog/blank.gif"],
                         #mfilter-content-container > span:before,
                         .spinner,
                         html .mfp-iframe-scaler iframe,
                         .quickview body,
                         .modal-content,
                         .news.v2  .media-body .bottom,
                         body,
                         .quickview .quickview-wrap,
                         .popup

                    ',
                ),
                'title'    => esc_html__( 'Body background ', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )

            ),

            array(
                'id'     => 'color-body-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* PRODUCT */
            array(
                'id'       => 'color-product-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Products', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-body_price_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .compare-info .price-new,
                        .product-info .price .woocommerce-Price-amount,
                        .product-grid .product .price, 
                        .product-list .actions > div .price,
                        .product-info .price .price-new,
                        .product-info .price,
                        ul.megamenu li .product .price,
                        .mini-cart-total td:last-child,
                        .cart-total table tr td:last-child,
                        .mini-cart-info td.total,
                        .advanced-grid-products .product .right .price,
                        .product-list .name-actions > .price,
                        .today-deals-products .product .price,
                        .medic-last-in-stock .price,
                        .architecture-products .product .right .price,
                        .matrialarts-products .matrial-product .right .price,
                        .today-deals-toys2-products .price,
                        .today-deals-petshop2-products .price,
                        .today-deals-shoes3-products .price,
                        .today-deals-computer8-products .price,
                        .today-deals-computer6-products .price,
                        .holidays-products .product .right .price,
                        .today-deals-computer6-products .countdown-section,
                        .woocommerce table td.product-total,
                        .woocommerce table td.product-subtotal,
                        .woocommerce table td.product-price
                        .woocommerce table tr.order-total td:last-child,
                        .woocommerce table tr.cart-subtotal td:last-child,
                        .woocommerce table tr.tax-rate td:last-child,
                        .woocommerce table.shop_table.order_details tr td:last-child,
                        .woocommerce table.shop_table.woocommerce-checkout-review-order-table td.product-total,
                        .woocommerce table tr.order-total td:last-child, 
                        .woocommerce table tr.cart-subtotal td:last-child,
                        .woocommerce table tr.tax-rate td:last-child, 
                        .woocommerce table.shop_table.order_details tr td:last-child, 
                        .woocommerce table.shop_table.woocommerce-checkout-review-order-table td.product-total,
                        .woocommerce table td.product-total, 
                        .woocommerce table td.product-subtotal, 
                        .woocommerce table td.product-price 
                    '

                ),
                'title'    => esc_html__( 'Price text ', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
             array(
                'id'       => 'color-body_price_old_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .product-list .name-actions > .price .price-old,
                        .product-grid .product .price .price-old,
                        .today-deals-products .product .price .price-old,
                        .architecture-products .product .right .price .price-old,
                        .today-deals-toys2-products .price .price-old,
                        .today-deals-petshop2-products .price .price-old,
                        .today-deals-shoes3-products .price .price-old,
                        .today-deals-computer8-products .price .price-old,
                        .today-deals-computer6-products .price .price-old,
                        .product-info .price .price-old .woocommerce-Price-amount,
                        .breadcrumb .price .price-old
                    '

                ),
                'title'    => esc_html__( 'Price old text', 'fastor' ),
                'default'  => '',
                 'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-body_price_old_text_on_product_page',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .product-info .price .price-old,
                        .product-info .price .price-old .woocommerce-Price-amount
                    '

                ),
                'title'    => esc_html__( 'Price old text on product page', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-product_hover_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .product-grid .product:hover:before,
                        .product-list > div:hover
                    '

                ),
                'title'    => esc_html__( 'Hover border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-product-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* PRODUCT BUTTONS */
            array(
                'id'       => 'color-product_buttons-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Products buttons', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-products_buttons_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        .product-grid .product .only-hover ul li a,
                        .architecture-products .product .right .only-hover ul li a,
                        .product-list .name-actions ul li a,
                        .today-deals-toys2-products .only-hover ul li a,
                        .today-deals-petshop2-products .only-hover ul li a,
                        .flower-product .right ul li a 
                    '

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-products_buttons_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .product-grid .product .only-hover ul li a,
                        .architecture-products .product .right .only-hover ul li a,
                        .product-list .name-actions ul li a,
                        .today-deals-toys2-products .only-hover ul li a,
                        .today-deals-petshop2-products .only-hover ul li a,
                        .flower-product .right ul li a
                    '

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-products_buttons_icon_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .product-grid .product .only-hover ul li a,
                        .architecture-products .product .right .only-hover ul li a,
                        .product-list .name-actions ul li a,
                        .today-deals-toys2-products .only-hover ul li a,
                        .today-deals-petshop2-products .only-hover ul li a,
                        .flower-product .right ul li a
                    '

                ),
                'title'    => esc_html__( 'Icon color ', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-product_buttons-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* PRODUCT BUTTONS HOVER */
            array(
                'id'       => 'color-product_buttons_hover-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Products buttons hover', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-products_buttons_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        .product-grid .product .only-hover ul li a:hover,
                        .architecture-products .product .right .only-hover ul li a:hover,
                        .product-list .name-actions ul li a:hover,
                        .today-deals-toys2-products .only-hover ul li a:hover,
                        .today-deals-petshop2-products .only-hover ul li a:hover,
                        .flower-product .right ul li a:hover
                    '

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-products_buttons_hover_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .product-grid .product .only-hover ul li a:hover,
                        .architecture-products .product .right .only-hover ul li a:hover,
                        .product-list .name-actions ul li a:hover,
                        .today-deals-toys2-products .only-hover ul li a:hover,
                        .today-deals-petshop2-products .only-hover ul li a:hover,
                        .flower-product .right ul li a:hover
                    '

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-products_buttons_hover_icon_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .product-grid .product .only-hover ul li a:hover,
                        .architecture-products .product .right .only-hover ul li a:hover,
                        .product-list .name-actions ul li a:hover,
                        .today-deals-toys2-products .only-hover ul li a:hover,
                        .today-deals-petshop2-products .only-hover ul li a:hover,
                        .flower-product .right ul li a:hover
                    '

                ),
                'title'    => esc_html__( 'Icon color ', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-product_buttons_hover-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Dropdown */
            array(
                'id'       => 'color-dropdown-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Dropdown', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-dropdown_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .dropdown-menu,
                        .ui-autocomplete
                    ',
                    'border-bottom-color'            => '
                        .dropdown-menu,
                        .ui-autocomplete
                    '

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-dropdown_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .dropdown-menu 
                    '
                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-dropdown_links_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .dropdown-menu li a,
                        .dropdown-menu .mini-cart-info a,
                        .ui-autocomplete li a 
                    '
                ),
                'title'    => esc_html__( 'Links color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-dropdown_links_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .dropdown-menu li a:hover,
                        .dropdown-menu .mini-cart-info a:hover,
                        .ui-autocomplete li a:hover,
                        .ui-autocomplete li a.ui-state-focus
                    '
                ),
                'title'    => esc_html__( 'Links color hover', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'     => 'color-dropdown-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

            /* Inputs */
            array(
                'id'       => 'color-inputs-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Inputs', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-inputs_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        textarea, 
                        input[type="text"], 
                        input[type="password"], 
                        input[type="datetime"], 
                        input[type="datetime-local"], 
                        input[type="date"], 
                        input[type="month"], 
                        input[type="time"], 
                        input[type="week"], 
                        input[type="number"], 
                        input[type="email"], 
                        input[type="url"], 
                        input[type="search"], 
                        input[type="tel"], 
                        input[type="color"], 
                        .uneditable-input,
                         .select2 .select2-selection, select,
                         .select2-container--default .select2-selection--single .select2-selection__rendered
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-inputs_background_focus_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        textarea:focus,
                        input[type="text"]:focus,
                        input[type="password"]:focus,
                        input[type="datetime"]:focus,
                        input[type="datetime-local"]:focus,
                        input[type="date"]:focus,
                        input[type="month"]:focus,
                        input[type="time"]:focus,
                        input[type="week"]:focus,
                        input[type="number"]:focus,
                        input[type="email"]:focus,
                        input[type="url"]:focus,
                        input[type="search"]:focus,
                        input[type="tel"]:focus,
                        input[type="color"]:focus,
                        .uneditable-input:focus
                    ',

                ),
                'title'    => esc_html__( 'Background focus color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-inputs_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        textarea, 
                        input[type="text"], 
                        input[type="password"], 
                        input[type="datetime"], 
                        input[type="datetime-local"], 
                        input[type="date"], 
                        input[type="month"], 
                        input[type="time"], 
                        input[type="week"], 
                        input[type="number"], 
                        input[type="email"], 
                        input[type="url"], 
                        input[type="search"], 
                        input[type="tel"], 
                        input[type="color"], 
                        .uneditable-input
                    ',

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'       => 'color-inputs_border_focus_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        textarea:focus,
                        input[type="text"]:focus,
                        input[type="password"]:focus,
                        input[type="datetime"]:focus,
                        input[type="datetime-local"]:focus,
                        input[type="date"]:focus,
                        input[type="month"]:focus,
                        input[type="time"]:focus,
                        input[type="week"]:focus,
                        input[type="number"]:focus,
                        input[type="email"]:focus,
                        input[type="url"]:focus,
                        input[type="search"]:focus,
                        input[type="tel"]:focus,
                        input[type="color"]:focus,
                        .uneditable-input:focus
                    ',

                ),
                'title'    => esc_html__( 'Border focus color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-inputs_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        textarea, 
                        input[type="text"], 
                        input[type="password"], 
                        input[type="datetime"], 
                        input[type="datetime-local"], 
                        input[type="date"], 
                        input[type="month"], 
                        input[type="time"], 
                        input[type="week"], 
                        input[type="number"], 
                        input[type="email"], 
                        input[type="url"], 
                        input[type="search"], 
                        input[type="tel"], 
                        input[type="color"], 
                        .uneditable-input,
                        .select2-container--default .select2-selection--single .select2-selection__rendered
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-inputs-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

            /* Selects */
            array(
                'id'       => 'color-selects-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Selects', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-selects_background_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        select
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-selects_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        select
                    ',

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-selects_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        select
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-selects_arrow_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .select:after,
                        .product-filter .list-options .sort:after,
                        .product-filter .list-options .limit:after
                    ',

                ),
                'title'    => esc_html__( 'Arrow color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-selects-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Header */
            array(
                'id'       => 'color-header-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Header', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-header_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        header
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'     => 'color-header-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Header type 3, 4, 8 */
            array(
                'id'       => 'color-header_type_3-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Header type 3,4,8,10', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-header_type_3_border_bottom_1_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .header-type-3 #top
                    ',

                ),
                'title'    => esc_html__( 'Border bottom color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'     => 'color-header_type_3-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* Header type 3, 4, 8 -> Search */
            array(
                'id'       => 'color-header_type_3_search-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Header type 3,4,8,10 -> Search', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-header_type_3_search_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .header-type-3 #top .search_form,
                        .header-type-8 #top .search_form,
                        .body-header-type-27 #top .search_form 
                    ',

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-header_type_3_search_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        .header-type-3 #top .search_form,
                        .header-type-8 #top .search_form,
                        .body-header-type-27 #top .search_form 
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-header_type_3_search_icon_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .header-type-3 #top .search_form,
                        .header-type-8 #top .search_form,
                        .header-type-3 #top .search_form a,
                        .header-type-8 #top .search_form a,
                        .body-header-type-27 #top .search_form .button-search
                    ',

                ),
                'title'    => esc_html__( 'Icon color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-header_type_3_search_border_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .header-type-3 #top .search_form:hover,
                        .header-type-8 #top .search_form:hover,
                        .body-header-type-27 #top .search_form:hover
                    ',

                ),
                'title'    => esc_html__( 'Border hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-header_type_3_search_background_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        .header-type-3 #top .search_form:hover,
                        .header-type-8 #top .search_form:hover,
                        .body-header-type-27 #top .search_form:hover
                    ',

                ),
                'title'    => esc_html__( 'Background hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-header_type_3_search_icon_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .header-type-3 #top .search_form:hover,
                        .header-type-8 #top .search_form:hover,
                        .header-type-3 #top .search_form:hover a,
                        .header-type-8 #top .search_form:hover a,
                        .body-header-type-27 #top .search_form:hover .button-search 
                    ',

                ),
                'title'    => esc_html__( 'Icon hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'     => 'color-header_type_3_search-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Header type 12 -> Search */
            array(
                'id'       => 'color-header_type_12_search-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Header type 12 -> Search', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-header_type_12_search_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .header-type-12 #top .search_form
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-header_type_12_search_icon_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .header-type-12 #top .search_form .button-search
                    ',

                ),
                'title'    => esc_html__( 'Icon color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-header_type_12_search_select_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .header-type-12 #top .search_form .search-cat select,
                        .header-type-12 #top .search_form .search-cat .select:after
                    ',

                ),
                'title'    => esc_html__( 'Select text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-header_type_12_search_input_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .header-type-12 #top .search_form input
                    ',

                ),
                'title'    => esc_html__( 'Input text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-header_type_12_search_input_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .header-type-12 #top .search_form input
                    ',

                ),
                'title'    => esc_html__( 'Input background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-header_type_12_search_input_focus_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .header-type-12 #top .search_form input:focus
                    ',

                ),
                'title'    => esc_html__( 'Input focus background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'     => 'color-header_type_12_search-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* Header type 13 -> Search */
            array(
                'id'       => 'color-header_type_13_search-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Header type 13 -> Search', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-header_type_13_search_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .header-type-13 .search_form 
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-header_type_13_search_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .header-type-13 .search-cat
                    ',

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-header_type_13_search_select_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .header-type-13 .search-cat select,
                        .header-type-13 .search-cat .select:after 
                    ',

                ),
                'title'    => esc_html__( 'Select text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-header_type_13_search_input_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .header-type-13 .overflow-input input
                    ',

                ),
                'title'    => esc_html__( 'Input text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-header_type_13_search_icon_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .header-type-13 .button-search 
                    ',

                ),
                'title'    => esc_html__( 'Icon search background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-header_type_13_search_icon_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .header-type-13 .button-search:hover
                    ',

                ),
                'title'    => esc_html__( 'Icon search hover background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'       => 'color-header_type_13_search_icon_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .header-type-13 .button-search
                    ',

                ),
                'title'    => esc_html__( 'Icon search text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-header_type_13_search_icon_hover_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .header-type-13 .button-search:hover
                    ',

                ),
                'title'    => esc_html__( 'Icon search hover text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'     => 'color-header_type_13_search-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* Top bar */
            array(
                'id'       => 'color-top_bar-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Top bar', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-top_bar_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .top-bar
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_bar_border_bottom_color',
                'type'     => 'color',
                'output'    => array(
                    'border-bottom-color'            => '
                        .top-bar
                    ',

                ),
                'title'    => esc_html__( 'Border bottom color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-top_bar-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

            /* Top */
            array(
                'id'       => 'color-top-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Top', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-top_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #top .background,
                        #top > .background
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_border_bottom_color',
                'type'     => 'color',
                'output'    => array(
                    'border-bottom-color'            => '
                        .megamenu-background 
                    ',

                ),
                'title'    => esc_html__( 'Border bottom 1px color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-top_border_bottom_2px_color',
                'type'     => 'color',
                'output'    => array(
                    'border-bottom-color'            => '
                        .megamenu-background 
                    ',

                ),
                'title'    => esc_html__( 'Border bottom 2px color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_border_bottom_4px_color',
                'type'     => 'color',
                'output'    => array(
                    'border-bottom-color'            => '
                        .megamenu-background 
                    ',

                ),
                'title'    => esc_html__( 'Border bottom 4px color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-top-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

            /* Top menu */
            array(
                'id'       => 'color-top_links-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Top -> Menu', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-top_links_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .top-bar .menu li a,
                        .header-type-9 #top #header-center .menu li a,
                        .header-type-17 #top #header-left .menu li a,
                        .header-type-26 #top .menu li a 
                    ',

                ),
                'title'    => esc_html__( 'Links color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_links_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .top-bar .menu li a:hover,
                        .header-type-9 #top #header-center .menu li a:hover,
                        .header-type-17 #top #header-left .menu li a:hover,
                        .header-type-26 #top .menu li a:hover 
                    ',

                ),
                'title'    => esc_html__( 'Links hover', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-top_links-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Top search */
            array(
                'id'       => 'color-top_search-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Top -> Search', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-top_search_input_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #top .search_form input
                    ',

                ),
                'title'    => esc_html__( 'Input background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_search_input_focus_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #top .search_form input:focus 
                    ',

                ),
                'title'    => esc_html__( 'Input focus background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_search_input_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        #top .search_form input
                    ',

                ),
                'title'    => esc_html__( 'Input border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_search_input_focus_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        #top .search_form input:focus
                    ',

                ),
                'title'    => esc_html__( 'Input focus border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-top_search_input_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top .search_form input
                    ',

                ),
                'title'    => esc_html__( 'Input text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_search_icon_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .search_form .button-search, 
                        .search_form .button-search2
                    ',

                ),
                'title'    => esc_html__( 'Search icon color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-top_search-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Top change currency, language */
            array(
                'id'       => 'color-top_change-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Top -> Currency/Language Switcher', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-top_change_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top .dropdown > a
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_change_bullet_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top .dropdown > a:after
                    ',

                ),
                'title'    => esc_html__( 'Bullet hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_change_text_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top .dropdown:hover > a
                    ',

                ),
                'title'    => esc_html__( 'Text hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_change_bullet_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top .dropdown:hover > a:after
                    ',

                ),
                'title'    => esc_html__( 'Bullet hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-top_change-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

            /* Top my account */
            array(
                'id'       => 'color-top_my_account-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Top -> My account', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-top_my_account_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        #top .my-account,
                        .rtl .header-type-10 #top .my-account 
                    ',

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_my_account_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #top .my-account
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_my_account_icon_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top .my-account,
                        .header-type-23 .dropdown i
                    ',

                ),
                'title'    => esc_html__( 'Icon color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_my_account_border_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        #top .my-account:hover,
                        .rtl .header-type-10 #top .my-account:hover
                    ',

                ),
                'title'    => esc_html__( 'Border hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_my_account_background_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #top .my-account:hover
                    ',

                ),
                'title'    => esc_html__( 'Background hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_my_account_icon_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top .my-account:hover,
                        .header-type-23 .dropdown:hover i
                    ',

                ),
                'title'    => esc_html__( 'Icon hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-top_my_account-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Top cart */
            array(
                'id'       => 'color-top_cart-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Top -> Cart', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-top_cart_icon_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        #top #cart_block .cart-heading .cart-icon,
                        .cart-block-type-2 #top #cart_block .cart-heading,
                        .cart-block-type-9 #top #cart_block .cart-heading,
                        .cart-block-type-8 #top #cart_block .cart-heading,
                        .cart-block-type-7 #top #cart_block .cart-heading,
                        .cart-block-type-4 #top #cart_block .cart-heading,
                        .cart-block-type-6 #top #cart_block .cart-heading,
                        .cart-block-type-8 #top #cart_block .cart-heading p,
                        .cart-block-type-4 #top #cart_block .cart-heading .cart-icon,
                        .rtl .cart-block-type-8 #top #cart_block .cart-heading p,
                        .rtl .header-type-10 #top #cart_block .cart-heading .cart-icon,
                        .rtl .cart-block-type-4 #top #cart_block .cart-heading .cart-icon
                    ',

                ),
                'title'    => esc_html__( 'Cart icon border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_cart_icon_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #top #cart_block .cart-heading .cart-icon,
                        .cart-block-type-2 #top #cart_block .cart-heading,
                        .cart-block-type-9 #top #cart_block .cart-heading,
                        .cart-block-type-8 #top #cart_block .cart-heading,
                        .cart-block-type-7 #top #cart_block .cart-heading,
                        .cart-block-type-4 #top #cart_block .cart-heading 
                    ',

                ),
                'title'    => esc_html__( 'Cart icon background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_cart_amount_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top #cart_block .cart-heading .cart-count
                    ',

                ),
                'title'    => esc_html__( 'Cart amount text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_cart_amount_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        #top #cart_block .cart-heading .cart-count
                    ',

                ),
                'title'    => esc_html__( 'Cart amount background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_cart_icon_image',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Cart icon', 'fastor' ),
                'compiler' => 'true',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_cart_price_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top #cart_block .cart-heading p
                    ',

                ),
                'title'    => esc_html__( 'Cart price color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_cart_bullet_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top #cart_block .cart-heading p:after
                    ',

                ),
                'title'    => esc_html__( 'Cart bullet color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-top_cart-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

            /* Top cart hover */
            array(
                'id'       => 'color-top_cart_hover-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Top -> Cart hover', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-top_cart_icon_hover_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        #top #cart_block:hover .cart-heading .cart-icon,
                        .cart-block-type-2 #top #cart_block:hover .cart-heading,
                        .cart-block-type-9 #top #cart_block:hover .cart-heading,
                        .cart-block-type-8 #top #cart_block:hover .cart-heading,
                        .cart-block-type-7 #top #cart_block:hover .cart-heading,
                        .cart-block-type-4 #top #cart_block:hover .cart-heading,
                        .cart-block-type-6 #top #cart_block:hover .cart-heading,
                        .cart-block-type-8 #top #cart_block:hover .cart-heading p,
                        .cart-block-type-4 #top #cart_block:hover .cart-heading .cart-icon,
                        .rtl .cart-block-type-8 #top #cart_block:hover .cart-heading p,
                        .rtl .header-type-10 #top #cart_block:hover .cart-heading .cart-icon,
                        .rtl .cart-block-type-4 #top #cart_block:hover .cart-heading .cart-icon
                    ',

                ),
                'title'    => esc_html__( 'Cart icon hover border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_cart_icon_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #top #cart_block:hover .cart-heading .cart-icon,
                        .cart-block-type-2 #top #cart_block:hover .cart-heading,
                        .cart-block-type-9 #top #cart_block:hover .cart-heading,
                        .cart-block-type-8 #top #cart_block:hover .cart-heading,
                        .cart-block-type-7 #top #cart_block:hover .cart-heading,
                        .cart-block-type-4 #top #cart_block:hover .cart-heading 
                    ',

                ),
                'title'    => esc_html__( 'Cart icon hover background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_cart_icon_hover_image',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Cart icon hover', 'fastor' ),
                'compiler' => 'true',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_cart_amount_hover_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top #cart_block:hover .cart-heading .cart-count
                    ',

                ),
                'title'    => esc_html__( 'Cart amount hover text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_cart_amount_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        #top #cart_block:hover .cart-heading .cart-count
                    ',

                ),
                'title'    => esc_html__( 'Cart amount hover background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_cart_price_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top #cart_block:hover .cart-heading p
                    ',

                ),
                'title'    => esc_html__( 'Cart price hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-top_cart_bullet_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #top #cart_block:hover .cart-heading p:after
                    ',

                ),
                'title'    => esc_html__( 'Cart bullet hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-top_cart_hover-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Menu */
            array(
                'id'       => 'color-menu-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Menu', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-menu_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                           .megamenu-background
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-main_links_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        ul.megamenu > li > a,
                        .responsive .megamenu-wrapper .megamenu-close-fixed 
                    ',

                ),
                'title'    => esc_html__( 'Main links color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-main_links_bullet_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        ul.megamenu > li.with-sub-menu > a strong:after
                    ',

                ),
                'title'    => esc_html__( 'Main links bullet color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-main_links_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        ul.megamenu > li:hover > a,
                        ul.megamenu > li.active > a,
                        ul.megamenu > li.home > a
                    ',

                ),
                'title'    => esc_html__( 'Main links hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-main_links_bullet_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        ul.megamenu > li.with-sub-menu:hover > a strong:after 
                    ',

                ),
                'title'    => esc_html__( 'Main links bullet hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-menu-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Sidebar menu  */
            array(
                'id'       => 'color-vertical_menu-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Sidebar menu', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-vertical_menu_heading_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                           #main .vertical .megamenuToogle-wrapper .container
                    ',

                ),
                'title'    => esc_html__( 'Heading text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-vertical_menu_heading_bullet_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .vertical .megamenuToogle-wrapper .container:after
                    ',
                    'background'            => '
                        .megamenu-type-15 .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        .megamenu-type-15 .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        .megamenu-type-15 .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        .megamenu-type-20 .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        .megamenu-type-20 .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        .megamenu-type-20 .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        .megamenu-type-34 .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        .megamenu-type-34 .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        .megamenu-type-34 .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        .megamenu-type-28 .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        .megamenu-type-28 .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        .megamenu-type-28 .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        .megamenu-type-25 .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        .megamenu-type-25 .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        .megamenu-type-25 .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        .megamenu-type-18 .slideshow-modules .vertical .megamenuToogle-wrapper .container:before,
                        .megamenu-type-18 .slideshow-modules .vertical .megamenuToogle-wrapper .container:after,
                        .megamenu-type-18 .slideshow-modules .vertical .megamenuToogle-wrapper:before
                    ',

                ),
                'title'    => esc_html__( 'Heading bullet color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-vertical_menu_heading_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        #main .vertical .megamenuToogle-wrapper,
                        .standard-body .full-width .megamenu-background .mega-menu-modules > div:first-child:before 
                    ',

                ),
                'title'    => esc_html__( 'Heading background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-vertical_menu_heading_hover_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .vertical:hover .megamenuToogle-wrapper .container,
                        body.home.show-vertical-megamenu #main .megamenu-background .vertical .megamenuToogle-wrapper .container,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page #main .megamenu-background .vertical .megamenuToogle-wrapper .container,
                        .home.show-vertical-megamenu #main .slideshow-modules .vertical .megamenuToogle-wrapper .container
                    ',

                ),
                'title'    => esc_html__( 'Heading hover text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-vertical_menu_heading_hover_bullet_color',
                'type'     => 'color',
                'output'    => array(
                    'color' =>  '
                        #main .vertical:hover .megamenuToogle-wrapper .container:after,
                        body.home.show-vertical-megamenu #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after
                    ',
                    'background'            => '
                        .megamenu-type-15 .megamenu-background .vertical:hover .megamenuToogle-wrapper .container:before,
                        .megamenu-type-15 .megamenu-background .vertical:hover .megamenuToogle-wrapper .container:after,
                        .megamenu-type-15 .megamenu-background .vertical:hover .megamenuToogle-wrapper:before,
                        .megamenu-type-18 .slideshow-modules .vertical:hover .megamenuToogle-wrapper .container:before,
                        .megamenu-type-18 .slideshow-modules .vertical:hover .megamenuToogle-wrapper .container:after,
                        .megamenu-type-18 .slideshow-modules .vertical:hover .megamenuToogle-wrapper:before,
                        .megamenu-type-20 .slideshow-modules .vertical:hover .megamenuToogle-wrapper .container:before,
                        .megamenu-type-20 .slideshow-modules .vertical:hover .megamenuToogle-wrapper .container:after,
                        .megamenu-type-20 .slideshow-modules .vertical:hover .megamenuToogle-wrapper:before,
                        .megamenu-type-34 .slideshow-modules .vertical:hover .megamenuToogle-wrapper .container:before,
                        .megamenu-type-34 .slideshow-modules .vertical:hover .megamenuToogle-wrapper .container:after,
                        .megamenu-type-34 .slideshow-modules .vertical:hover .megamenuToogle-wrapper:before,
                        .megamenu-type-28 .slideshow-modules .vertical:hover .megamenuToogle-wrapper .container:before,
                        .megamenu-type-28 .slideshow-modules .vertical:hover .megamenuToogle-wrapper .container:after,
                        .megamenu-type-28 .slideshow-modules .vertical:hover .megamenuToogle-wrapper:before,
                        .megamenu-type-25 .slideshow-modules .vertical:hover .megamenuToogle-wrapper .container:before,
                        .megamenu-type-25 .slideshow-modules .vertical:hover .megamenuToogle-wrapper .container:after,
                        .megamenu-type-25 .slideshow-modules .vertical:hover .megamenuToogle-wrapper:before,
                        body.home.show-vertical-megamenu.megamenu-type-15 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        body.home.show-vertical-megamenu.megamenu-type-15 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body.home.show-vertical-megamenu.megamenu-type-15 #main .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        body.home.show-vertical-megamenu.megamenu-type-18 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        body.home.show-vertical-megamenu.megamenu-type-18 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body.home.show-vertical-megamenu.megamenu-type-18 #main .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        body.home.show-vertical-megamenu.megamenu-type-20 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        body.home.show-vertical-megamenu.megamenu-type-20 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body.home.show-vertical-megamenu.megamenu-type-20 #main .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        body.home.show-vertical-megamenu.megamenu-type-34 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        body.home.show-vertical-megamenu.megamenu-type-34 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body.home.show-vertical-megamenu.megamenu-type-34 #main .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        body.home.show-vertical-megamenu.megamenu-type-28 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        body.home.show-vertical-megamenu.megamenu-type-28 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body.home.show-vertical-megamenu.megamenu-type-28 #main .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        body.home.show-vertical-megamenu.megamenu-type-25 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        body.home.show-vertical-megamenu.megamenu-type-25 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body.home.show-vertical-megamenu.megamenu-type-25 #main .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-15 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-15 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-15 #main .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-18 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-18 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-18 #main .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-20 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-20 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-20 #main .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-34 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-34 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-34 #main .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-28 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-28 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-28 #main .megamenu-background .vertical .megamenuToogle-wrapper:before,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-25 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:before,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-25 #main .megamenu-background .vertical .megamenuToogle-wrapper .container:after,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page.megamenu-type-25 #main .megamenu-background .vertical .megamenuToogle-wrapper:before
                    ',

                ),
                'title'    => esc_html__( 'Heading bullet hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-vertical_menu_heading_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        #main .vertical:hover .megamenuToogle-wrapper,
                        body.home.show-vertical-megamenu #main .megamenu-background .vertical .megamenuToogle-wrapper,
                        body[class*="body-product-category"].show-vertical-megamenu-category-page #main .megamenu-background .vertical .megamenuToogle-wrapper,
                        body.home.show-vertical-megamenu #main .slideshow-modules .vertical .megamenuToogle-wrapper
                    ',

                ),
                'title'    => esc_html__( 'Heading hover background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-vertical_menu_content_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        #main .vertical .megamenu-wrapper
                    ',

                ),
                'title'    => esc_html__( 'Content background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-vertical_menu_content_links_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .vertical ul.megamenu > li > a
                    ',

                ),
                'title'    => esc_html__( 'Content links color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-vertical_menu_content_border2_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        #main .vertical .megamenu-wrapper
                    ',

                ),
                'title'    => esc_html__( 'Content border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-vertical_menu_content_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        #main .vertical ul.megamenu > li
                    ',

                ),
                'title'    => esc_html__( 'Content links border top color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-vertical_menu_content_links_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .vertical ul.megamenu > li:hover > a,
                        #main .vertical ul.megamenu > li.active > a
                    ',

                ),
                'title'    => esc_html__( 'Content links hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-vertical_menu_content_links_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #main .vertical ul.megamenu > li:hover
                    ',

                ),
                'title'    => esc_html__( 'Content links hover background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-vertical_menu_content_bullet_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .vertical ul.megamenu > li.with-sub-menu > a:before,
                        #main .vertical ul.megamenu > li.with-sub-menu > a:after
                    ',

                ),
                'title'    => esc_html__( 'Content bullet color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-vertical_menu_content_bullet_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .vertical ul.megamenu > li.with-sub-menu:hover > a:before,
                        #main .vertical ul.megamenu > li.with-sub-menu:hover > a:after
                    ',

                ),
                'title'    => esc_html__( 'Content bullet hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-menu_vertical-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* Menu -> Submenu */
            array(
                'id'       => 'color-submenu-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Menu -> Submenu', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-submenu_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        ul.megamenu li .sub-menu .content,
                        ul.megamenu li .sub-menu .content .hover-menu .menu ul ul
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-submenu_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        ul.megamenu li .sub-menu .content
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-submenu_links_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        ul.megamenu li .sub-menu .content a
                    ',

                ),
                'title'    => esc_html__( 'Links color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-submenu_links_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        ul.megamenu li .sub-menu .content a:hover,
                        ul.megamenu li .sub-menu .content .hover-menu .menu ul li:hover > a
                    ',

                ),
                'title'    => esc_html__( 'Links hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-submenu_bullets_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        ul.megamenu li .sub-menu .content .hover-menu a.with-submenu:before
                    ',

                ),
                'title'    => esc_html__( 'Bullets color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-submenu_bullets_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        ul.megamenu li .sub-menu .content .hover-menu a.with-submenu:after,
                        ul.megamenu li .sub-menu .content .hover-menu li:hover > a.with-submenu:before
                    ',

                ),
                'title'    => esc_html__( 'Bullets hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-submenu_main_links_in_visible_type_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        ul.megamenu li .sub-menu .content .static-menu a.main-menu
                    ',

                ),
                'title'    => esc_html__( 'Main links in visible type color', 'fastor' ),
                'default'  => '',

                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-submenu_main_links_hover_in_visible_type_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        ul.megamenu li .sub-menu .content .static-menu a.main-menu:hover
                    ',

                ),
                'title'    => esc_html__( 'Main links in visible type hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-submenu_main_links_in_visible_type_border_bottom_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        ul.megamenu li .sub-menu .content .static-menu a.main-menu:after
                    ',

                ),
                'title'    => esc_html__( 'Main links in visible type border bottom color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-submenu-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),




            /* Mobile menu -> Heading */
            array(
                'id'       => 'color-mobile_menu-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Mobile menu -> Heading', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-mobile_menu_heading_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        .megamenuToogle-wrapper
                    ',

                ),
                'title'    => esc_html__( 'Heading background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-mobile_menu_heading_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .megamenuToogle-wrapper .container 
                    ',

                ),
                'title'    => esc_html__( 'Heading text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-mobile_menu_heading_bullet_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .megamenuToogle-wrapper .container > div span
                    ',

                ),
                'title'    => esc_html__( 'Heading bullet color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-mobile_menu_heading_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        .megamenuToogle-wrapper:hover,
                        .active .megamenuToogle-wrapper
                    ',

                ),
                'title'    => esc_html__( 'Heading hover background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-mobile_menu_heading_hover_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .megamenuToogle-wrapper:hover .container,
                        .active .megamenuToogle-wrapper .container
                    ',

                ),
                'title'    => esc_html__( 'Heading text hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-mobile_menu_heading_hover_bullet_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .megamenuToogle-wrapper:hover .container > div span,
                        .active .megamenuToogle-wrapper .container > div span
                    ',

                ),
                'title'    => esc_html__( 'Heading bullet hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-mobile_menu-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* Mobile menu -> Content */
            array(
                'id'       => 'color-mobile_menu_content-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Mobile menu -> Content', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-mobile_menu_content_background_color',
                'type'     => 'color',
//                'output'    => array(),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-mobile_menu_content_border_color',
                'type'     => 'color',
                //'output'    => array(),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-mobile_menu_content_link_color',
                'type'     => 'color',
//                'output'    => array(),
                'title'    => esc_html__( 'Link color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-mobile_menu_content_link_active_color',
                'type'     => 'color',
//                'output'    => array(),
                'title'    => esc_html__( 'Link active color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-mobile_menu_content_link_border_top_color',
                'type'     => 'color',
//                'output'    => array(),
                'title'    => esc_html__( 'Link border top color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-mobile_menu_content_link_hover_background_color',
                'type'     => 'color',
//                'output'    => array(),
                'title'    => esc_html__( 'Link hover background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-mobile_menu_content_plus_minus_color',
                'type'     => 'color',
//                'output'    => array(),
                'title'    => esc_html__( 'Plus/minus color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'     => 'color-mobile_menu_content-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* Breadcrumb */
            array(
                'id'       => 'color-breadcrumb-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Breadcrumb', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-breadcrumb_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #main .breadcrumb .background
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-breadcrumb_border_bottom_color',
                'type'     => 'color',
                'output'    => array(
                    'border-bottom-color'            => '
                        #main .breadcrumb .background
                    ',

                ),
                'title'    => esc_html__( 'Border bottom color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-breadcrumb_border_bottom_4px_color',
                'type'     => 'color',
                'output'    => array(
                    'border-bottom-color'            => '
                        #main .breadcrumb .background
                    ',

                ),
                'title'    => esc_html__( 'Border bottom 4px color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-breadcrumb_border_top_color',
                'type'     => 'color',
                'output'    => array(
                    'border-top-color'            => '
                        #main .breadcrumb .background 
                    ',

                ),
                'title'    => esc_html__( 'Border top color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-breadcrumb_heading_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .breadcrumb .container h1
                    ',

                ),
                'title'    => esc_html__( 'Heading color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-breadcrumb_heading_border_bottom_color',
                'type'     => 'color',
                'output'    => array(
                    'border-bottom-color'            => '
                        .breadcrumb .container h1
                    ',

                ),
                'title'    => esc_html__( 'Heading border bottom color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-breadcrumb_links_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .breadcrumb ul,
                        .breadcrumb ul a
                    ',

                ),
                'title'    => esc_html__( 'Links color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-breadcrumb_links_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .breadcrumb ul a:hover
                    ',

                ),
                'title'    => esc_html__( 'Links hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-breadcrumb_price_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .next-product .right .price
                    ',

                ),
                'title'    => esc_html__( 'Price color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-breadcrumb-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Breadcrumb -> Product next/prev product */
            array(
                'id'       => 'color-breadcrumb_button-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Breadcrumb -> Product next/prev button', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-breadcrumb_button_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .button-previous-next,
                        .next-product
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-breadcrumb_button_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .button-previous-next,
                        .next-product
                    ',

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-breadcrumb_button_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .button-previous-next
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-breadcrumb_button_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .button-previous-next:hover
                    ',

                ),
                'title'    => esc_html__( 'Background hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-breadcrumb_button_hover_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .button-previous-next:hover 
                    ',

                ),
                'title'    => esc_html__( 'Border hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-breadcrumb_button_hover_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .button-previous-next:hover
                    ',

                ),
                'title'    => esc_html__( 'Text hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-breadcrumb_button-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

            /* Main content */
            array(
                'id'       => 'color-main_content-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Main content', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'color-main_content_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        .product-filter,
                        .product-list,
                        .center-column .product-grid,
                        .standard-body .full-width .center-column.content-with-background:before,
                        .manufacturer-heading,
                        .manufacturer-content,
                        .center-column .tab-content,
                        .body-other .standard-body .full-width .product-info:before,
                        .product-info .cart,
                        .box .box-content.products,
                        .product-grid .product-hover .only-hover,
                        html .mfp-iframe-scaler iframe,
                        .quickview body,
                        table.attribute tr, table.list tr, .wishlist-product table tr, .wishlist-info table tr, .compare-info tr, .checkout-product table tr, .table tr, .table,
                        .spinner,
                        img[src="image/catalog/blank.gif"],
                        #mfilter-content-container > span:before,
                        .cart-info table tr,
                        .center-column .panel-heading,
                        .center-column .panel-body,
                        .popup,
                        .product-block,
                        .review-list .text,
                        .modal-content,
                        .product-info .product-image,
                        .product-page-type-2 .standard-body .full-width .overflow-thumbnails-carousel,
                        .product-page-type-2 .standard-body .full-width .product-info .product-center:before,
                        .main-fixed3 .main-content .background,
                        .product-grid-type-2 .product-grid .product:hover:before,
                        .product-grid-type-3 .product-grid .product:hover:before,
                        .product-grid-type-5 .product-grid .product:hover:before,
                        .tab-content,
                        .news.v2  .media-body .bottom
                    ',
                    'border-bottom-color' => '
                        .review-list .text:after,
                        #main .post .comments-list .text:after 
                    ',
                    'border-color' => '
                        product-grid .product:before
                    '

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-main_content_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        table.attribute,
                        table.list,
                        .wishlist-product table,
                        .wishlist-info table,
                        .compare-info,
                        .cart-info table,
                        .checkout-product table,
                        .table,
                        table.attribute td,
                        table.list td,
                        .wishlist-product table td,
                        .wishlist-info table td,
                        .compare-info td,
                        .cart-info table td,
                        .checkout-product table td,
                        .table td ,
                        .manufacturer-list,
                        .manufacturer-heading,
                        .center-column .panel-body,
                        .review-list .text,
                        .product-info .cart,
                        .product-info .cart .links,
                        .product-info .cart .links a:last-child,
                        .product-info .cart .minimum,
                        .product-info .review,
                        .border-width-1 .standard-body .full-width .col-md-12 .col-md-12.center-column .cart-info thead td:first-child:before,
                        .cart-info table thead td,
                        #main .center-column .panel-heading,
                        .main-fixed .center-column .panel:last-child, .standard-body .full-width .center-column .panel:last-child, .standard-body .fixed .center-column .panel:last-child,
                        .center-column .panel-body,
                        .body-white.checkout-checkout .standard-body .full-width .center-column .panel:last-child,
                        .manufacturer-content,
                        .product-block,
                        .modal-header,
                        .product-info .thumbnails li img, .product-info .thumbnails-carousel img,
                        .product-info .product-image,
                        .box-type-15 .col-sm-12 .box.box-with-products .box-content,
                        .box-type-15 .col-md-12 .box.box-with-products .box-content,
                        .box-type-15 .col-sm-12 .filter-product .tab-content,
                        .box-type-15 .col-md-12 .filter-product .tab-content,
                        .body-white.module-faq .standard-body #main .full-width .center-column .faq-section:last-child .panel:last-child,
                        .product-info .radio-type-button2 span,
                        .product-info .radio-type-button span,
                        #main .mfilter-image ul li,
                        .news.v2  .media-body .bottom,
                        .news.v2 .media-body .date-published,
                        #main .post .comments-list .text,
                        #main .posts .post .post-content,
                        #main .post .date-published,
                        #main .post .meta,
                        #main .post .post-content,
                        .category-wall ul li a,
                        .more-link,
                        .body-white-type-2.checkout-cart .main-fixed .center-column > form > *:first-child,
                        table.woocommerce-checkout-review-order-table tfoot tr:first-child td,
                         table.woocommerce-checkout-review-order-table tfoot tr:first-child th,
                          table.order_details tfoot tr:first-child td, 
                          table.order_details tfoot tr:first-child th,
                           table.customer_details tr th,
                           table th,
                           .product-center .wcpb-bundled-product,
                           .woocommerce-MyAccount-navigation ul li a,
                           .product-center .wcpb-bundled-product,
                           .cart-total table,
                           .entry-content table td, .post-content table td, .comments table td,
                           .widget_recent_entries ul li
                    ',
                    'border-bottom-color'   =>  '
                        .product-info .description,
                        .category-list,
                        .review-list .text:before,
                        #main .post .comments-list .text:before
                    ',
                    'border-top-color'   =>  '
                        .product-info .options,
                        .product-list,
                        .list-box li 
                    ',
                    'background'   =>  '
                        .box-with-products .clear:before,
                        .box-with-products .clear:after,
                        .product-grid .product:before,
                        .product-list > div:before,
                        .product-list .name-actions:before,
                        .product-list .desc:before,
                        .center-column .product-grid:before,
                        .center-column .product-grid:after,
                        .product-grid > .row:before,
                        .category-info:before,
                        .refine_search_overflow:after,
                        .tab-content:before,
                        .tab-content:after,
                        .product-filter .list-options .limit:before,
                        .product-filter .list-options .sort:before,
                        .product-filter .options .product-compare:before,
                        .is-countdown .countdown-section:after
                    '

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-main_content_headings_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .center-column h1,
                        .center-column h2,
                        .center-column h3,
                        .center-column h4,
                        .center-column h5,
                        .center-column h6,
                        .center-column legend,
                        .popup h4
                    ',

                ),
                'title'    => esc_html__( 'Headings color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-main_content-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Pagination */
            array(
                'id'       => 'color-pagination-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Pagination', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-pagination_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #mfilter-content-container > div.pagination-results .text-right,
                        .content-without-background #mfilter-content-container > p
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-pagination-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

            /* Product filter */
            array(
                'id'       => 'color-product_filter-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Product filter', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-product_filter_icon_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .product-filter .options .button-group button
                    ',

                ),
                'title'    => esc_html__( 'Icon color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-product_filter_icon_active_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .product-filter .options .button-group button:hover,
                        .product-filter .options .button-group .active
                    ',

                ),
                'title'    => esc_html__( 'Icon active color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-product_filter-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Box */
            array(
                'id'       => 'color-box-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Box', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-box_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .box .box-content.products,
                        .product-grid .product-hover .only-hover
                    ',
                    'border-color'            => '
                        .product-grid .product:before
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .box .box-content
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_links_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .box .box-content a
                    ',

                ),
                'title'    => esc_html__( 'Links color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-box-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Box -> Heading */
            array(
                'id'       => 'color-box_heading-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Box -> Heading', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-box_heading_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .box,
                        .bg-filter-tabs,
                        .htabs:before 
                    '

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_heading_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .box .box-heading,
                        .woocommerce-billing-fields h3,
                        .product-block .title-block,
                        .refine_search
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_heading_border_bottom_color',
                'type'     => 'color',
                'output'    => array(
                    'border-bottom-color'            => '
                        .box .box-heading,
                        .col-sm-4 .box-no-advanced.box.today-deals-toys2 .box-heading,
                        .woocommerce-billing-fields h3,
                        .categories-wall .category-wall h3,
                        .product-block .title-block,
                        .refine_search,
                        .market-products-categories > ul > li > a
                    ',

                ),
                'title'    => esc_html__( 'Border bottom color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-box_heading-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Box -> Button prev/next */
            array(
                'id'       => 'color-box_button-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Box -> Prev/Next Button', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-box_button_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .box > .prev, 
                        .box > .next,
                        .product-info .thumbnails-carousel .owl-buttons .owl-prev, 
                        .product-info .thumbnails-carousel .owl-buttons .owl-next,
                        div.pagination-results ul li,
                        .tab-content .prev-button,
                        .tab-content .next-button 
                    '

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_button_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .box > .prev, .box > .next, box_button_text_color,
                        .product-info .thumbnails-carousel .owl-buttons .owl-prev, 
                        .product-info .thumbnails-carousel .owl-buttons .owl-next,
                        div.pagination-results ul li,
                        .tab-content .prev-button,
                        .tab-content .next-button
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_button_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .box > .prev, 
                        .box > .next,
                        .product-info .thumbnails-carousel .owl-buttons .owl-prev, 
                        .product-info .thumbnails-carousel .owl-buttons .owl-next,
                        div.pagination-results ul li,
                        .tab-content .prev-button,
                        .tab-content .next-button
                    ',

                ),
                'title'    => esc_html__( 'Border bottom color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-box_button_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .box > .prev:hover, 
                        .box > .next:hover,
                        .product-info .thumbnails-carousel .owl-buttons .owl-prev:hover, 
                        .product-info .thumbnails-carousel .owl-buttons .owl-next:hover,
                        div.pagination-results ul li:hover,
                        .tab-content .prev-button:hover,
                        .tab-content .next-button:hover
                    '

                ),
                'title'    => esc_html__( 'Background hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_button_hover_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .box > .prev:hover, 
                        .box > .next:hover,
                        .product-info .thumbnails-carousel .owl-buttons .owl-prev:hover, 
                        .product-info .thumbnails-carousel .owl-buttons .owl-next:hover,
                        div.pagination-results ul li:hover,
                        .tab-content .prev-button:hover,
                        .tab-content .next-button:hover
                    ',

                ),
                'title'    => esc_html__( 'Text hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_button_hover_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .box > .prev:hover, 
                        .box > .next:hover,
                        .product-info .thumbnails-carousel .owl-buttons .owl-prev:hover, 
                        .product-info .thumbnails-carousel .owl-buttons .owl-next:hover,
                        div.pagination-results ul li:hover,
                        .tab-content .prev-button:hover,
                        .tab-content .next-button:hover
                    ',

                ),
                'title'    => esc_html__( 'Border bottom hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-box_button-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* BOX ON LEFT/RIGHT COLUMN */
            array(
                'id'       => 'color-box_left-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Box on left/right column', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-box_left_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #order_review, .col-sm-3 .box-no-advanced.box .box-content, .col-sm-4 .box-no-advanced.box .box-content, .col-md-3 .box-no-advanced.box .box-content, .col-md-4 .box-no-advanced.box .box-content
                    '

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_left_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        #order_review, .col-sm-3 .box-no-advanced.box .box-content, .col-sm-4 .box-no-advanced.box .box-content, .col-md-3 .box-no-advanced.box .box-content, .col-md-4 .box-no-advanced.box .box-content,
                         #order_review, .col-sm-3 .box-no-advanced.box .box-heading, .col-sm-4 .box-no-advanced.box .box-heading, .col-md-3 .box-no-advanced.box .box-heading, .col-md-4 .box-no-advanced.box .box-heading
                    ',

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_left_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #order_review, .col-sm-3 .box-no-advanced.box .box-content, .col-sm-4 .box-no-advanced.box .box-content, .col-md-3 .box-no-advanced.box .box-content, .col-md-4 .box-no-advanced.box .box-content,
                        #main .mfilter-price-inputs input
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-box_left_links_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .col-sm-3 .box-no-advanced.box .box-content a, .col-sm-4 .box-no-advanced.box .box-content a, .col-md-3 .box-no-advanced.box .box-content a, .col-md-4 .box-no-advanced.box .box-content a 
                    '

                ),
                'title'    => esc_html__( 'Links color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_left_links_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .col-sm-3 .box-no-advanced.box .box-content a:hover, .col-sm-4 .box-no-advanced.box .box-content a:hover, .col-md-3 .box-no-advanced.box .box-content a:hover, .col-md-4 .box-no-advanced.box .box-content a:hover
                    ',

                ),
                'title'    => esc_html__( 'Links hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'     => 'color-box_left-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* BOX ON LEFT/RIGHT COLUMN -> Heading */
            array(
                'id'       => 'color-box_left_heading-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Box on left/right column -> Heading', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-box_left_heading_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .col-sm-3 .box-no-advanced.box, .col-sm-4 .box-no-advanced.box, .col-md-3 .box-no-advanced.box, .col-md-4 .box-no-advanced.box
                    '
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_left_heading_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .col-sm-3 .box-no-advanced.box .box-heading, .col-sm-4 .box-no-advanced.box .box-heading, .col-md-3 .box-no-advanced.box .box-heading, .col-md-4 .box-no-advanced.box .box-heading 
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_left_heading_border_bottom_color',
                'type'     => 'color',
                'output'    => array(
                    'border-bottom-color'            => '
                        .col-sm-3 .box-no-advanced.box .box-heading, .col-sm-4 .box-no-advanced.box .box-heading, .col-md-3 .box-no-advanced.box .box-heading, .col-md-4 .box-no-advanced.box .box-heading,
                        .col-sm-3 .blog-module.box .box-heading, .col-sm-4 .blog-module.box .box-heading, .col-md-3 .blog-module.box .box-heading, .col-md-4 .blog-module.box .box-heading
                    ',

                ),
                'title'    => esc_html__( 'Border bottom color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-box_left_heading-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* BOX Categories */
            array(
                'id'       => 'color-box_categories-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Box categories', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-box_categories_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #main .box-with-categories .box-content 
                    '
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_categories_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .box-with-categories .box-content
                    ',

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_categories_link_border_top_color',
                'type'     => 'color',
                'output'    => array(
                    'border-top-color'            => '
                        .box-category > ul li
                    ',

                ),
                'title'    => esc_html__( 'Link border top color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-box_categories_links_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .box-category ul li > a 
                    ',

                ),
                'title'    => esc_html__( 'Links color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_categories_links_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .box-category ul li > a:hover 
                    ',

                ),
                'title'    => esc_html__( 'Links hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_categories_links_active_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .box-category ul li a.active
                    ',

                ),
                'title'    => esc_html__( 'Links active color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_categories_links_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .box-category > ul li > a:hover, 
                        .box-category > ul li:hover > a, 
                        .box-category > ul li a.active
                    ',

                ),
                'title'    => esc_html__( 'Links hover background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_categories_bullet_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .box-category ul li .head a
                    ',

                ),
                'title'    => esc_html__( 'Bullet color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-box_categories-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* BOX Categories -> Heading */
            array(
                'id'       => 'color-box_categories_heading-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Box categories -> Heading', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-box_categories_heading_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .box-with-categories .box-heading
                    '
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_categories_heading_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .box-with-categories .box-heading 
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'     => 'color-box_categories_heading-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Box with products */
            array(
                'id'       => 'color-box_with_products-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Box with products', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-box_with_products_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                            .box.box-with-products,
                            .product-filter,
                            .product-list, 
                            .center-column .product-grid,
                            #main .box .box-content.products,
                            body #main .post .box.box-with-products .box-content,
                            .product-grid .product-hover .only-hover,
                            .product-grid-type-2 .product-grid .product:hover:before, 
                            .product-grid-type-3 .product-grid .product:hover:before, 
                            .product-grid-type-5 .product-grid .product:hover:before,
                            .product-info .product-image 
                    ',
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_with_products_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .product-grid .product:before,
                        .product-list
                        
                    ',
                    'background-color'            => '
                        .box-with-products .clear:before, 
                        .box-with-products .clear:after, 
                        .product-grid .product:before, 
                        .product-list > div:before, 
                        .product-list .desc:before,
                        .product-list .name-actions:before,
                        .center-column .product-grid:before, 
                        .center-column .product-grid:after, 
                        .product-grid > .row:before, 
                        .product-filter .list-options .limit:before, 
                        .product-filter .list-options .sort:before, 
                        .product-filter .options .product-compare:before
                        
                    ',

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

             array(
                'id'       => 'color-box_with_products_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .box.box-with-products,
                        .product-filter,
                        .product-list, 
                        .center-column .product-grid,
                        .box .box-content.products,
                        .product-grid .product-hover .only-hover,
                        .product-filter .list-options select
                    ',

                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                 'required' => array( 'color-status', '=', 1 )
            ),
             array(
                'id'       => 'color-box_with_products_links_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .box.box-with-products a,
                        .product-filter a,
                        .product-list a, 
                        .center-column .product-grid a,
                        .box .box-content.products a,
                        .product-grid .product-hover .only-hover a
                    ',

                ),
                'title'    => esc_html__( 'Links color', 'fastor' ),
                'default'  => '',
                 'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_with_products_links_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .box.box-with-products a:hover,
                        .product-filter a:hover,
                        .product-list a:hover, 
                        .center-column .product-grid a:hover,
                        .box .box-content.products a:hover,
                        .product-grid .product-hover .only-hover a:hover 
                    ',

                ),
                'title'    => esc_html__( 'Links hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-box_with_products_heading_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .box.box-with-products .box-heading
                    ',

                ),
                'title'    => esc_html__( 'Heading color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-box_with_products_heading_border_bottom_color',
                'type'     => 'color',
                'output'    => array(
                    'border-bottom-color'            => '
                        .box.box-with-products .box-heading
                    ',

                ),
                'title'    => esc_html__( 'Heading border bottom color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'     => 'color-box_with_products-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* Tabs */
            array(
                'id'       => 'color-tabs-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Tabs', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-tabs_link_active',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .filter-product .filter-tabs ul > li.active > a, .filter-product .filter-tabs ul > li.active > a:hover, .filter-product .filter-tabs ul > li.active > a:focus, .htabs a.selected, .htabs a:hover 
                    ',
                ),
                'title'    => esc_html__( 'Link active color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-tabs_link_active_border_bottom_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .htabs a.selected:before,
                        .filter-product .filter-tabs ul > li.active > a:before 
                    ',

                ),
                'title'    => esc_html__( 'Link active border bottom color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

             array(
                'id'       => 'color-tabs_links_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .filter-product .filter-tabs ul > li > a,
                        .htabs  a
                    ',

                ),
                'title'    => esc_html__( 'Links color', 'fastor' ),
                'default'  => '',
                 'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-tabs-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),
//
//
////            /* Category wall */
////            array(
////                'id'       => 'color-category_wall-section-start',
////                'type'     => 'section',
////                'title'    => esc_html__( 'Category wall', 'fastor' ),
////                'indent'   => true, // Indent all options below until the next 'section' option is set.
////            ),
////
////            array(
////                'id'       => 'color-category_wall_heading_border_bottom_color',
////                'type'     => 'color',
////                'output'    => array(
////                    'border-bottom-color'            => '
////                        .categories-wall .category-wall h3
////                     ',
////                ),
////                'title'    => esc_html__( 'Heading border bottom color', 'fastor' ),
////                'default'  => '',
////                'required' => array( 'color-status', '=', 1 )
////            ),
////
////            array(
////                'id'     => 'color-category_wall-section-end',
////                'type'   => 'section',
////                'indent' => false, // Indent all options below until the next 'section' option is set.
////            ),
//
//            /* Category wall -> Button */
//            array(
//                'id'       => 'color-category_wall_button-section-start',
//                'type'     => 'section',
//                'title'    => esc_html__( 'Category wall -> Button', 'fastor' ),
//                'indent'   => true, // Indent all options below until the next 'section' option is set.
//            ),
//
//            array(
//                'id'       => 'color-category_wall_button_background_color',
//                'type'     => 'color',
//                'output'    => array(
//                    'background'            => '
//                        .categories-wall .category-wall .more-categories
//                     ',
//                ),
//                'title'    => esc_html__( 'Background color', 'fastor' ),
//                'default'  => '',
//                'required' => array( 'color-status', '=', 1 )
//            ),
//            array(
//                'id'       => 'color-category_wall_button_border_color',
//                'type'     => 'color',
//                'output'    => array(
//                    'border-color'            => '
//                        .categories-wall .category-wall .more-categories
//                     ',
//                ),
//                'title'    => esc_html__( 'Border color', 'fastor' ),
//                'default'  => '',
//                'required' => array( 'color-status', '=', 1 )
//            ),
//            array(
//                'id'       => 'color-category_wall_button_text_color',
//                'type'     => 'color',
//                'output'    => array(
//                    'color'            => '
//                        .categories-wall .category-wall .more-categories
//                     ',
//                ),
//                'title'    => esc_html__( 'Text color', 'fastor' ),
//                'default'  => '',
//                'required' => array( 'color-status', '=', 1 )
//            ),
//
//            array(
//                'id'       => 'color-category_wall_button_hover_background_color',
//                'type'     => 'color',
//                'output'    => array(
//                    'background'            => '
//                        .categories-wall .category-wall .more-categories:hover
//                     ',
//                ),
//                'title'    => esc_html__( 'Background hover color', 'fastor' ),
//                'default'  => '',
//                'required' => array( 'color-status', '=', 1 )
//            ),
//            array(
//                'id'       => 'color-category_wall_button_hover_border_color',
//                'type'     => 'color',
//                'output'    => array(
//                    'border-color'            => '
//                        .categories-wall .category-wall .more-categories:hover
//                     ',
//                ),
//                'title'    => esc_html__( 'Border hover color', 'fastor' ),
//                'default'  => '',
//                'required' => array( 'color-status', '=', 1 )
//            ),
//            array(
//                'id'       => 'color-category_wall_button_hover_text_color',
//                'type'     => 'color',
//                'output'    => array(
//                    'color'            => '
//                        .categories-wall .category-wall .more-categories:hover
//                     ',
//                ),
//                'title'    => esc_html__( 'Text hover color', 'fastor' ),
//                'default'  => '',
//                'required' => array( 'color-status', '=', 1 )
//            ),
//
//            array(
//                'id'     => 'color-category_wall_button-section-end',
//                'type'   => 'section',
//                'indent' => false, // Indent all options below until the next 'section' option is set.
//            ),

            /* Popup */
            array(
                'id'       => 'color-popup-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Popup', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-popup_heading_border_bottom_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .popup h4:after
                     ',
                ),
                'title'    => esc_html__( 'Heading border bottom color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'     => 'color-popup-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Popup -> Newsletter*/
            array(
                'id'       => 'color-popup_newsletter-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Popup -> Newsletter', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-popup_newsletter_input_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .popup .newsletter input,
                        .popup .newsletter input::-webkit-input-placeholder,
                        .popup .newsletter input:-moz-placeholder,
                        .popup .newsletter input::-moz-placeholder,
                        .popup .newsletter input:-ms-input-placeholder
                     ',
                ),
                'title'    => esc_html__( 'Input text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-popup_newsletter_input_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .popup .newsletter input 
                     ',
                ),
                'title'    => esc_html__( 'Input background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-popup_newsletter_input_focus_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .popup .newsletter input:focus
                     ',
                ),
                'title'    => esc_html__( 'Input focus background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-popup_newsletter_subscribe_button_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .popup .newsletter .subscribe
                     ',
                ),
                'title'    => esc_html__( 'Subscribe button text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-popup_newsletter_subscribe_button_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .popup .newsletter .subscribe
                     ',
                ),
                'title'    => esc_html__( 'Subscribe button background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-popup_newsletter_subscribe_button_hover_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        popup .newsletter .subscribe:hover
                     ',
                ),
                'title'    => esc_html__( 'Subscribe button hover text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-popup_newsletter_subscribe_button_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        popup .newsletter .subscribe:hover
                     ',
                ),
                'title'    => esc_html__( 'Subscribe button hover background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-popup_newsletter-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* Popup -> Close button*/
            array(
                'id'       => 'color-popup_close_button-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Popup -> Close button', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-popup_close_button_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        body .popup-module .mfp-close
                     ',
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-popup_close_button_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        body .popup-module .mfp-close
                     ',
                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-popup_close_button_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        body .popup-module .mfp-close
                     ',
                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-popup_close_button_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        body .popup-module .mfp-close:hover
                     ',
                ),
                'title'    => esc_html__( 'Background hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-popup_close_button_hover_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        body .popup-module .mfp-close:hover
                     ',
                ),
                'title'    => esc_html__( 'Border hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-popup_close_button_hover_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        body .popup-module .mfp-close:hover
                     ',
                ),
                'title'    => esc_html__( 'Text hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'     => 'color-popup_close_button-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),




            /* Slider */
            array(
                'id'       => 'color-slider-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Slider', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-slider_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #slider .pattern
                     ',
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-slider_loader_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background-color'            => '
                        .spinner
                     ',
                ),
                'title'    => esc_html__( 'Loader background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-slider_loader_border_bottom_color',
                'type'     => 'color',
                'output'    => array(
                    'border-bottom-color'            => '
                        #slider .pattern
                    ',

                ),
                'title'    => esc_html__( 'Border bottom 4px color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'     => 'color-slider-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Slider -> Prev/Next Button */
            array(
                'id'       => 'color-slider_button-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Slider prev/next buttons', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-slider_buttons_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .camera_wrap .owl-controls .owl-buttons .owl-prev, .camera_wrap .owl-controls .owl-buttons .owl-next,
                        #main .tp-leftarrow.default,
                        #main .tp-rightarrow.default,
                        #main .post .post-media .media-slider .owl-controls .owl-buttons .owl-prev,
                        #main .post .post-media .media-slider .owl-controls .owl-buttons .owl-next
                     ',
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-slider_buttons_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .camera_wrap .owl-controls .owl-buttons .owl-prev, .camera_wrap .owl-controls .owl-buttons .owl-next,
                        #main .tp-leftarrow.default,
                        #main .tp-rightarrow.default,
                        #main .post .post-media .media-slider .owl-controls .owl-buttons .owl-prev,
                        #main .post .post-media .media-slider .owl-controls .owl-buttons .owl-next
                     ',
                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-slider_buttons_icon_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .camera_wrap .owl-controls .owl-buttons .owl-prev:before, .camera_wrap .owl-controls .owl-buttons .owl-next:before,
                        #main .tp-leftarrow.default:before,
                        #main .tp-rightarrow.default:before,
                        #main .post .post-media .media-slider .owl-controls .owl-buttons .owl-prev:before,
                        #main .post .post-media .media-slider .owl-controls .owl-buttons .owl-next:before 
                     ',
                ),
                'title'    => esc_html__( 'Icon color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-slider_buttons_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .camera_wrap .owl-controls .owl-buttons .owl-prev:hover, .camera_wrap .owl-controls .owl-buttons .owl-next:hover,
                        #main .tp-leftarrow.default:hover,
                        #main .tp-rightarrow.default:hover,
                        #main .post .post-media .media-slider .owl-controls .owl-buttons .owl-prev:hover,
                        #main .post .post-media .media-slider .owl-controls .owl-buttons .owl-next:hover
                     ',
                ),
                'title'    => esc_html__( 'Background hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-slider_buttons_hover_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .camera_wrap .owl-controls .owl-buttons .owl-prev:hover, .camera_wrap .owl-controls .owl-buttons .owl-next:hover,
                        #main .tp-leftarrow.default:hover,
                        #main .tp-rightarrow.default:hover,
                        #main .post .post-media .media-slider .owl-controls .owl-buttons .owl-prev:hover,
                        #main .post .post-media .media-slider .owl-controls .owl-buttons .owl-next:hover
                     ',
                ),
                'title'    => esc_html__( 'Border hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-slider_buttons_hover_icon_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .camera_wrap .owl-controls .owl-buttons .owl-prev:hover:before, .camera_wrap .owl-controls .owl-buttons .owl-next:hover:before,
                        #main .tp-leftarrow.default:hover:before,
                        #main .tp-rightarrow.default:hover:before,
                        #main .post .post-media .media-slider .owl-controls .owl-buttons .owl-prev:hover:before,
                        #main .post .post-media .media-slider .owl-controls .owl-buttons .owl-next:hover:before
                     ',
                ),
                'title'    => esc_html__( 'Icon hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'     => 'color-slider_button-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* Sale badges */
            array(
                'id'       => 'color-sale-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Sale badge', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-sale_color_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .sale-badge
                     ',
                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-sale_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .sale-badge
                     ',
                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-sale_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .sale-badge
                     ',
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-sale-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* New badges */
            array(
                'id'       => 'color-new-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'New badge', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-new_color_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .new-badge
                     ',
                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-new_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .new-badge
                     ',
                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-new_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .new-badge
                     ',
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-new-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),




            /* Ratings icon */
            array(
                'id'       => 'color-ratings-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Rating icons', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-ratings_background_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .rating i
                     ',
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-ratings_active_background_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .rating i.active
                     ',
                ),
                'title'    => esc_html__( 'Background active color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-ratings-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Button */
            array(
                'id'       => 'color-button-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Button', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-buttons_color_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .button, .btn, input[type="submit"],
                        .widget_layered_nav_clear ul a,
                        .categories-wall .category-wall .more-categories:hover
                     ',
                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
          
            array(
                'id'       => 'color-buttons_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .button, .btn, input[type="submit"],
                        .widget_layered_nav_clear ul a,
                        .categories-wall .category-wall .more-categories:hover
                     ',
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-buttons_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .button, .btn, input[type="submit"],
                        .widget_layered_nav_clear ul a,
                        .categories-wall .category-wall .more-categories:hover
                     ',
                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-buttons_hover_color_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .button:hover, .btn:hover, input[type="submit"]:hover,
                        .woocommerce .widget_layered_nav ul.yith-wcan-label li a:hover,
                        .woocommerce-page .widget_layered_nav ul.yith-wcan-label li a:hover,
                        .woocommerce .widget_layered_nav ul.yith-wcan-label li.chosen a, 
                        .woocommerce-page .widget_layered_nav ul.yith-wcan-label li.chosen a,
                        .variable-items-wrapper .variable-item.button-variable-item.selected,
                        .variable-items-wrapper .variable-item.button-variable-item.selected:hover,
                        ul.sizes li.chosen .size-filter,
                        ul.sizes li .size-filter:hover,
                        .widget_layered_nav_clear ul a:hover
                     ',
                ),
                'title'    => esc_html__( 'Text hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-buttons_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .button:hover, .btn:hover, input[type="submit"]:hover,
                        .woocommerce .widget_layered_nav ul.yith-wcan-label li a:hover,
                        .woocommerce-page .widget_layered_nav ul.yith-wcan-label li a:hover,
                        .woocommerce .widget_layered_nav ul.yith-wcan-label li.chosen a, 
                        .woocommerce-page .widget_layered_nav ul.yith-wcan-label li.chosen a,
                        .variable-items-wrapper .variable-item.button-variable-item.selected,
                        .variable-items-wrapper .variable-item.button-variable-item.selected:hover,
                        ul.sizes li.chosen .size-filter,
                        ul.sizes li .size-filter:hover,
                        .widget_layered_nav_clear ul a:hover
                     ',
                ),
                'title'    => esc_html__( 'Background hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-buttons_hover_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .button:hover, .btn:hover, input[type="submit"]:hover,
                        .variable-items-wrapper .variable-item.button-variable-item.selected,
                        .variable-items-wrapper .variable-item.button-variable-item.selected:hover,
                        .widget_layered_nav_clear ul a:hover
                        
                     ',
                ),
                'title'    => esc_html__( 'Border hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-button-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* Second Button */
            array(
                'id'       => 'color-second_button-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Second Button', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-second_buttons_color_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .buttons .left .button, .buttons .center .button, .btn-default, button#place_order, .input-group-btn .btn-primary
                     ',
                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-second_buttons_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .buttons .left .button, .buttons .center .button, .btn-default, button#place_order, .input-group-btn .btn-primary
                     ',
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-second_buttons_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .buttons .left .button, .buttons .center .button, .btn-default, button#place_order, .input-group-btn .btn-primary
                     ',
                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-second_buttons_hover_color_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .buttons .left .button:hover, .buttons .center .button:hover, .btn-default:hover,button#place_order:hover, .input-group-btn .btn-primary:hover
                     ',
                ),
                'title'    => esc_html__( 'Text hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-second_buttons_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .buttons .left .button:hover, .buttons .center .button:hover, .btn-default:hover, button#place_order:hover, .input-group-btn .btn-primary:hover
                     ',
                ),
                'title'    => esc_html__( 'Background hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-second_buttons_hover_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .buttons .left .button:hover, .buttons .center .button:hover, .btn-default:hover, button#place_order:hover, .input-group-btn .btn-primary:hover
                     ',
                ),
                'title'    => esc_html__( 'Border hocer color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-second_button-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Customfooter */
            array(
                'id'       => 'color-customfooter-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Custom footer', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-customfooter_color_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .custom-footer .pattern,
                        .custom-footer .pattern a,
                        ul.contact-us li 
                     ',
                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-customfooter_color_heading',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .custom-footer h4, 
                        .custom-footer .box-heading 
                     ',
                ),
                'title'    => esc_html__( 'Heading color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-customfooter_color_icon_heading',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .custom-footer h4 i,
                        ul.contact-us li span,
                        .custom-footer .tweets li a
                     ',
                ),
                'title'    => esc_html__( 'Heading icon color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-customfooter_color_icon_contact_us',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        ul.contact-us li i,
                        .tweets li:before
                     ',
                ),
                'title'    => esc_html__( 'Contact us icon color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-customfooter_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        .custom-footer h4,
                        .custom-footer .background,
                        .standard-body .custom-footer .background,
                        .fb-like-box,
                        ul.contact-us li i 
                     ',
                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-customfooter_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .custom-footer .background,
                        .standard-body .custom-footer .background
                     ',
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'     => 'color-customfooter-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Footer */
            array(
                'id'       => 'color-footer-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Footer', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-footer_color_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .footer .pattern,
                        .footer .pattern a,
                        ul.contact-us li 
                     ',
                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-footer_color_links',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .footer .pattern a
                     ',
                ),
                'title'    => esc_html__( 'Links color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-footer_color_links_hover',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .footer .pattern a:hover
                     ',
                ),
                'title'    => esc_html__( 'Links hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-footer_color_heading',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .footer h4,
                        .footer .box-heading,
                        .footer .box.box-products .box-heading
                     ',
                ),
                'title'    => esc_html__( 'Heading color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-footer_color_heading_border_bottom',
                'type'     => 'color',
                'output'    => array(
                    'border-bottom-color'            => '
                        .footer h4,
                        .footer .box-heading,
                        .footer .box.box-products .box-heading
                     ',
                ),
                'title'    => esc_html__( 'Heading border bottom color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
             array(
                'id'       => 'color-footer_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .footer .background,
                        .standard-body .footer .background,
                        .copyright .background,
                        .standard-body .copyright .background
                     ',
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                 'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-footer_border_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .footer .container > .row:before, 
                        .footer .advanced-grid .container > div > .row:before,
                        .footer .container > .row > div:before, 
                        .footer .advanced-grid .container > div > .row > div:before,
                        .footer-type-11 .footer .container > .row:nth-last-child(2) > div:before, 
                        .footer-type-11 .footer .advanced-grid .container > div > .row:nth-last-child(2) > div:before,
                        .footer-type-16 .footer .container > .row:nth-last-child(2) > div:before, 
                        .footer-type-16 .footer .advanced-grid .container > div > .row:nth-last-child(2) > div:before,
                        .footer-type-21 .footer .container > .row > div:last-child:after, 
                        .footer-type-21 .footer .advanced-grid .container > div > .row > div:last-child:after
                     ',
                    'border-color'            => '
                        .footer-type-11 .footer .container > .row:nth-last-child(2), 
                        .footer-type-11 .footer .advanced-grid .container > div > .row:nth-last-child(2),
                        .footer-type-16 .footer .container > .row:nth-last-child(2), 
                        .footer-type-16 .footer .advanced-grid .container > div > .row:nth-last-child(2)
                     ',
                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-footer-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Footer -> Button */
            array(
                'id'       => 'color-footer_button-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Footer -> Button', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-footer_button_color_text',
                'type'     => 'color',
                'compiler'  => true,
                'output'    => array(
                    'color'            => '
                        .footer-button,
                        .footer .pattern .footer-button
                     ',
                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'   => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-footer_button_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .footer-button,
                        .footer .pattern .footer-button
                        
                     ',
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'       => 'color-footer_button_hover_color_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        .footer-button:hover,
                         .footer .pattern .footer-button:hover
                     ',
                ),
                'title'    => esc_html__( 'Text hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-footer_button_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        .footer-button:hover,
                        .footer .pattern .footer-button:hover
                     ',
                ),
                'title'    => esc_html__( 'Background hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'     => 'color-footer_button-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),



            /* Blog */
            array(
                'id'       => 'color-blog-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Blog', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-blog_date_text',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .post .date-published,
                        #main .news.v2 .media-body .bottom,
                        .cosmetics-news .media .date-published,
                        .medic-news .media .date-published,
                        .wine-news .media .date-published,
                        .cameras-news .media .date-published
                    '

                ),
                'title'    => esc_html__( 'Date text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-blog_categories_links_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                         #main .post .meta > li a
                    ',

                ),
                'title'    => esc_html__( 'Categories links color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-blog_categories_links_hover_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .post .meta > li a:hover
                    ',

                ),
                'title'    => esc_html__( 'Categories links hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-blog-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


            /* Blog -> tag */
            array(
                'id'       => 'color-blog_tag-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Blog -> Tag', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-blog_tag_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .tagcloud a,
                        #main .footer .pattern .tagcloud a,
                        #main .post .tags a,
                        #main .news .media-body .tags a,
                        #main .posts .post .tags a,
                        .cosmetics-news .media .tags a,
                        .cameras-news .media .tags a 
                    '
                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-blog_tag_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                         #main .tagcloud a,
                         #main .footer .pattern .tagcloud a,
                        #main .post .tags a,
                        #main .news .media-body .tags a,
                        #main .posts .post .tags a,
                        .cosmetics-news .media .tags a,
                        .cameras-news .media .tags a
                    ',

                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'       => 'color-blog_tag_hover_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                        #main .tagcloud a:hover,
                        #main .footer .pattern .tagcloud a:hover,
                        #main .post .tags a:hover,
                        #main .news .media-body .tags a:hover,
                        #main .posts .post .tags a:hover,
                        .cosmetics-news .media .tags a:hover,
                        .cameras-news .media .tags a:hover
                    '
                ),
                'title'    => esc_html__( 'Text hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-blog_tag_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #main .tagcloud a:hover,
                        #main .footer .pattern .tagcloud a:hover,
                        #main .post .tags a:hover,
                        #main .news .media-body .tags a:hover,
                        #main .posts .post .tags a:hover,
                        .cosmetics-news .media .tags a:hover,
                        .cameras-news .media .tags a:hover 
                    ',

                ),
                'title'    => esc_html__( 'Background hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),

            array(
                'id'     => 'color-blog_tag-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

            /* Blog -> buttons */
            array(
                'id'       => 'color-blog_button-section-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Blog -> Button', 'fastor' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

            array(
                'id'       => 'color-blog_button_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #main .posts .button-more,
                        .wine-news .button-more
                    '
                ),
                'title'    => esc_html__( 'Background color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-blog_button_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        #main .posts .button-more,
                        .wine-news .button-more 
                    ',

                ),
                'title'    => esc_html__( 'Border color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'       => 'color-blog_button_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                         #main .posts .button-more,
                        .wine-news .button-more 
                    '
                ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-blog_button_hover_background_color',
                'type'     => 'color',
                'output'    => array(
                    'background'            => '
                        #main .posts .button-more:hover,
                        .wine-news .button-more:hover
                    '
                ),
                'title'    => esc_html__( 'Background hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),
            array(
                'id'       => 'color-blog_button_hover_border_color',
                'type'     => 'color',
                'output'    => array(
                    'border-color'            => '
                        #main .posts .button-more:hover,
                        .wine-news .button-more:hover 
                    ',

                ),
                'title'    => esc_html__( 'Border hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'       => 'color-blog_button_hover_text_color',
                'type'     => 'color',
                'output'    => array(
                    'color'            => '
                         #main .posts .button-more:hover,
                        .wine-news .button-more:hover
                    '
                ),
                'title'    => esc_html__( 'Text hover color', 'fastor' ),
                'default'  => '',
                'required' => array( 'color-status', '=', 1 )
            ),


            array(
                'id'     => 'color-blog_button-section-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),

        ),
    ) );



Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Backgrounds', 'fastor' ),
    'id'         => 'design-background',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'background-status',
            'type'     => 'switch',
            'title'    => esc_html__( 'Status', 'fastor' ),
            'subtitle' => esc_html__( 'Enable/disable custom backgrounds ', 'fastor' ),
            'default'  => false,
        ),
        array(
            'id'       => 'background-body-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Body', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-body_background',
            'type'     => 'background',
            'output'   => array( 'body' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-body-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'background-body2-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Body II layer', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-body2_background',
            'type'     => 'background',
            'output'   => array( 'body .standard-body:before, body .fixed-body:before' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-body2-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-body3-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Body III layer', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-body3_background',
            'type'     => 'background',
            'output'   => array( '.fixed-body, .standard-body ' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-body3-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),



        array(
            'id'       => 'background-topbar-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Top bar', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-topbar_background',
            'type'     => 'background',
            'output'   => array( '.top-bar' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-topbar-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),




        array(
            'id'       => 'background-header-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Header', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

     
        array(
            'id'       => 'background-header_background',
            'type'     => 'background',
            'output'   => array( 'header' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-header-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),



        array(
            'id'       => 'background-top-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Top', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),


        array(
            'id'       => 'background-top_background',
            'type'     => 'background',
            'output'   => array( '#top > .background' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-top-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),


        array(
            'id'       => 'background-menu-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Menu', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-menu_background',
            'type'     => 'background',
            'output'   => array( '.megamenu-background > div ' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-menu-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),


        array(
            'id'       => 'background-slider-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Slider', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-slider_background',
            'type'     => 'background',
            'output'   => array( '#slider .pattern' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-slider-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),


        array(
            'id'       => 'background-customfooter-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Custom Footer', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-customfooter_background',
            'type'     => 'background',
            'output'   => array( '.customfooter .pattern' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-customfooter-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),


        array(
            'id'       => 'background-categories_heading-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Categories Heading', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-categories_heading_background',
            'type'     => 'background',
            'output'   => array( '.box-with-categories .box-heading' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-categories_heading-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),


        array(
            'id'       => 'background-mobilemenu_heading-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Mobile Menu -> Heading', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-mobilemenu_heading_background',
            'type'     => 'background',
            'output'   => array( '.megamenuToogle-wrapper' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-mobilemenu_heading-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),



        array(
            'id'       => 'background-footer-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Footer', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-footer_background',
            'type'     => 'background',
            'output'   => array( '.footer .pattern' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-customfooter-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),


        array(
            'id'       => 'background-sale_badge-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Sale badge', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-sale_badge_background',
            'type'     => 'background',
            'output'   => array( '.sale-badge' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-sale_badge-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),


        array(
            'id'       => 'background-button-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Button', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-button_background',
            'type'     => 'background',
            'output'   => array( '.button, .btn, .button:hover, .btn:hover, input[type="submit"], input[type="submit"]:hover' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-button-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),


        array(
            'id'       => 'background-secondary_button-section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Secondary button', 'fastor' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'background-secondary_button_background',
            'type'     => 'background',
            'output'   => array( '
                .buttons .left .button,
                .buttons .center .button,
                .btn-default,
                .input-group-btn .btn-primary,
                .buttons .left .button:hover,
                .buttons .center .button:hover,
                .btn-default:hover,
                .input-group-btn .btn-primary:hover
            ' ),
            'title'    => esc_html__( 'Own background', 'fastor' ),
            'required' => array( 'background-status', '=', 1 )
        ),
        array(
            'id'     => 'background-secondary_button-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
    )
));

        // -> START Custom code
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Custom code', 'fastor' ),
        'id'               => 'custom-code',
        'customizer_width' => '500px',
        'icon'             => 'el el-edit',
    ) );


    

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'JS', 'fastor' ),
        'id'         => 'custom-code-js',
        //'icon'  => 'el el-home'
        'desc'       => esc_html__( 'Custom JS code', 'fastor'),
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'js-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable custom js ', 'fastor' ),
                'default'  => true,
            ),

            array(
                'id'       => 'js-value',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'JS Code', 'fastor' ),
                'subtitle' => esc_html__( 'Paste your JS code here.', 'fastor' ),
                'mode'     => 'javascript',
                'theme'    => 'chrome',
                'desc'     => 'Possible modes can be found at <a href="' . 'http://' . 'ace.c9.io" target="_blank">' . 'http://' . 'ace.c9.io/</a>.',
                'default'  => "jQuery(document).ready(function(){\n\n});"
            ),

        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'CSS', 'fastor' ),
        'id'         => 'custom-code-css',
        'desc'       => esc_html__( 'Custom CSS code', 'fastor'),
        'subsection' => true,
        //'class' =>  'hidden',
        'fields'     => array(
            array(
                'id'       => 'css-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable custom css ', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'css-value',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'CSS Code', 'fastor' ),
                'subtitle' => esc_html__( 'Paste your CSS code here.', 'fastor' ),
                'mode'     => 'css',
                'theme'    => 'monokai',
                'desc'     => 'Possible modes can be found at <a href="' . 'http://' . 'ace.c9.io" target="_blank">' . 'http://' . 'ace.c9.io/</a>.',
                'default'  => "#header{\n   margin: 0 auto;\n}"
            ),
        )
    ) );
     
    
    // -> START Custom Block
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Custom blocks', 'fastor' ),
        'id'               => 'custom-block',
        'customizer_width' => '500px',
        'icon'             => 'el el-pause',
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Popup', 'fastor' ),
        'id'         => 'block-popup',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'block-popup-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block-popup-width',
                'type'     => 'text',
                'title'    => esc_html__( 'Popup width', 'fastor' ),
                'default'  => '750px',
            ),
            array(
                'id'       => 'block-popup-showonlyonce',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show only once', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block-popup-only-homepage',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show on homepage only', 'fastor' ),
                'default'  => true,
            ),

            array(
                'id'       => 'block-popup-dont-show-again-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Display: No show again', 'fastor' ),
                'default'  => true
            ),
            array(
                'id'       => 'block-popup-dont-show-again-text',
                'type'     => 'text',
                'title'    => esc_html__( 'No show again text', 'fastor' ),
                'default'  => "Don't show again",
            ),

            array(
                'id'       => 'block-popup-custom_block',
                'type'     => 'text',
                'title'    => esc_html__('Custom block name', 'fastor'),
                'subtitle'         => esc_html__('Use custom block in popup', 'fastor'),
            ),
            array(
                'id'               => 'block-popup-content',
                'type'             => 'editor',
                'title'            => esc_html__('Content', 'fastor'),
                'subtitle'         => esc_html__('Popup content', 'fastor'),
                'args'   => array(
                    'teeny'            => true,
                    'textarea_rows'    => 20
                )
            ),
            array(
                'id'       => 'block-popup-background',
                'type'     => 'background',
                'output'   => array( 'body #popup' ),
                'title'    => esc_html__( 'Background', 'fastor' ),
            ),

        )
    ) );
    

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Header notice', 'fastor' ),
        'id'         => 'block-header-notice',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'block-header-notice-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'               => 'block-header-notice-content',
                'type'             => 'editor',
                'title'            => esc_html__('Content', 'fastor'),
                'subtitle'         => esc_html__('Header notice text', 'fastor'),
                'args'   => array(
                    'teeny'            => true,
                    'textarea_rows'    => 20
                )
            ),
            array(
                'id'       => 'block-header-notice-background',
                'type'     => 'background',
                'output'   => array( 'body .header-notice' ),
                'title'    => esc_html__( 'Background', 'fastor' ),
            ),
            array(
                'id'       => 'block-header-notice-text-color',
                'type'     => 'color',
                'output'   => array( 'body .header-notice' ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
            ),
            array(
                'id'       => 'block-header-notice-link-color',
                'type'     => 'color',
                'output'   => array( 'body .header-notice a' ),
                'title'    => esc_html__( 'Link color', 'fastor' ),
            ),
            array(
                'id'       => 'block-header-notice-link-hover-color',
                'type'     => 'color',
                'output'   => array( 'body .header-notice a:hover' ),
                'title'    => esc_html__( 'Link hover color', 'fastor' ),
            ),
            array(
                'id'       => 'block-header-notice-close-button-background-color',
                'type'     => 'background',
                'output'   => array( 'body .header-notice a.close-notice' ),
                'title'    => esc_html__( 'Close button background color', 'fastor' ),
            ),
            array(
                'id'       => 'block-header-notice-close-text-color',
                'type'     => 'color',
                'output'   => array( 'body .header-notice a.close-notice' ),
                'title'    => esc_html__( 'Close button text color', 'fastor' ),
            ),
            array(
                'id'       => 'block-header-notice-close-button-hover-background-color',
                'type'     => 'background',
                'output'   => array( '.header-notice a.close-notice:hover' ),
                'title'    => esc_html__( 'Close button hover background color', 'fastor' ),
            ),
            array(
                'id'       => 'block-header-notice-close-hover-text-color',
                'type'     => 'color',
                'output'   => array( '.header-notice a.close-notice:hover' ),
                'title'    => esc_html__( 'Close button hover text color', 'fastor' ),
            ),
            array(
                'id'       => 'block-header-notice-showonlyonce',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show only once', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block-header-notice-only-homepage',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show on homepage only', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'block-header-notice-disable-desktop',
                'type'     => 'switch',
                'title'    => esc_html__( 'Disable desktop', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block-header-notice-disable-mobile',
                'type'     => 'switch',
                'title'    => esc_html__( 'Disable mobile', 'fastor' ),
                'default'  => false,
            ),

        )
    ) );


    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Cookie', 'fastor' ),
        'id'         => 'block-cookie',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'block-cookie-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'               => 'block-cookie-content',
                'type'             => 'editor',
                'title'            => esc_html__('Content', 'fastor'),
                'subtitle'         => esc_html__('Cookie text', 'fastor'),
                'args'   => array(
                    'teeny'            => true,
                    'textarea_rows'    => 20
                )
            ),
            array(
                'id'       => 'block-cookie-background',
                'type'     => 'background',
                'output'   => array( 'body .cookie' ),
                'title'    => esc_html__( 'Background', 'fastor' ),
            ),
            array(
                'id'       => 'block-cookie-text-color',
                'type'     => 'color',
                'output'   => array( 'body .cookie' ),
                'title'    => esc_html__( 'Text color', 'fastor' ),
            ),
            array(
                'id'       => 'block-cookie-link-color',
                'type'     => 'color',
                'output'   => array( 'body .cookie a' ),
                'title'    => esc_html__( 'Link color', 'fastor' ),
            ),
            array(
                'id'       => 'block-cookie-link-hover-color',
                'type'     => 'color',
                'output'   => array( 'body .cookie a:hover' ),
                'title'    => esc_html__( 'Link hover color', 'fastor' ),
            ),


            array(
                'id'       => 'block-cookie-button-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Display close button', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'block-cookie-button-text',
                'type'     => 'text',
                'title'    => esc_html__( 'Close button text', 'fastor' ),
                'default'  => "Accept cookies",
            ),
            array(
                'id'       => 'block-cookie-close-button-background-color',
                'type'     => 'background',
                'output'   => array( 'body .cookie .button' ),
                'title'    => esc_html__( 'Close button background color', 'fastor' ),
            ),
            array(
                'id'       => 'block-cookie-close-text-color',
                'type'     => 'color',
                'output'   => array( 'body .cookie .button' ),
                'title'    => esc_html__( 'Close button text color', 'fastor' ),
            ),
            array(
                'id'       => 'block-cookie-close-button-hover-background-color',
                'type'     => 'background',
                'output'   => array( '.cookie .button:hover' ),
                'title'    => esc_html__( 'Close button hover background color', 'fastor' ),
            ),
            array(
                'id'       => 'block-cookie-close-hover-text-color',
                'type'     => 'color',
                'output'   => array( '.cookie .button:hover' ),
                'title'    => esc_html__( 'Close button hover text color', 'fastor' ),
            ),
            array(
                'id'=>'block-cookie-position',
                'type' => 'select',
                'title' => esc_html__( 'Display position', 'fastor' ),
                'options' => array(
                    'bottom'       => 'Bottom',
                    'top'       => 'Top',
                ),
                'default' => 'bottom',
            ),


        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Product enquire', 'fastor' ),
        'id'         => 'block-product-enquire',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'block-product-enquire-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block-product-enquire-shortcode',
                'type'     => 'text',
                'title'    => esc_html__( 'Contact Form 7 shortcode', 'fastor' ),
                'default'  => '',
            ),

        )
    ) );
    
    // -> START Custom Footer
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Custom footer', 'fastor' ),
        'id'               => 'custom-footer',
        'customizer_width' => '500px',
        'icon'             => 'el el-inbox',
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Contact', 'fastor' ),
        'id'         => 'footer-contact',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'footer-contact-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable contact block ', 'fastor' ),
                'default'  => true,
            ),
            array(
                'id'       => 'footer-contact-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Title', 'fastor' ),
                'subtitle' => esc_html__( 'Contact section title', 'fastor' ),
                'default'  => '',
            ),
            array(
                'id'       => 'footer-contact-phone',
                'type'     => 'text',
                'title'    => esc_html__( 'Phone', 'fastor' ),
                'subtitle' => esc_html__( 'Contact section phone', 'fastor' ),
                'default'  => '',
            ),
            array(
                'id'       => 'footer-contact-phone2',
                'type'     => 'text',
                'title'    => esc_html__( 'Phone 2', 'fastor' ),
                'subtitle' => esc_html__( 'Contact section phone 2', 'fastor' ),
                'default'  => '',
            ),
            array(
                'id'       => 'footer-contact-skype',
                'type'     => 'text',
                'title'    => esc_html__( 'Skype', 'fastor' ),
                'subtitle' => esc_html__( 'Contact section skype', 'fastor' ),
                'default'  => '',
            ),
            array(
                'id'       => 'footer-contact-skype2',
                'type'     => 'text',
                'title'    => esc_html__( 'Skype 2', 'fastor' ),
                'subtitle' => esc_html__( 'Contact section skype 2', 'fastor' ),
                'default'  => '',
            ),
            
            array(
                'id'       => 'footer-contact-email',
                'type'     => 'text',
                'title'    => esc_html__( 'Email', 'fastor' ),
                'subtitle' => esc_html__( 'Contact section email', 'fastor' ),
                'default'  => '',
            ),
            
            array(
                'id'       => 'footer-contact-email2',
                'type'     => 'text',
                'title'    => esc_html__( 'Email 2', 'fastor' ),
                'subtitle' => esc_html__( 'Contact section email2', 'fastor' ),
                'default'  => '',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'About us', 'fastor' ),
        'id'         => 'footer-aboutus',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'footer-aboutus-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable about us block ', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'footer-aboutus-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Title', 'fastor' ),
                'subtitle' => esc_html__( 'About us section title', 'fastor' ),
                'default'  => '',
            ),
            array(
                'id'               => 'footer-aboutus-content',
                'type'             => 'editor',
                'title'            => esc_html__('Content', 'fastor'), 
                'subtitle'         => esc_html__('About us section content', 'fastor'),
                'args'   => array(
                    'teeny'            => true,
                    'textarea_rows'    => 20
                )
            )

        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Facebook', 'fastor' ),
        'id'         => 'footer-facebook',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'footer-facebook-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable facebook block ', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'footer-facebook-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Title', 'fastor' ),
                'subtitle' => esc_html__( 'Facebook section title', 'fastor' ),
                'default'  => '',
            ),
            array(
                'id'       => 'footer-facebook-id',
                'type'     => 'text',
                'title'    => esc_html__( 'Facebook ID', 'fastor' ),
                'default'  => '',
            ),
            array(
                'id'       => 'footer-facebook-showfaces',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show faces status', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable display faces ', 'fastor' ),
                'default'  => true,
            ),
           
            array(
                'id'       => 'footer-facebook-height',
                'type'     => 'text',
                'title'    => esc_html__( 'Height', 'fastor' ),
                'subtitle'    => esc_html__( 'Facebook block height in px', 'fastor' ),
                'default'  => '',
            ),
            array(
                'id'=>'footer-facebook-colorscheme',
                'type' => 'select',
                'title' => 'Theme skin',
                'title' => 'Select color of scheme',
                'options' => array(
                    '0'       => 'Light',
                    '1'       => 'Dark',
                ),
                'default' => '0',
            ),

        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Twitter', 'fastor' ),
        'id'         => 'footer-twitter',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'footer-twitter-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable twitter block ', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'footer-twitter-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Title', 'fastor' ),
                'subtitle' => esc_html__( 'Twitter section title', 'fastor' ),
                'default'  => '',
            ),
            array(
                'id'       => 'footer-twitter-id',
                'type'     => 'text',
                'title'    => esc_html__( 'Twitter username', 'fastor' ),
                'default'  => '',
            ),
            array(
                'id'       => 'footer-twitter-limit',
                'type'     => 'text',
                'title'    => esc_html__( 'Limit', 'fastor' ),
                'default'  => '2',
            ),

        )
    ) );
    

        
 // -> START Footer
                
//    Redux::setSection( $opt_name, array(
//        'title'            => esc_html__( 'Footer', 'fastor' ),
//        'id'               => 'footer',
//        'customizer_width' => '500px',
//        'icon'             => 'el el-photo',
//    ) );
//
//    Redux::setSection( $opt_name, array(
//        'title' => esc_html__( 'Payments', 'fastor' ),
//        'id'    => 'footer-payments',
//        'subsection' => true,
//        'fields'     => array(
//            array(
//                'id'       => 'payment-status',
//                'type'     => 'switch',
//                'title'    => esc_html__( 'Status', 'fastor' ),
//                'default'  => false,
//            ),
//            array(
//                'id'          => 'payment',
//                'type'        => 'slides',
//                'title'       => esc_html__( 'Payment options', 'fastor' ),
//                'placeholder' => array(
//                    'title'       => esc_html__( 'Name', 'fastor' ),
//                    'url'         => esc_html__( 'Link', 'fastor' ),
//                ),
//            ),
//        )
//    ) );
//
//   
//
//    Redux::setSection( $opt_name, array(
//        'title' => esc_html__( 'Copyright', 'fastor' ),
//        'id'    => 'footer-copyright',
//        'subsection' => true,
//        'fields'     => array(
//            array(
//                'id'               => 'footer-copyright-content',
//                'type'             => 'editor',
//                'title'            => esc_html__('Content', 'fastor'), 
//                'subtitle'         => esc_html__('Cpyright block content', 'fastor'),
//                'args'   => array(
//                    'teeny'            => true,
//                    'textarea_rows'    => 20
//                )
//            )
//        )
//    ) );
//
//   
// 
    
            
    // -> START Widgets
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Widget tabs', 'fastor' ),
        'id'               => 'widget',
        'customizer_width' => '500px',
        'icon'             => 'el el-puzzle',
    ) );


    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Facebook', 'fastor' ),
        'id'         => 'widget-facebook',
        'subsection' => true,
        'fields'     => array(          
            array(
                'id'       => 'widget-facebook-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable facebook widget ', 'fastor' ),
                'default'  => false,
            ),

            array(
                'id'       => 'widget-facebook-id',
                'type'     => 'text',
                'title'    => esc_html__( 'Facebook ID', 'fastor' ),
                'default'  => '',
            ),

            array(
                'id'=>'widget-facebook-position',
                'type' => 'select',
                'title' => 'Position',
                'options' => array(
                    '0'       => 'Right',
                    '1'       => 'Left',
                ),
                'default' => '0',
            ),

        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Twitter', 'fastor' ),
        'id'         => 'widget-twitter',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'widget-twitter-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable twitter widget ', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'       => 'widget-twitter-username',
                'type'     => 'text',
                'title'    => esc_html__( 'Username', 'fastor' ),
                'subtitle' => esc_html__( 'Twitter username', 'fastor' ),
                'default'  => '',
            ),
            
            array(
                'id'=>'widget-twitter-limit',
                'type' => 'select',
                'title' => 'Tweets limit',
                'options' => array(
                    '1'       => '1',
                    '2'       => '2',
                    '3'       => '3',
                ),
                'default' => '3',
            ),
            
            array(
                'id'=>'widget-twitter-position',
                'type' => 'select',
                'title' => 'Position',
                'options' => array(
                    '0'       => 'Right',
                    '1'       => 'Left',
                ),
                'default' => '0',
            ),

        )
    ) );
 

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Custom', 'fastor' ),
        'id'         => 'widget-custom',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'widget-custom-status',
                'type'     => 'switch',
                'title'    => esc_html__( 'Status', 'fastor' ),
                'subtitle' => esc_html__( 'Enable/disable custom widget ', 'fastor' ),
                'default'  => false,
            ),
            array(
                'id'               => 'widget-custom-content',
                'type'             => 'editor',
                'title'            => esc_html__('Content', 'fastor'), 
                'subtitle'         => esc_html__('Custom section content', 'fastor'),
                'args'   => array(
                    'teeny'            => true,
                    'textarea_rows'    => 20
                )
            ),
            array(
                'id'=>'widget-custom-position',
                'type' => 'select',
                'title' => 'Position',
                'options' => array(
                    '0'       => 'Right',
                    '1'       => 'Left',
                ),
                'default' => '0',
            ),

            )
    ) );





    // -> START Advanced settings
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Advanced settings', 'fastor' ),
        'id'               => 'advanced-settings',
        'customizer_width' => '500px',
        'icon'             => 'el el-adjust-alt',
    ) );


    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Header', 'fastor' ),
        'id'         => 'advanced-settings-header',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'=>'advanced-settings-header-margin-top',
                'type' => 'select',
                'title' => 'Header margin top',
                'options' => array(
                    0       => '0px',
                    20       => '20px',
                    30       => '30px',
                    80       => '80px',
                ),
                'default' => 0,
            ),
            array(
                'id'=>'advanced-settings-header-topbar-type',
                'type' => 'select',
                'title' => 'Top bar',
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                ),
                'default' => 0,
            ),
            array(
                'id'=>'advanced-settings-header-myaccount-type',
                'type' => 'select',
                'title' => 'My account',
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                    5       => 'Type 5',
                ),
                'default' => 0,
            ),
            array(
                'id'=>'advanced-settings-header-cartblock-type',
                'type' => 'select',
                'title' => 'Cart block',
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                    5       => 'Type 5',
                    6       => 'Type 6',
                    7       => 'Type 7',
                    8       => 'Type 8',
                    9       => 'Type 9',
                    10       => 'Type 10',
                    11       => 'Type 11',
                ),
                'default' => 0,
            ),
            array(
                'id'=>'advanced-settings-header-categorybox-style',
                'type' => 'select',
                'title' => 'Category box',
                'options' => array(
                    0       => 'Default',
                    1       => 'Type 2',
                    2       => 'Type 3',
                    3       => 'Type 4',
                ),
                'default' => 0,
            ),
            array(
                'id'=>'advanced-settings-header-megamenu-label-type',
                'type' => 'select',
                'title' => 'Megamenu label',
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                    5       => 'Type 5',
                    6       => 'Type 6',
                    7       => 'Type 7',
                ),
                'default' => 0,
            ),
            array(
                'id'=>'advanced-settings-header-search-type',
                'type' => 'select',
                'title' => 'Search',
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                    5       => 'Type 5',
                    6       => 'Type 6',
                    7       => 'Type 7',
                ),
                'default' => 0,
            ),

            array(
                'id'=>'advanced-settings-header-megamenu-type',
                'type' => 'select',
                'title' => 'Menu',
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                    5       => 'Type 5',
                    6       => 'Type 6',
                    7       => 'Type 7',
                    8       => 'Type 8',
                    9       => 'Type 9',
                    10       => 'Type 10',
                    11       => 'Type 11',
                    12       => 'Type 12',
                    13       => 'Type 13',
                    14       => 'Type 14',
                    15       => 'Type 15',
                    16       => 'Type 16',
                    17       => 'Type 17',
                    18       => 'Type 18',
                    19       => 'Type 19',
                    20       => 'Type 20',
                    21       => 'Type 21',
                    22       => 'Type 22',
                    23       => 'Type 23',
                    24       => 'Type 24',
                    25       => 'Type 25',
                    26       => 'Type 26',
                    27       => 'Type 27',
                    28       => 'Type 28',
                    29       => 'Type 29',
                    30       => 'Type 30',
                    31       => 'Type 31',
                    32       => 'Type 32',
                    33       => 'Type 33',
                    34       => 'Type 34',
                ),
                'default' => 0,
            ),

            array(
                'id'=>'advanced-settings-header-dropdown-type',
                'type' => 'select',
                'title' => 'Dropdown menu type',
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                ),
                'default' => 0,
            ),

            array(
                'id'=>'advanced-settings-header-buttons-prev-next-slider',
                'type' => 'select',
                'title' => 'Buttons prev.next in slider',
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                ),
                'default' => 0,
            ),
        )
    ) );



    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Category page', 'fastor' ),
        'id'         => 'advanced-settings-category',
        'subsection' => true,
        'fields'     => array(

            array(
                'id'=>'advanced-settings-category-breadcrumb-style',
                'type' => 'select',
                'title' => 'Breadcrumb',
                'options' => array(
                    0       => 'Default',
                    1       => 'Type 2',
                    2       => 'Type 3',
                    3       => 'Type 4',
                    4       => 'Type 5',
                    5       => 'Type 6',
                    6       => 'Type 7',
                    7       => 'Type 8',
                    8       => 'Type 9',
                    9       => 'Type 10',
                    10       => 'Type 11',
                    11       => 'Type 12',
                ),
                'default' => 0,
            ),

            array(
                'id'=>'advanced-settings-category-productgrid-type',
                'type' => 'select',
                'title' => 'Product grid',
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                    5       => 'Type 5',
                    6       => 'Type 6',
                    7       => 'Type 7',
                    8       => 'Type 8',
                ),
                'default' => 0,
            ),

            array(
                'id'=>'advanced-settings-category-productlist-type',
                'type' => 'select',
                'title' => 'Product list',
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4'
                ),
                'default' => 0,
            ),

        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Product page', 'fastor' ),
        'id'         => 'advanced-settings-product',
        'subsection' => true,
        'fields'     => array(

            array(
                'id'=>'advanced-settings-product-page-type',
                'type' => 'select',
                'title' => esc_html__( 'Product page', 'fastor' ),
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                ),
                'default' => 0,
            ),
            array(
                'id'=>'advanced-settings-product-buttons',
                'type' => 'select',
                'title' => esc_html__( 'Product buttons', 'fastor' ),
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',

                ),
                'default' => 0,
            ),

        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Footer', 'fastor' ),
        'id'         => 'advanced-settings-footer',
        'subsection' => true,
        'fields'     => array(

            array(
                'id'=>'advanced-settings-footer-type',
                'type' => 'select',
                'title' => esc_html__( 'Footer type', 'fastor' ),
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                    5       => 'Type 5',
                    6       => 'Type 6',
                    7       => 'Type 7',
                    8       => 'Type 8',
                    9       => 'Type 9',
                    10       => 'Type 10',
                    11       => 'Type 11',
                    12       => 'Type 12',
                    13       => 'Type 13',
                    14       => 'Type 14',
                    15       => 'Type 15',
                    16       => 'Type 16',
                    17       => 'Type 17',
                    18       => 'Type 18',
                    19       => 'Type 19',
                    20       => 'Type 20',
                    21       => 'Type 21',
                    22       => 'Type 22',
                    23       => 'Type 23',
                    24       => 'Type 24',
                    25       => 'Type 25',
                    26       => 'Type 26',
                    27       => 'Type 27',
                ),
                'default' => 0,
            ),

        )
    ) );


    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Other', 'fastor' ),
        'id'         => 'advanced-settings-other',
        'subsection' => true,
        'fields'     => array(

            array(
                'id'=>'advanced-settings-other-border-width',
                'type' => 'select',
                'title' => esc_html__( 'Border width in full-width', 'fastor' ),
                'options' => array(
                    0       => 'Default',
                    1      => '100%',

                ),
                'default' => 0,
            ),

            array(
                'id'=>'advanced-settings-other-countdown',
                'type' => 'select',
                'title' => esc_html__( 'Countdown special', 'fastor' ),
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                    5       => 'Type 5',
                    6       => 'Type 6',
                    7       => 'Type 7',
                    8       => 'Type 8',
                    9       => 'Type 9',

                ),
                'default' => 0,
            ),

            array(
                'id'=>'advanced-settings-other-button-type',
                'type' => 'select',
                'title' => esc_html__( 'Button type', 'fastor' ),
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                    5       => 'Type 5',
                    6       => 'Type 6',
                    7       => 'Type 7',
                    8       => 'Type 8',
                    9       => 'Type 9',
                    10       => 'Type 10',
                    11       => 'Type 11',
                    12       => 'Type 12',
                    13       => 'Type 13',
                    14       => 'Type 14',
                    15       => 'Type 15',

                ),
                'default' => 0,
            ),

            array(
                'id'=>'advanced-settings-other-salenew-type',
                'type' => 'select',
                'title' => esc_html__( 'Product label type', 'fastor' ),
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                    5       => 'Type 5',
                    6       => 'Type 6',
                    7       => 'Type 7',
                    8       => 'Type 8',
                    9       => 'Type 9',
                    10       => 'Type 10',

                ),
                'default' => 0,
            ),

            array(
                'id'=>'advanced-settings-other-box-type',
                'type' => 'select',
                'title' => esc_html__( 'Box type', 'fastor' ),
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                    5       => 'Type 5',
                    6       => 'Type 6',
                    7       => 'Type 7',
                    8       => 'Type 8',
                    9       => 'Type 9',
                    10       => 'Type 10',
                    11       => 'Type 11',
                    12       => 'Type 12',
                    13       => 'Type 13',
                    14       => 'Type 14',
                    15       => 'Type 15',
                    16       => 'Type 16',
                    17       => 'Type 17',
                    18       => 'Type 18',
                    19       => 'Type 19',
                ),
                'default' => 0,
            ),

            array(
                'id'=>'advanced-settings-other-inputs-type',
                'type' => 'select',
                'title' => esc_html__( 'Inputs type', 'fastor' ),
                'options' => array(
                    0       => 'Default',
                    2       => 'Type 2',
                    3       => 'Type 3',
                    4       => 'Type 4',
                    5       => 'Type 5',
                    6       => 'Type 6',
                    7       => 'Type 7',
                ),
                'default' => 0,
            ),

        )
    ) );


    /*
     * <--- END SECTIONS
     */

