<?php

// Content Slider
add_shortcode('filter_products', 'fastor_shortcode_filter_products');
add_shortcode('filter_products_tab', 'fastor_shortcode_filter_products_tab');

$filter_products_tabs  = array();
$filter_products_tabs_index  = 0;

function fastor_shortcode_filter_products($attr, $content = null) {

    $id = rand();

    do_shortcode($content);
    global $filter_products_tabs;
    global $filter_products_tabs_index;

    extract(shortcode_atts(array(
        'id' => count($filter_products_tabs),
        'title' => '',
        'class' => ''
    ), $attr));


    if($title){
        $title = ' <div class="main-heading"><div class="heading-title"><h2><span>' . $title . '</span></h2></div></div>';
    }

    $scontent = '<div class="filter-tabs">'
        . $title
        . '<div class="bg-filter-tabs"><div class="bg-filter-tabs2 clearfix">'
        . '<ul id="tab' . $id . '">'
        . implode('', $filter_products_tabs['tabs']) .
        '</ul></div></div></div>'
        .'<div class="tab-content">'
        . implode('', $filter_products_tabs['panes'])
        . '</div>';
    if (trim($scontent) != "") {
        $output = '<div class="filter-product ' . $class . '">' . $scontent;
        $output .= '</div>';
        $filter_products_tabs = array();
        $filter_products_tabs_index++;
        return $output;
    } else {
        return "";
    }

}

function fastor_shortcode_filter_products_tab($attr, $content = null) {
    global $filter_products_tabs;
    global $filter_products_tabs_index;

    extract(shortcode_atts(array(
        'title' => '',
        'active' => '',
        'class' => ''
    ), $attr));

    if($active == 'yes'){
        $active = 'active';
    }else{
        $active = '';
    }

    $index = count($filter_products_tabs);
    if (!isset($filter_products_tabs['tabs'])) {
        $filter_products_tabs['tabs'] = array();
    }
    $pane_id = 'pane-' . $index . '-' .  count($filter_products_tabs['tabs']) . '-'.$filter_products_tabs_index;
    $filter_products_tabs['tabs'][] = '<li class="' . $active. '"><a  href="#' . $pane_id . '" data-toggle="tab">' . $title
        . '</a></li>';
    $filter_products_tabs['panes'][] = '<div class="tab-pane ' . $active . '" id="'
        . $pane_id . '">'
        . do_shortcode
        (trim($content)) . '</div>';

}

// Register Shortcodes in Visual Composer Editor
if (function_exists('vc_set_as_theme')) {

    function fastor_vc_shortcode_filter_products() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => esc_html__("Filter Products", "fastor"),
            "base" => "filter_products",
            "category" => "Fastor",
            "icon" => $vc_icon,
            'is_container' => true,
            'js_view' => 'VcColumnView',
            "as_parent" => array('only' => 'filter_products_tab'),
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => "Title",
                    "param_name" => "title",
                    "admin_label" => true
                ),
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
            class WPBakeryShortCode_Filter_Products extends WPBakeryShortCodesContainer {
            }
        }
    }

    function fastor_vc_shortcode_filter_products_tab() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => esc_html__("Filter Products Tab", "fastor"),
            "base" => "filter_products_tab",
            "category" => "Fastor",
            "icon" => $vc_icon,
            'is_container' => true,
            'js_view' => 'VcColumnView',
            "as_child" => array('only' => 'filter_products'),
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => "Title",
                    "param_name" => "title",
                    "admin_label" => true
                ),
                array(
                    "type" => "yes_no",
                    "heading" => "Active",
                    "param_name" => "active",
                ),
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
            class WPBakeryShortCode_Filter_Products_Tab extends WPBakeryShortCodesContainer {
            }
        }
    }
}
