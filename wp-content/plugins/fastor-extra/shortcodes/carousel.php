<?php
  
// Content Slider
add_shortcode('carousel', 'fastor_shortcode_carousel');
add_shortcode('carousel_item', 'fastor_shortcode_carousel_item');

function fastor_shortcode_carousel($attr, $content = null) {
    
    $fastor_carousel_id = rand();
    
    extract(shortcode_atts(array(
        'title' => '',
        'class' => ''
    ), $attr));
    
    ob_start();
    ?>

    <div class="box box-with-products box-carousel">
        <!-- Carousel nav -->
        <a class="next" href="#myCarousel<?php echo esc_html($fastor_carousel_id); ?>" id="myCarousel<?php echo esc_html($fastor_carousel_id); ?>_next"><span></span></a>
        <a class="prev" href="#myCarousel<?php echo esc_html($fastor_carousel_id); ?>" id="myCarousel<?php echo esc_html($fastor_carousel_id); ?>_prev"><span></span></a>
  
    <script type="text/javascript">
        (function($) {
            $(document).ready(function() {
                var owl<?php echo esc_html($fastor_carousel_id); ?> = $(".box #myCarousel<?php echo esc_html($fastor_carousel_id); ?> .carousel-inner");

                $("#myCarousel<?php echo esc_html($fastor_carousel_id); ?>_next").click(function(){
                    owl<?php echo esc_html($fastor_carousel_id); ?>.trigger('owl.next');
                    return false;
                  })
                $("#myCarousel<?php echo esc_html($fastor_carousel_id); ?>_prev").click(function(){
                    owl<?php echo esc_html($fastor_carousel_id); ?>.trigger('owl.prev');
                    return false;
                });

                owl<?php echo esc_html($fastor_carousel_id); ?>.owlCarousel({
                    slideSpeed : 500,
                    singleItem:true,
                    pagination: false,
                    <?php if(is_rtl()): ?>
                    direction: 'rtl'
                    <?php endif; ?>
                 });
            });
         })(jQuery)
    /* ]]> */
    </script>
  <?php if($title):?>
  <div class="box-heading"><?php echo esc_html($title); ?></div>
  <div class="strip-line"></div>
  <?php endif; ?>
    <div class="clear"></div>
    <div class="box-content products">
  	<div id="myCarousel<?php echo esc_html($fastor_carousel_id); ?>" class="carousel slide">
  		<div class="carousel-inner">
			<?php echo do_shortcode($content); ?>
		</div>
		
	</div>
  </div>
</div>
    <?php
    $fastor_carousel_id++;
    $str = ob_get_contents();
    ob_end_clean();
    
    return $str;
}

function fastor_shortcode_carousel_item($attr, $content = null) {
    
    extract(shortcode_atts(array(
        'class' => ''
    ), $attr));
    
    ob_start();
    ?>
    <div class="shortcode carousel_item item <?php echo esc_html($class) ?>">
        <?php echo do_shortcode($content); ?>
    </div>

    <?php
    $str = ob_get_contents();
    ob_end_clean();
    
    return $str;
}

// Register Shortcodes in Visual Composer Editor
if (function_exists('vc_set_as_theme')) {

    function fastor_vc_shortcode_carousel() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $layout_type = fastor_vc_layout_type();
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => esc_html__("Carousel", "fastor"),
            "base" => "carousel",
            "category" => "Fastor",
            "icon" => $vc_icon,
            'is_container' => true,
            'js_view' => 'VcColumnView',
            "as_parent" => array('only' => 'carousel_item'),
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
            class WPBakeryShortCode_Carousel extends WPBakeryShortCodesContainer {
            }
        }
    }

    function fastor_vc_shortcode_carousel_item() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => esc_html__("Carousel Item", "fastor"),
            "base" => "carousel_item",
            "category" => "Fastor",
            "icon" => $vc_icon,
            'is_container' => true,
            'js_view' => 'VcColumnView',
            "as_child" => array('only' => 'carousel'),
            "params" => array(
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
            class WPBakeryShortCode_Carousel_Item extends WPBakeryShortCodesContainer {
            }
        }
    }
}
