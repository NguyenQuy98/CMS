<?php
/**
 * Fastor functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fastor
 */

$theme = wp_get_theme();
define('FASTOR_VERSION', $theme->get('Version'));


/**
 * Fastor admin functions
 */
require_once(get_template_directory().'/admin/functions.php');

// Function for Content Type, ReduxFramework


function fastor_get_core_skins(){
    $SKINS_CORE = array('default','default2', 'fullwidth', 'computer', 'computer2', 'computer3', 'computer4', 'computer5',
        'tools','tools2', 'gardentools', 'jewelry', 'jewelry2', 'jewelryblack', 'barber', 'ceramica', 'antique', 'wine', 'games',
        'games2', 'games3', 'toys', 'military', 'cosmetics', 'cosmetics2', 'naturalcosmetics', 'glamshop', 'medic', 'fashionsimple', 'gardentools2',
        'fashion2', 'fashion3', 'fashion4', 'cameras', 'shoes', 'shoes2', 'bakery', 'sportwinter', 'architecture', 'grocery',
        'exclusive', 'coffeetea', 'perfume', 'spices', 'books', 'sport', 'sport2',  'market', 'carparts', 'carparts2', 'petshop', 'stationery',
        'fashion5','jewelryblack2', 'cleaning', 'stationery2', 'fishing', 'computer6', 'shoes3', 'toys2'

    );
    return $SKINS_CORE;
}



function fastor_get_theme_menus(){
    return array(
        'main_menu' => esc_html__('Main Menu', 'fastor'),
        'top_nav' => esc_html__('Top Navigation', 'fastor'),
        'lang_switcher' => esc_html__('Lang Switcher', 'fastor'),
        'sidebar_menu' => esc_html__('Sidebar Menu', 'fastor'),
    );
}


function fastor_addAndOverridePanelScripts() {
    wp_enqueue_style(
        'redux-custom-css',
        get_template_directory_uri() . '/admin/theme_options/assets/css/panel.css',
        array( 'farbtastic' ), // Notice redux-admin-css is removed and the wordpress standard farbtastic is included instead
        time(),
        'all'
    );

    wp_enqueue_script( 'redux-custom-js',get_template_directory_uri() . '/admin/theme_options/assets/js/panel.js', array(), null, true);
}

add_action( 'redux/page/fastor_options/enqueue', 'fastor_addAndOverridePanelScripts' );

add_action ('redux/options/fastor_options/saved', 'fastor_save_config_file');
add_action ('redux/options/fastor_options/settings/change', 'fastor_save_config_file');
add_action('customize_save_after', 'fastor_save_config_file_customizer', 100);


function fastor_get_active_skin($dash = false){
    $fastor_skin = get_option('fastor_skin_active');
    return isset($fastor_skin) ? ($dash ? str_replace('_', '-', $fastor_skin) : $fastor_skin) : 'default';
}


function fastor_save_config_file($arg){

    $fastor_skin = get_option('fastor_skin_active');
    update_option('fastor_' . esc_html($fastor_skin) . '_options', json_encode($arg));


}

function fastor_save_config_file_customizer($arg){
    $fastor_options = fastor_get_options();
    if($fastor_options){

        $fastor_skin = get_option('fastor_skin_active');
        update_option('fastor_' . esc_html($fastor_skin) . '_options', json_encode($fastor_options));
    }
}


add_action ('redux/loaded', 'fastor_load_config_file', 10);

function fastor_load_config_file($fastor){
    $fastor_options = fastor_get_options();

    global $wp_customize;
    if (! isset( $wp_customize ) && is_admin()) {



        $fastor_skin = get_option('fastor_skin_active');
        $args = json_decode(get_option('fastor_' . htmlentities($fastor_skin) . '_options'), true);

        $args['skin-theme'] = $fastor_skin;

        $fastor->options = $args;

        $fastor_options = $args;

    }

}


add_action( 'wp_ajax_fastor_ajax_skin_activate', 'fastor_skin_activate' );
function fastor_skin_activate() {

    $fastor_skin_active = esc_html($_POST['skin']);
    update_option('fastor_skin_active', esc_html($_POST['skin']));
    $args = json_decode(get_option('fastor_' . esc_html($fastor_skin_active) . '_options'), true);

    if(!$args){
        $config = json_decode(wp_remote_fopen(get_template_directory_uri() . '/admin/skins/'.$fastor_skin_active .'.json'), true);
        if(!$config){
            $config = json_decode(wp_remote_fopen('http://cleventhemes.net/fastor/woocommerce/skins/default.json' . '/admin/skins/'.$fastor_skin_active .'.json'), true);
        }
        update_option('fastor_' . esc_html($fastor_skin_active) . '_options', json_encode($config));
        $args = $config;
    }

    $redux = ReduxFrameworkInstances::get_instance('fastor_options');
    $redux->set_options($args);


    $response = array(
        'status' => 'success',
        'action' => 'reload'
    );
    echo json_encode($response);
    die();
}

add_action( 'wp_ajax_fastor_ajax_skin_create', 'fastor_skin_create' );
function fastor_skin_create() {
    $new_skin = fastor_slugify(esc_html($_POST['skin']));


    update_option('fastor_' . esc_html($new_skin) . '_options', json_encode(array()));
    update_option('fastor_skin_active', esc_html($new_skin));

    $fastor_skins = json_decode(get_option('fastor_skins'), true);
    $fastor_skins[] = esc_html($new_skin);
    update_option('fastor_skins', json_encode($fastor_skins));


    $response = array(
        'status' => 'success',
        'action' => 'reload'
    );
    echo json_encode($response);
    die();
}

add_action( 'wp_ajax_fastor_ajax_skin_remove', 'fastor_skin_remove' );
function fastor_skin_remove() {
    $skin = $_POST['skin'];

    $fastor_skin_active = get_option('fastor_skin_active');

    if($skin != $fastor_skin_active){
        $fastor_skins = json_decode(get_option('fastor_skins'), true);
        $skin_key = array_search($skin, $fastor_skins);
        unset($fastor_skins[$skin_key]);

        update_option('fastor_skins', json_encode($fastor_skins));
        delete_option('fastor_' . htmlentities($skin) . '_options');
    }else{
        $response = array(
            'status' => esc_html__('You cannot remove active skin', 'fastor'),
        );
        echo json_encode($response);
        die();
    }

    $response = array(
        'status' => 'success',
        'action' => 'reload'
    );
    echo json_encode($response);
    die();
}

function fastor_redux_remove_demo_link() {
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
    }
}

add_action('admin_init', 'fastor_redux_remove_demo_link');


function fastor_slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

    // trim
    $text = trim($text, '-');

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    if (empty($text))
    {
        return 'n-a';
    }

    return $text;
}

function fastor_install_predefined_skins(){
    $skins = fastor_get_core_skins();

    foreach($skins as $skin){
        $config = json_decode(wp_remote_fopen(get_template_directory_uri() . '/admin/skins/'.$skin .'.json'), true);
        if(!$config){
            $config = json_decode(wp_remote_fopen('http://cleventhemes.net/fastor/woocommerce/skins/default.json' . '/admin/skins/'.$skin .'.json'), true);
        }
        update_option('fastor_' . esc_html($skin) . '_options', json_encode($config));
    }
    update_option('fastor_skins', json_encode($skins));
    update_option('fastor_skin_active', esc_html('default'));

}

function fastor_layouts() {
    return array(
        "fullwidth" => esc_html__("Full Width", 'fastor'),
        "left-sidebar" => esc_html__("Left Sidebar", 'fastor'),
        "right-sidebar" => esc_html__("Right Sidebar", 'fastor'),
    );
}

function fastor_ct_sidebars() {
    global $wp_registered_sidebars;

    $sidebar_options = array();
    if (!empty($wp_registered_sidebars)) {
        foreach ($wp_registered_sidebars as $sidebar) {
            $sidebar_options[$sidebar['id']] = $sidebar['name'];
        }
    };

    return $sidebar_options;
}


function fastor_slider_type() {
    return array(
        "custom_block" => esc_html__("Custom Block", 'fastor'),
        "revslider" => esc_html__("Revolution Slider", 'fastor'),

    );
}

function fastor_slider_align() {
    return array(
        "standard" => esc_html__("Standard", 'fastor'),
        "top" => esc_html__("Top", 'fastor'),

    );
}


function fastor_revslider_list() {
    global $wpdb;

    $table_name = esc_sql($wpdb->prefix . "revslider_sliders");

    $sql_table_name = $wpdb->get_var( $wpdb->prepare(
        "SHOW TABLES LIKE %s",
        $table_name
    ));

    if ($sql_table_name == $table_name) {
        $sliders = $wpdb->get_results("SELECT * FROM " . esc_sql($sql_table_name));
        $rev_sliders = array();
        if (!empty($sliders)) {
            foreach($sliders as $slider) {
                $rev_sliders[$slider->alias] = '#'.$slider->id.': '.$slider->title;
            }
        }

        return $rev_sliders;
    }

    return null;
}

