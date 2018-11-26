<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fastor
 */

$fastor_options = fastor_get_options();
$page = $wp_query->get_queried_object();


?><!DOCTYPE html>
<html <?php language_attributes(); ?>  class="<?php echo esc_attr($fastor_options['layout-responsive']) == 1 ? 'responsive' : ''; ?> <?php echo fastor_get_active_skin(true); ?>">
<head>
     <meta charset="<?php bloginfo( 'charset' ); ?>">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="profile" href="http://gmpg.org/xfn/11">
     <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
     <?php if(isset($fastor_options['layout-favicon']['url']) && (! function_exists( 'has_site_icon' ) || ! has_site_icon())): ?>
     <link rel="shortcut icon" href="<?php echo esc_url($fastor_options['layout-favicon']['url']); ?>" type="image/x-icon" />
     <?php endif; ?>
     <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
    // Get Meta Values
    wp_reset_postdata();
    $fastor_layout = fastor_layout();
    $fastor_sidebar = fastor_sidebar();

?>


<?php if($fastor_options['block-header-notice-status']) { ?>
    <?php if (!$fastor_options['block-header-notice-only-homepage'] || ( $fastor_options['block-header-notice-only-homepage'] && is_front_page())):?>

        <div class="standard-body<?php if($fastor_options['block-header-notice-disable-desktop'] == 1) { echo ' hidden-lg hidden-md'; } ?> <?php if($fastor_options['block-header-notice-disable-mobile'] == 1) { echo ' hidden-sm hidden-xs'; } ?>">
            <div class="header-notice full-width clearfix <?php echo intval($fastor_options['block-header-notice-showonlyonce']) ? ' onlyonce' : ''; ?>" id="header-notice">
                <a href="#" class="close-notice"></a>
                <div class="container">
                    <?php echo fastor_parse_shortcode(html_entity_decode($fastor_options['block-header-notice-content'])); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php } ?>

<?php if ( is_active_sidebar( 'top-page-sidebar' ) ) : ?>
    <?php dynamic_sidebar( 'top-page-sidebar' ); ?>
<?php endif; ?>
    
