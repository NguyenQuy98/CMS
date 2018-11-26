<?php
$fastor_options = fastor_get_options();
?>

<?php if($fastor_options['layout-page-width'] == 3 && $fastor_options['layout-page-width-custom-value']  > 900): ?>
<style>
    .standard-body .full-width .container {
        max-width: <?php echo esc_html($fastor_options['layout-page-width-custom-value']); ?>px;
        <?php if($fastor_options['layout-responsive'] == '0') { ?>
        width: <?php echo esc_html($fastor_options['layout-page-width-custom-value']); ?>px;
        <?php } ?>
    }
    .standard-body .full-width .container .container {
        max-width: none;
    }

    .standard-body .fixed .background,
    .main-fixed {
        max-width: <?php echo esc_html($fastor_options['layout-page-width-custom-value']-40); ?>px;
        <?php if($fastor_options['layout-responsive'] == '0') { ?>
        width: <?php echo esc_html($fastor_options['layout-page-width-custom-value']-40); ?>px;
        <?php } ?>
    }
</style>
<?php endif; ?>

<style>
 ul.megamenu  li .sub-menu > .content {
 -webkit-transition: all <?php if($fastor_options['menu-animation-time'] > 0 && $fastor_options['menu-animation-time'] < 5000) { echo esc_html($fastor_options['menu-animation-time']); } else { echo 300; } ?>ms ease-out !important;
 -moz-transition: all <?php if($fastor_options['menu-animation-time'] > 0 && $fastor_options['menu-animation-time'] < 5000) { echo esc_html($fastor_options['menu-animation-time']); } else { echo 300; } ?>ms ease-out !important;
 -o-transition: all <?php if($fastor_options['menu-animation-time'] > 0 && $fastor_options['menu-animation-time'] < 5000) { echo esc_html($fastor_options['menu-animation-time']); } else { echo 300; } ?>ms ease-out !important;
 -ms-transition: all <?php if($fastor_options['menu-animation-time'] > 0 && $fastor_options['menu-animation-time'] < 5000) { echo esc_html($fastor_options['menu-animation-time']); } else { echo 300; } ?>ms ease-out !important;
 transition: all <?php if($fastor_options['menu-animation-time'] > 0 && $fastor_options['menu-animation-time'] < 5000) { echo esc_html($fastor_options['menu-animation-time']); } else { echo 300; } ?>ms ease-out !important;
}
</style>


