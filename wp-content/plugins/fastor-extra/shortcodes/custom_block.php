<?php
  
// Custom Block
add_shortcode('custom_block', 'fastor_shortcode_custom_block');

function fastor_shortcode_custom_block($atts, $content = null) {
    
    extract(shortcode_atts(array(
        'id' => '',
        'name' => '',
        'class' => '',
    ), $atts));
    
    if (!($id || $name))
        return;
            
    if ($id)
        $custom_block = get_posts( array( 'include' => $id, 'post_type' => 'custom_block' ) ); 
        
    if ($name)
        $custom_block = get_posts( array( 'name' => $name, 'post_type' => 'custom_block' ) );

    if (!$custom_block)
        return;

    $addthis_options = get_option('addthis_settings');
    if (defined('ADDTHIS_INIT' && !(isset($addthis_options) && isset($addthis_options['addthis_for_wordpress']) && ($addthis_options['addthis_for_wordpress'] == true))))
        add_filter('addthis_above_content', 'fastor_addthis_remove', 10, 1);

    $custom_block_content = $custom_block[0]->post_content;

    ob_start();
    ?>
        <?php echo do_shortcode($custom_block_content) ?>
    <?php
    $id = $custom_block[0]->ID;
    if ( $id ) {
        $shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
        if ( ! empty( $shortcodes_custom_css ) ) { ?>
            <style type="text/css" data-type="vc_shortcodes-custom-css">
                <?php echo str_replace('__child__', '>', (esc_html(str_replace('>', '__child__', $shortcodes_custom_css))));?>
            </style>
        <?php }
    }
    $str = ob_get_contents();
    ob_end_clean();
    
    return $str;
}

// Register Shortcodes in Visual Composer Editor
if (function_exists('vc_set_as_theme')) {

    function fastor_vc_shortcode_custom_block() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => "Custom Block",
            "base" => "custom_block",
            "category" => "Fastor",
            "icon" => $vc_icon,
            "params" => array(
                array(
                    "type" => "label",
                    "heading" => "Input custom_block id & name",
                    "param_name" => "label"
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Block ID",
                    "param_name" => "id",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Block Name",
                    "param_name" => "name",
                    "admin_label" => true
                ),
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodes' ) ) {
            class WPBakeryShortCode_Custom_Block extends WPBakeryShortCodes {
            }
        }
    }
}

