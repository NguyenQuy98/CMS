<?php
defined( 'ABSPATH' ) or die( 'You cannot access this script directly' );
// add import ajax actions
add_action( 'wp_ajax_fastor_reset_menus', 'fastor_reset_menus' );
add_action( 'wp_ajax_fastor_reset_widgets', 'fastor_reset_widgets' );
add_action( 'wp_ajax_fastor_import_dummy', 'fastor_import_dummy' );
add_action( 'wp_ajax_fastor_import_widgets', 'fastor_import_widgets' );

function fastor_extra_demos() {
    $SKINS_CORE = array('default','default2', 'fullwidth', 'computer', 'computer2', 'computer3', 'computer4', 'computer5', 'computer6',
        'tools', 'tools2', 'gardentools', 'jewelry', 'jewelry2', 'jewelryblack', 'barber', 'ceramica', 'antique', 'wine', 'games',
        'games2', 'games3', 'toys', 'military', 'cosmetics', 'cosmetics2', 'naturalcosmetics', 'glamshop', 'medic', 'fashionsimple', 'gardentools2',
        'fashion2', 'fashion3', 'fashion4', 'fashion5', 'cameras', 'shoes','shoes2', 'bakery', 'sportwinter', 'architecture', 'grocery',
        'exclusive', 'coffeetea', 'perfume', 'spices', 'books', 'sport', 'sport2',  'market', 'carparts', 'carparts2', 'petshop', 'stationery',
        'fashion5','jewelryblack2', 'cleaning', 'stationery2', 'fishing', 'shoes3', 'toys2'
    );
    return $SKINS_CORE;
}
function fastor_reset_menus() {

    if ( current_user_can( 'manage_options' ) ) {

        $menus = array(
            'Main Menu',
            'Main Menu Simple',
            'Main Menu Computer',
            'Main Menu Barber',
            'Main Menu Ceramica',
            'Main Menu Naturalcosmetics',
            'Main Menu Wine',
            'Main Menu Computer3',
            'Main Menu Games3',
            'Main Menu Glamshop',
            'Main Menu Gardentools2',
            'Sidebar Menu',
            'Sidebar Menu Naturalcosmetics',
            'Footer I',
            'Footer II',
            'Footer III',
            'Footer IV',
            'Top Nav',
        );

        foreach ($menus as $menu) {
            wp_delete_nav_menu($menu);
        }

        echo esc_html__('Successfully reset menus!', 'fastor');
    }
    die;
}
function fastor_reset_widgets() {

    if ( current_user_can( 'manage_options' ) ) {
        ob_start();
        $sidebars_widgets = retrieve_widgets();
        foreach ($sidebars_widgets as $area => $widgets) {
            foreach ( $widgets as $key => $widget_id ) {
                $pieces = explode( '-', $widget_id );
                $multi_number = array_pop( $pieces );
                $id_base = implode( '-', $pieces );
                $widget = get_option( 'widget_' . $id_base );
                unset( $widget[$multi_number] );
                update_option( 'widget_' . $id_base, $widget );
                unset( $sidebars_widgets[$area][$key] );
            }
        }
        wp_set_sidebars_widgets( $sidebars_widgets );
        ob_clean();
        ob_end_clean();
        echo esc_html__('Successfully reset widgets!', 'fastor');
    }
    die;
}
function fastor_set_skin($skin = 'default') {

    $skin = (isset($_POST['demo']) && $_POST['demo']) ? $_POST['demo'] : $skin;
    $args = json_decode(get_option('fastor_' . htmlentities($skin) . '_options'), true);

    $redux = ReduxFrameworkInstances::get_instance('fastor_options');
    $redux->set_options($args);
    update_option('fastor_skin_active', $skin);


}


