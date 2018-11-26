<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

$fastor_options = fastor_get_options();

$review_index = 0;

$custom_tab_title1 = get_post_meta(get_the_id(), 'custom_tab_title1', true);
$custom_tab_content1 = get_post_meta(get_the_id(), 'custom_tab_content1', true);
$custom_tab_title2 = get_post_meta(get_the_id(), 'custom_tab_title2', true);
$custom_tab_content2 = get_post_meta(get_the_id(), 'custom_tab_content2', true);

if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs" id="product-tab">
		<div id="tabs" class="htabs">
			<?php $i = 0; foreach ( $tabs as $key => $tab ) : ?>

				<a href="#tab-<?php echo $key ?>">
					<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?>
				</a>
                
                <?php if ($key == 'reviews') $review_index = $i; ?>

			<?php $i++; endforeach; ?>

            <?php if ($custom_tab_title1 && $custom_tab_content1) : ?>
                <a href="#tab-custom1">
                    <?php echo esc_html($custom_tab_title1); ?>
                </a>
            <?php $i++; endif; ?>

            <?php if ($custom_tab_title2 && $custom_tab_content2) : ?>
                <a href="#tab-custom2">
                    <?php echo esc_html($custom_tab_title2); ?>
                </a>
            <?php $i++; endif; ?>

		</div>
        <?php foreach ( $tabs as $key => $tab ) : ?>

            <div id="tab-<?php echo $key ?>" class="tab-content">
                <?php call_user_func( $tab['callback'], $key, $tab ) ?>
            </div>

        <?php endforeach; ?>

        <?php if ($custom_tab_title1 && $custom_tab_content1) : ?>
            <div id="tab-custom1" class="tab-content">
                <?php echo do_shortcode($custom_tab_content1) ?>
            </div>
        <?php endif; ?>

        <?php if ($custom_tab_title2 && $custom_tab_content2) : ?>
            <div id="tab-custom2" class="tab-content">
                <?php echo do_shortcode($custom_tab_content2) ?>
            </div>
        <?php endif; ?>

	</div>
    
    
<script>
(function($) { 
     $.fn.tabs = function() {
     	var selector = this;
     	
     	this.each(function() {
     		var obj = $(this); 
     		
     		$(obj.attr('href')).hide();
     		
     		$(obj).click(function() {
     			$(selector).removeClass('selected');
     			
     			$(selector).each(function(i, element) {
     				$($(element).attr('href')).hide();
     			});
     			
     			$(this).addClass('selected');
     			
     			$($(this).attr('href')).show();
     			
     			return false;
     		});
     	});
     
     	$(this).show();
     	
     	$(this).first().click();
     };
     
     $('#tabs a').tabs();
})(jQuery)
</script> 

<?php endif; ?>
