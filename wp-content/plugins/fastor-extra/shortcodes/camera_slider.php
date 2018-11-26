<?php
  
// Content Slider
add_shortcode('camera_slider', 'fastor_shortcode_camera_slider');
add_shortcode('camera_slide', 'fastor_shortcode_camera_slide');

function fastor_shortcode_camera_slider($attr, $content = null) {
    
    $fastor_slider_id = rand();
    
    extract(shortcode_atts(array(
        'pagination' => 'false',
        'navigation' => 'true',
        'layout_type' => 1,
        'class' => ''
    ), $attr));
    
    ob_start();
    ?>


    <!-- Slider -->
    <div class="<?php if($layout_type == 1) { echo 'container'; } else { echo 'fullwidth'; } ?>" id="camera_<?php echo esc_html($fastor_slider_id) ?>">
        <div class="camera_slider">
            <div class="spinner"></div>
            <div class="camera_wrap" id="camera_wrap_<?php echo esc_html($fastor_slider_id) ?>" style="min-height: 100px">
                    <?php echo do_shortcode($content); ?>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
   (function($) { 
    $(document).ready(function() {
        $("#camera_wrap_<?php echo esc_html($fastor_slider_id) ?>").owlCarousel({
            pagination : <?php echo ($pagination == 'true')?'true':'false' ?>,
            navigation : <?php echo ($navigation == 'true')?'true':'false' ?>,
            navigationText: false,
            slideSpeed : 300,
            lazyLoad : true,
            singleItem: true,
            autoPlay: 7000,
            stopOnHover: true,
            <?php if(is_rtl()): ?>
            direction: 'rtl'
            <?php endif; ?>
        });

        $(window).load(function() {
            $("#camera_<?php echo esc_html($fastor_slider_id) ?> .spinner").fadeOut(200);
            $("#camera_wrap_<?php echo esc_html($fastor_slider_id) ?>").css("height", "auto");
        });
    })
    })(jQuery)
    /* ]]> */
    </script>
    <?php
    $fastor_slider_id++;
    $str = ob_get_contents();
    ob_end_clean();
    
    return $str;
}

function fastor_shortcode_camera_slide($attr, $content = null) {
    
    extract(shortcode_atts(array(
        'class' => ''
    ), $attr));
    
    ob_start();
    ?>
    <div class="shortcode slide <?php echo esc_html($class) ?>">
        <?php echo do_shortcode($content); ?>
    </div>

    <?php
    $str = ob_get_contents();
    ob_end_clean();
    
    return $str;
}

// Register Shortcodes in Visual Composer Editor
if (function_exists('vc_set_as_theme')) {

    function fastor_vc_shortcode_camera_slider() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $layout_type = fastor_vc_layout_type();
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => esc_html__("Camera Slider", "fastor"),
            "base" => "camera_slider",
            "category" => "Fastor",
            "icon" => $vc_icon,
            'is_container' => true,
            'js_view' => 'VcColumnView',
            "as_parent" => array('only' => 'camera_slide'),
            "params" => array(
                array(
                    "type" => "boolean",
                    "heading" => esc_html__("Pagination", "fastor"),
                    "param_name" => "pagination",
                    "value" => "false"
                ),
                array(
                    "type" => "boolean",
                    "heading" => esc_html__("Navigation", "fastor"),
                    "param_name" => "navigation",
                    "value" => "true"
                ),
                $layout_type,
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
            class WPBakeryShortCode_Camera_Slider extends WPBakeryShortCodesContainer {
            }
        }
    }

    function fastor_vc_shortcode_camera_slide() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => esc_html__("Camera Slide", "fastor"),
            "base" => "camera_slide",
            "category" => "Fastor",
            "icon" => $vc_icon,
            'is_container' => true,
            'js_view' => 'VcColumnView',
            "as_child" => array('only' => 'camera_slider'),
            "params" => array(
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
            class WPBakeryShortCode_Camera_Slide extends WPBakeryShortCodesContainer {
            }
        }
    }
}
