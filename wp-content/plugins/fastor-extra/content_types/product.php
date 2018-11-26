<?php

// Insert Post Meta Boxes
function fastor_product_meta_boxes() {

    global $product_meta_boxes;

    fastor_show_meta_boxes($product_meta_boxes);
}

function fastor_add_product_meta_box() {
    if ( function_exists('add_meta_box') ) {
        add_meta_box( 'new-meta-boxes', 'Product Options', 'fastor_product_meta_boxes', 'product', 'normal', 'high' );
    }
}

// Save Product Metas        
function fastor_product_save_postdata( $post_id ) {
    global $product_meta_boxes;

    return fastor_save_postdata( $post_id, $product_meta_boxes );
}

// Get Product Metas
function fastor_product_get_postdata() {
    global $product_meta_boxes, $product_cat_meta_boxes;

    // Product Meta Options
    $theme_layouts = fastor_layouts();
    $sidebar_options = fastor_ct_sidebars();
    $slider_type = fastor_slider_type();
    $slider_align = fastor_slider_align();
    $rev_sliders = fastor_revslider_list();

    $product_meta_boxes = array(
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
            "woocommerce-sidebar",
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

        // Custom Tab Title
        "custom_tab_title1"=> fastor_labels_meta(
            "custom_tab_title1",
            "Custom Tab Title 1",
            "Input the custom tab title.",
            "text"
        ),
        // Content Tab Content
        "custom_tab_content1"=> fastor_labels_meta(
            "custom_tab_content1",
            "Custom Tab Content 1",
            "Input the custom tab content.",
            "textarea"
        ),
        // Custom Tab Title
        "custom_tab_title2"=> fastor_labels_meta(
            "custom_tab_title2",
            "Custom Tab Title 2",
            "Input the custom tab title.",
            "text"
        ),
        // Content Tab Content
        "custom_tab_content2"=> fastor_labels_meta(
            "custom_tab_content2",
            "Custom Tab Content 2",
            "Input the custom tab content.",
            "textarea"
        ),
        // Product custom block
        "product_block_custom" => fastor_labels_meta(
            "product_block_custom",
            "Product block: CUSTOM",
            "Type the custom block name",
            "text"
        ),
        // Product image top block
        "product_block_image_top" => fastor_labels_meta(
            "product_block_image_top",
            "Product block: IMAGE TOP",
            "Type the custom block name",
            "text"
        ),
        // Product image bottom block
        "product_block_image_bottom" => fastor_labels_meta(
            "product_block_image_bottom",
            "Product block: IMAGE BOTTOM",
            "Type the custom block name",
            "text"
        ),
        // Product over add to cart block
        "product_block_over_add_to_cart" => fastor_labels_meta(
            "product_block_over_add_to_cart",
            "Product block: OVER ADD TO CART",
            "Type the custom block name",
            "text"
        ),
        // Product over tabs block
        "product_block_over_tabs" => fastor_labels_meta(
            "product_block_over_tabs",
            "Product block: OVER TABS",
            "Type the custom block name",
            "text"
        ),

    );

    $banner_type['featured_products'] = "Featured Products";

    // Category Meta Boxes
    $product_cat_meta_boxes = array(
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
            "woocommerce-sidebar",
            "",
            $sidebar_options
        ),


        // Banner Type
        "banner_type"=> fastor_labels_meta(
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

    );
}

add_action('add_meta_boxes', 'fastor_add_product_meta_box');
add_action('admin_menu', 'fastor_product_get_postdata');
add_action('save_post', 'fastor_product_save_postdata');

// Create Product Cat Meta
global $wpdb;
$type = 'product_cat';
$table_name = $wpdb->prefix . $type . 'meta';
$variable_name = $type . 'meta';
$wpdb->$variable_name = $table_name;

// Create Product Cat Meta Table
create_metadata_table($table_name, $type);

// category meta
add_action( 'product_cat_add_form_fields', 'fastor_add_product_cat', 10, 2);
function fastor_add_product_cat() {
    global $product_cat_meta_boxes;

    fastor_show_tax_add_meta_boxes($product_cat_meta_boxes);
}

add_action( 'product_cat_edit_form_fields', 'fastor_edit_product_cat', 10, 2);
function fastor_edit_product_cat($tag, $taxonomy) {
    global $product_cat_meta_boxes;

    fastor_show_tax_edit_meta_boxes($tag, $taxonomy, $product_cat_meta_boxes);
}

add_action( 'created_term', 'fastor_save_product_cat', 10,3 );
add_action( 'edit_term', 'fastor_save_product_cat', 10,3 );

function fastor_save_product_cat($term_id, $tt_id, $taxonomy) {
    if (!$term_id) return;

    global $product_cat_meta_boxes;

    fastor_product_get_postdata();
    return fastor_save_taxdata( $term_id, $tt_id, $taxonomy, $product_cat_meta_boxes );
}

?>