function fastor_import_dummy() {
    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true); // we are loading importers

    if ( ! class_exists('Fastor_WP_Import') ) { // if WP importer doesn't exist
        $wp_import = get_template_directory().'/inc/plugins/importer/wordpress-importer.php';
        include $wp_import;
    }

    if ( current_user_can( 'manage_options' ) && class_exists( 'WP_Importer' )) { // check for main import class and wp import class
        $process = (isset($_POST['process']) && $_POST['process']) ? $_POST['process'] : 'import_start';
        $demo = (isset($_POST['demo']) && $_POST['demo']) ? $_POST['demo'] : 'default';
        $index = (isset($_POST['index']) && $_POST['index']) ? $_POST['index'] : 0;

        $importer = new WP_Import();
        $theme_xml = get_template_directory().'/inc/plugins/importer/sample_data/'.$demo .'/sample_data.xml';

        $importer->fetch_attachments = true;


//
//        @ini_set('max_execution_time', '10000');
//        @ini_set('memory_limit', '256M');


        $importer->fetch_attachments = true;
        ob_start();
        $importer->import($theme_xml);
        ob_end_clean();



//        $loop = (int)(ini_get('max_execution_time') / 60);
//        if ($loop < 1) $loop = 1;
//        if ($loop > 10) $loop = 10;
//        $i = 0;
//        while ($i < $loop) {
//            $response = $importer->import($theme_xml, $process, $index);
//            if (isset($response['count']) && isset($response['index']) && $response['count'] && $response['index'] && $response['index'] < $response['count']) {
//                $i++;
//                $index = $response['index'];
//            } else {
//                break;
//            }
//        }
//        echo json_encode($response);
        //if ($response['process'] == 'complete' && $demo != 'shortcodes') {
        // Set woocommerce pages

        // Set woocommerce pages
//        $woopages = array(
//            'woocommerce_shop_page_id' => 'Shop',
//            'woocommerce_cart_page_id' => 'Cart',
//            'woocommerce_checkout_page_id' => 'Checkout',
//            'woocommerce_pay_page_id' => 'Checkout &#8594; Pay',
//            'woocommerce_thanks_page_id' => 'Order Received',
//            'woocommerce_myaccount_page_id' => 'My Account',
//            'woocommerce_edit_address_page_id' => 'Edit My Address',
//            'woocommerce_view_order_page_id' => 'View Order',
//            'woocommerce_change_password_page_id' => 'Change Password',
//            'woocommerce_logout_page_id' => 'Logout',
//            'woocommerce_lost_password_page_id' => 'Lost Password'
//        );
//        foreach ($woopages as $woo_page_name => $woo_page_title) {
//            $woopage = get_page_by_title( $woo_page_title );
//            if (isset($woopage) && $woopage->ID) {
//                update_option($woo_page_name, $woopage->ID); // Front Page
//            }
//        }
//
//
//        // We no longer need to install pages
//        delete_option( '_wc_needs_pages' );
//        delete_transient( '_wc_activation_redirect' );


        // Set imported menus to registered theme locations


        $response =  array(
            'count' => 100,
            'index' => 100,
            'process' => 'complete',
            'message' => 'Successfully imported demo content',
        );
        echo json_encode($response);

    }
    die();
}
function fastor_import_widgets() {
    if ( current_user_can( 'manage_options' ) ) {
        $demo = (isset($_POST['demo']) && $_POST['demo']) ? $_POST['demo'] : 'default';


        $locations = fastor_get_theme_menus();

        $menus = wp_get_nav_menus(); // registered menus

        if ($menus) {
            foreach($menus as $menu) { // assign menus to theme locations
                if( $menu->slug == 'main-menu') {
                    $locations['main_menu'] = $menu->term_id;
                } else if( $menu->slug == 'top-nav') {
                    $locations['top_nav'] = $menu->term_id;
                } else if( $menu->slug == 'lang-switcher' ) {
                    $locations['lang_switcher'] = $menu->term_id;
                } else if( $menu->slug == 'sidebar-menu' || $menu->slug == 'sidebar') {
                    $locations['sidebar_menu'] = $menu->term_id;
                }


                // Custom settings for skins
                switch($demo) {
                    case 'default2':
                        $locations['sidebar_menu'] = '';
                        break;
                    case 'computer':
                    case 'computer2':
                        $locations['sidebar_menu'] = '';

                        if ($menu->slug == 'main-menu-computer') {
                            $locations['main_menu'] = $menu->term_id;
                        }

                        break;

                    case 'jewelry':
                    case 'jewelryblack':
                        $locations['sidebar_menu'] = '';

                        if ($menu->slug == 'main-menu-jewelry') {
                            $locations['main_menu'] = $menu->term_id;
                        }

                        break;

                    case 'barber':
                        $locations['sidebar_menu'] = '';

                        if ($menu->slug == 'main-menu-barber') {
                            $locations['main_menu'] = $menu->term_id;
                        }

                        break;

                    case 'gardentools':
                        $locations['sidebar_menu'] = '';

                        break;

                    case 'ceramica':
                        $locations['sidebar_menu'] = '';

                        if ($menu->slug == 'main-menu-ceramica') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        break;

                    case 'antique':
                        // do nothing
                        break;

                    case 'naturalcosmetics':

                        $locations['sidebar_menu'] = '';

                        if ($menu->slug == 'main-menu-naturalcosmetics') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        break;

                    case 'wine':

                        $locations['sidebar_menu'] = '';

                        if ($menu->slug == 'main-menu-wine') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        break;

                    case 'computer3':

                        $locations['sidebar_menu'] = '';

                        if ($menu->slug == 'main-menu-computer3') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        break;

                    case 'games':
                    case 'games2':

                        // do nothing
                        break;
                    case 'games3':

                        $locations['sidebar_menu'] = '';

                        if ($menu->slug == 'main-menu-games3') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        break;

                    case 'military':

                        // do nothing
                        break;

                    case 'toys':

                        // do nothing
                        break;

                    case 'toys2':

                        if ($menu->slug == 'main-menu-toys2') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        if($menu->slug == 'sidebar-menu-toys2'){
                            $locations['sidebar_menu'] = $menu->term_id;
                        }


                        break;

                    case 'glamshop':

                        $locations['sidebar_menu'] = '';
                        if ($menu->slug == 'main-menu-glamshop') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        break;

                    case 'gardentools2':

                        $locations['sidebar_menu'] = '';
                        if ($menu->slug == 'main-menu-gardentools2') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        break;

                    case 'tools':
                    case 'tools2':

                        $locations['sidebar_menu'] = '';
                        break;

                    case 'cosmetics':

                        $locations['sidebar_menu'] = '';
                        if ($menu->slug == 'sidebar-menu-cosmetics') {
                            $locations['sidebar_menu'] = $menu->term_id;
                        }

                        if ($menu->slug == 'main-menu-simple') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        break;

                    case 'cosmetics2':

                        if ($menu->slug == 'main-menu-simple') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        break;

                    case 'medic':

                        if ($menu->slug == 'main-menu-simple') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        break;

                    case 'computer5':

                        $locations['sidebar_menu'] = '';

                        break;

                    case 'shoes':

                        // do nothing
                        break;
                    case 'cleaning':

                        // do nothing
                        break;
                    case 'shoes2':

                        $locations['sidebar_menu'] = '';
                        break;
                    case 'shoes3':

                        $locations['sidebar_menu'] = '';
                        if ($menu->slug == 'main-menu-presentation') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        break;

                    case 'fashion2':

                        $locations['sidebar_menu'] = '';
                        break;

                    case 'fashion4':

                        $locations['sidebar_menu'] = '';
                        break;

                    case 'fashion5':

                        $locations['sidebar_menu'] = '';
                        break;

                    case 'cameras':

                        $locations['sidebar_menu'] = '';
                        break;

                    case 'carparts2':

                        $locations['sidebar_menu'] = '';

                        if ($menu->slug == 'main-menu-carparts2') {
                            $locations['main_menu'] = $menu->term_id;
                        }

                        break;

                    case 'architecture':

                        $locations['sidebar_menu'] = '';
                        break;

                    case 'fashionsimple':

                        $locations['sidebar_menu'] = '';
                        break;

                    case 'architecture':
                        // do nothing
                        break;

                    case 'jewelry2':
                        $locations['sidebar_menu'] = '';
                        break;

                    case 'coffeetea':
                        $locations['sidebar_menu'] = '';
                        break;

                    case 'perfume':
                        $locations['sidebar_menu'] = '';
                        break;
                    case 'spices':
                        $locations['sidebar_menu'] = '';
                        break;
                    case 'sport':
                        // do nothing
                        break;

                    case 'books':
                        // do nothing
                        break;

                    case 'petshop':
                        $locations['sidebar_menu'] = '';
                        break;

                    case 'stationery':
                        $locations['sidebar_menu'] = '';
                        break;

                    case 'computer4':
                        $locations['sidebar_menu'] = '';
                        break;
                    case 'sport2':
                        $locations['sidebar_menu'] = '';
                        break;

                    case 'jewelryblack2':
                        $locations['sidebar_menu'] = '';
                        break;
                }

            }
        }

        set_theme_mod( 'nav_menu_locations', $locations ); // set menus to locations

        // home page as started page
        $home = get_page_by_title( 'Home' );

        if ($home->ID){
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front',  $home->ID);
        }
        $posts_page = get_page_by_title( 'Blog' );

        if (isset($posts_page->ID) && $posts_page->ID) {
            update_option('page_for_posts', $posts_page->ID); // Blog Page
        }

        // Import widgets
        ob_start();
        include(get_template_directory().'/inc/plugins/importer/sample_data/' . $demo . '/widget_data.json');
        $widget_data = ob_get_clean();

        fastor_import_widget_data( $widget_data, $demo );
        echo esc_html__('Successfully imported widgets!', 'fastor');
    }
    die();
}

