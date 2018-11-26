<?php

// Insert Page Meta Boxes
function fastor_page_meta_boxes() {
    
    global $page_meta_boxes;
    
    fastor_show_meta_boxes($page_meta_boxes);
}
        
function fastor_add_page_meta_box() {
    if ( function_exists('add_meta_box') ) {
        add_meta_box( 'new-meta-boxes', 'Page Options', 'fastor_page_meta_boxes', 'page', 'normal', 'high' );
    }
}

// Save Page Metas        
function fastor_page_save_postdata( $post_id ) {
    global $page_meta_boxes;
    
    return fastor_save_postdata( $post_id, $page_meta_boxes );
}

// Get Page Metas        
function fastor_page_get_postdata() {
    global $page_meta_boxes, $wp_registered_sidebars;
    
    // Page Meta Options
    $theme_layouts = fastor_layouts();
    $sidebar_options = fastor_ct_sidebars();
    $slider_type = fastor_slider_type();
    $rev_sliders = fastor_revslider_list();
    $slider_align = fastor_slider_align();
    
    
    // Page Meta Boxes
    $page_meta_boxes = array(
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
        // Title
        "title"=> fastor_labels_meta(
            "title",
            "Page Title",
            "Hide page title",
            "checkbox"
        ),
        // Layout
        "layout" => fastor_labels_meta(
            "layout", 
            "Layout",
            "Select the layout.",
            "radio",
            "fullwidth",
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


        // Slider Type
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
        "rev_slider"=> fastor_labels_meta(
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


  
    );
}

add_action('add_meta_boxes', 'fastor_add_page_meta_box');
add_action('admin_menu', 'fastor_page_get_postdata');
add_action('save_post', 'fastor_page_save_postdata');

?>
