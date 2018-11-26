<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

$fastor_options = fastor_get_options();
?>

<?php if ( version_compare( WOOCOMMERCE_VERSION, "3.4.0" ) >= 0 ): ?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>
<?php else: ?>
<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php endif; ?>



    <div class="product-info <?php echo isset($fastor_options['productpage-layout']) ? 'product-layout-'.esc_attr($fastor_options['productpage-layout']) : '' ?> ">
        <div class="row">
            <div class="col-sm-<?php if(get_post_meta(get_the_id(), 'product_block_custom', true) != '' && is_product()) { echo 9; } else { echo 12; } ?>">
                <div class="row" id="quickview_product">
                <?php
                    /**
					 * Hook: woocommerce_single_product_summary.
                     *
                     * @hooked woocommerce_show_product_sale_flash - 10
                     * @hooked woocommerce_show_product_images - 20
                     */
                    do_action( 'woocommerce_before_single_product_summary' );
                ?>
                <?php $product_center_grid = 6;

                if ($fastor_options['productpage-image-size'] == 1) {
                    $product_center_grid = 8;
                }

                if ($fastor_options['productpage-image-size'] == 3) {
                    $product_center_grid = 4;
                }
                ?>
                    
					<div class="col-sm-<?php echo $product_center_grid; ?> product-center clearfix">
						<?php
						/**
						 * woocommerce_single_product_summary hook
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_meta - 40
						 * @hooked woocommerce_template_single_rating - 45
						 * @hooked woocommerce_template_single_sharing - 50
						 */
						do_action( 'woocommerce_single_product_summary' );

					?>
					</div>

                </div>
            </div><!-- .summary -->
            
            <div class="col-sm-3">

				<?php $product_block_custom = get_post_meta(get_the_id(), 'product_block_custom', true); ?>
				<?php if ($product_block_custom != '' && is_product()): ?>
					<?php echo do_shortcode('[custom_block name="'.$product_block_custom.'"]') ?>
				<?php endif; ?>

            </div>
            
        </div>
    </div>

	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php if($fastor_options['block-product-enquire-status']): ?>
	<div class="popup popup mfp-hide" id="product-enquiry-wrapper" >
		<?php echo do_shortcode($fastor_options['block-product-enquire-shortcode']); ?>
	</div>
<?php endif; ?>
<script>
	(function($) {


		$(window).load(function(){

			$('.flex-control-thumbs li').addClass('item')

			$('.flex-control-thumbs').addClass('overflow-thumbnails-carousel thumbnails-carousel')


			$(".thumbnails-carousel").owlCarousel({
				autoPlay: 6000, //Set AutoPlay to 3 seconds
				navigation: true,
				navigationText: ['', ''],
				itemsCustom : [
					[0, 4],
					[450, 5],
					[550, 6],
					[768, 3],
					[1200, 4]
				],
				<?php if(is_rtl()): ?>
				direction: 'rtl'
				<?php endif; ?>
			});

			var viewport = $(window).width();
			var itemCount = $(".thumbnails-carousel .item").length;

			if(
				(viewport >= 1200 && itemCount > 4) //desktop
				|| ((viewport >= 768 && viewport < 1200) && itemCount > 5) //desktopsmall
				|| ((viewport >= 550 && viewport < 768) && itemCount > 3) //tablet
				|| ((viewport >= 550 && viewport < 550) && itemCount > 6) //tablet
				|| (viewport < 450 && itemCount > 4) //mobile
			)
			{
				$('.overflow-thumbnails-carousel ').removeClass('hide-nav');
			}
			else
			{

				$('.overflow-thumbnails-carousel').addClass('hide-nav');

			}

		});


	})(jQuery)
</script>