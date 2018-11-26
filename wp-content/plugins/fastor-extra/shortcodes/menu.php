<?php

// Menu Shortcode

add_shortcode("menu", "fastor_shortcode_menu");

function fastor_shortcode_menu($attr, $content = null) {

    extract(shortcode_atts(array(
        "title" => '',
        'menu' => 'menu',
        'class' => ''
    ), $attr));

    $fastor_options = fastor_get_options();
    $nav_menu = ! empty( $menu ) ? wp_get_nav_menu_object( $menu ) : false;

    if ( !$nav_menu )
        return;


    ob_start();
    ?>
    <div class="container-megamenu container vertical">
        <div id="menuHeading">
            <div class="megamenuToogle-wrapper">
                <div class="megamenuToogle-pattern">
                    <div class="container"> <?php echo esc_html($title) ?></div>
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
                        'walker' => new fastor_main_menuwalker
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php

    $str = ob_get_contents();
    ob_end_clean();
    return $str;
}

// Register Shortcodes in Visual Composer Editor
if (function_exists('vc_set_as_theme')) {

    function fastor_vc_shortcode_menu() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => "Menu",
            "base" => "menu",
            "category" => "Fastor",
            "icon" => $vc_icon,
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => "Title",
                    "param_name" => "title",
                    "admin_label" => true
                ),
                array(
                    "type" => "menu_type",
                    "heading" => "Menu",
                    "param_name" => "menu",
                    "value" => "default",
                ),
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodes' ) ) {
            class WPBakeryShortCode_Menus extends WPBakeryShortCodes {
            }
        }
    }

}