function fastor_import_options() {
    if ( current_user_can( 'manage_options' ) ) {
        $demo = (isset($_POST['demo']) && $_POST['demo']) ? $_POST['demo'] : 'default';
        ob_start();
        include(get_template_directory().'/inc/plugins/importer/data/' . $demo . '/theme_options.php');
        $theme_options = ob_get_clean();
        ob_start();
        $options = json_decode($theme_options, true);
        $redux = ReduxFrameworkInstances::get_instance('fastor_settings');
        $redux->set_options($options);
        ob_clean();
        ob_end_clean();
        try {
            fastor_save_theme_settings();
            fastor_import_theme_settings();
            echo esc_html__('Successfully imported theme options!', 'fastor');
        } catch (Exception $e) {
            echo esc_html__('Successfully imported theme options! Please compile default css files in Theme Options > Skin > Compile Default CSS.', 'fastor');
        }
    }
    die();
}
// Parsing Widgets Function
// Reference: http://wordpress.org/plugins/widget-settings-importexport/
function fastor_import_widget_data( $widget_data, $demo = 'default' ) {

    // set new skin active
    fastor_set_skin($demo);

    $json_data = $widget_data;
    $json_data = json_decode( $json_data, true );
    $sidebar_data = $json_data[0];
    $widget_data = $json_data[1];
    foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
        $widgets[ $widget_data_title ] = '';
        foreach( $widget_data_value as $widget_data_key => $widget_data_array ) {
            if( is_int( $widget_data_key ) ) {
                $widgets[$widget_data_title][$widget_data_key] = 'on';
            }
        }
    }
    unset($widgets[""]);
    foreach ( $sidebar_data as $title => $sidebar ) {
        $count = count( $sidebar );
        for ( $i = 0; $i < $count; $i++ ) {
            $widget = array( );
            $widget['type'] = trim( substr( $sidebar[$i], 0, strrpos( $sidebar[$i], '-' ) ) );
            $widget['type-index'] = trim( substr( $sidebar[$i], strrpos( $sidebar[$i], '-' ) + 1 ) );
            if ( !isset( $widgets[$widget['type']][$widget['type-index']] ) ) {
                unset( $sidebar_data[$title][$i] );
            }
        }
        $sidebar_data[$title] = array_values( $sidebar_data[$title] );
    }
    foreach ( $widgets as $widget_title => $widget_value ) {
        foreach ( $widget_value as $widget_key => $widget_value ) {
            $widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
        }
    }
    $sidebar_data = array( array_filter( $sidebar_data ), $widgets );

    fastor_parse_import_data( $sidebar_data, $demo );
}
function fastor_parse_import_data( $import_array, $demo = 'default'  ) {
    global $wp_registered_sidebars;


    // remove default widgets
    update_option('widget_search', array());
    update_option('widget_categories', array());
    update_option('widget_recent-posts', array());
    update_option('widget_recent-comments', array());
    update_option('widget_archives', array());
    update_option('widget_meta', array());

    $sidebars_data = $import_array[0];
    $widget_data = $import_array[1];
    $current_sidebars = get_option( 'sidebars_widgets' );
    $new_widgets = array( );



    foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

        foreach ( $import_widgets as $import_widget ) :
            //if the sidebar exists
            if ( isset( $wp_registered_sidebars[$import_sidebar] ) ) :
                $title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
                $index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
                $current_widget_data = get_option( 'widget_' . esc_html($title) );
                $new_widget_name = fastor_get_new_widget_name( $title, $index );
                $new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

                if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
                    while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
                        $new_index++;
                    }
                }
                $current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
                if ( array_key_exists( $title, $new_widgets ) ) {
                    $new_widgets[$title][$new_index] = $widget_data[$title][$index];
                    $multiwidget = $new_widgets[$title]['_multiwidget'];
                    unset( $new_widgets[$title]['_multiwidget'] );
                    $new_widgets[$title]['_multiwidget'] = $multiwidget;
                } else {
                    $current_widget_data[$new_index] = $widget_data[$title][$index];
                    $current_multiwidget = (isset($current_widget_data['_multiwidget']))?$current_widget_data['_multiwidget']:'';
                    $new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
                    $multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
                    unset( $current_widget_data['_multiwidget'] );
                    $current_widget_data['_multiwidget'] = $multiwidget;
                    $new_widgets[$title] = $current_widget_data;
                }

            endif;
        endforeach;
    endforeach;


    if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
        update_option( 'sidebars_widgets', $current_sidebars );

        foreach ( $new_widgets as $title => $content ){

            // Fastor ONLY
            // TO DO!!

            $fastor_nav_places = array(
                'default'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array()
                ),
                'default2'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array()
                ),
                'fullwidth'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array()
                ),
                'tools'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array()
                ),
                'tools2'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'computer'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array(),
                    'Footer IV'   =>  array()
                ),
                'computer2'   =>  array(
                    'Footer I'   =>  array('credits'),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array(),
                    'Footer IV'   =>  array()
                ),
                'gardentools'   =>  array(
                    'Footer I'   =>  array('custom block'),
                    'Footer II'   =>  array('put here'),
                    'Footer III'   =>  array(),
                    'Footer IV'   =>  array()
                ),
                'jewelry'   =>  array(
                    'Footer I'   =>  array(''),
                    'Footer II'   =>  array(''),
                    'Footer III'   =>  array(),
                    'Footer IV'   =>  array()
                ),
                'jewelryblack'   =>  array(
                    'Footer I'   =>  array(''),
                    'Footer II'   =>  array(''),
                    'Footer III'   =>  array(),
                    'Footer IV'   =>  array()
                ),
                'jewelryblack2'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array()
                ),
                'ceramica'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'antique'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('service'),
                    'Footer III'   =>  array(),
                    'Footer IV'   =>  array()
                ),
                'naturalcosmetics'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array(),
                    'Footer III'   =>  array(),
                    'Footer IV'   =>  array()
                ),
                'wine'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array()
                ),
                'computer3'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'computer6'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'games'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array(),
                    'Footer III'   =>  array('customer service', ''),
                    'Footer IV'   =>  array()
                ),
                'games2'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'games3'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array()
                ),
                'military'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('custom links')
                ),
                'toys'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array(),
                    'Footer III'   =>  array(),
                    'Footer IV'   =>  array()
                ),
                'toys2'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array('my account')
                ),
                'glamshop'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array()
                ),
                'gardentools2'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array('my account')
                ),
                'cosmetics'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array()
                ),
                'cosmetics2'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array('my account')
                ),
                'medic'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array('my account')
                ),
                'computer5'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array()
                ),
                'shoes'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array()
                ),
                'shoes2'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'shoes3'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array('my account')
                ),
                'fashion2'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('my account'),
                    'Footer III'   =>  array(),
                    'Footer IV'   =>  array()
                ),
                'fashion4'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('information'),
                    'Footer IV'   =>  array('custom links')
                ),
                'fashion5'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array(),
                    'Footer III'   =>  array(),
                    'Footer IV'   =>  array()
                ),
                'cameras'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('information'),
                    'Footer IV'   =>  array('custom links')
                ),
                'bakery'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('information'),
                    'Footer IV'   =>  array()
                ),
                'architecture'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'sportwinter'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'fashionsimple'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array(),
                    'Footer III'   =>  array(),
                    'Footer IV'   =>  array()
                ),
                'grocery'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'exclusive'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'jewelry2'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'cofeetea'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'perfume'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'spices'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'sport'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'books'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'market'   =>  array(
                    'Footer I'   =>  array('information', 'my account'),
                    'Footer II'   =>  array('customer service', 'home'),
                    'Footer III'   =>  array('extras', 'others'),
                    'Footer IV'   =>  array()
                ),
                'carparts'   =>  array(
                    'Footer I'   =>  array('home'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array()
                ),
                'carparts2'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array('my account')
                ),
                'petshop'   =>  array(
                    'Footer I'   =>  array('home'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'stationery'   =>  array(
                    'Footer I'   =>  array('home'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'stationery2'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'computer4'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('customer service'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array('my account')
                ),
                'sport2'   =>  array(
                    'Footer I'   =>  array(),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array()
                ),
                'cleaning'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('extras'),
                    'Footer IV'   =>  array('my account')
                ),
                'fishing'   =>  array(
                    'Footer I'   =>  array('information'),
                    'Footer II'   =>  array('custom block'),
                    'Footer III'   =>  array('put here'),
                    'Footer IV'   =>  array('my account')
                ),
            );


            if($title == 'footer_menu'){
                if(!empty($content))
                {
                    foreach ($content as &$item){
                        $w_title = strtolower(trim($item['title']));

                        if(isset($fastor_nav_places[$demo]['Footer I']) && in_array($w_title, $fastor_nav_places[$demo]['Footer I'])){
                            $term = get_term_by('name', 'Footer I', 'nav_menu');
                            $item['nav_menu'] = $term->term_id;
                        }
                        if(isset($fastor_nav_places[$demo]['Footer II']) && in_array($w_title, $fastor_nav_places[$demo]['Footer II'])){
                            $term = get_term_by('name', 'Footer II', 'nav_menu');
                            $item['nav_menu'] = $term->term_id;
                        }
                        if(isset($fastor_nav_places[$demo]['Footer III']) && in_array($w_title, $fastor_nav_places[$demo]['Footer III'])){
                            $term = get_term_by('name', 'Footer III', 'nav_menu');
                            $item['nav_menu'] = $term->term_id;
                        }
                        if(isset($fastor_nav_places[$demo]['Footer IV']) && in_array($w_title, $fastor_nav_places[$demo]['Footer IV'])){
                            $term = get_term_by('name', 'Footer II', 'nav_menu');
                            $item['nav_menu'] = $term->term_id;
                        }
                    }
                }
            }

            if($title == 'sidebar_menu'){
                if(!empty($content))
                {
                    foreach ($content as &$item){
                        if($item['title'] == 'Categories'){
                            $term = get_term_by('name', 'Sidebar menu', 'nav_menu');
                            $item['nav_menu'] = $term->term_id;
                        }
                    }
                }
            }

            // END LOGANCEE ONLY


            update_option( 'widget_' . $title, $content );
        }

        return true;
    }

    return false;
}

function fastor_get_new_widget_name( $widget_name, $widget_index ) {
    $current_sidebars = get_option( 'sidebars_widgets' );
    $all_widget_array = array( );
    foreach ( $current_sidebars as $sidebar => $widgets ) {
        if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
            foreach ( $widgets as $widget ) {
                $all_widget_array[] = $widget;
            }
        }
    }
    while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
        $widget_index++;
    }
    $new_widget_name = $widget_name . '-' . $widget_index;
    return $new_widget_name;
}