if ( ! function_exists( 'fastor_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function fastor_setup() {

        /*
         * Add Redux Framework
         */
        require get_template_directory() . '/admin/admin-init.php';


        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded title tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

        // Register Navigation Menu
        register_nav_menus( array(
            'main_menu' => esc_html__('Main Menu', 'fastor'),
            'top_nav' => esc_html__('Top Navigation', 'fastor'),
            'lang_switcher' => esc_html__('Lang Switcher', 'fastor'),
            'sidebar_menu' => esc_html__('Sidebar Menu', 'fastor'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );

        /*
         * Enable support for Post Formats.
         * See https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support( 'post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
        ) );

        add_image_size( 'fastor_blog_home_page_thumb', 300, 450, true );
        add_image_size( 'fastor_blog_home_page_cosmetics_thumb', 270, 200, true );
        add_image_size( 'fastor_blog_home_page_cameras_thumb', 280, 160, true );



        // Default RSS feed links
        add_theme_support('automatic-feed-links');
        // Woocommerce Support
        add_theme_support('woocommerce');
        // Post Formats
        add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio', 'chat'));
        // Image Size
        add_theme_support('post-thumbnails');


        add_editor_style();
        // Translation
        load_theme_textdomain('fastor', get_stylesheet_directory() . '/languages');

        $fastor_skin_active = get_option('fastor_skin_active');
        //install predefined skins
        if(!$fastor_skin_active){
            fastor_install_predefined_skins();
        }



    }

endif; // fastor_setup
add_action( 'after_setup_theme', 'fastor_setup' );

add_action('after_switch_theme', 'fastor_setup_options');

function fastor_setup_options(){


    $fastor_skin_active = get_option('fastor_skin_active');
    //install predefined skins
    if(!$fastor_skin_active){
        fastor_install_predefined_skins();
    }
}


// Location Files
$locale = get_locale();
$locale_file = get_template_directory_uri() . "/languages/$locale.php";
if (is_readable($locale_file) )
    require_once($locale_file);



if ( defined( 'WOOCOMMERCE_VERSION' ) ) {
    if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
        add_filter( 'woocommerce_enqueue_styles', '__return_false' );
    } else {
        define( 'WOOCOMMERCE_USE_CSS', false );
    }
}


// Theme Activation Hook
add_action('admin_init','fastor_theme_activation');

function fastor_theme_activation() {
    global $pagenow;
    if(is_admin() && 'themes.php' == $pagenow && isset($_GET['activated']))
    {
        update_option('shop_catalog_image_size', array('width' => 200, 'height' => '', 0));
        update_option('shop_single_image_size', array('width' => 800, 'height' => '', 0));
        update_option('shop_thumbnail_image_size', array('width' => 128, 'height' => '', 0));


    }
}

require_once(get_template_directory() . '/inc/widgets.php');
require_once(get_template_directory() . '/inc/shortcodes.php');
require_once(get_template_directory() . '/inc/plugins.php');
require_once(get_template_directory() . '/inc/content_types.php');
require_once(get_template_directory() . '/inc/menu.php');


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */

function fastor_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'fastor_content_width', 640 );
}
add_action( 'after_setup_theme', 'fastor_content_width', 0 );

/* get global vars */
function fastor_get_options(){
    global $fastor_options;
    if(empty($fastor_options)){
        $fastor_skin_active = get_option('fastor_skin_active');
        $fastor_options = json_decode(get_option('fastor_' . htmlentities($fastor_skin_active) . '_options'), true);

        //fallback
        if(!$fastor_options){
            $fastor_options =  json_decode(wp_remote_fopen(get_template_directory_uri() . '/admin/skins/'.htmlentities($fastor_skin_active) .'.json'), true);
        }
        $fastor_options['skin-theme'] = $fastor_skin_active;
    }

    // ONLY FOR DEMO CONTENT
    $category_layout = isset($_GET['category_layout'])? $_GET['category_layout'] : null;
    if(isset($category_layout)) {
        if ($category_layout == 'left-column') {
            $fastor_options['layout-type-woocategory'] = 'left-sidebar';
            $fastor_options['category-product-per-page'] = '4';
        }
        if ($category_layout == 'right-column') {
            $fastor_options['layout-type-woocategory'] = 'right-sidebar';
            $fastor_options['category-product-per-page'] = '4';
        }
        if ($category_layout == 'no-column') {
            $fastor_options['layout-type-woocategory'] = 'fullwidth';
            $fastor_options['category-product-per-page'] = '5';
        }
        if ($category_layout == 'big-products') {
            $fastor_options['layout-type-woocategory'] = 'fullwidth';
            $fastor_options['category-product-per-page'] = '3';
        }
        if ($category_layout == 'small-products') {
            $fastor_options['layout-type-woocategory'] = 'fullwidth';
            $fastor_options['category-product-per-page'] = '6';
        }
    }

    $product_image = isset($_GET['product_image'])? $_GET['product_image'] : null;
    if($product_image){
        if($product_image == 'big'){
            $fastor_options['productpage-image-size'] = 3;
        }
    }

    return $fastor_options;
}
function fastor_get_product(){
    global $product;
    return $product;
}
function fastor_get_post(){
    global $post;
    return $post;
}
function fastor_get_woocommerce(){
    global $woocomerce;
    return $woocomerce;
}
function fastor_get_woocommerce_loop(){
    global $fastor_woocommerce_loop;
    return $fastor_woocommerce_loop;
}
function fastor_get_yith_woocompare(){
    global $yith_woocompare;
    return $yith_woocompare;
}
function fastor_get_yith_ajax_searchform_count(){
    global $yith_ajax_searchform_count;
    return $yith_ajax_searchform_count;
}
function fastor_get_wp_query(){
    global $wp_query;
    return $wp_query;
}


/**
 * Enqueue scripts and styles.
 */

// FONTS

function fastor_slug_fonts_url() {
    $fonts_url = '';

    $poppins = _x( 'on', 'Poppins font: on or off', 'fastor' );

    if ('off' !== $poppins) {
        $font_families = array();

        if ( 'off' !== $poppins ) {
            $font_families[] = 'Poppins:800,700,600,500,400,300';
        }

        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );
}

function fastor_slug_scripts_styles() {
    wp_enqueue_style( 'fastor-fonts', fastor_slug_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'fastor_slug_scripts_styles' );
add_action( 'admin_enqueue_scripts', 'fastor_slug_scripts_styles' );

function fastor_site_icon_url($url, $size, $blog_id) {
    $fastor_options = fastor_get_options();

    if(isset($fastor_options['layout-favicon']) && $fastor_options['layout-favicon']){
        $url = esc_url($fastor_options['layout-favicon']['url']);
    }
    return $url;
}
add_filter('get_site_icon_url', 'fastor_site_icon_url', 5, 3);


add_action('wp_enqueue_scripts', 'fastor_scripts');
add_action('wp_enqueue_scripts', 'fastor_css');
add_action('admin_enqueue_scripts', 'fastor_admin_scripts', 1000);
add_action('admin_enqueue_scripts', 'fastor_admin_css', 1000);

// Load Admin Scripts
function fastor_admin_scripts() {

    wp_enqueue_media();
    // wp default styles
    // admin script
    wp_register_script('fastor-admin', get_template_directory_uri().'/js/admin.js', array('common', 'jquery', 'media-upload', 'thickbox', 'wp-color-picker'), FASTOR_VERSION, true);
    wp_enqueue_script('fastor-admin');

}

// Load Admin CSS
function fastor_admin_css() {
    // wp default styles
    wp_enqueue_style( 'wp-color-picker' );
    // admin style
    wp_enqueue_style('fastor-admin', get_template_directory_uri().'/css/admin.css', false, FASTOR_VERSION, 'all');
}



// Load CSS
function fastor_css() {
    $fastor_options = fastor_get_options();

    // bootstrap styles
    wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/css/bootstrap.css' );

    if(is_rtl()) {
        // bootstrap rtl styles
        wp_enqueue_style('bootstrap_rtl', get_template_directory_uri().'/css/bootstrap_rtl.css');
    }

    // flag-icon styles
    wp_enqueue_style( 'flag-icon', get_template_directory_uri().'/css/flag-icon.min.css' );

    // animate styles
    wp_enqueue_style( 'animate', get_template_directory_uri().'/css/animate.css' );

    // eleganticons styles
    wp_enqueue_style( 'eleganticons', get_template_directory_uri().'/css/eleganticons.css' );

    // simple-line-icons styles
    wp_enqueue_style( 'simple-line-icons', get_template_directory_uri().'/css/simple-line-icons.css' );

    // jquery-vegas styles
    wp_enqueue_style( 'jquery-vegas', get_template_directory_uri().'/css/jquery.vegas.css' );

    // jqueryui styles
    wp_enqueue_style( 'jqueryui', get_template_directory_uri().'/css/jquery-ui.min.css' );

    // slider styles
    wp_enqueue_style( 'slider', get_template_directory_uri().'/css/slider.css' );

    // menu styles
    wp_enqueue_style( 'menu', get_template_directory_uri().'/css/menu.css' );

    // yith styles
    wp_enqueue_style( 'yith', get_template_directory_uri().'/css/yith.css' );

    // icheck styles
    wp_enqueue_style( 'icheck', get_template_directory_uri().'/css/icheck.css' );

    // fullPage styles
    wp_enqueue_style( 'fullPage', get_template_directory_uri().'/css/jquery.fullPage.css' );

    // magnific-popup
    wp_enqueue_style( 'magnific-popup', get_template_directory_uri().'/css/magnific-popup.css' );

    // owl.carousel styles
    wp_enqueue_style( 'owl.carousel', get_template_directory_uri().'/css/owl.carousel.css' );

    // filter_product styles
    wp_enqueue_style( 'filter_product', get_template_directory_uri().'/css/filter_product.css' );

    // font-awesome styles
    wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.min.css' );

    // blog styles
    wp_enqueue_style( 'blog', get_template_directory_uri().'/css/blog/blog.css' );

    // blog-articles styles
    wp_enqueue_style( 'blog-article', get_template_directory_uri().'/css/blog/article.css' );

    // fastor styles
    wp_enqueue_style( 'fastor-theme-styles', get_template_directory_uri() . '/style.css' );

    // fastor styles
    wp_enqueue_style( 'stylesheet', get_template_directory_uri().'/css/stylesheet.css' );

    // multiscroll styles
    wp_enqueue_style( 'multiscroll', get_template_directory_uri().'/css/jquery.multiscroll.css' );

    // woocommerce styles
    wp_enqueue_style( 'woocommerce', get_template_directory_uri().'/css/woocommerce.css' );

    // responsive styles
    wp_enqueue_style( 'responsive', get_template_directory_uri().'/css/responsive.css' );

    // fastor js composer
    wp_enqueue_style( 'js_composer', get_template_directory_uri().'/css/js_composer.css' );

    // slick
    wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css' );
    // portfolio

    wp_enqueue_style( 'portfolio',  get_template_directory_uri() . '/css/portfolio.css' );

    if($fastor_options['layout-page-width'] == 1){
        wp_enqueue_style( 'wide-grid', get_template_directory_uri().'/css/wide-grid.css' );
    }
    if($fastor_options['layout-page-width'] == 2){
        wp_enqueue_style( 'standard-grid', get_template_directory_uri().'/css/standard-grid.css' );
    }

    if($fastor_options['layout-spacing_between_columns'] == 2){
        wp_enqueue_style( 'standard-grid', get_template_directory_uri().'/css/spacing_20.css' );
    }

}


/*
 * LOAD JAVASCRIPT
 * */


function fastor_scripts() {
    if (!is_admin() && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) )) {
        wp_reset_postdata();
        global $wp_scripts;
        $fastor_options = fastor_get_options();

        if($fastor_options['header-autocomplete-status']){
            wp_enqueue_script( 'jquery-ui-autocomplete' );
        }

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        // jquery.easing scripts
        wp_enqueue_script( 'jquery.easing', get_template_directory_uri().'/js/jquery.easing.1.3.js', array(), null, true);

        // bootstrap scripts
        wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', array(), null, true);

        // twitter-bootstrap-hover-dropdown scripts
        wp_enqueue_script( 'twitter-bootstrap-hover-dropdown', get_template_directory_uri().'/js/twitter-bootstrap-hover-dropdown.js', array(), null, true);

        // bootstrap-notify scripts
        wp_enqueue_script( 'bootstrap-notify', get_template_directory_uri().'/js/bootstrap-notify.min.js', array(), null, true);

        // twitter-bootstrap-hover-dropdown scripts
        wp_enqueue_script( 'twitter-bootstrap-hover-dropdown', get_template_directory_uri().'/js/twitter-bootstrap-hover-dropdown.js', array(), null, true);

        // tweetfeed
        wp_enqueue_script( 'tweetfeed', get_template_directory_uri().'/js/tweetfeed.min.js', array(), null, true);

        // owl.carousel
        wp_enqueue_script( 'owl.carousel', get_template_directory_uri().'/js/owl.carousel.min.js', array(), null, true);

        // jquery.magnific-popup
        wp_enqueue_script( 'jquery.magnific-popup', get_template_directory_uri().'/js/jquery.magnific-popup.min.js', array(), null, true);

        // megamenu
        wp_enqueue_script( 'megamenu', get_template_directory_uri().'/js/megamenu.js', array(), null, true);

        // jquery.cookie
        wp_enqueue_script( 'jquery.cookie', get_template_directory_uri().'/js/jquery.cookie.js', array(), null, true);

//        // icheck
//        wp_enqueue_script( 'icheck', get_template_directory_uri().'/js/icheck.min.js', array(), null, true);

//        // jquery.matchHeight
//        wp_enqueue_script( 'matchHeight', get_template_directory_uri().'/js/jquery.matchHeight-min.js', array(), null, true);

//        // jquery.fullPage
//        wp_enqueue_script( 'fullPage', get_template_directory_uri().'/js/jquery.fullPage.min.js', array(), null, true);
//
//        // jquery.multiscroll
//        wp_enqueue_script( 'multiscroll', get_template_directory_uri().'/js/jquery.multiscroll.min.js', array(), null, true);

        // jquery.scrolly
        wp_enqueue_script( 'scrolly', get_template_directory_uri().'/js/jquery.scrolly.js', array(), null, true);

        if($fastor_options['product-lazy-load-img'] != 0){
            //  wp_enqueue_script( 'echo', get_template_directory_uri().'/js/echo.min.js', array(), null, true);
            // JqueryLazy
            wp_enqueue_script( 'jquery-lazy', get_template_directory_uri().'/js/jquery.lazy.min.js', array(), null, true);

        }
        // megamenu
        wp_enqueue_script( 'commons', get_template_directory_uri().'/js/common.js', array(), null, true);


        // Masonry
        wp_enqueue_script( 'masonry', get_template_directory_uri().'/js/masonry.pkgd.min.js', array(), null, true);
        // Slick
        wp_enqueue_script( 'slick', get_template_directory_uri().'/js/slick.min.js', array(), null, true);

        wp_localize_script( 'commons', 'js_fastor_vars', array(
            'email' => esc_html__('Email', 'fastor'),
            'ajax_url' => esc_url(admin_url( 'admin-ajax.php' )),
            'ajax_loader_url' => get_template_directory_uri() . '/images/ajax-loader@2x.gif',
            'add_to_cart_msg_success' => esc_html__('Product successfully added to your cart.', 'fastor'),
            'add_to_wishlist_msg_success' => esc_html__( 'Product successfully added to your wishlist.','fastor' )
        ) );



        if($fastor_options['header-sticky-status'] != 0){
            wp_enqueue_script( 'jquery.sticky', get_template_directory_uri().'/js/jquery.sticky.js', array(), null, true);
        }

        if($fastor_options['product-quickview-status'] != 0){
            wp_enqueue_script( 'wc-add-to-cart-variation' );
        }

        // Specials countdown
        if($fastor_options['product-countdown-status'] == '1') {

            wp_enqueue_script( 'jquery.plugin', get_template_directory_uri().'/js/jquery.plugin.min.js', array(), null, true);

            $locale = get_locale();
            $locale = explode('_', $locale);
            $lang = strtolower($locale[0]);

            wp_enqueue_script( 'jquery.countdown', get_template_directory_uri().'/js/jquery.countdown.min.js', array(), null, true);

            if($lang != 'en'){
                wp_enqueue_script( 'jquery.countdown-lang', get_template_directory_uri().'/js/countdown_lang/jquery.countdown-'.$lang.'.js', array(), null, true);
            }

        }

        // Portfolio
        wp_enqueue_script( 'portfolio', get_template_directory_uri().'/js/portfolio.js', array(), null, true);
        wp_localize_script( 'portfolio' , 'fastor_loadmoreportfolio' , array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );


        // If Portfolio Custom Templates are loaded then load this script with it
        if( is_page_template( 'template-portfolio-col-1.php' ) || is_page_template( 'template-portfolio-col-2.php' ) || is_page_template( 'template-portfolio-col-3.php' ) || is_page_template( 'template-portfolio-masonary-1.php' ) || is_page_template( 'template-portfolio-masonary-2.php' ) || is_page_template( 'template-portfolio-masonary-3.php' ) || is_page_template( 'template-portfolio-masonary-4.php' ) || is_page_template( 'template-portfolio-style-1.php' ) || is_page_template( 'template-portfolio-style-2.php' ) || is_page_template( 'template-portfolio-style-3.php' ) || is_page_template( 'template-portfolio-style-4.php' ) ) {
            wp_localize_script( 'fastor_portfolioloadmoretemplate' , 'fastor_loadmoreportfolio' , array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
        }



    }

}


// Ajax Responder For Portfolio Load More /
add_action( 'wp_ajax_nopriv_fastor_portfolio_ajaxloader' , 'fastor_portfolio_ajaxloader' );
add_action( 'wp_ajax_fastor_portfolio_ajaxloader' , 'fastor_portfolio_ajaxloader' );

function fastor_portfolio_ajaxloader() {
    $fastor_options = fastor_get_options();

    $fastor_page_template = esc_attr( $_POST[ 'template' ] );
    $fastor_start_point = esc_attr( $_POST[ 'click' ] );
    $fastor_limit = $fastor_options['portfolio-limit'] ? $fastor_options['portfolio-limit'] : 6;
    if(isset($_POST['limit'])){
        $fastor_limit = esc_attr( $_POST[ 'limit' ] );
    }
    $fastor_cat = '';
    if(isset($_POST['category'])){
        $fastor_cat = esc_attr( $_POST[ 'category' ] );
    }

    require_once get_template_directory() . '/inc/portfolio/portfolio_loader.php';

    $fastor_load_more = new FastorPortfolioLoader($fastor_options, $fastor_page_template , $fastor_start_point , $fastor_limit, $fastor_cat );

    $fastor_load_more->load_content();

    wp_reset_postdata();

    wp_die();
}


add_filter( 'woocommerce_add_to_cart_redirect', 'fastor_redirect_on_add_to_cart' );
function fastor_redirect_on_add_to_cart() {

    //Get product ID
    if ( isset( $_POST['add-to-cart'] ) ) {

        $product_id = (int) apply_filters( 'woocommerce_add_to_cart_product_id', $_POST['add-to-cart'] );
        //if(is_home()){
            return  get_permalink( $product_id ) ;
       // }

    }

}

function fastor_print_inline_head() {
    $fastor_options = fastor_get_options();
    ob_start();
    ?>
    <!-- JS -->
    <script>
        var responsive_design = '<?php if($fastor_options['layout-responsive'] == 0) { echo 'no'; } else { echo 'yes'; } ?>';
    </script>

    <?php
    require_once(get_template_directory(). '/inc/style_configuration.php');

    echo ob_get_clean();
}
add_action( 'wp_head', 'fastor_print_inline_head', 999 );


function fastor_print_inline_footer() {
    $fastor_options = fastor_get_options();
    ob_start();
    ?>
    <?php if($fastor_options['product-quickview-status'] == 1) { ?>
        <script>
            (function($) {
                $(window).load(function(){
                    $('.quickview a').magnificPopup({
                        preloader: true,
                        tLoading: '',
                        type: 'ajax',
                        mainClass: 'quickview',
                        removalDelay: 200,
                        gallery: {
                            enabled: true
                        }
                    });
                });
            })(jQuery)
        </script>
    <?php } ?>



    <?php if($fastor_options['js-status'] == 1):?>
        <script>
            <?php echo ($fastor_options['js-value']); ?>
        </script>
    <?php endif; ?>
    <?php

    echo ob_get_clean();
}
add_action( 'wp_footer', 'fastor_print_inline_footer', PHP_INT_MAX);



/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);






function fastor_html_topmenu($default = true) {

    ob_start(); ?>
    <!-- top navigation -->
    <?php
    if ( has_nav_menu( 'top_nav' ) ) : ?>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'top_nav',
            'menu_class' => 'menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'depth' => 0,
            'fallback_cb' => false,
            'walker' => new wp_bootstrap_navwalker
        ));
        ?>
    <?php elseif($default): ?>
        <?php echo wp_kses( 'Define your top navigation in <b>Apperance > Menus</b>', 'fastor', array( 'b' ) ) ?>
    <?php endif; ?>
    <!-- end top navigation -->
    <?php
    return ob_get_clean();
}

