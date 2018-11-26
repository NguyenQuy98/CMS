<?php

// Widgets
require(get_template_directory() . '/inc/widgets/categories.php');
require(get_template_directory() . '/inc/widgets/sidebar-menu-widget.php');
require(get_template_directory() . '/inc/widgets/footer-menu-widget.php');
require(get_template_directory() . '/inc/widgets/custom-block-widget.php');
if ( class_exists( 'Woocommerce' ) ) {
    require(get_template_directory() . '/inc/widgets/product-categories.php');
    require(get_template_directory() . '/inc/widgets/product-top-rated.php');
    require(get_template_directory() . '/inc/widgets/product-recently-viewed.php');
}

// Register sidebars and widgetized areas

register_sidebar( array(
    'name' => esc_html__('Home Sidebar', 'fastor'),
    'id' => 'home-sidebar',
    'before_widget' => '<div id="%1$s" class="widget %2$s box box-no-advanced "> <div class="box-heading">',
    'after_widget' => "</div></div>",
    'before_title' => '',
    'after_title' => '
        </div><div class="strip-line"></div>
        <div class="box-content">
    ',
) );

register_sidebar( array(
    'name' => esc_html__('Blog Sidebar', 'fastor'),
    'id' => 'blog-sidebar',
    'before_widget' => '<div id="%1$s" class="widget %2$s box box-no-advanced"> <div class="box-heading">',
    'after_widget' => "</div></div>",
    'before_title' => '',
    'after_title' => '
        </div><div class="strip-line"></div>
        <div class="box-content">
    ',
) );

register_sidebar( array(
    'name' => esc_html__('Portfolio Sidebar', 'fastor'),
    'id' => 'portfolio-sidebar',
    'before_widget' => '<div id="%1$s" class="widget %2$s box"> <div class="box-heading">',
    'after_widget' => "</div></div>",
    'before_title' => '',
    'after_title' => '
        </div><div class="strip-line"></div>
        <div class="box-content">
    ',
) );

register_sidebar(array(
    'name' => esc_html__('Top Page Widget', 'fastor'),
    'id' => 'top-page-sidebar',
));

register_sidebar(array(
    'name' => esc_html__('Header block Widget', 'fastor'),
    'id' => 'header-block',
));


register_sidebar( array(
    'name' => esc_html__('Under Menu Widget', 'fastor'),
    'id' => 'under-menu',
) );


register_sidebar( array(
    'name' => esc_html__('Slider Widget', 'fastor'),
    'id' => 'slider',
) );

register_sidebar( array(
    'name' => esc_html__('Content Top Widget', 'fastor'),
    'id' => 'content-top',
    'before_widget' => '<div id="%1$s" class="widget %2$s box box-no-advanced"> <div class="box-heading">',
    'after_widget' => "</div></div>",
    'before_title' => '',
    'after_title' => '
        </div><div class="strip-line"></div>
        <div class="box-content">
    ',
) );

register_sidebar( array(
    'name' => esc_html__('Content Bottom Widget', 'fastor'),
    'id' => 'content-bottom',
    'before_widget' => '<div id="%1$s" class="widget %2$s box box-no-advanced"> <div class="box-heading">',
    'after_widget' => "</div></div>",
    'before_title' => '',
    'after_title' => '
        </div><div class="strip-line"></div>
        <div class="box-content">
    ',
) );


if ( class_exists( 'Woocommerce' ) ) {

register_sidebar( array(
    'name' => esc_html__('WooCommerce Sidebar', 'fastor'),
    'id' => 'woocommerce-sidebar',
    'before_widget' => '<div id="%1$s" class="widget box box-no-advanced %2$s "> <div class="box-heading">',
    'after_widget' => "</div></div>",
    'before_title' => '',
    'after_title' => '
        </div><div class="strip-line"></div>
        <div class="box-content">
    ',
) );

register_sidebar( array(
    'name' => esc_html__('WooCommerce Product Sidebar', 'fastor'),
    'id' => 'woocommerce-product-sidebar',
    'before_widget' => '<div id="%1$s" class="widget box box-no-advanced %2$s "> <div class="box-heading">',
    'after_widget' => "</div></div>",
    'before_title' => '',
    'after_title' => '
    </div><div class="strip-line"></div>
    <div class="box-content">
',
) );


}

register_sidebar( array(
    'name' => esc_html__('Footer Top Widget', 'fastor'),
    'id' => 'footer-top',
    'before_widget' => '<div class="overflow %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => ' </h4><div class="strip-line"></div><div class="clearfix"></div>',
) );

register_sidebar( array(
    'name' => esc_html__('Footer Widget 1', 'fastor'),
    'id' => 'footer-column-1',
    'before_widget' => '<div class="overflow %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div><h4>',
    'after_title' => ' </h4><div class="strip-line"></div></div><div class="clearfix"></div>',
) );

register_sidebar( array(
    'name' => esc_html__('Footer Widget 2', 'fastor'),
    'id' => 'footer-column-2',
    'before_widget' => '<div class="overflow %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div><h4>',
    'after_title' => ' </h4><div class="strip-line"></div></div><div class="clearfix"></div>',
) );

register_sidebar( array(
    'name' => esc_html__('Footer Widget 3', 'fastor'),
    'id' => 'footer-column-3',
    'before_widget' => '<div class="overflow %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div><h4>',
    'after_title' => ' </h4><div class="strip-line"></div></div><div class="clearfix"></div>',
) );

register_sidebar( array(
    'name' => esc_html__('Footer Widget 4', 'fastor'),
    'id' => 'footer-column-4',
    'before_widget' => '<div class="overflow %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div><h4>',
    'after_title' => ' </h4><div class="strip-line"></div></div><div class="clearfix"></div>',
) );

register_sidebar( array(
    'name' => esc_html__('Footer Bottom Widget', 'fastor'),
    'id' => 'footer-bottom',
    'before_widget' => '<div class="overflow %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div><h4>',
    'after_title' => ' </h4><div class="strip-line"></div></div><div class="clearfix"></div>',
) );

register_sidebar( array(
    'name' => esc_html__('Footer Bottom II Widget', 'fastor'),
    'id' => 'footer-bottom2',
    'before_widget' => '<div class="overflow %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div><h4>',
    'after_title' => ' </h4><div class="strip-line"></div></div><div class="clearfix"></div>',
) );

?>
