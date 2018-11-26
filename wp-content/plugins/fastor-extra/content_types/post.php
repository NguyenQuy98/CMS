<?php

// Insert Post Meta Boxes
function fastor_post_meta_boxes() {

    global $post_meta_boxes;

    fastor_show_meta_boxes($post_meta_boxes);
}

function fastor_add_post_meta_box() {
    if ( function_exists('add_meta_box') ) {
        add_meta_box( 'new-meta-boxes', 'Post Options', 'fastor_post_meta_boxes', 'post', 'normal', 'high' );
    }
}

// Save Past Metas        
function fastor_post_save_postdata( $post_id ) {
    global $post_meta_boxes;

    return fastor_save_postdata( $post_id, $post_meta_boxes );
}

// Get Past Metas        
function fastor_post_get_postdata() {
    global $post_meta_boxes, $category_meta_boxes;

    // Post Meta Options
    $theme_layouts = fastor_layouts();
    $sidebar_options = fastor_ct_sidebars();
    $slider_type = fastor_slider_type();
    $slider_align = fastor_slider_align();
    $rev_sliders = fastor_revslider_list();



    // Post Meta Boxes
    $post_meta_boxes = array(
        // Breadcrumbs
        "breadcrumbs"=> fastor_labels_meta(
            "breadcrumbs",
            "Breadcrumbs",
            "Disable breadcrumbs",
            "checkbox"
        ),
        "breadcrumb_background"=> fastor_labels_meta(
            "breadcrumb_background",
            "Breadcrumb background url",
            "Set breadcrumb background url",
            "text"
        ),
        // Layout, Sidebar
        "default"=> fastor_labels_meta(
            "default",
            "Layout & Sidebar",
            "Use selected layout and sidebar",
            "checkbox"
        ),
        // Layout
        "layout" => fastor_labels_meta(
            "layout",
            "Layout",
            "Select the layout.",
            "radio",
            "right-sidebar",
            "radio",
            $theme_layouts
        ),
        // Sidebar
        "sidebar"=> fastor_labels_meta(
            "sidebar",
            "Sidebar",
            "Select the sidebar you would like to display. <strong>Note</strong>: You must first create the sidebar under <strong>Appearance > Sidebars</strong>.",
            "customselect",
            "blog-sidebar",
            "",
            $sidebar_options
        ),

        // Banner Type
        "slider_type"=> fastor_labels_meta(
            "slider_type",
            "Slider Type",
            "Select the slider type which display above the page content.",
            "customselect",
            "",
            "",
            $slider_type
        ),

        // Custom block Type
        "customblock_slider"=> fastor_labels_meta(
            "customblock_slider",
            "Custom Block Slider Type",
            "Type custom block name.",
            "text",
            "",
            "",
            $slider_type
        ),

        // Revolution Slider
        "revslider"=> fastor_labels_meta(
            "revslider",
            "Revolution Slider",
            "Select the Revolution Slider.",
            "customselect",
            "",
            "",
            $rev_sliders
        ),
        //Slider alignment
        "slider_align"=> fastor_labels_meta(
            "slideralign",
            "Slider Alignment",
            "Select Slider Alignment.",
            "customselect",
            "",
            "",
            $slider_align
        ),



        // Video & Audio Embed Code
        "video_code"=> fastor_labels_meta(
            "video_code",
            "Video & Audio Embed Code",
            "Paste the iframe code of the Flash (YouTube or Vimeo etc). Only necessary when the portfolio type is video.",
            "textarea"
        ),
        // Website Link
        "external_url"=> fastor_labels_meta(
            "external_url",
            "External URL",
            "Input website url if post format is link.",
            "text"
        ),

    );

    // Category Meta Boxes
    $category_meta_boxes = array(
        // Breadcrumbs
        "breadcrumbs"=> fastor_labels_meta(
            "breadcrumbs",
            "Breadcrumbs",
            "Disable breadcrumbs",
            "checkbox"
        ),
        "breadcrumb_background"=> fastor_labels_meta(
            "breadcrumb_background",
            "Breadcrumb background url",
            "Set breadcrumb background url",
            "text"
        ),
        // Layout, Sidebar
        "default"=> fastor_labels_meta(
            "default",
            "Layout & Sidebar",
            "Use selected layout and sidebar",
            "checkbox"
        ),
        // Layout
        "layout" => fastor_labels_meta(
            "layout",
            "Layout",
            "Select layout.",
            "radio",
            "right-sidebar",
            "radio",
            $theme_layouts
        ),
        // Sidebar
        "sidebar"=> fastor_labels_meta(
            "sidebar",
            "Sidebar",
            "Select the sidebar you would like to display. <strong>Note</strong>: You must first create the sidebar under <strong>Appearance > Sidebars</strong>.",
            "customselect",
            "blog-sidebar",
            "",
            $sidebar_options
        ),

        // Banner Type
        "slider_type"=> fastor_labels_meta(
            "slider_type",
            "Slider Type",
            "Select the banner type which display above the page content.",
            "customselect",
            "",
            "",
            $slider_type
        ),


        // Custom block Type
        "customblock_slider"=> fastor_labels_meta(
            "customblock_slider",
            "Custom Block Slider Type",
            "Type custom block name.",
            "text",
            "",
            "",
            $slider_type
        ),


        // Revolution Slider
        "revslider"=> fastor_labels_meta(
            "revslider",
            "Revolution Slider",
            "Select the Revolution Slider.",
            "customselect",
            "",
            "",
            $rev_sliders
        ),


    );
}

add_action('add_meta_boxes', 'fastor_add_post_meta_box');
add_action('admin_menu', 'fastor_post_get_postdata');
add_action('save_post', 'fastor_post_save_postdata');

// Create Category Meta
global $wpdb;
$type = 'category';
$table_name = $wpdb->prefix . $type . 'meta';
$variable_name = $type . 'meta';
$wpdb->$variable_name = $table_name;

// Create Category Meta Table
create_metadata_table($table_name, $type);

// category meta
add_action( 'category_add_form_fields', 'fastor_add_category', 10, 2);
function fastor_add_category() {
    global $category_meta_boxes;

    fastor_show_tax_add_meta_boxes($category_meta_boxes);
}

add_action( 'category_edit_form_fields', 'fastor_edit_category', 10, 2);
function fastor_edit_category($tag, $taxonomy) {
    global $category_meta_boxes;

    fastor_show_tax_edit_meta_boxes($tag, $taxonomy, $category_meta_boxes);
}

add_action( 'created_term', 'fastor_save_category', 10,3 );
add_action( 'edit_term', 'fastor_save_category', 10,3 );

function fastor_save_category($term_id, $tt_id, $taxonomy) {
    if (!$term_id) return;

    global $category_meta_boxes;

    fastor_post_get_postdata();
    return fastor_save_taxdata( $term_id, $tt_id, $taxonomy, $category_meta_boxes );
}

?>
