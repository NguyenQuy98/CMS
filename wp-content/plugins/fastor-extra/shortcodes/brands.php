<?php
  
// Brands Slider
add_shortcode('brands', 'fastor_shortcode_brands');
add_shortcode('brand', 'fastor_shortcode_brand');

function fastor_shortcode_brands($atts, $content = null) {
    
    extract(shortcode_atts(array(
        'title' => '',
        'items' => 6,
        'items_desktop' => 4,
        'items_desktop_small' => 3,
        'items_tablet' => 2,
        'class' => ''
    ), $atts));
    
    $fastor_brands_id = rand();

    ob_start();
    ?>
    <div class=" carousel-brands  <?php echo esc_html($class) ?>">
        <?php if ($title) : ?>
            <h2 class="entry-title brands-title"><?php echo esc_html($title) ?></h2>
        <?php endif; ?>
        <div id="carousel<?php echo esc_html($fastor_brands_id) ?>" class="owl-carousel">
            <?php echo do_shortcode($content); ?>
        </div>
    </div>
    <script type="text/javascript"><!--
    (function($) { 
        $(document).ready(function($) {
            $('#carousel<?php echo esc_html($fastor_brands_id) ?>').owlCarousel({
                autoPlay: 3000,
                navigation: true,
                navigationText: false,
                pagination: true,
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                items: <?php echo esc_html($items) ?>,
                itemsDesktop: [1199, <?php echo esc_html($items_desktop) ?>],
                itemsDesktopSmall: [991, <?php echo esc_html($items_desktop_small) ?>],
                itemsTablet: [750, <?php echo esc_html($items_tablet) ?>],
                <?php if(is_rtl()): ?>
                direction: 'rtl'
                <?php endif; ?>
            });
        })
    })(jQuery)
    --></script>

    <?php
    $str = ob_get_contents();
    ob_end_clean();
    
    return $str;
}

function fastor_shortcode_brand($atts, $content = null) {
    
    extract(shortcode_atts(array(
        'title' => '',
        'image' => '',
        'image_id' => '',
        'link' => '',
        'target' => '',
        'class' => ''
    ), $atts));

    if (!$image && $image_id)
        $image = wp_get_attachment_url($image_id);
    
    if (!$image)
        return;
    
    ob_start();
    ?>
    <div class="brand item text-center <?php echo esc_html($class) ?>">
        <?php if ($link) : ?><a href="<?php echo esc_url($link) ?>" title="<?php echo esc_html($title) ?>" target="<?php echo esc_url($target) ?>"><?php endif; ?>
            <img alt="<?php echo esc_html($title) ?>" src="<?php echo str_replace( array( 'http:', 'https:' ), '', $image ) ?>"/>
        <?php if ($link) : ?></a><?php endif; ?>
    </div>


    <?php
    $str = ob_get_contents();
    ob_end_clean();
    
    return $str;
}

// Register Shortcodes in Visual Composer Editor
if (function_exists('vc_set_as_theme')) {

    function fastor_vc_shortcode_brands() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => "Brands",
            "base" => "brands",
            "category" => "Fastor",
            "icon" => $vc_icon,
            'is_container' => true,
            'js_view' => 'VcColumnView',
            "as_parent" => array('only' => 'brand'),
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => "Title",
                    "param_name" => "title",
                    "admin_label" => true
                ),
                array(
                    "type" => "label",
                    "heading" => "If Single Item is 'false' then",
                    "param_name" => "label"
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Items",
                    "param_name" => "items",
                    "value" => "6",
                    "description" => "window width >= 1200px"
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Items on Desktop",
                    "param_name" => "items_desktop",
                    "value" => "4",
                    "description" => "992px <= window width < 1200px"
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Items on Small Desktop",
                    "param_name" => "items_desktop_small",
                    "value" => "3",
                    "description" => "768px <= window width < 992px"
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Items on Tablet",
                    "param_name" => "items_tablet",
                    "value" => "2",
                    "description" => "480px <= window width < 768px"
                ),
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
            class WPBakeryShortCode_Brands extends WPBakeryShortCodesContainer {
            }
        }
    }

    function fastor_vc_shortcode_brand() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => "Brand",
            "base" => "brand",
            "category" => "Fastor",
            "icon" => $vc_icon,
            "params" => array(
                array(
                    "type" => "label",
                    "heading" => "Input Image URL or Select Image.",
                    "param_name" => "label"
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Image URL",
                    "param_name" => "image",
                    "admin_label" => true
                ),
                array(
                    "type" => "attach_image",
                    "heading" => "Brand Image",
                    "param_name" => "image_id",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Title",
                    "param_name" => "title"
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Link URL",
                    "param_name" => "link"
                ),
                array(
                    "type" => "link_target",
                    "heading" => "Link Target",
                    "param_name" => "target"
                ),
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodes' ) ) {
            class WPBakeryShortCode_Brand extends WPBakeryShortCodes {
            }
        }
    }
}
