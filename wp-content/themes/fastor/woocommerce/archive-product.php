<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$fastor_options = fastor_get_options();
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 5);

get_header( 'shop' ); ?>

<?php
/**
 * woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action( 'woocommerce_before_main_content' );
?>

<?php
/**
 * woocommerce_archive_description hook.
 *
 * @hooked woocommerce_taxonomy_archive_description - 10
 * @hooked woocommerce_product_archive_description - 10
 */
do_action( 'woocommerce_archive_description' );
?>



<?php
// if ( woocommerce_product_loop() ): SINCE 3.4.0 version
if ( have_posts() ) : ?>




	<?php
	/**
	 * woocommerce_before_shop_loop hook.
	 *
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );
	?>


	<?php
	$subcategories_tpl = woocommerce_maybe_show_product_subcategories('');
	?>

	<?php if (trim($subcategories_tpl)): ?>
	<div class="category-subcats">
		<div class="row">
			<?php  echo $subcategories_tpl; ?>
		</div>
	</div>
	<?php endif; ?>

	<?php
	// we use div products category-products instead of loop_start function
	//woocommerce_product_loop_start();
	?>

	<div class="products category-products">

		<?php do_action( 'fastor_woocommerce_before_catalog' ); ?>

		<div id="mfilter-content-container">

		<?php if ( wc_get_loop_prop( 'total' ) ): ?>

			<div class="product-grid <?php if($fastor_options['category-default-list-grid'] == 1) { echo ' active'; } ?>">
				<div class="row">
				<?php
				$class = 3;
				$row = 4;

				if($fastor_options['category-product-per-page'] == 6) { $class = 2; }
				if($fastor_options['category-product-per-page'] == 5) { $class = 25; }
				if($fastor_options['category-product-per-page'] == 3) { $class = 4; }
				if($fastor_options['category-product-per-page'] > 0){
				   $row = esc_html($fastor_options['category-product-per-page']);
				}


				$row_fluid = 0;
				?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						$row_fluid++; ?>
						<?php $r = $row_fluid - floor($row_fluid/$row) * $row;
						if($row_fluid > $row && $r == 1) {
							echo '</div><div class="row">';

						}?>
						<div class="col-sm-<?php echo esc_attr($class); ?> col-xs-6">
						<?php wc_get_template_part( 'content', 'product' ); ?>
						</div>

				<?php endwhile; // end of the loop. ?>
				</div>
			</div>

			<?php

			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_single_excerpt', 5);
			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10);
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 5);
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
			?>

				<div class="product-list <?php if($fastor_options['category-default-list-grid'] == 0) { echo ' active'; } ?>">
				<?php while ( have_posts() ) : the_post(); ?>
					<div>
						<div class="row">
						<?php wc_get_template_part( 'content_list', 'product' ); ?>
						</div>
					</div>
				<?php endwhile; // end of the loop. ?>
				</div>

		<?php endif; ?>


		</div>


	<?php woocommerce_product_loop_end(); ?>

	<?php
	/**
	 * woocommerce_after_shop_loop hook.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
	?>

<?php else: ?>

	<?php wc_get_template( 'loop/no-products-found.php' ); ?>

<?php endif; ?>

<?php
/**
 * woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );
?>

<?php
/**
 * woocommerce_sidebar hook.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );
?>

<?php get_footer( 'shop' ); ?>