<div class="<?php if($fastor_options['layout-main'] == 1 || $fastor_options['layout-main'] == 5) {
        echo 'standard-body';
    } else {
        echo 'fixed-body';
    }
    if($fastor_options['layout-main'] == 7) {
        echo ' fixed-body-shoes';
    }
    if($fastor_options['layout-main'] == 4 || $fastor_options['layout-main'] == 6) {
        echo ' fixed-body-2';
    }
    if($fastor_options['layout-main'] == 5) {
        echo ' fixed-body-2-2';
    }
    if($fastor_options['layout-main'] == 3) {
        echo ' with-shadow';
    }

    ?>">

	<div id="main" class="<?php if($fastor_options['layout-main'] == 4) {
	    echo 'main-fixed2 main-fixed';
	}else if($fastor_options['layout-main'] == 6){
	    echo 'main-fixed2 main-fixed3 main-fixed';
    }else if($fastor_options['layout-main'] != 1 && $fastor_options['layout-main'] != 5){
        echo 'main-fixed';
    } ?>">


        <?php
        switch($fastor_options['header-type']){
        case 1:
		  include get_template_directory() .'/layout/header/header_01.php';
            break;
        case 2:
            include get_template_directory() .'/layout/header/header_02.php';
            break;
        case 3:
            include get_template_directory() .'/layout/header/header_03.php';
            break;
        case 4:
            include get_template_directory() .'/layout/header/header_04.php';
            break;
        case 5:
            include get_template_directory() .'/layout/header/header_05.php';
            break;
        case 6:
            include get_template_directory() .'/layout/header/header_06.php';
            break;
        case 7:
            include get_template_directory() .'/layout/header/header_07.php';
            break;
        case 8:
            include get_template_directory() .'/layout/header/header_08.php';
            break;
        case 9:
            include get_template_directory() .'/layout/header/header_09.php';
            break;
        case 10:
            include get_template_directory() .'/layout/header/header_10.php';
            break;
        case 11:
            include get_template_directory() .'/layout/header/header_11.php';
            break;
        case 12:
            include get_template_directory() .'/layout/header/header_12.php';
            break;
        case 13:
            include get_template_directory() .'/layout/header/header_13.php';
            break;
        case 15:
            include get_template_directory() .'/layout/header/header_15.php';
            break;
        case 16:
            include get_template_directory() .'/layout/header/header_16.php';
            break;
        case 17:
            include get_template_directory() .'/layout/header/header_17.php';
            break;
        case 18:
            include get_template_directory() .'/layout/header/header_18.php';
            break;
        case 19:
            include get_template_directory() .'/layout/header/header_19.php';
            break;
        case 21:
            include get_template_directory() .'/layout/header/header_21.php';
            break;
        case 23:
            include get_template_directory() .'/layout/header/header_23.php';
            break;
        case 24:
            include get_template_directory() .'/layout/header/header_24.php';
            break;

        default:
            include get_template_directory() .'/layout/header/header_01.php';
            break;
        }
		?>

        <?php if(!is_front_page()):?>
        <!-- BREADCRUMB
            ================================================== -->
        <div class="breadcrumb
            <?php if($fastor_options['layout-breadcrumb'] == 1) {
                echo 'full-width';
            } else if ($fastor_options['layout-breadcrumb'] == 4){
                echo 'fixed3 fixed2';
            } else if ($fastor_options['layout-breadcrumb'] == 3){
                echo 'fixed2';
            }else{
                echo 'fixed';
            } ?>">


            <div class="background-breadcrumb"></div>
            <?php if(fastor_get_breadcrumb_bg()){
                echo '<div class="background with-other-image" style="background-image: url('.fastor_get_breadcrumb_bg().'); background-repeat:no-repeat;background-position:top center;">';
            } else{
                echo '<div class="background">';
            }?>
                <div class="shadow"></div>
                <div class="pattern">
                    <div class="container">
                        <div class="clearfix">
                            <div class="row">
                                <?php
                                $is_singular = is_singular('product');
                                $previous_post = false;
                                $next_post = false;
                                $center_columns = 12;

                                if($is_singular && $fastor_options['product-breadcrumb']){
                                    $previous_post = get_previous_post();
                                    $next_post = get_next_post();

                                    if($previous_post || $next_post){
                                        $center_columns = 6;
                                    }
                                }


                                ?>

                                <?php if ($previous_post):?>
                                    <div class="col-md-3 hidden-xs hidden-sm">
                                        <?php
                                        $previous_product = wc_get_product($previous_post->ID);
                                        ?>
                                        <?php if($fastor_options['product-breadcrumb'] == 1):?>
                                            <div class="next-product clearfix">
                                                <div class="image"><a href="<?php echo $previous_product->get_permalink();  ?>"><?php echo $previous_product->get_image() ?></a></div>
                                                <div class="right">
                                                    <div class="name"><a href="<?php echo $previous_product->get_permalink(); ?>"><?php echo $previous_product->get_title() ?></a></div>
                                                    <div class="price"><?php echo $previous_product->get_price_html() ?></div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="next-product-2 clearfix">
                                                <a href="<?php echo $previous_product->get_permalink();  ?>" data-toggle="tooltip" data-placement="top"
                                                   title="<?php echo $previous_product->get_title() ?>" class="button-previous-next">
                                                    <?php echo esc_html__('Previous product', 'fastor') ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif($next_post): ?>
                                    <div class="col-md-3 hidden-xs hidden-sm"></div>
                                <?php endif; ?>

                                <div class="col-md-<?php echo $center_columns ?>">

                                    <?php
                                    $breadcrumbs_tpl = '';
                                    ob_start();

                                    if(fastor_show_breadcrumbs()){
                                        fastor_breadcrumbs();
                                    }
                                    $breadcrumbs_tpl = ob_get_contents();
                                    ob_end_clean();
                                    if(!trim($breadcrumbs_tpl)) {
                                        $breadcrumbs_tpl = "<ul style='margin-top: -30px'><li>&nbsp;</li></ul>";
                                    } 

                                    ?>

                                    <?php if (!isset($page->ID) || get_post_meta($page->ID, 'title', true) != 'title') : ?>
                                        <h1 id="title-page">
                                            <?php fastor_get_page_title(); ?>
                                        </h1>
                                    <?php endif; ?>
                                    <?php if(fastor_show_breadcrumbs()):?>
                                        <?php  echo $breadcrumbs_tpl ?>
                                    <?php else: ; ?>
                                        <?php  echo $breadcrumbs_tpl ?>
                                    <?php endif; ?>
                                </div>

                                <?php if ( $next_post):?>
                                    <div class="col-md-3 hidden-xs hidden-sm">
                                        <?php
                                        $next_product = wc_get_product($next_post->ID);
                                        ?>
                                        <?php if($fastor_options['product-breadcrumb'] == 1):?>
                                            <div class="next-product right clearfix">
                                                <div class="image"><a href="<?php echo $next_product->get_permalink();  ?>"><?php echo $next_product->get_image() ?></a></div>
                                                <div class="right">
                                                    <div class="name"><a href="<?php echo $next_product->get_permalink(); ?>"><?php echo $next_product->get_title() ?></a></div>
                                                    <div class="price"><?php echo $next_product->get_price_html() ?></div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="next-product-2 right clearfix">
                                                <a href="<?php echo $next_product->get_permalink();  ?>" data-toggle="tooltip" data-placement="top"
                                                   title="<?php echo $next_product->get_title() ?>" class="button-previous-next">
                                                    <?php echo esc_html__('Next product', 'fastor') ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif($previous_post): ?>
                                    <div class="col-md-3 hidden-xs hidden-sm"></div>
                                <?php endif; ?>


                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
          <!-- MAIN CONTENT
          ================================================== -->
          <div class="main-content inner-page
            <?php if($fastor_options['layout-content'] == 1) {
              echo 'full-width';
          } else if ($fastor_options['layout-content'] == 4){
              echo 'fixed3 fixed2';
          } else if ($fastor_options['layout-content'] == 3){
              echo 'fixed2';
          }else{
              echo 'fixed';
          } ?>">
               <div class="background-content"></div>
               <div class="background">
                    <div class="shadow"></div>
                    <div class="pattern">
                         <div class="container">
                        <?php if ( is_active_sidebar( 'content-top' ) ) : ?>
                        <div class="row">
                            <div class="col-sm-12">
                            <?php dynamic_sidebar( 'content-top' ); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                            <div class="row">
                                <?php if ($fastor_layout == 'left-sidebar' && $fastor_sidebar && is_active_sidebar( $fastor_sidebar )) : ?>
                                <div class="col-md-3 sidebar" id="column-left"><!-- main sidebar -->
                                    <?php dynamic_sidebar( $fastor_sidebar ); ?>
                                </div><!-- end main sidebar -->
                                <?php endif; ?>

                                <?php
                                if($fastor_options['background-status']) {
                                   $content_class = 'content-with-background';
                                } else{
                                    $content_class = 'content-without-background';
                                }
                                if(defined('WC_VERSION')) {
                                    if (is_product_category() || is_product() || is_shop()) {
                                        $content_class = 'content-without-background';
                                    }
                                }

                                ?>
                                
                                <div class="<?php if (($fastor_layout == 'left-sidebar' || $fastor_layout == 'right-sidebar') && $fastor_sidebar && is_active_sidebar( $fastor_sidebar )) echo 'col-md-9'; else echo 'col-sm-12 col-md-12'; ?>">
                                     <div <?php if(!is_front_page()):?>class="center-column <?php echo $content_class?>"<?php endif; ?> <?php if(!is_front_page()):?> id="content" <?php endif; ?>>
                                        <?php if(function_exists('wc_print_notices')):?>
                                        <?php wc_print_notices(); ?>
                                        <?php endif; ?>