<style>
    <?php if($fastor_options['color-top_search_input_border_color'] != '') { ?>
    #top .search_form input {
        border: 1px solid <?php echo esc_html($fastor_options['color-top_search_input_border_color']) ?>;
    }
    <?php } ?>
    <?php if($fastor_options['color-inputs_border_color'] != '') { ?>
    textarea,
    input[type="text"],
    input[type="password"],
    input[type="datetime"],
    input[type="datetime-local"],
    input[type="date"],
    input[type="month"],
    input[type="time"],
    input[type="week"],
    input[type="number"],
    input[type="email"],
    input[type="url"],
    input[type="search"],
    input[type="tel"],
    input[type="color"],
    .select2 .select2-selection, select,
    .uneditable-input {
        border: 1px solid <?php echo esc_html($fastor_options['color-inputs_border_color']) ?>;
    }
    <?php } ?>

    <?php if($fastor_options['color-top_border_bottom_color'] == 'transparent') { ?>
    .megamenu-background {
        border-bottom: none !important;
    }
    <?php } ?>


    <?php if($fastor_options['color-top_bar_border_bottom_color'] != '') { ?>
    .top-bar {
        border-bottom: 1px solid <?php echo esc_html($fastor_options['color-top_bar_border_bottom_color']) ?> !important;
    }
    <?php } ?>


    <?php if($fastor_options['color-top_bar_border_bottom_color'] != '') { ?>
    .top-bar {
        border-bottom-color: transparent !important;
    }
    <?php } ?>


    <?php if($fastor_options['color-top_border_bottom_2px_color'] != '') { ?>
    .megamenu-background {
        border-bottom: 2px solid <?php echo esc_html($fastor_options['color-top_border_bottom_2px_color']) ?> !important;
    }
    <?php } ?>

    <?php if($fastor_options['color-top_border_bottom_2px_color'] == 'transparent' ) { ?>
    .megamenu-background {
        border-bottom: none !important;
    }
    <?php } ?>

    <?php if($fastor_options['color-top_border_bottom_4px_color'] != '') { ?>
    .megamenu-background {
        border-bottom: 4px solid <?php echo esc_html($fastor_options['color-top_border_bottom_4px_color']) ?> !important
    }
    <?php } ?>


    <?php if($fastor_options['color-top_border_bottom_4px_color'] == 'transparent' ) { ?>
    .megamenu-background {
        border-bottom: none !important;
    }
    <?php } ?>


    <?php if($fastor_options['color-vertical_menu_heading_background_color'] != '') { ?>
    @media (max-width: 991px) {
        .responsive .standard-body .full-width .megamenu-background .megaMenuToggle:before {
            background-color: <?php echo esc_html($fastor_options['color-vertical_menu_heading_background_color']); ?>;
        }
    }
    <?php } ?>

    <?php if($fastor_options['color-mobile_menu_heading_background_color'] != '') { ?>
    @media (max-width: 991px) {
        .responsive .standard-body .full-width .megamenu-background .megaMenuToggle:before  {
            background-color: <?php echo esc_html($fastor_options['color-mobile_menu_heading_background_color']); ?>;
        }
    }
    <?php } ?>

    <?php if($fastor_options['color-vertical_menu_content_background_color'] != '') { ?>
    #main .vertical .megamenu-wrapper {
        background-color: <?php echo esc_html($fastor_options['color-vertical_menu_content_background_color']) ?> !important;
    }
    <?php } ?>


    <?php if($fastor_options['color-vertical_menu_content_border2_color'] != '') { ?>
    #main .vertical .megamenu-wrapper {
        border: 1px solid <?php echo esc_html($fastor_options['color-vertical_menu_content_border2_color']) ?>;
        border-top: none;
    }
    <?php } ?>

    <?php if($fastor_options['color-breadcrumb_border_top_color'] != '') { ?>
    #main .breadcrumb .background {
        border-top: 1px solid <?php echo esc_html($fastor_options['color-breadcrumb_border_top_color']); ?> !important;
    }
    <?php } ?>

    <?php if($fastor_options['color-breadcrumb_border_bottom_color'] != '') { ?>
    #main .breadcrumb .background {
        border-bottom: 1px solid <?php echo esc_html($fastor_options['color-breadcrumb_border_bottom_color']); ?> !important;
    }
    <?php } ?>

    <?php if($fastor_options['color-breadcrumb_border_bottom_4px_color'] != '') { ?>
    #main .breadcrumb .background {
        border-bottom: 4px solid <?php echo esc_html($fastor_options['color-breadcrumb_border_bottom_4px_color']); ?> !important;
    }
    <?php } ?>


    <?php if($fastor_options['color-slider_loader_border_bottom_color'] != '') { ?>
    #slider .pattern {
        border-bottom: 4px solid <?php echo esc_html($fastor_options['color-slider_loader_border_bottom_color']); ?> ;
    }
    <?php } ?>


    <?php if($fastor_options['color-dropdown_background_color'] != '') { ?>
    .dropdown-menu,
    .ui-autocomplete {
        background: <?php echo esc_html($fastor_options['color-dropdown_background_color']); ?> !important;
    }

    .dropdown-menu:after,
    .ui-autocomplete:after {
        border-bottom-color: <?php echo esc_html($fastor_options['color-dropdown_background_color']); ?> !important;
    }
    <?php } ?>

    <?php if($fastor_options['color-dropdown_links_color'] != '') { ?>
    .dropdown-menu li a,
    .dropdown-menu .mini-cart-info a,
    .ui-autocomplete li a  {
        color: <?php echo esc_html($fastor_options['color-dropdown_links_color']); ?> !important;
    }
    <?php } ?>

    <?php if($fastor_options['color-dropdown_links_hover_color'] != '') { ?>
    .dropdown-menu li a:hover,
    .dropdown-menu .mini-cart-info a:hover,
    .ui-autocomplete li a:hover,
    .ui-autocomplete li a.ui-state-focus {
        color: <?php echo esc_html($fastor_options['color-dropdown_links_hover_color']); ?> !important;
    }
    <?php } ?>


    <?php if($fastor_options['color-box_categories_border_color'] != '') { ?>
    .box-with-categories .box-content {
        border: 1px solid <?php echo esc_html($fastor_options['color-box_categories_border_color']) ?> !important; ;
    }
    <?php } ?>

    <?php if($fastor_options['color-main_content_background_color'] != '') { ?>
    .product-filter,
    .product-list,
    .center-column .product-grid,
    .standard-body .full-width .center-column.content-with-background:before,
    .manufacturer-heading,
    .manufacturer-content,
    .center-column .tab-content,
    .body-other .standard-body .full-width .product-info:before,
    .product-info .cart,
    .box .box-content.products,
    .product-grid .product-hover .only-hover,
    html .mfp-iframe-scaler iframe,
    .quickview body,
    table.attribute tr, table.list tr, .wishlist-product table tr, .wishlist-info table tr, .compare-info tr, .checkout-product table tr, .table tr, .table,
    .spinner,
    img[src="image/catalog/blank.gif"],
    #mfilter-content-container > span:before,
    .cart-info table tr,
    .center-column .panel-heading,
    .center-column .panel-body,
    .popup,
    .product-block,
    .review-list .text,
    .modal-content,
    .product-info .product-image,
    .product-page-type-2 .standard-body .full-width .overflow-thumbnails-carousel,
    .product-page-type-2 .standard-body .full-width .product-info .product-center:before,
    .main-fixed3 .main-content .background,
    .product-grid-type-2 .product-grid .product:hover:before,
    .product-grid-type-3 .product-grid .product:hover:before,
    .product-grid-type-5 .product-grid .product:hover:before,
    .tab-content,
    .news.v2  .media-body .bottom{
        background-color: <?php echo esc_html($fastor_options['color-main_content_background_color']) ?> !important;
    }

        <?php if($fastor_options['color-main_content_background_color'] == 'transparent'): ?>
            .popup{
                background-color: <?php echo esc_html($fastor_options['color-body_background_color']) ?> !important;
            }
        <?php endif; ?>

    <?php } ?>

    <?php if($fastor_options['color-main_content_border_color'] != '') { ?>
    table.attribute,
    table.list,
    .wishlist-product table,
    .wishlist-info table,
    .compare-info,
    .cart-info table,
    .checkout-product table,
    .table,
    table.attribute td,
    table.list td,
    .wishlist-product table td,
    .wishlist-info table td,
    .compare-info td,
    .cart-info table td,
    .checkout-product table td,
    .table td ,
    .manufacturer-list,
    .manufacturer-heading,
    .center-column .panel-body,
    .review-list .text,
    .product-info .cart,
    .product-info .cart .links,
    .product-info .cart .links a:last-child,
    .product-info .cart .minimum,
    .product-info .review,
    .border-width-1 .standard-body .full-width .col-md-12 .col-md-12.center-column .cart-info thead td:first-child:before,
    .cart-info table thead td,
    #main .center-column .panel-heading,
    .main-fixed .center-column .panel:last-child, .standard-body .full-width .center-column .panel:last-child, .standard-body .fixed .center-column .panel:last-child,
    .center-column .panel-body,
    .body-white.checkout-checkout .standard-body .full-width .center-column .panel:last-child,
    .manufacturer-content,
    .product-block,
    .modal-header,
    .product-info .thumbnails li img, .product-info .thumbnails-carousel img,
    .product-info .product-image,
    .box-type-15 .col-sm-12 .box.box-with-products .box-content,
    .box-type-15 .col-md-12 .box.box-with-products .box-content,
    .box-type-15 .col-sm-12 .filter-product .tab-content,
    .box-type-15 .col-md-12 .filter-product .tab-content,
    .body-white.module-faq .standard-body #main .full-width .center-column .faq-section:last-child .panel:last-child,
    .product-info .radio-type-button2 span,
    .product-info .radio-type-button span,
    #main .mfilter-image ul li,
    .news.v2  .media-body .bottom,
    .news.v2 .media-body .date-published,
    #main .post .comments-list .text,
    #main .posts .post .post-content,
    #main .post .date-published,
    #main .post .meta,
    #main .post .post-content,
    .category-wall ul li a,
    .more-link,
    .body-white-type-2.checkout-cart .main-fixed .center-column > form > *:first-child {
        border-color: <?php echo esc_html($fastor_options['color-main_content_border_color']) ?>;
    }

    .product-info .description,
    .category-list {
        background: none;
        border-bottom: 1px solid <?php echo esc_html($fastor_options['color-main_content_border_color']); ?>;
    }

    .product-info .options,
    .product-list,
    .list-box li {
        background: none;
        border-top: 1px solid <?php echo esc_html($fastor_options['color-main_content_border_color']); ?>;
    }

    .list-box li:first-child {
        border: none;
    }

    .box-with-products .clear:before,
    .box-with-products .clear:after,
    .product-grid .product:before,
    .product-list > div:before,
    .product-list .name-actions:before,
    .product-list .desc:before,
    .center-column .product-grid:before,
    .center-column .product-grid:after,
    .product-grid > .row:before,
    .category-info:before,
    .refine_search_overflow:after,
    .tab-content:before,
    .tab-content:after,
    .product-filter .list-options .limit:before,
    .product-filter .list-options .sort:before,
    .product-filter .options .product-compare:before,
    table th,
    .is-countdown .countdown-section:after {
        background: <?php echo esc_html($fastor_options['color-main_content_border_color']); ?>;
    }

    .review-list .text:before,
    #main .post .comments-list .text:before {
        border-bottom-color: <?php echo esc_html($fastor_options['color-main_content_border_color']); ?>;
    }

    @media (max-width: 500px) {
        .responsive #main .product-grid .row > div.col-xs-6 .product:after {
            background: <?php echo esc_html($fastor_options['color-main_content_border_color']); ?>;
        }
    }

    @media (max-width: 767px) {
        .responsive .product-grid .row > div.col-xs-6 .product:after {
            background: <?php echo esc_html($fastor_options['color-main_content_border_color']); ?>;
        }
    }
    <?php } ?>

    <?php if($fastor_options['color-vertical_menu_heading_hover_background_color'] != '') { ?>
        #main .vertical:hover .megamenuToogle-wrapper,
        .common-home.show-vertical-megamenu #main .megamenu-background .vertical .megamenuToogle-wrapper,
        body[class*="product-category-"].show-vertical-megamenu-category-page #main .megamenu-background .vertical .megamenuToogle-wrapper,
        .common-home.show-vertical-megamenu #main .slideshow-modules .vertical .megamenuToogle-wrapper {
            background-color: <?php echo esc_html($fastor_options['color-vertical_menu_heading_hover_background_color']) ?> !important;
        }

        @media (max-width: 991px) {
            .responsive #main .vertical .megamenuToogle-wrapper{
                background: <?php echo esc_html($fastor_options['color-vertical_menu_heading_hover_background_color']) ?> !important;
            }
        }


    <?php } ?>


    <?php if($fastor_options['color-submenu_background_color'] != '') { ?>
        ul.megamenu > li > .sub-menu > .content > .arrow:after {
            border-bottom-color: <?php echo esc_html($fastor_options['color-submenu_background_color']) ?>;
        }
        .vertical ul.megamenu > li > .sub-menu > .content > .arrow:after,
        ul.megamenu li .sub-menu .content .hover-menu .menu ul ul:after {
            border-right-color: <?php echo esc_html($fastor_options['color-submenu_background_color']) ?>;
        }

        .rtl ul.megamenu li .sub-menu .content .hover-menu .menu ul ul:after,
        .rtl .vertical ul.megamenu > li > .sub-menu > .content > .arrow:after {
            border-left-color: <?php echo esc_html($fastor_options['color-submenu_background_color']) ?>;
        }

        @media (max-width: 767px) {
            .responsive ul.megamenu li .sub-menu .content .hover-menu .menu ul li a,
            .responsive ul.megamenu li .sub-menu .content .static-menu .menu ul li a,
            .responsive ul.megamenu li .sub-menu .content .hover-menu .menu ul li a:hover,
            .responsive ul.megamenu li .sub-menu .content .static-menu .menu ul li a:hover,
            .responsive ul.megamenu li .sub-menu .content .hover-menu .menu ul li.active > a,
            .responsive ul.megamenu li .sub-menu .content .static-menu .menu ul li.active > a {
                background: <?php echo esc_html($fastor_options['color-submenu_background_color']) ?>;
            }

            .responsive ul.megamenu li .sub-menu .content .hover-menu .menu ul li,
            .responsive ul.megamenu li .sub-menu .content .static-menu .menu ul li,
            .responsive ul.megamenu .sub-menu .content .row > div {
                border-top-color: rgba(120,120,120,0.15);
            }
        }

    <?php } ?>


    <?php if($fastor_options['color-box_with_products_background_color'] != '') { ?>
    .box.box-with-products,
    .product-filter,
    .product-list,
    .center-column .product-grid,
    #main .box .box-content.products,
    body #main .post .box.box-with-products .box-content,
    .product-grid .product-hover .only-hover,
    .product-grid-type-2 .product-grid .product:hover:before,
    .product-grid-type-3 .product-grid .product:hover:before,
    .product-grid-type-5 .product-grid .product:hover:before,
    .product-info .product-image  {
        background-color: <?php echo esc_html($fastor_options['color-box_with_products_background_color']) ?> !important; ;
    }
    <?php } ?>




    <?php if($fastor_options['color-box_categories_background_color'] != '') { ?>
    #main .box-with-categories .box-content {
        background: <?php echo esc_html($fastor_options['color-box_categories_background_color']); ?> !important;
    }
    <?php } ?>

    <?php if($fastor_options['color-buttons_color_text'] != '') { ?>
    .button, .btn, input[type="submit"] {
        color: <?php echo esc_html($fastor_options['color-buttons_color_text']); ?> !important;
    }
    <?php } ?>

    <?php if($fastor_options['color-buttons_hover_color_text'] != '') { ?>
    .button:hover, .btn:hover, input[type="submit"]:hover {
        color: <?php echo esc_html($fastor_options['color-buttons_hover_color_text']); ?> !important;
    }
    <?php } ?>

    <?php if($fastor_options['color-second_buttons_color_text'] != '') { ?>
    .buttons .left .button, .buttons .center .button, .btn-default, .input-group-btn .btn-primary {
        color: <?php echo esc_html($fastor_options['color-second_buttons_color_text']); ?> !important;
    }
    <?php } ?>

    <?php if($fastor_options['color-second_buttons_hover_color_text'] != '') { ?>
    .buttons .left .button:hover, .buttons .center .button:hover, .btn-default:hover, .input-group-btn .btn-primary:hover {
        color: <?php echo esc_html($fastor_options['color-second_buttons_color_text']); ?> !important;
    }
    <?php } ?>
    <?php if($fastor_options['color-second_buttons_border_color'] != '') { ?>
    .buttons .left .button, .buttons .center .button, .btn-default, .input-group-btn .btn-primary{
        border: 1px solid <?php echo esc_html($fastor_options['color-second_buttons_border_color']); ?> !important;
    }
    <?php } ?>

    <?php if($fastor_options['color-footer_button_color_text'] != '') { ?>
        .footer-button {
            color: <?php echo esc_html($fastor_options['color-footer_button_color_text']); ?> !important;
        }
    <?php } ?>

    <?php if($fastor_options['color-top_search_input_text_color'] != '') { ?>
        #top .search_form input::-webkit-input-placeholder{
            color: <?php echo esc_html($fastor_options['color-top_search_input_text_color']); ?> !important;
        }
        #top .search_form input:-moz-placeholder{
            color: <?php echo esc_html($fastor_options['color-top_search_input_text_color']); ?> !important;
        }
        #top .search_form input::-moz-placeholder{
            color: <?php echo esc_html($fastor_options['color-top_search_input_text_color']); ?> !important;
        }
        #top .search_form input:-ms-input-placeholder {
            color: <?php echo esc_html($fastor_options['color-top_search_input_text_color']); ?> !important;
        }
    <?php } ?>

    <?php if($fastor_options['color-mobile_menu_content_background_color'] != '') { ?>
        @media (max-width: 991px) {
            .responsive .horizontal .megamenu-wrapper {
                background: <?php echo esc_html($fastor_options['color-mobile_menu_content_background_color']); ?> !important;
            }
        }
    <?php } ?>
    <?php if($fastor_options['color-mobile_menu_content_border_color'] != '') { ?>
        @media (max-width: 991px) {
            .responsive .horizontal .megamenu-wrapper {
                border: 1px solid <?php echo esc_html($fastor_options['color-mobile_menu_content_border_color']); ?> !important;
                border-top: none !important;
            }
        }
    <?php } ?>

    <?php if($fastor_options['color-mobile_menu_content_link_color'] != '') { ?>
        @media (max-width: 991px) {
            .responsive .megamenu-wrapper .megamenu-close-fixed,
            .responsive .horizontal ul.megamenu > li > a{
                color: <?php echo esc_html($fastor_options['color-mobile_menu_content_link_color']); ?> !important;
            }
        }
    <?php } ?>

    <?php if($fastor_options['color-mobile_menu_content_link_border_top_color'] != '') { ?>
        @media (max-width: 991px) {
            .responsive .horizontal ul.megamenu > li{
                border-top-color: <?php echo esc_html($fastor_options['color-mobile_menu_content_link_border_top_color']); ?> ;
            }
        }
    <?php } ?>

    <?php if($fastor_options['color-mobile_menu_content_link_hover_background_color'] != '') { ?>
        @media (max-width: 991px) {
            .responsive ul.megamenu > li:hover,
            .responsive ul.megamenu > li.active{
                background: <?php echo esc_html($fastor_options['color-mobile_menu_content_link_hover_background_color']); ?> !important;
            }
        }
    <?php } ?>

    <?php if($fastor_options['color-mobile_menu_content_plus_minus_color'] != '') { ?>
        @media (max-width: 991px) {
            .responsive ul.megamenu > li.with-sub-menu .open-menu,
            .responsive ul.megamenu > li.with-sub-menu .close-menu{
                color: <?php echo esc_html($fastor_options['color-mobile_menu_content_plus_minus_color']); ?> !important;
            }
        }
    <?php } ?>

    /* FONTS */


    <?php if($fastor_options['font-status']): ?>
        <?php if($fastor_options['font-button']['font-size']) { ?>
        .button, .btn, .footer-button,
        .widget_layered_nav_clear ul a,
        .product-info .cart .add-to-cart #button-cart{
            font-size: <?php echo esc_html($fastor_options['font-button']['font-size']); ?> !important;
        }
        <?php } ?>
    <?php endif; ?>

</style>

<?php if($fastor_options['css-status'] == 1):?>
    <style type="text/css">
        <?php echo str_replace('__child__', '>', (esc_html(str_replace('>', '__child__',$fastor_options['css-value'])))); ?>
    </style>
<?php endif; ?>