function fastor_html_mainmenu() {
    $fastor_options = fastor_get_options();
    ob_start(); ?>
    <!-- top navigation -->
    <div class="container-megamenu container horizontal">
        <div class="megaMenuToggle">
            <div class="megamenuToogle-wrapper">
                <div class="megamenuToogle-pattern">
                    <div class="container">
                        <div><span></span><span></span><span></span></div>
                        <?php echo esc_html__('Navigation', 'fastor'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="megamenu-wrapper<?php if(isset($fastor_options['menu-mobile-type']) && $fastor_options['menu-mobile-type'] == 'fixed_left'): ?> mobile-left<?php endif; ?>">

            <?php if(isset($fastor_options['menu-mobile-type']) && $fastor_options['menu-mobile-type'] == 'fixed_left'): ?>
                <div class="megamenu-close-fixed"><i class="icon_close"></i></div>
            <?php endif; ?>


            <div class="megamenu-pattern">
                <div class="container">
                    <?php
                    if ( has_nav_menu( 'main_menu' ) ) : ?>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'main_menu',
                            'menu_class' => 'megamenu ' . esc_attr($fastor_options['menu-animation-type']),
                            'before' => '',
                            'after' => '',
                            'link_before' => '',
                            'link_after' => '',
                            'fallback_cb' => false,
                            'walker' => new fastor_main_menuwalker
                        ));
                        ?>
                    <?php else: ?>
                        <?php echo wp_kses( 'Define your main menu in <b>Apperance > Menus</b>', 'fastor', array( 'b' ) ) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <!-- end top navigation -->
    <?php
    return ob_get_clean();
}


function fastor_sidebar_menu() {
    $fastor_options = fastor_get_options();
    ob_start(); ?>
    <?php
    if ( has_nav_menu( 'sidebar_menu' ) ) : ?>
        <!-- top navigation -->
        <div class="container-megamenu container vertical">
            <div class="menuHeading">
                <div class="megamenuToogle-wrapper">
                    <div class="megamenuToogle-pattern">
                        <div class="container">
                            <?php echo esc_html__('Categories', 'fastor'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="megamenu-wrapper">
                <div class="megamenu-pattern">
                    <div class="container">

                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'sidebar_menu',
                            'menu_class' => 'megamenu shift-left',
                            'before' => '',
                            'after' => '',
                            'link_before' => '',
                            'link_after' => '',
                            'fallback_cb' => false,
                            'walker' => new fastor_main_menuwalker
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php echo wp_kses( 'Define your sidebar menu in <b>Apperance > Menus</b>', 'fastor', array( 'b' ) ) ?>
    <?php endif; ?>
    <!-- end top navigation -->
    <?php
    return ob_get_clean();
}


function fastor_get_allowed_tags(){
    return array(
        'a' => array(
            'href' => array (),
            'title' => array ()),
        'abbr' => array(
            'title' => array ()),
        'acronym' => array(
            'title' => array ()),
        'b' => array(),
        'blockquote' => array(
            'cite' => array ()),
        'cite' => array (),
        'p' => array (),
        'br' => array (),
        'del' => array(
            'datetime' => array ()
        ),
        'em' => array (),
        'i' => array (),
        'q' => array(
            'cite' => array ()
        ),
        'strike' => array(),
        'strong' => array(),
    );

}

function fastor_html_minicart() {
    if(!defined('WC_VERSION')){
        return;
    }
    global $woocommerce, $fastor_options;
    ob_start();
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :
        $_cartQty = $woocommerce->cart->cart_contents_count;
        ?>
        <div id="cart_block" class="dropdown">
        <div class="cart-heading cart-head" data-hover="dropdown" data-toggle="dropdown">
            <i class="cart-count"><span class="total_count_ajax"><?php echo ($_cartQty > 0) ? $_cartQty : '0'; ?></span></i>

            <i class="cart-icon">
                <?php if(isset($fastor_options['color-top_cart_icon_hover_image']['url']) && $fastor_options['color-top_cart_icon_hover_image']['url']):?>
                    <img src="<?php echo esc_url($fastor_options['color-top_cart_icon_hover_image']['url']) ?>" class="cart-icon-hover" alt="">
                <?php else: ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/icon-cart-hover.png" class="cart-icon-hover" alt="">
                <?php endif; ?>
                <?php if(isset($fastor_options['color-top_cart_icon_image']['url']) && $fastor_options['color-top_cart_icon_image']['url']):?>
                    <img src="<?php echo esc_url($fastor_options['color-top_cart_icon_image']['url']) ?>" class="cart-icon-standard" alt="">
                <?php else: ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/icon-cart.png" class="cart-icon-standard" alt="">
                <?php endif; ?>
            </i>

            <p><strong class="total_price_ajax"><span class="total_price"><?php echo WC()->cart->get_cart_total(); ?></span></strong></p>
        </div>

        <div class="dropdown-menu" id="cart_content">
            <div class="block-content cart-content">
                <?php if ($_cartQty == 0) :?>
                    <div class="empty"><?php echo esc_html__('No products in the cart.','fastor'); ?> </div>
                <?php else : ?>

                    <?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
                        <div class="mini-cart-info ">
                        <table>
                        <?php
                        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                            $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

                                $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
                                $thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                                ?>
                                <tr>
                                    <td class="image">
                                        <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
                                            <?php if ( ! $_product->is_visible() ) { ?>
                                                <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
                                            <?php } else { ?>
                                                <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) ?>
                                            <?php } ?>
                                        </a>
                                    </td>
                                    <td class="name">
                                        <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
                                            <?php if ( ! $_product->is_visible() ) : ?>
                                                <?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?>
                                            <?php else : ?>
                                                <?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?>
                                            <?php endif; ?>
                                        </a>
                                    </td>
                                    <td class="quantity">x <?php echo esc_html($cart_item['quantity']); ?></td>
                                    <td class="total"><?php echo strip_tags($product_price); ?></td>
                                    <td class="remove">
                                        <?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="javascript:;" class="remove-icon"  title="%s" onclick="cart.remove(%s);" >&times;</a>', esc_html__('Remove this item', 'fastor'), "'".$cart_item_key."'"  ), $cart_item_key ); ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    <?php endif; ?>
                    </table>
                    </div>

                    <div class="mini-cart-total">
                        <table>
                            <tr>
                                <td class="right"><b><?php echo esc_html__('Subtotal', 'fastor') ?>:</b></td>
                                <td class="right"><?php echo WC()->cart->get_cart_total(); ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="checkout">
                        <a class="button  btn-default" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php esc_html_e('Cart', 'fastor'); ?></a>
                        &nbsp;
                        <a class="button" href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php esc_html_e('Checkout', 'fastor'); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div><!-- // .dropdown-menu -->
        <?php
    endif;

    ?> </div> <?php
    return ob_get_clean();
}

function fastor_search_form($show_content = true) {
    if ( !class_exists( 'Woocommerce' ) ){
        return;
    }

    if(!$show_content){
        ?> <div class="search_form"><a href="<?php echo get_page_link( get_page_by_title( 'search' )->ID ); ?>"<i class="fa fa-search"></i></a></div> <?php
        return;
    }

    ?>
    <div class="search_form">
    <?php
    $fastor_options = fastor_get_options();
    if (fastor_is_plugin_active( 'yith-woocommerce-ajax-search/init.php' ) && $fastor_options['header-autocomplete-status']) {
        $wc_get_template = function_exists('wc_get_template') ? 'wc_get_template' : 'woocommerce_get_template';
        $wc_get_template( 'yith-woocommerce-ajax-search.php', array(), '', YITH_WCAS_DIR . 'templates/' );
    }else{
        ?>
        <?php
        $fastor_options = fastor_get_options();

        ?>

        <form action="<?php echo esc_url( home_url( '/' ) ); ?>/" method="get" >
            <button class="button-search" type="submit"></button>

            <?php if(in_array($fastor_options['header-type'], array(12, 24, 13, 19))): ?>
                <?php
                $all_categories = fastor_get_product_categories();
                ?>
                <?php if(!empty($all_categories)): ?>
                    <div class="search-cat">
                        <div class="select">
                            <select name="product_category" class="form-control">
                                <option value=""><?php echo esc_html__('All categories', 'fastor'); ?></option>
                                <?php foreach($all_categories as $category): ?>
                                    <option value="<?php echo $category->slug ?>" <?php echo isset($_GET['product_category']) && $_GET['product_category'] == $category->slug ? 'selected': '' ?>><?php echo $category->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>


            <input type="hidden" name="post_type" value="product" />

            <?php if(in_array($fastor_options['header-type'], array(12, 24, 13, 19))): ?>
            <div class="overflow-input">
                <?php endif; ?>
                <input class="<?php if($fastor_options['header-autocomplete-status']){ echo 'auto-suggest'; }?>" name="s" id="s" type="text" value="<?php echo isset($_GET['s'])? htmlentities2($_GET['s']) : '' ?>" placeholder="<?php echo esc_html__('Search here', 'fastor'); ?>" autocomplete="off" />
                <div id="autocomplete-results" class="autocomplete-results"></div>
        </form>

        <?php if(in_array($fastor_options['header-type'], array(12, 24, 13, 19))): ?>
            </div>
        <?php endif; ?>

        <?php
    } ?>
    </div>
    <?php
}

function fastor_search_form_get_content($show_content = true){
    ob_start();
    fastor_search_form($show_content);
    return ob_get_clean();
}


if (!function_exists('fastor_comment')) :
function fastor_comment($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>

<div <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

    <div class="meta">
        <div class="author">
            <strong><?php echo get_comment_author_link() ?></strong>
            <span class="date">
                    <?php printf(esc_html__('%1$s at %2$s', 'fastor'), get_comment_date(),  get_comment_time()) ?></span>
            </span>
        </div>
        <?php edit_comment_link(esc_html__('Edit', 'fastor'),'  ','') ?> <?php comment_reply_link(array_merge( $args, array('reply_text' => esc_html__('Reply', 'fastor'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    <div class="text">
        <div class="avatar-wrapper">
            <?php echo get_avatar($comment, 70); ?>
        </div>
        <div class="comment-content">
            <?php if ($comment->comment_approved == '0') : ?>
                <em><?php echo esc_html__('Your comment is awaiting moderation.', 'fastor') ?></em>
                <br />
            <?php endif; ?>
            <?php comment_text() ?>
        </div>

    </div>

    <?php }
    endif;


    // Post Comment Form Field
    add_filter('comment_form_default_fields', 'fastor_comment_form_default_fields', 5, 1);
    add_filter('comment_form_defaults', 'fastor_comment_form_defaults', 10, 1);

    if (!function_exists('fastor_comment_form_default_fields')) :
        function fastor_comment_form_default_fields($fields) {

            $fields['author'] =
                '<div class="col-xs-12 col-sm-4">
                '.
                str_replace(
                    array('<label for="author">', '<input id="author"'),
                    array('<label for="author" class="control-label">', '<input id="input-author" class="form-control"'),
                    $fields['author']).
                '</div>';
            $fields['email'] =
                '<div class="col-xs-12 col-sm-4">
                '.
                str_replace(
                    array('<label for="email">', '<input id="email"'),
                    array('<label for="email" class="control-label">', '<input id="input-email" class="form-control"'),
                    $fields['email']).
                '</div>';
            $fields['url'] =
                '<div class="col-xs-12 col-sm-4">
                '.
                str_replace(
                    array('<label for="url">', '<input id="url"'),
                    array('<label for="url" class="control-label">', '<input id="input-url" class="form-control"'),
                    $fields['url']).
                '</div>';

            return $fields;
        }
    endif;

    if (!function_exists('fastor_comment_form_defaults')) :
        function fastor_comment_form_defaults($default) {
            $default['id_form'] = 'form-comment';
            $default['class_form'] = 'form-horizontal';
            $default['comment_field'] = '
                <div class="row"><div class="col-xs-12">'
                .str_replace(
                    array('<label for="comment">', '<textarea id="comment"'),
                    array('<label for="comment" class="control-label">', '<textarea id="comment" class="form-control"'),
                    $default['comment_field']).
                '</div></div>';
            $default['class_submit'] = "button button-large button-comment";
            $default['title_reply_before'] = '<div class="box-heading">';
            $default['title_reply_after'] = '</div><div class="strip-line"></div><div class="clearfix"></div>';
            $default['submit_button'] = '<div class="text-center clear">' . $default['submit_button']. '</div>';

            return $default;
        }
    endif;

    if (!function_exists('get_related_posts')) :
        function get_related_posts($post_id) {
            $query = new WP_Query();

            $args = '';

            $args = wp_parse_args($args, array(
                'showposts' => -1,
                'post__not_in' => array($post_id),
                'ignore_sticky_posts' => 0,
                'category__in' => wp_get_post_categories($post_id)
            ));

            $query = new WP_Query($args);

            return $query;
        }
    endif;


    if (!function_exists('fastor_excerpt')) :
        function fastor_excerpt($limit = 45, $more_link = true) {
            $fastor_options = fastor_get_options();

            $custom_excerpt = false;

            $post = get_post(get_the_ID());

            if (has_excerpt()) {
                $content = strip_tags( strip_shortcodes(get_the_excerpt()) );
            } else {
                $content = strip_tags( strip_shortcodes(get_the_content()) );
            }

            $content = explode(' ', $content, $limit);

            if (count($content) >= $limit) {
                array_pop($content);
                $content = implode(" ",$content).'...';
            } else {
                $content = implode(" ",$content);
            }

            $content = apply_filters('the_content', $content);
            $content = do_shortcode($content);

            $content = '<div class="entry-excerpt">'.$content.' </div>';

            $content.= '<a class="button-more" href="'.esc_url( apply_filters( 'the_permalink', get_permalink() ) ).'">'.esc_html__('Read More', 'fastor').'</a>';

            return $content;
        }
    endif;

    if(!function_exists('fastor_pagination')):
        function fastor_pagination($pages = '', $range = 2)
        {
            global $data;

            $showitems = ($range * 2)+1;

            global $paged;

            if (empty($paged)) $paged = 1;

            if ($pages == '')
            {
                global $wp_query;
                $pages = $wp_query->max_num_pages;
                if (!$pages)
                {
                    $pages = 1;
                }
            }

            if (1 != $pages)
            {
                echo "<div class='clearfix'><div class=' pagination-results text-center'>";

                echo '<ul class="page-numbers">';
                if ($paged > 1) echo "<li><a class='prev' href='".get_pagenum_link($paged - 1)."'><</a></li>";
                for ($i=1; $i <= $pages; $i++)
                {
                    if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
                    {
                        echo '<li '.(($paged == $i)? 'class="active"' : '').'>';
                        echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
                        echo '</li>';
                    }
                }

                if ($paged < $pages) echo "<li><a class='next' href='".get_pagenum_link($paged + 1)."'>></a></li>";

                echo "</ul></div></div>\n";
            }
        }
    endif;

    // get attribute from html tag
    if (!function_exists('fastor_get_html_attribute')):
        function fastor_get_html_attribute($attrib, $tag) {
            $re = '/'.$attrib.'=["\']?([^"\' ]*)["\' ]/is';
            preg_match($re, $tag, $match);

            if ($match) {
                return urldecode($match[1]);
            }
            return false;
        }
    endif;

    // add url parameters
    if (!function_exists('fastor_add_url_parameters')):
        function fastor_add_url_parameters($url, $name, $value) {
            $url_data = parse_url(str_replace('#038;', '&', $url));
            if (!isset($url_data["query"]))
                $url_data["query"]="";

            $params = array();
            parse_str($url_data['query'], $params);
            $params[$name] = $value;
            $url_data['query'] = http_build_query($params);
            return esc_attr(str_replace('#038;', '&', fastor_build_url($url_data)));
        }
    endif;

    // remove url parameters
    if (!function_exists('fastor_remove_url_parameters')):
        function fastor_remove_url_parameters($url, $name) {
            $url_data = parse_url(str_replace('#038;', '&', $url));
            if (!isset($url_data["query"]))
                $url_data["query"]="";

            $params = array();
            parse_str($url_data['query'], $params);
            $params[$name] = "";
            $url_data['query'] = http_build_query($params);
            return str_replace('#038;', '&', fastor_build_url($url_data));
        }
    endif;

    // build url
    if (!function_exists('fastor_build_url')):
        function fastor_build_url($url_data) {
            $url="";
            if (isset($url_data['host'])) {
                $url .= $url_data['scheme'] . '://';
                if (isset($url_data['user'])) {
                    $url .= $url_data['user'];
                    if (isset($url_data['pass']))
                        $url .= ':' . $url_data['pass'];
                    $url .= '@';
                }
                $url .= $url_data['host'];
                if (isset($url_data['port']))
                    $url .= ':' . $url_data['port'];
            }
            if (isset($url_data['path']))
                $url .= $url_data['path'];
            if (isset($url_data['query']))
                $url .= '?' . $url_data['query'];
            if (isset($url_data['fragment']))
                $url .= '#' . $url_data['fragment'];

            return $url;
        }
    endif;

    // get breadcrumbs
    if (!function_exists('fastor_breadcrumbs')):
        function fastor_breadcrumbs() {
            $fastor_options = fastor_get_options();
            global $post, $wp_query, $author;

            $prepend = '';
            $before = '<li>';
            $after = '</li>';
            $home = esc_html__('Home', 'fastor');
            $delimiter = '';

            $shop_page_id = false;
            $shop_page = false;
            $front_page_shop = false;
            if ( defined( 'WOOCOMMERCE_VERSION' ) ) {
                $permalinks   = get_option( 'woocommerce_permalinks' );
                $shop_page_id = wc_get_page_id( 'shop' );
                $shop_page    = get_post( $shop_page_id );
                $front_page_shop = get_option( 'page_on_front' ) == wc_get_page_id( 'shop' );
            }

            // If permalinks contain the shop page in the URI prepend the breadcrumb with shop
            if ( $shop_page_id && $shop_page && strstr( $permalinks['product_base'], '/' . $shop_page->post_name ) && get_option( 'page_on_front' ) != $shop_page_id ) {
                $prepend = $before . '<a href="' . get_permalink( $shop_page ) . '">' . $shop_page->post_title . '</a> ' . $after . $delimiter;
            }

            if ( ( ! is_home() && ! is_front_page() && ! ( is_post_type_archive() && $front_page_shop ) ) || is_paged() ) {
                echo '<ul>';

                if ( ! empty( $home ) ) {
                    echo $before . '<a class="home" href="' . apply_filters( 'woocommerce_breadcrumb_home_url', esc_url( home_url( '/' ) ) ) . '">' . $home . '</a>' . $after . $delimiter;
                }

                if ( is_home() ) {

                    echo $before . single_post_title('', false) . $after;

                } else if ( is_category() ) {

                    $cat_obj = $wp_query->get_queried_object();
                    $this_category = get_category( $cat_obj->term_id );

                    if ( 0 != $this_category->parent ) {
                        $parent_category = get_category( $this_category->parent );
                        if ( ( $parents = get_category_parents( $parent_category, TRUE, $after . $delimiter . $before ) ) && ! is_wp_error( $parents ) ) {
                            echo $before . substr( $parents, 0, strlen($parents) - strlen($after . $delimiter . $before) ) . $after . $delimiter;
                        }
                    }

                    echo $before . single_cat_title( '', false ) . $after;

                } elseif ( is_tax('product_cat') || is_tax('portfolio_cat') || is_tax('portfolio_skills') ) {

                    echo $prepend;

                    $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

                    $ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );

                    foreach ( $ancestors as $ancestor ) {
                        $ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );

                        echo $before . '<a href="' . get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) ) . '">' . esc_html( $ancestor->name ) . '</a>' . $after . $delimiter;
                    }

                    echo $before . esc_html( $current_term->name ) . $after;

                } elseif ( is_tax('product_tag') ) {

                    $queried_object = $wp_query->get_queried_object();
                    echo $prepend . $before . sprintf( esc_html__( 'Products tagged &ldquo;%s&rdquo;', 'fastor' ), $queried_object->name ) . $after;

                } elseif ( is_day() ) {

                    echo $before . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $after . $delimiter;
                    echo $before . '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $after . $delimiter;
                    echo $before . get_the_time('d') . $after;

                } elseif ( is_month() ) {

                    echo $before . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $after . $delimiter;
                    echo $before . get_the_time('F') . $after;

                } elseif ( is_year() ) {

                    echo $before . get_the_time('Y') . $after;

                } elseif ( is_post_type_archive('product') && get_option('page_on_front') !== $shop_page_id ) {

                    $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

                    if ( ! $_name ) {
                        $product_post_type = get_post_type_object( 'product' );
                        $_name = $product_post_type->labels->singular_name;
                    }

                    if ( is_search() ) {

                        echo $before . '<a href="' . get_post_type_archive_link('product') . '">' . $_name . '</a>' . $delimiter . sprintf( esc_html__( 'Search results for &ldquo;%s&rdquo;', 'fastor' ), get_search_query() ) . $after;

                    } elseif ( is_paged() ) {

                        echo $before . '<a href="' . get_post_type_archive_link('product') . '">' . $_name . '</a>' . $after;

                    } else {

                        echo $before . $_name . $after;

                    }

                } elseif ( is_single() && ! is_attachment() ) {

                    if ( 'product' == get_post_type() ) {

                        echo $prepend;

                        if ( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {
                            $main_term = $terms[0];
                            $ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
                            $ancestors = array_reverse( $ancestors );

                            foreach ( $ancestors as $ancestor ) {
                                $ancestor = get_term( $ancestor, 'product_cat' );

                                if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                                    echo $before . '<a href="' . get_term_link( $ancestor ) . '">' . $ancestor->name . '</a>' . $after . $delimiter;
                                }
                            }

                            echo $before . '<a href="' . get_term_link( $main_term ) . '">' . $main_term->name . '</a>' . $after . $delimiter;

                        }

                        echo $before . get_the_title() . $after;

                    } elseif ( 'post' != get_post_type() ) {

                        $post_type = get_post_type_object( get_post_type() );
                        $slug = $post_type->rewrite;
                        echo $before . '<a href="' . get_post_type_archive_link( get_post_type() ) . '">' . $post_type->labels->singular_name . '</a>' . $after . $delimiter;
                        echo $before . get_the_title() . $after;

                    } else {

                        $cat = current( get_the_category() );
                        if ( ( $parents = get_category_parents( $cat, TRUE, $after . $delimiter . $before ) ) && ! is_wp_error( $parents ) ) {
                            echo $before . substr( $parents, 0, strlen($parents) - strlen($after . $delimiter . $before) ) . $after . $delimiter;
                        }
                        echo $before . get_the_title() . $after;

                    }

                } elseif ( is_404() ) {

                    echo $before . esc_html__( 'Error 404', 'fastor' ) . $after;

                } elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' ) {

                    $post_type = get_post_type_object( get_post_type() );

                    if ( $post_type ) {
                        echo $before . $post_type->labels->singular_name . $after;
                    }

                } elseif ( is_attachment() ) {

                    $parent = get_post( $post->post_parent );
                    $cat = get_the_category( $parent->ID );
                    if(isset($cat[0])){
                        $cat = $cat[0];
                    }
                    if ( ( $parents = get_category_parents( $cat, TRUE, $after . $delimiter . $before ) ) && ! is_wp_error( $parents ) ) {
                        echo $before . substr( $parents, 0, strlen($parents) - strlen($after . $delimiter . $before) ) . $after . $delimiter;
                    }
                    echo $before . '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>' . $after . $delimiter;
                    echo $before . get_the_title() . $after;

                } elseif ( is_page() && !$post->post_parent ) {

                    echo $before . get_the_title() . $after;

                } elseif ( is_page() && $post->post_parent ) {

                    $parent_id  = $post->post_parent;
                    $breadcrumbs = array();

                    while ( $parent_id ) {
                        $page = get_post( $parent_id );
                        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title( $page->ID ) . '</a>';
                        $parent_id  = $page->post_parent;
                    }

                    $breadcrumbs = array_reverse( $breadcrumbs );

                    foreach ( $breadcrumbs as $crumb ) {
                        echo $before . $crumb . $after . $delimiter;
                    }

                    echo $before . get_the_title() . $after;

                } elseif ( is_search() ) {

                    echo $before . sprintf( esc_html__( 'Search results for &ldquo;%s&rdquo;', 'fastor' ), get_search_query() ) . $after;

                } elseif ( is_tag() ) {

                    echo $before . sprintf( esc_html__( 'Posts tagged &ldquo;%s&rdquo;', 'fastor' ), single_tag_title( '', false ) ) . $after;

                } elseif ( is_author() ) {

                    $userdata = get_userdata($author);
                    echo $before . sprintf( esc_html__( 'Author: %s', 'fastor' ), $userdata->display_name ) . $after;

                }

                if ( get_query_var( 'paged' ) ) {
                    echo ' (' . sprintf( esc_html__( 'Page %d', 'fastor' ), get_query_var( 'paged' ) ) . ')';
                }

                echo '</ul>';
            } else {
                if ( is_home() && !is_front_page() ) {
                    echo '<ul>';

                    if ( ! empty( $home ) ) {
                        echo $before . '<a class="home" href="' . apply_filters( 'woocommerce_breadcrumb_home_url', esc_url( home_url( '/' ) ) ) . '">' . $home . '</a>' . $after . $delimiter;

                        echo $before . esc_attr($fastor_options['blog-title']) . $after;
                    }

                    echo '</ul>';
                }
            }
        }
    endif;
    // Woocommerce Hooks
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
    add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 50 );

    // Woocommerce Functions
    add_action('fastor_woocommerce_before_catalog', 'fastor_woocommerce_catalog_ordering', 10);
    function fastor_woocommerce_catalog_ordering() {
        $fastor_options = fastor_get_options();

        $query_string = filter_input(INPUT_SERVER, 'QUERY_STRING', FILTER_SANITIZE_URL);

        if(!$query_string && $_SERVER['QUERY_STRING']){
            $query_string = htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES);
            $query_string = html_entity_decode($query_string);
        }

        parse_str($query_string, $params);

        $query_string = '?'.$query_string;

        // replace it with theme option

        $per_page = explode(',', '9,15,27,36');

        if($fastor_options['category-product-per-page'] == 6) { $per_page = explode(',', '18,24,30,48'); }
        if($fastor_options['category-product-per-page'] == 5) { $per_page = explode(',', '15,25,30,50'); }
        if($fastor_options['category-product-per-page'] == 4) { $per_page = explode(',', '12,16,24,32'); }


        $orderby = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
        $order = !empty($params['product_order']) ? $params['product_order'] : 'asc';
        $item_count = !empty($params['product_count']) ? $params['product_count'] : $per_page[0];
        ?>
        <div class="product-filter clearfix" style="clear: both">
            <div class="options">
                <div class="button-group display view-mode gridlist-toggle" data-toggle="buttons-radio">
                    <button id="grid" <?php if($fastor_options['category-default-list-grid'] == 1) { echo 'class="active"'; } ?> rel="tooltip" title="Grid" onclick="display('grid');"><i class="fa fa-th-large"></i></button>
                    <button id="list" <?php if($fastor_options['category-default-list-grid'] != 1) { echo 'class="active"'; } ?> rel="tooltip" title="List" onclick="display('list');"><i class="fa fa-th-list"></i></button>
                </div>
            </div>
            <div class="list-options">
                <div class="limit">
                    <select onchange="location = this.value;">
                        <?php foreach ($per_page as $count):?>
                            <option <?php if ($item_count == $count) : ?> selected <?php endif; ?>  value="<?php echo fastor_add_url_parameters($query_string, 'product_count', $count) ?>"><?php echo $count ?></option>
                        <?php endforeach; ?>
                    </select>


                </div>
            </div>
            <div class="list-options">
                <div class="sort">
                    <?php if($order == 'desc'): ?>
                        <a class="btn-arrow order-desc" href="<?php echo fastor_add_url_parameters($query_string, 'product_order', 'asc') ?>">
                            <i class="arrow_down"></i>
                        </a>
                    <?php else: ?>
                        <a class="btn-arrow order-asc left" href="<?php echo fastor_add_url_parameters($query_string, 'product_order', 'desc') ?>">
                            <i class="arrow_up"></i>
                        </a>
                    <?php endif; ?>
                    <select onchange="location = this.value;">
                        <option <?php if ($orderby == 'default') : ?> selected <?php endif; ?>  value="<?php echo fastor_add_url_parameters($query_string, 'product_orderby', 'default') ?>"><?php echo esc_html__('Default', 'fastor') ?></option>
                        <option <?php if ($orderby == 'popularity') : ?> selected <?php endif; ?>  value="<?php echo fastor_add_url_parameters($query_string, 'product_orderby', 'popularity') ?>"><?php echo esc_html__('Popularity', 'fastor') ?></option>
                        <option <?php if ($orderby == 'rating') : ?> selected <?php endif; ?>  value="<?php echo fastor_add_url_parameters($query_string, 'product_orderby', 'rating') ?>"><?php echo esc_html__('Rating', 'fastor') ?></option>
                        <option <?php if ($orderby == 'date') : ?> selected <?php endif; ?> value="<?php echo fastor_add_url_parameters($query_string, 'product_orderby', 'date') ?>"><?php echo esc_html__('Date', 'fastor') ?></option>
                        <option <?php if ($orderby == 'price') : ?> selected <?php endif; ?>  value="<?php echo fastor_add_url_parameters($query_string, 'product_orderby', 'price') ?>"><?php echo esc_html__('Price', 'fastor') ?></option>
                        <option <?php if ($orderby == 'name') : ?> selected <?php endif; ?>  value="<?php echo fastor_add_url_parameters($query_string, 'product_orderby', 'name') ?>"><?php echo esc_html__('Name', 'fastor') ?></option>
                    </select>


                </div>
            </div>


        </div>

        <?php
    }

    // woocommerce ordering args

    add_action( 'wp', 'fastor_remove_ordering_args' );

    function fastor_remove_ordering_args() {
        remove_filter( 'posts_clauses', 'fastor_order_by_popularity_post_clauses' );
        remove_filter( 'posts_clauses', 'fastor_order_by_rating_post_clauses' );
    }

    add_action('woocommerce_get_catalog_ordering_args', 'fastor_woocommerce_get_catalog_ordering_args', 20);
    function fastor_woocommerce_get_catalog_ordering_args($args) {
        $query_string = filter_input(INPUT_SERVER, 'QUERY_STRING', FILTER_SANITIZE_URL);

        if(!$query_string && $_SERVER['QUERY_STRING']){
            $query_string = htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES);
            $query_string = html_entity_decode($query_string);
        }

        parse_str($query_string, $params);

        $orderby = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
        $order = !empty($params['product_order']) ? $params['product_order'] : 'asc';

        switch ($orderby) {
            case 'date':
                $_orderby = 'date';
                $_order = 'desc';
                $_meta_key = '';
                break;
            case 'price':
                $_orderby = 'meta_value_num';
                $_order = 'asc';
                $_meta_key = '_price';
                break;
            case 'popularity':
                $_orderby = 'popularity';
                break;
            case 'rating':
                $_orderby = 'rating';
                break;
            case 'title':
                $_orderby = 'title';
                $_order = 'asc';
                $_meta_key = '';
                break;
            case 'default':
            default:
                $_orderby = 'menu_order title';
                $_order = 'asc';
                $_meta_key = '';
                break;
        }

        switch ($order) {
            case 'desc':
                $_order = 'desc';
                break;
            case 'asc':
            default:
                $_order = $_order;
                break;
        }

        switch ($_orderby) {
            case 'popularity' :
                $args['meta_key'] = 'total_sales';
                // Sorting handled later though a hook
                add_filter( 'posts_clauses', 'fastor_order_by_popularity_post_clauses' );
                break;
            case 'rating' :
                // Sorting handled later though a hook
                add_filter( 'posts_clauses', 'fastor_order_by_rating_post_clauses' );
                break;
            default:
                break;
        }

        $args['orderby'] = $_orderby;
        $args['order'] = $_order;
        $args['meta_key'] = $_meta_key;

        return $args;
    }

    // Sorting handled later though a hook
    function fastor_order_by_popularity_post_clauses( $args ) {
        global $wpdb;

        $query_string = filter_input(INPUT_SERVER, 'QUERY_STRING', FILTER_SANITIZE_URL);
        parse_str($query_string, $params);

        $order = !empty($params['product_order']) ? $params['product_order'] : 'asc';
        $args['orderby'] = esc_sql("$wpdb->postmeta.meta_value+0 $order, $wpdb->posts.post_date DESC");

        return $args;
    }

    // Sorting handled later though a hook
    function fastor_order_by_rating_post_clauses( $args ) {
        global $wpdb;

        $query_string = filter_input(INPUT_SERVER, 'QUERY_STRING', FILTER_SANITIZE_URL);
        parse_str($query_string, $params);

        $order = !empty($params['product_order']) ? $params['product_order'] : 'desc';
        $args['fields'] .= ", AVG( ".esc_sql($wpdb->commentmeta).".meta_value ) as average_rating ";
        $args['where'] .= " AND ( ".esc_sql($wpdb->commentmeta).".meta_key = 'rating' OR ".esc_sql($wpdb->commentmeta).".meta_key IS null ) ";
        $args['join'] .= "
        LEFT OUTER JOIN ".esc_sql($wpdb->comments)." ON(".esc_sql($wpdb->posts).".ID = ".esc_sql($wpdb->comments).".comment_post_ID)
        LEFT JOIN $wpdb->commentmeta ON(".esc_sql($wpdb->comments).".comment_ID = ".esc_sql($wpdb->commentmeta).".comment_id)
    ";
        $args['orderby'] = esc_sql("average_rating $order, $wpdb->posts.post_date DESC");
        $args['groupby'] = esc_sql("$wpdb->posts.ID");

        return $args;
    }

    // get product count per page
    add_filter('loop_shop_per_page', 'fastor_loop_shop_per_page');
    function fastor_loop_shop_per_page() {
        $fastor_options = fastor_get_options();

        $query_string = filter_input(INPUT_SERVER, 'QUERY_STRING', FILTER_SANITIZE_URL);
        parse_str($query_string, $params);


        $per_page = explode(',', '9,15,27,36');

        if($fastor_options['category-product-per-page'] == 6) { $per_page = explode(',', '18,24,30,48'); }
        if($fastor_options['category-product-per-page'] == 5) { $per_page = explode(',', '15,25,30,50'); }
        if($fastor_options['category-product-per-page'] == 4) { $per_page = explode(',', '12,16,24,32'); }


        $item_count = !empty($params['product_count']) ? $params['product_count'] : $per_page[0];

        return $item_count;
    }

    // Get Product Thumbnail
    add_action('woocommerce_before_shop_loop_item', 'fastor_woocommerce_thumbnail', 10);
    remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

    function fastor_woocommerce_thumbnail() {
        global $product, $woocommerce, $fastor_options;

        $id = get_the_ID();
        $size = 'shop_catalog';

        if(isset($_SESSION['DYNAMIC_IMAGE_SIZE'])){
            $size = htmlentities($_SESSION['DYNAMIC_IMAGE_SIZE']);
        }

        $gallery = get_post_meta($id, '_product_image_gallery', true);
        $attachment_image = '';
        if ($fastor_options['product-image-effect'] == 1 && !empty($gallery)) {
            $gallery = explode(',', $gallery);
            $first_image_id = $gallery[0];
            $attachment_image = wp_get_attachment_image($first_image_id , $size, false, array('class' => 'swap-image'));
        }
        if ($fastor_options['product-image-effect'] == 2){
            $thumb_image = get_the_post_thumbnail($id , $size, array('class' => 'zoom-image-effect'));
        }else{
            $thumb_image = get_the_post_thumbnail($id , $size);
        }

        $class="image";

        if ($fastor_options['product-image-effect'] == 1){
            $class .= " image-swap-effect ";
        }


        if (!$thumb_image) {
            if ( wc_placeholder_img_src() )
                $thumb_image = wc_placeholder_img( $size );
        }


        if($fastor_options['product-lazy-load-img']){
            $thumb_image = str_replace('src', 'src="'.get_template_directory_uri().'/img/blank.gif" data-src', $thumb_image);
            $attachment_image = str_replace('src', 'src="'.get_template_directory_uri().'/img/blank.gif" data-src', $attachment_image);
            $thumb_image .= '<img class="img-loader" src="'.get_template_directory_uri().'/img/loader.svg' . '"/>';
        }

        woocommerce_show_product_loop_sale_flash();
        // show quick view


        echo '<div class="'.$class.'">';

        ?><a href="<?php the_permalink(); ?>"><?php
        echo $attachment_image;
        echo $thumb_image;
        ?></a><?php

        if($fastor_options['product-countdown-status'] == '1'){
            $sales_price_to = get_post_meta($id, '_sale_price_dates_to', true);
            if( $sales_price_to != "" ){
                echo '<div  data-date-end="'.$sales_price_to.'" class="product-price-countdown clearfix"></div>';
            }
        }


        echo '</div>';
    }

    add_action('woocommerce_before_shop_loop_item_list', 'fastor_woocommerce_thumbnail_list', 10);

    function fastor_woocommerce_thumbnail_list() {
        global $product, $woocommerce, $fastor_options;

        $id = get_the_ID();
        $size = 'shop_catalog';

        $gallery = get_post_meta($id, '_product_image_gallery', true);
        $attachment_image = '';
        if ($fastor_options['product-image-effect'] == 1 && !empty($gallery)) {
            $gallery = explode(',', $gallery);
            $first_image_id = $gallery[0];
            $attachment_image = wp_get_attachment_image($first_image_id , $size, false, array('class' => 'swap-image'));
        }
        if ($fastor_options['product-image-effect'] == 2){
            $thumb_image = get_the_post_thumbnail($id , $size, array('class' => 'zoom-image-effect '));
        }else{
            $thumb_image = get_the_post_thumbnail($id , $size);
        }

        $class="product-image";

        if ($fastor_options['product-image-effect'] == 1){
            $class .= " image-swap-effect ";
        }


        if (!$thumb_image) {
            if ( wc_placeholder_img_src() )
                $thumb_image = wc_placeholder_img( $size );
        }


        woocommerce_show_product_loop_sale_flash();
        // show quick view
        echo '<div class="'.$class.'">';
        ?><a href="<?php the_permalink(); ?>"><?php
        echo '<span class="front margin-image">';
        echo $thumb_image;
        echo '</span>';
        echo '<span class="product-img-additional back margin-image">';
        echo $attachment_image;
        echo '</span>';

        ?></a>
        <div class="category-over product-show-box">
            <div class="main-quickview quickview">
                <?php if ($fastor_options['product-quickview-status']) : ?>
                    <a class="btn show-quickview"" href="<?php echo esc_url(admin_url( 'admin-ajax.php?action=fastor_product_quickview&context=frontend&pid=' )) ?><?php echo the_ID() ?>" data-toggle="tooltip" data-original-title="<?php echo esc_html__('Quickview', 'fastor') ?>">
                    <i aria-hidden="true" class="arrow_expand"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php


        echo '</div>';
    }

    function fastor_woocommerce_image() {
        global $product, $woocommerce, $fastor_options;

        $id = get_the_ID();
        $size = 'shop_single';

        if ( has_post_thumbnail() ) {
            $image = get_the_post_thumbnail( $id, apply_filters( 'single_product_small_thumbnail_size', $size ) );
        } else {
            $gallery = get_post_meta($id, '_product_image_gallery', true);
            $attachment_image = '';
            if (!empty($gallery)) {
                $gallery = explode(',', $gallery);
                $first_image_id = $gallery[0];
                $image = wp_get_attachment_image($first_image_id , $size, false, array('class' => ''));
            }
        }

        if (!$image)
            $image = wc_placeholder_img_src();

        $class="product-image";

        echo '<span class="'.$class.'">';

        // show images, sale label
        echo $image; fastor_woocommerce_sale();

        echo '</span>';
    }


    // Get Fastor Meta Values
    function fastor_layout() {
        global $wp_query, $fastor_options;

        $layout = isset($fastor_options['layout-type'])? $fastor_options['layout-type']:'fullwidth';
        $layout = (isset($_GET['layout'])) ? $_GET['layout-type-blog'] : $layout;
        $default = fastor_meta_use_default();

        if (is_404()) {
            $layout = 'widewidth';
        } else if (is_category()) {
            $cat = $wp_query->get_queried_object();
            if ($default)
                $layout = esc_attr($fastor_options['layout-type-blog']);
            else
                $layout = get_metadata('category', $cat->term_id, 'layout', true);
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop())  {
                if ($default)
                    $layout = esc_attr($fastor_options['layout-type-woocategory']);
                else
                    $layout = get_post_meta(wc_get_page_id( 'shop' ), 'layout', true);
            } else {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                if ($term) {

                    if ($default) {
                        switch ($term->taxonomy) {
                            case 'product_cat':
                            case 'product_tag':
                                $layout = esc_attr($fastor_options['layout-type-woocategory']);
                                break;
                            case 'portfolio-category':
                                $layout = $fastor_options['layout-type-portfolio'];
                                break;
                            default:
                                $layout = esc_attr($fastor_options['layout-type-blog']);
                                break;
                        }
                    } else {
                        $layout = get_metadata($term->taxonomy, $term->term_id, 'layout', true);
                    }
                }
            }
        } else {
            if (is_singular()) {
                global $post;
                if ($default) {
                    switch ($post->post_type) {
                        case 'product':
                            $layout = esc_attr($fastor_options['layout-type-wooproduct']);
                            break;
                        case 'portfolio':
                            $layout = $fastor_options['layout-type-single-portfolio'];
                            break;
                        case 'post':
                            $layout = esc_attr($fastor_options['layout-type-single-post']);
                            break;
                    }
                } else {
                    $layout = get_post_meta(get_the_id(), 'layout', true);
                }
            } else {
                if (!is_home() && is_front_page()) {
                    $layout = esc_attr($fastor_options['layout-type-home']);
                } else if (is_home() && !is_front_page()) {
                    $layout = esc_attr($fastor_options['layout-type-blog']);
                    $layout = (isset($_GET['layout-type-blog'])) ? $_GET['layout-type-blog'] : $layout;
                } else if (is_home() || is_front_page()) {
                    $layout = esc_attr($fastor_options['layout-type-home']);
                }
            }
        }

        return esc_attr($layout);
    }


    function fastor_show_breadcrumbs() {
        global $wp_query, $fastor_options;

        $breadcrumbs = '';

        if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $breadcrumbs = get_metadata('category', $cat->term_id, 'breadcrumbs', true);
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop())  {
                $breadcrumbs = get_post_meta(wc_get_page_id( 'shop' ), 'breadcrumbs', true);
            } else {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                if ($term) {
                    $breadcrumbs = get_metadata($term->taxonomy, $term->term_id, 'breadcrumbs', true);
                }
            }
        } else {
            if (is_singular()) {
                $breadcrumbs = get_post_meta(get_the_id(), 'breadcrumbs', true);
            } else {
                if (!is_home() && is_front_page()) {
                    $breadcrumbs = 'breadcrumbs';
                } else if (is_home() && !is_front_page()) {
                    $breadcrumbs = 'breadcrumbs';
                } else if (is_home() || is_front_page()) {
                    $breadcrumbs = 'breadcrumbs';
                }
            }
        }

        $breadcrumbs = ($breadcrumbs != 'breadcrumbs')?true:false;

        if (is_search()) {
            if (function_exists('is_shop') && is_shop())
                $breadcrumbs = true;
            else
                $breadcrumbs = false;
        }

        if (is_404())
            $breadcrumbs = false;

        return $breadcrumbs;
    }

    function fastor_get_page_title(){
        if (is_home()) {
            if (get_option('page_for_posts', true)) {
                echo get_the_title(get_option('page_for_posts', true));
            } else {
                echo esc_html__('Latest Posts', 'fastor');
            }
        } elseif (is_archive()) {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            if ($term) {
                echo $term->name;
            } elseif (is_post_type_archive()) {
                echo get_queried_object()->labels->name;
            } elseif (is_day()) {
                printf(esc_html__('Daily Archives: %s', 'fastor'), get_the_date());
            } elseif (is_month()) {
                printf(esc_html__('Monthly Archives: %s', 'fastor'), get_the_date('F Y'));
            } elseif (is_year()) {
                printf(esc_html__('Yearly Archives: %s', 'fastor'), get_the_date('Y'));
            } elseif (is_author()) {
                $author = get_queried_object();
                printf(esc_html__('Author Archives: %s', 'fastor'), $author->display_name);
            } else {
                single_cat_title();
            }
        } elseif (is_search()) {
            printf(esc_html__('Search Results for %s', 'fastor'), get_search_query());
        } elseif (is_404()) {
            echo esc_html__('Not Found', 'fastor');
        } else {
            the_title();
        }
    }

    function fastor_get_breadcrumb_bg(){
        global $wp_query, $fastor_options;

        $breadcrumb_background = $fastor_options['layout-breadcrumb-background']['url'] != '' ? esc_url($fastor_options['layout-breadcrumb-background']['url']):'';

        if (is_404()) {
            // nothing
        } else if (is_category()) {
            $cat = $wp_query->get_queried_object();
            if(get_metadata('category', $cat->term_id, 'breadcrumb_background', true) != '') {
                $breadcrumb_background = get_metadata('category', $cat->term_id, 'breadcrumb_background', true);
            }elseif ($fastor_options['layout-breadcrumb-background-blog']['url'] != '') {
                $breadcrumb_background = esc_url($fastor_options['layout-breadcrumb-background-blog']['url']);
            }
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop())  {
                if(get_post_meta(wc_get_page_id('shop'), 'breadcrumb_background', true) != '') {
                    $breadcrumb_background = get_post_meta(wc_get_page_id('shop'), 'breadcrumb_background', true);
                }
                if ($fastor_options['layout-breadcrumb-background-woocategory']['url'] != '') {
                    $breadcrumb_background = esc_url($fastor_options['layout-breadcrumb-background-woocategory']['url']);
                }

            } else {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

                if ($term) {
                    if(get_metadata($term->taxonomy, $term->term_id, 'breadcrumb_background', true) != '') {
                        $breadcrumb_background = get_metadata($term->taxonomy, $term->term_id, 'breadcrumb_background', true);
                    }
                    else{

                        switch ($term->taxonomy) {
                            case 'product_cat':
                            case 'product_tag':
                                if($fastor_options['layout-breadcrumb-background-woocategory']['url'] != '') {
                                    $breadcrumb_background = esc_url($fastor_options['layout-breadcrumb-background-woocategory']['url']);
                                }
                                break;
                            case 'portfolio-category':
                                if($fastor_options['layout-breadcrumb-background-portfolio']['url'] != '') {
                                    $breadcrumb_background = esc_url($fastor_options['layout-breadcrumb-background-portfolio']['url']);
                                }
                                break;
                            default:
                                $breadcrumb_background = esc_url($fastor_options['layout-breadcrumb-background-blog']['url']);
                                break;
                        }
                    }
                }
            }
        } else {
            if (is_singular()) {

                global $post;
                if(get_post_meta(get_the_id(), 'breadcrumb_background', true) != '') {
                    $breadcrumb_background = get_post_meta(get_the_id(), 'breadcrumb_background', true);
                } else {

                    switch ($post->post_type) {
                        case 'product':
                            if($fastor_options['layout-breadcrumb-background-wooproduct']['url'] != '') {
                                $breadcrumb_background = esc_url($fastor_options['layout-breadcrumb-background-wooproduct']['url']);
                            }
                            break;
                        case 'post':
                            if($fastor_options['layout-breadcrumb-background-single-post']['url'] != '') {
                                $breadcrumb_background = esc_url($fastor_options['layout-breadcrumb-background-single-post']['url']);
                            }
                            break;
                        case 'portfolio':
                            if($fastor_options['layout-breadcrumb-background-single-portfolio']['url'] != '') {
                                $breadcrumb_background = esc_url($fastor_options['layout-breadcrumb-background-single-portfolio']['url']);
                            }
                            break;
                    }
                }
            }
        }


        return esc_url($breadcrumb_background);
    }


    function fastor_meta_use_default() {
        global $wp_query, $fastor_settings;

        $default = '';

        if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $default = get_metadata('category', $cat->term_id, 'default', true);
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop())  {
                $default = get_post_meta(wc_get_page_id( 'shop' ), 'default', true);
            } else {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                if ($term) {
                    $default = get_metadata($term->taxonomy, $term->term_id, 'default', true);
                }
            }
        } else {
            if (is_singular()) {
                global $post;
                if ($post->post_type == 'page') {
                    $default = 'default';
                } else {
                    $default = get_post_meta(get_the_id(), 'default', true);
                }
            }
        }

        $default = ($default != 'default')?true:false;

        return $default;
    }

    function fastor_slideshow_type() {
        global $wp_query, $fastor_options;

        $banner_type = '';

        if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $banner_type = get_metadata('category', $cat->term_id, 'slider_type', true);
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop())  {
                $banner_type = get_post_meta(wc_get_page_id( 'shop' ), 'slider_type', true);
            } else {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                if ($term) {
                    $banner_type = get_metadata($term->taxonomy, $term->term_id, 'slider_type', true);
                }
            }
        } else {
            if (is_singular()) {
                $banner_type = get_post_meta(get_the_id(), 'slider_type', true);
            } else {
                if (is_home() && !is_front_page()) {
                    $banner_type = isset($fastor_options['blog-slideshow-type']) ? $fastor_options['blog-slideshow-type'] : '';
                }
            }
        }

        if (is_search())
            $banner_type = '';

        return $banner_type;
    }


    function fastor_rev_slider() {
        global $wp_query, $fastor_options;

        $rev_slider = '';

        if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $rev_slider = get_metadata('category', $cat->term_id, 'revslider', true);
        } else if (is_archive()) {

            if (function_exists('is_shop') && is_shop())  {
                $rev_slider = get_post_meta(wc_get_page_id( 'shop' ), 'revslider', true);
            } else {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                if ($term) {
                    $rev_slider = get_metadata($term->taxonomy, $term->term_id, 'revslider', true);
                }
            }
        } else {
            if (is_singular()) {
                $rev_slider = get_post_meta(get_the_id(), 'revslider', true);
            } else {
                if (is_home() && !is_front_page()) {
                    $rev_slider = isset($fastor_options['blog-slideshow-revslider']) ? $fastor_options['blog-slideshow-revslider'] : '';
                }
            }
        }

        return $rev_slider;
    }

    function fastor_customblock_slider() {
        global $wp_query, $fastor_options;

        $customblock_slider = '';

        if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $customblock_slider = get_metadata('category', $cat->term_id, 'customblock_slider', true);
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop())  {
                $customblock_slider = get_post_meta(wc_get_page_id( 'shop' ), 'customblock_slider', true);
            } else {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                if ($term) {
                    $customblock_slider = get_metadata($term->taxonomy, $term->term_id, 'customblock_slider', true);
                }
            }
        } else {
            if (is_singular()) {
                $customblock_slider = get_post_meta(get_the_id(), 'customblock_slider', true);
            } else {
                if (is_home() && !is_front_page()) {
                    $customblock_slider = esc_attr($fastor_options['blog-slideshow-custom_block']);
                }
            }
        }

        return $customblock_slider;
    }

    function fastor_get_slider_align() {
        global $wp_query, $fastor_options;

        $slider_align = '';

        if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $slider_align = get_metadata('category', $cat->term_id, 'slideralign', true);
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop())  {
                $slider_align = get_post_meta(wc_get_page_id( 'shop' ), 'slideralign', true);
            } else {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                if ($term) {
                    $slider_align = get_metadata($term->taxonomy, $term->term_id, 'slideralign', true);
                }
            }
        } else {
            if (is_singular()) {
                $slider_align = get_post_meta(get_the_id(), 'slideralign', true);
            }
        }
        return $slider_align;
    }

    function fastor_get_body_class($classes) {
        $fastor_options = fastor_get_options();
        global $post;

        $classes[]= 'body-header-type-'.esc_attr($fastor_options['header-type']);
        $classes[]= 'header-margin-top-'.esc_attr($fastor_options['advanced-settings-header-margin-top']);

        if($fastor_options['layout-page-width'] == 3 && $fastor_options['layout-page-width-custom-value'] > 1400){
            $classes[] = 'body-full-width';
        }


        if(intval($fastor_options['advanced-settings-other-border-width']) == 1){
            $classes[] = 'border-width-1';
        }else{
            $classes[] = 'border-width-0';
        }

        if($fastor_options['advanced-settings-header-topbar-type'] > 0 ){
            $classes[]= 'top-bar-type-'.esc_attr($fastor_options['advanced-settings-header-topbar-type']);
        }
        if($fastor_options['advanced-settings-header-myaccount-type'] > 0 ){
            $classes[]= 'my-account-type-'.esc_attr($fastor_options['advanced-settings-header-myaccount-type']);
        }

        if($fastor_options['advanced-settings-header-cartblock-type'] > 0 ){
            $classes[]= 'cart-block-type-'.esc_attr($fastor_options['advanced-settings-header-cartblock-type']);
        }

        if($fastor_options['advanced-settings-header-megamenu-label-type'] > 0 ){
            $classes[]= 'megamenu-label-type-'.esc_attr($fastor_options['advanced-settings-header-megamenu-label-type']);
        }

        if($fastor_options['advanced-settings-header-search-type'] > 0 ){
            $classes[]= 'search-type-'.esc_attr($fastor_options['advanced-settings-header-search-type']);
        }

        if($fastor_options['advanced-settings-header-megamenu-type'] > 0 ){
            $classes[]= 'megamenu-type-'.esc_attr($fastor_options['advanced-settings-header-megamenu-type']);
        }

        if($fastor_options['advanced-settings-header-dropdown-type'] > 0 ){
            $classes[]= 'dropdown-menu-type-'.esc_attr($fastor_options['advanced-settings-header-dropdown-type']);
        }

        if($fastor_options['advanced-settings-header-buttons-prev-next-slider'] > 0 ){
            $classes[]= 'buttons-prev-next-type-'.esc_attr($fastor_options['advanced-settings-header-buttons-prev-next-slider']);
        }

        if($fastor_options['advanced-settings-category-breadcrumb-style'] > 0 ){
            $classes[]= 'breadcrumb-style-'.esc_attr($fastor_options['advanced-settings-category-breadcrumb-style']);
        }

        if($fastor_options['advanced-settings-category-productgrid-type'] > 0 ){
            $classes[]= 'product-grid-type-'.esc_attr($fastor_options['advanced-settings-category-productgrid-type']);
        }

        if($fastor_options['advanced-settings-category-productlist-type'] > 0 ){
            $classes[]= 'product-list-type-'.esc_attr($fastor_options['advanced-settings-category-productlist-type']);
        }

        if($fastor_options['advanced-settings-product-page-type'] > 0 ){
            $classes[]= 'product-page-type-'.esc_attr($fastor_options['advanced-settings-product-page-type']);
        }

        if($fastor_options['advanced-settings-product-buttons'] > 0 ){
            $classes[]= 'products-buttons-action-type-'.esc_attr($fastor_options['advanced-settings-product-buttons']);
        }

        if($fastor_options['advanced-settings-footer-type'] > 0 ){
            $classes[]= 'footer-type-'.esc_attr($fastor_options['advanced-settings-footer-type']);
        }

        if($fastor_options['advanced-settings-other-countdown'] > 0 ){
            $classes[]= 'countdown-special-type-'.esc_attr($fastor_options['advanced-settings-other-countdown']);
        }

        if($fastor_options['advanced-settings-other-button-type'] > 0 ){
            $classes[]= 'button-body-type-'.esc_attr($fastor_options['advanced-settings-other-button-type']);
        }

        if($fastor_options['advanced-settings-other-salenew-type'] > 0 ){
            $classes[]= 'sale-new-type-'.esc_attr($fastor_options['advanced-settings-other-salenew-type']);
        }

        if($fastor_options['advanced-settings-other-box-type'] == 7 ){
            $classes[]= 'box-type-4';
        }else{
            $classes[]= 'no-box-type-7';
        }
        if($fastor_options['advanced-settings-other-box-type'] > 0 ){
            $classes[]= 'box-type-'.esc_attr($fastor_options['advanced-settings-other-box-type']);
        }

        if($fastor_options['advanced-settings-other-inputs-type'] > 0 ){
            $classes[]= 'inputs-type-'.esc_attr($fastor_options['advanced-settings-other-inputs-type']);
        }



        if($fastor_options['banners-hover-status']){
            $classes[]= 'banners-effect-'.esc_attr($fastor_options['banners-hover-type']);
        }

        if($fastor_options['header-show_vertical_menu']){
            $classes[]= 'show-vertical-megamenu';
        }
        if($fastor_options['header-show_vertical_menu_category_page']){
            $classes[]= 'show-vertical-megamenu-category-page';
        }

        if(isset($fastor_options['menu-mobile-type'])){
            $classes[]= 'mobile-menu-'.esc_attr($fastor_options['menu-mobile-type']);
        }


        if(fastor_get_slider_align() == 'top'){
            $classes[] = 'slider-align-top';
        }

        if(
            (
                $fastor_options['color-body_background_color'] == '#ffffff'
                ||
                (
                    $fastor_options['color-body_background_color'] == $fastor_options['color-main_content_background_color']
                    && $fastor_options['color-body_background_color'] != ''
                )
                ||  $fastor_options['color-main_content_background_color'] == 'transparent'
            )
            && $fastor_options['color-status']
        ){
            $classes[] = 'body-white';
        }else{
            $classes[] = 'body-other';
        }

        if($fastor_options['color-main_content_background_color'] == 'transparent' && $fastor_options['color-status']){
            $classes[] = 'body-white-type-2';
        }
        if($fastor_options['color-main_content_background_color'] == 'transparent' && $fastor_options['color-box_with_products_background_color'] == '#ffffff' && $fastor_options['color-status']){
            $classes[] = 'body-white-type-3';
        }

        if(defined('WC_VERSION')){
            if(is_product_category() || is_shop()){
                $classes[] = 'body-product-category';
            }
            if(is_product()){
                $classes[] = 'body-product-detail';
            }
        }

        if($fastor_options['product-lazy-load-img'] != 0){
            $classes[] = 'lazy-images';
        }

        if ( isset( $post ) ) {
            $classes[] = esc_attr( $post->post_type . '_' . $post->post_name );
        }
        if (is_single() ) {
            foreach((wp_get_post_terms( $post->ID)) as $term) {
                // add category slug to the $classes array
                $classes[] = esc_attr( $term->slug );
            }
            foreach((wp_get_post_categories( $post->ID, array('fields' => 'slugs'))) as $category) {
                // add category slug to the $classes array
                $classes[] = esc_attr( $category );
            }
        }

        return $classes;
    }

    add_filter( 'body_class','fastor_get_body_class' );


    function fastor_slideshow() {
        $slider_type = fastor_slideshow_type();
        $rev_slider = fastor_rev_slider();
        $custom_block_slider = fastor_customblock_slider();

        if ($slider_type === 'revslider' && isset($rev_slider)) { ?>
            <?php echo do_shortcode('[rev_slider '.$rev_slider.']'); ?>
            <?php
        }
        if ($slider_type === 'custom_block') { ?>
            <?php echo do_shortcode('[custom_block name="'.$custom_block_slider.'"]') ?>
            <?php
        }
    }

    function is_fastor_slideshow() {
        $slider_type = fastor_slideshow_type();
        $rev_slider = fastor_rev_slider();
        $custom_block_slider = fastor_customblock_slider();

        if ($slider_type === 'revslider' && isset($rev_slider)) {
            return true;
        }
        if ($slider_type === 'custom_block') {
            return true;
        }
        return false;
    }

    function fastor_sidebar() {
        global $wp_query;

        $sidebar = 'blog-sidebar';
        $default = fastor_meta_use_default();


        if (is_404()) {
            $sidebar = '';
        } else if (is_category()) {
            $cat = $wp_query->get_queried_object();

            if ($default)
                $sidebar = 'blog-sidebar';
            else
                $sidebar = get_metadata('category', $cat->term_id, 'sidebar', true);
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop())  {
                if ($default)
                    $sidebar = 'woocommerce-sidebar';
                else
                    $sidebar = get_post_meta(wc_get_page_id( 'shop' ), 'sidebar', true);
            } else {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                if ($term) {
                    if ($default) {
                        switch ($term->taxonomy) {
                            case 'product_cat':
                            case 'product_tag':
                                $sidebar = 'woocommerce-sidebar';
                                break;
                            case 'portfolio-category':
                                $sidebar = 'portfolio-sidebar';
                                break;
                            default:
                                $sidebar = 'blog-sidebar';
                                break;
                        }
                    } else {
                        $sidebar = get_metadata($term->taxonomy, $term->term_id, 'sidebar', true);
                    }
                }
            }
        } else {
            if (is_singular()) {
                global $post;

                if ($default) {
                    switch ($post->post_type) {
                        case 'product':
                            $sidebar = 'woocommerce-product-sidebar';
                            break;
                        case 'portfolio':
                            $sidebar = 'portfolio-sidebar';
                            break;
                        case 'post':
                        default:
                            $sidebar = 'blog-sidebar';
                            break;
                    }
                } else {
                    $sidebar = get_post_meta(get_the_id(), 'sidebar', true);
                }
            } else {

                if (!is_home() && is_front_page()) {
                    $sidebar = 'home-sidebar';
                } else if (is_home() && !is_front_page()) {
                    $sidebar = 'blog-sidebar';
                } else if (is_home() || is_front_page()) {
                    $sidebar = 'home-sidebar';
                }
            }
        }
        return $sidebar;
    }

    add_filter('woocommerce_product_categories_widget_args', 'fastor_product_categories_widget_args', 10, 1);

    function fastor_product_categories_widget_args($args) {
        $args['walker'] = new Fastor_WC_Product_Cat_List_Walker;
        return $args;
    }


    add_filter('widget_categories_args', 'fastor_blog_categories_widget_args', 10, 1);

    function fastor_blog_categories_widget_args($args) {

        $args['walker'] = new Fastor_WC_Blog_Cat_List_Walker;
        return $args;
    }


    //custom get price html
    add_filter( 'woocommerce_get_price_html', 'fastor_custom_price_html', 100, 2 );
    function fastor_custom_price_html( $price, $product ){
        global $post, $fastor_quickview, $fastor_options;



        if((is_product() || $fastor_quickview) && $post->ID == $product->get_id()){
            $price_part = explode('</del>', $price);
            if(isset($price_part[1])){
                $price = $price_part[1]. '&nbsp;'.$price_part[0].'</del>';
            }
        }

        if(strpos($price, '<ins>') === false){

            if(strpos($price, 'woocommerce-Price-amount')){
                $price = str_replace( '<span class="woocommerce-Price-amount amount">', '<span class="woocommerce-Price-amount price-new">', $price );
            }else{
                $price = str_replace( '<span class="amount">', '<span class="price-new" price>', $price );
            }
        }


        $price = str_replace( '<del>', '<span class="old-price price-old">', $price );
        $price = str_replace( '</del>', '</span>', $price );
        $price = str_replace( '<ins>', '<span class="special-price price-new">', $price );
        $price = str_replace( '</ins>', '</span>', $price );


        return $price;
    }



    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    remove_action('woocommerce_single_product_summary', 'toastie_wc_smsb_form_code', 31);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
    add_action('woocommerce_template_single_sharing', 'toastie_wc_smsb_form_code', 10);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 15);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5);

    // Add woocommerce actions
    add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 5 );

    add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 5 );

    // Remove woocommerce actions
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
    remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
    // add the filter
    add_action('woocommerce_after_shop_list_loop_item_title', 'woocommerce_template_loop_rating', 5);
    add_action('woocommerce_after_shop_list_loop_item_title', 'woocommerce_template_loop_price', 10);
    add_action('woocommerce_after_shop_list_loop_item_title', 'woocommerce_template_single_excerpt', 10);



    // Remove compare action
    if ( get_option('yith_woocompare_compare_button_in_products_list') == 'yes' ) {
        global $yith_woocompare;
        if ($yith_woocompare)
            remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
    }

    if ( get_option('yith_woocompare_compare_button_in_product_page') == 'yes' ) {
        global $yith_woocompare;
        if ($yith_woocompare)
            remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
    }

    // Remove display yith whislist link
    $whislist_link_position = get_option('yith_wcwl_button_position');
    if(isset($whislist_link_position) && $whislist_link_position != 'shortcode'){
        update_option('yith_wcwl_button_position', 'shortcode');
    }


    // Ajax filter product container
    if (fastor_is_plugin_active( 'yith-woocommerce-ajax-search/init.php' )) {
        add_filter( 'yith_wcan_ajax_frontend_classes', 'fastor_yith_wcan_ajax_frontend_classes', 10, 1);
        function fastor_yith_wcan_ajax_frontend_classes($arg) {
            $arg['container'] = '#content #mfilter-content-container .products';
            return $arg;
        }

    }


    // Today deals template
    add_action('fastor_today_deals_woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 5);
    add_action('fastor_today_deals_woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 5);
    add_action('fastor_today_deals_woocommerce_after_shop_loop_item', 'fastor_woocommerce_template_loop_add_to_cart_simple', 5);


    // Custom woocommerce actions

    function fastor_woocommerce_template_loop_add_to_cart_simple() {
        wc_get_template( 'loop/add-to-cart-simple.php' );
    }



    function fastor_is_plugin_active($plugin_path) {
        $active_plugins = get_option( 'active_plugins' );
        if(!$active_plugins) return false;
        $return_var = in_array( $plugin_path, apply_filters( 'active_plugins', $active_plugins ) );
        return $return_var;
    }

    add_filter( 'woocommerce_before_widget_product_list', 'fastor_before_widget_product_list', 10, 1);
    function fastor_before_widget_product_list($arg) {
        return '<div class="product_list_widget products"><div class="box-product"><div class="product-grid">';
    }
    add_filter( 'woocommerce_after_widget_product_list', 'fastor_after_widget_product_list', 10, 1);
    function fastor_after_widget_product_list($arg) {
        return '</div></div></div>';
    }

    // get ajax cart fragment
    //add_filter('add_to_cart_fragments', 'fastor_woocommerce_header_add_to_cart_fragment');
    add_filter('woocommerce_add_to_cart_fragments', 'fastor_woocommerce_header_add_to_cart_fragment');
    function fastor_woocommerce_header_add_to_cart_fragment( $fragments ) {
        global $woocommerce;

        $_cartQty = WC()->cart->cart_contents_count;
        $fragments['header .cart-head .cart-count .total_count_ajax'] = '<span class="total_count_ajax">'. ($_cartQty > 0 ? $_cartQty : '0') .'</span>';
        $fragments['header .total_price_ajax .total_price, .sticky-header  .total_price_ajax .total_price'] = '<span class="total_price">'. WC()->cart->get_cart_total() . '</span>';

        ob_start();
        ?>
        <div class="block-content cart-content">

            <?php if ($_cartQty == 0) :?>
                <div class="empty"><?php echo esc_html__('No products in the cart.','fastor'); ?> </div>
            <?php else : ?>

                <?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
                    <div class="mini-cart-info ">
                    <table>
                    <?php
                    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                        $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                        $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

                            $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
                            $thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                            $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                            ?>
                            <tr>
                                <td class="image">
                                    <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
                                        <?php if ( ! $_product->is_visible() ) { ?>
                                            <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
                                        <?php } else { ?>
                                            <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) ?>
                                        <?php } ?>
                                    </a>
                                </td>
                                <td class="name">
                                    <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
                                        <?php if ( ! $_product->is_visible() ) : ?>
                                            <?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?>
                                        <?php else : ?>
                                            <?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?>
                                        <?php endif; ?>
                                    </a>
                                </td>
                                <td class="quantity">x <?php echo $cart_item['quantity']; ?></td>
                                <td class="total"><?php echo strip_tags($product_price); ?></td>
                                <td class="remove">
                                    <?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="javascript:;" class="remove-icon" title="%s" onclick="cart.remove(%s);" >&times;</a>', esc_html__('Remove this item', 'fastor'), "'".$cart_item_key."'"  ), $cart_item_key ); ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                <?php endif; ?>
                </table>
                </div>

                <div class="mini-cart-total">
                    <table>
                        <tr>
                            <td class="right"><b><?php echo esc_html__('Subtotal', 'fastor') ?>:</b></td>
                            <td class="right"><?php echo WC()->cart->get_cart_total(); ?></td>
                        </tr>
                    </table>
                </div>

                <div class="checkout">
                    <a class="button btn-default" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php esc_html_e('Cart', 'fastor'); ?></a>
                    &nbsp;
                    <a class="button" href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php esc_html_e('Checkout', 'fastor'); ?></a>
                </div>
            <?php endif; ?>
        </div>

        <?php
        $fragments['header .cart-content, .sticky-header .cart-content'] = ob_get_clean();

        return $fragments;
    }



    function fastor_html_topnav() {

        ob_start(); ?>
        <!-- top navigation -->
        <?php
        if ( has_nav_menu( 'top_nav' ) ) : ?>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'top_nav',
                'menu_class' => 'topnav bt-links',
                'before' => '',
                'after' => '',
                'link_before' => '',
                'link_after' => '',
                'depth' => 2,
                'fallback_cb' => false,
                'walker' => new wp_bootstrap_navwalker
            ));
            ?>
        <?php else: ?>
            <?php echo wp_kses( 'Define your top navigation in <b>Apperance > Menus</b>', 'fastor', array( 'b' ) ) ?>
        <?php endif; ?>
        <!-- end top navigation -->
        <?php
        return ob_get_clean();
    }

    function fastor_html_menu() {
        $fastor_options = fastor_get_options();

        $menu_align = esc_attr($fastor_options['menu-align']);

        ob_start(); ?>
        <!-- main menu -->
        <div id="main-menu" class="mega-menu<?php if ($menu_align == 'right') echo ' menu-right' ?>">
            <?php
            if ( has_nav_menu( 'main_menu' ) ) :
                wp_nav_menu(array(
                    'theme_location' => 'main_menu',
                    'container' => '',
                    'menu_class' => '',
                    'before' => '',
                    'after' => '',
                    'link_before' => '',
                    'link_after' => '',
                    'fallback_cb' => false,
                    'walker' => new fastor_top_navwalker
                ));
            else: ?>
                <?php echo wp_kses( 'Define your main menu in <b>Apperance > Menus</b>', 'fastor', array( 'b' ) ) ?>
            <?php endif; ?>
        </div><!-- end main menu -->
        <?php
        return ob_get_clean();
    }


    function fastor_lang_switcher() {
        $fastor_options = fastor_get_options();
        ob_start();
        ?>
        <?php  if ( has_nav_menu( 'lang_switcher' ) || fastor_is_plugin_active('woocommerce-multilingual/wpml-woocommerce.php')): ?>
            <div id="language_form">
                <?php  if ( has_nav_menu( 'lang_switcher' )): ?>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'lang_switcher',
                        'container' => '',
                        'menu_class' => 'lang-custom-menu clearfix',
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'depth' => 2,
                        'fallback_cb' => false,
                        'walker' => new wp_bootstrap_navwalker
                    ));
                    ?>
                <?php elseif ( fastor_is_plugin_active('woocommerce-multilingual/wpml-woocommerce.php') ): ?>
                    <?php
                    $languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0' );
                    ?>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"><?php echo ICL_LANGUAGE_NAME ?></a>

                        <ul class="dropdown-menu">
                            <?php
                            if(1 < count($languages)){
                                foreach($languages as $l){
                                    if(!$l['active']){
                                        echo '<li><a href="'.$l['url'].'">'.$l['translated_name'].'</a></li>';
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div><!-- end lang switcher -->
        <?php endif; ?>
        <?php

        return str_replace('&nbsp;', '', ob_get_clean());
    }

    function fastor_currency_switcher() {

        if (fastor_is_plugin_active('woocommerce-multilingual/wpml-woocommerce.php')):
            ob_start();
                            do_action('wcml_currency_switcher', array(
                                'format' => '%name%',
                                'currency_switcher' => 'fastor-dropdown'
                            ));
            $currencies_list = trim(ob_get_clean());
            ob_start();
            ?>
            <div id="currency_form">
                <!-- Currency -->
                <div class="dropdown<?php echo $currencies_list ? '' : ' none' ?>">

                    <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                        <?php echo get_woocommerce_currency_symbol(); ?>
                    </a>
                    <?php if($currencies_list): ?>
                        <div class="dropdown-menu">
                            <?php echo $currencies_list; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div><!-- end lang switcher -->
            <?php return str_replace('&nbsp;', '', ob_get_clean()); ?>
        <?php endif;
    }


    function fastor_parse_shortcode($tpl){
        $pattern = '/\[.*\]/';
        $new_tpl = preg_replace_callback(
            $pattern,
            function ($matches) {
                return do_shortcode($matches[0]);
            },
            $tpl
        );

        return $new_tpl;

    }



    function fastor_get_product_categories() {
        $taxonomy     = 'product_cat';
        $orderby      = 'name';
        $show_count   = 0;      // 1 for yes, 0 for no
        $pad_counts   = 0;      // 1 for yes, 0 for no
        $hierarchical = 1;      // 1 for yes, 0 for no
        $title        = '';
        $empty        = 0;

        $args = array(
            'taxonomy'     => $taxonomy,
            'orderby'      => $orderby,
            'show_count'   => $show_count,
            'pad_counts'   => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li'     => $title,
            'hide_empty'   => $empty
        );
        return  get_categories( $args );
    }

    add_action("wp_ajax_fastor_ajax_search", "fastor_ajax_search");
    add_action("wp_ajax_nopriv_fastor_ajax_search", "fastor_ajax_search");

    function fastor_ajax_search() {

        $term = strtolower( $_GET['term'] );
        $product_category =  isset($_GET['product_category']) ?strtolower( $_GET['product_category'] ) : '';


        $suggestions = array();
        if(!$product_category){
            $loop = new WP_Query( 's=' . $term  . '&post_type=product');
        }else{
            $loop = new WP_Query( 's=' . $term  . '&post_type=product&product_category' . $product_category);
        }

        while( $loop->have_posts() ) {
            $loop->the_post();
            $suggestion = array();
            $suggestion['label'] = get_the_title();
            $suggestion['href'] = get_permalink();

            $suggestions[] = $suggestion;
        }

        wp_reset_postdata();

        $response = json_encode( $suggestions );
        echo $response;
        exit();


    }


    // Quick View Html
    add_action('wp_ajax_fastor_product_quickview', 'fastor_product_quickview');
    add_action('wp_ajax_nopriv_fastor_product_quickview', 'fastor_product_quickview');

    function fastor_array2json($arr) {
        if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
        $parts = array();
        $is_list = false;

        //Find out if the given array is a numerical array
        $keys = array_keys($arr);
        $max_length = count($arr)-1;
        if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
            $is_list = true;
            for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
                if($i != $keys[$i]) { //A key fails at position check.
                    $is_list = false; //It is an associative array.
                    break;
                }
            }
        }

        foreach($arr as $key=>$value) {
            if(is_array($value)) { //Custom handling for arrays
                if($is_list) $parts[] = fastor_array2json($value); /* :RECURSION: */
                else $parts[] = '"' . $key . '":' . fastor_array2json($value); /* :RECURSION: */
            } else {
                $str = '';
                if(!$is_list) $str = '"' . $key . '":';

                //Custom handling for multiple data types
                if(is_numeric($value)) $str .= $value; //Numbers
                elseif($value === false) $str .= 'false'; //The booleans
                elseif($value === true) $str .= 'true';
                else $str .= '"' . addslashes($value) . '"'; //All other things
                // :TODO: Is there any more datatype we should be in the lookout for? (Object?)

                $parts[] = $str;
            }
        }
        $json = implode(',',$parts);

        if($is_list) return '[' . $json . ']';//Return numerical JSON
        return '{' . $json . '}';//Return associative JSON
    }

    function fastor_product_quickview() {

        global $post, $product,  $fastor_options, $fastor_quickview;
        $post = get_post($_GET['pid']);
        $product = wc_get_product( $post->ID );

        if ( post_password_required() ) {
            echo get_the_password_form();
            die();
            return;
        }

        $fastor_quickview = true;


        $displaytypenumber = 0;
        if (is_plugin_active( 'woocommerce-colororimage-variation-select/woocommerce-colororimage-variation-select.php' ) )
            require_once wcva_plugin_path() . '/includes/wcva_common_functions.php';

        if (function_exists('wcva_return_displaytype_number'))
            $displaytypenumber = wcva_return_displaytype_number($product,$post);

        $goahead = 1;


        ?>

        <div  <?php post_class('quickview-wrap single-product product'); ?>>

            <div class="product-info <?php echo isset($fastor_options['productpage-layout']) ? 'product-layout-'.esc_attr($fastor_options['productpage-layout']) : '' ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <h2 class="product-name"><a href="<?php echo $product->get_permalink(); ?>"><?php echo $product->get_title(); ?></a></h2>
                        <div class="row" id="quickview_product">
                            <?php
                            /**
                             * woocommerce_before_single_product_summary hook
                             *
                             * @hooked woocommerce_show_product_sale_flash - 10
                             * @hooked woocommerce_show_product_images - 20
                             */
                            do_action( 'woocommerce_before_single_product_summary' );
                            ?>
                            <?php $product_center_grid = 6;

                            if ($fastor_options['productpage-image-size'] == 1) {
                                $product_center_grid = 8;
                            }

                            if ($fastor_options['productpage-image-size'] == 3) {
                                $product_center_grid = 4;
                            }
                            ?>

                            <div class="col-sm-<?php echo $product_center_grid; ?> product-center clearfix">
                                <?php
                                /**
                                 * woocommerce_single_product_summary hook
                                 *
                                 * @hooked woocommerce_template_single_title - 5
                                 * @hooked woocommerce_template_single_price - 10
                                 * @hooked woocommerce_template_single_excerpt - 20
                                 * @hooked woocommerce_template_single_add_to_cart - 30
                                 * @hooked woocommerce_template_single_meta - 40
                                 * @hooked woocommerce_template_single_rating - 45
                                 * @hooked woocommerce_template_single_sharing - 50
                                 */
                                do_action( 'woocommerce_single_product_summary' );

                                ?>
                            </div>

                        </div>
                    </div><!-- .summary -->
                </div>
            </div>


            <script>
                /* <![CDATA[ */
                <?php
                $suffix               = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
                $assets_path          = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
                $frontend_script_path = $assets_path . 'js/frontend/';
                ?>
                var wc_add_to_cart_params = <?php echo fastor_array2json(apply_filters( 'wc_add_to_cart_params', array(
                    'ajax_url'                => WC()->ajax_url(),
                    'ajax_loader_url'         => apply_filters( 'woocommerce_ajax_loader_url', $assets_path . 'images/ajax-loader@2x.gif' ),
                    'i18n_view_cart'          => esc_attr__( 'View Cart', 'fastor' ),
                    'cart_url'                => get_permalink( wc_get_page_id( 'cart' ) ),
                    'is_cart'                 => is_cart(),
                    'cart_redirect_after_add' => get_option( 'woocommerce_cart_redirect_after_add' )
                ) )) ?>;
                var wc_single_product_params = <?php echo fastor_array2json(apply_filters( 'wc_single_product_params', array(
                    'i18n_required_rating_text' => esc_attr__( 'Please select a rating', 'fastor' ),
                    'review_rating_required'    => get_option( 'woocommerce_review_rating_required' ),
                ) )) ?>;
                var woocommerce_params = <?php echo fastor_array2json(apply_filters( 'woocommerce_params', array(
                    'ajax_url'        => WC()->ajax_url(),
                    'ajax_loader_url' => apply_filters( 'woocommerce_ajax_loader_url', $assets_path . 'images/ajax-loader@2x.gif' ),
                ) )) ?>;
                var wc_cart_fragments_params = <?php echo fastor_array2json(apply_filters( 'wc_cart_fragments_params', array(
                    'ajax_url'      => WC()->ajax_url(),
                    'fragment_name' => apply_filters( 'woocommerce_cart_fragment_name', 'wc_fragments' )
                ) )) ?>;

                jQuery(document).ready(function($) {
                    $( document ).off( 'click', '.plus, .minus');
                    $( document ).off( 'click', '.add_to_cart_button');
                    $.getScript('<?php echo $frontend_script_path . 'add-to-cart' . $suffix . '.js' ?>');
                    $.getScript('<?php echo $frontend_script_path . 'single-product' . $suffix . '.js' ?>');
                    $.getScript('<?php echo $frontend_script_path . 'woocommerce' . $suffix . '.js' ?>');
                    <?php if (($goahead == 1) && ($displaytypenumber > 0)) : ?>
                    $.getScript('<?php echo wcva_PLUGIN_URL . 'js/manage-variation-selection.js' ?>');
                    <?php else : ?>
                    $.getScript('<?php echo $frontend_script_path . 'add-to-cart-variation' . $suffix . '.js' ?>');
                    <?php endif; ?>

                    $('.quickview-wrap.single-product .product-price-countdown').each(function(){
                        var date = $(this).data('date-end');
                        var austDay = new Date(date*1000);
                        $(this).countdown({until: austDay});
                    })
                    if($('.quickview-wrap.single-product #product-enquiry-button').length > 0) {
                        $('.quickview-wrap.single-product #product-enquiry-button').hide();
                    }

                    $(".quickview-wrap .images figure.woocommerce-product-gallery__wrapper ").owlCarousel({
                        autoPlay: 6000, //Set AutoPlay to 3 seconds
                        navigation: true,
                        slideSpeed : 300,
                        lazyLoad : true,
                        singleItem: true,
                        stopOnHover: true,
                        navigationText: ['<i class="icon-arrow-left"></i>', '<i class="icon-arrow-right"></i>'],

                        <?php if(is_rtl()): ?>
                        direction: 'rtl'
                        <?php endif; ?>
                    });

                });
                /* ]]> */
            </script>
        </div>

        <?php

        die();
    }


    // ajax remove item
    add_action( 'wp_ajax_fastor_product_remove', 'fastor_ajax_product_remove' );
    add_action( 'wp_ajax_nopriv_fastor_product_remove', 'fastor_ajax_product_remove' );
    function fastor_ajax_product_remove() {

        $cart = WC()->instance()->cart;
        $cart_id = $_POST['cart_id'];
        $cart_item_id = $cart->find_product_in_cart($cart_id);

        if ($cart_item_id) {
            $cart->set_quantity($cart_item_id, 0);
        }

        $cart_ajax = new WC_AJAX();
        $cart_ajax->get_refreshed_fragments();

        exit();
    }

    // Notifications
    add_filter( 'wc_add_to_cart_message_html', 'fastor_custom_add_to_cart_message' );

    function fastor_custom_add_to_cart_message() {

        global $woocommerce;

        // Output success messages
        if (get_option('woocommerce_cart_redirect_after_add') == 'yes') :

            $return_to = get_permalink(wc_get_page_id('shop')); // Give the url, you want to redirect
            $message = sprintf('%s', $return_to, esc_html__('Continue Shopping &rarr;', 'fastor'), esc_html__('Product successfully added to your cart.', 'fastor'));

        else :
            $message = sprintf('%s', esc_html__('Product successfully added to your cart.', 'fastor'));
        endif;

        return $message;

    }


    function my_password_form() {
        global $post;
        $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
        $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    ' . esc_html__( "To view this protected post, enter the password below:", 'fastor' ) . '
    <label for="' . $label . '">' . esc_html__( "Password:", 'fastor' ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" style="margin: 0 10px;" />&nbsp;<input type="submit" class="btn" name="Submit" value="' . esc_attr__( "Submit", 'fastor' ) . '" />
    </form>
    ';
        return $o;
    }
    add_filter( 'the_password_form', 'my_password_form' );


    // advanced search functionality
    function fastor_advanced_search_query($query) {

        if($query->is_search()) {
            // category terms search.
            if (isset($_GET['product_category']) && !empty($_GET['product_category'])) {
                $query->set('tax_query', array(array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => array($_GET['product_category']) )
                ));
            }
        }

        return $query;
    }
    add_action('pre_get_posts', 'fastor_advanced_search_query', 1000);


    // Defer Javascripts EXPERMINETNAL
    // Defer jQuery Parsing uWordpsing the HTML5 defer property
    if (!(is_admin() )) {
        function fastor_defer_parsing_of_js ( $url ) {
            if ( FALSE === strpos( $url, '.js' ) ) return $url;
            if ( strpos( $url, 'jquery.js' ) ) return $url;
            if ( strpos( $url, 'pagseguro.lightbox.js' ) ) return $url;
            // return "$url' defer ";
            return "$url' defer onload='";
        }
        add_filter( 'clean_url', 'fastor_defer_parsing_of_js', 11, 1 );
    }



    function fastor_filter_dynamic_sidebar_params( $sidebar_params ) {

        if ( is_admin() ) {
            return $sidebar_params;
        }

        global $wp_registered_widgets;
        $widget_id = $sidebar_params[0]['widget_id'];

        $wp_registered_widgets[ $widget_id ]['original_callback'] = $wp_registered_widgets[ $widget_id ]['callback'];
        $wp_registered_widgets[ $widget_id ]['callback'] = esc_html('fastor_custom_widget_callback_function');
        return $sidebar_params;

    }
    add_filter( 'dynamic_sidebar_params', 'fastor_filter_dynamic_sidebar_params' );


    function fastor_custom_widget_callback_function() {

        global $wp_registered_widgets;
        $original_callback_params = func_get_args();
        $widget_id = $original_callback_params[0]['widget_id'];

        $original_callback = $wp_registered_widgets[ $widget_id ]['original_callback'];
        $wp_registered_widgets[ $widget_id ]['callback'] = $original_callback;

        $widget_id_base = $wp_registered_widgets[ $widget_id ]['callback'][0]->id_base;

    if ( is_callable( $original_callback ) ) {

        ob_start();
        call_user_func_array( $original_callback, $original_callback_params );
        $widget_output = ob_get_clean();

        echo apply_filters( 'widget_output', $widget_output, $widget_id_base, $widget_id );

    }

}

    function fastor_widget_output_filter( $widget_output, $widget_id_base, $widget_id ) {


        if ( strpos($widget_output, 'widget_categories') !== false ) {
            $widget_output = str_replace('widget_categories', 'box-with-categories category-box-type-2', $widget_output);

            // pmet
            $widget_output_arr = explode('box-with-categories category-box-type-2', $widget_output);

            $res = preg_replace('/box-content/', esc_html('box-content box-category'), $widget_output_arr[1], 1);
            if($res){
                $widget_output_arr[1] = $res;
            }
            // pmet

            $widget_output = implode('box-with-categories category-box-type-2', $widget_output_arr);
        }


        return $widget_output;

    }
    add_filter( 'widget_output', 'fastor_widget_output_filter', 10, 3 );

    ?>
