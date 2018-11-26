<?php

/**********************/
/* Wordpress Importer */
/**********************/
$plugin = get_template_directory().'/inc/plugins/importer/importer.php';
include $plugin;


/************************************/
/* Include Easy Bootstrap ShortCode */
/************************************/

// Filter for Custom options
function fastor_apply_ebs_custom_option( $prevent ) {
    return true;
}
add_filter( 'ebs_custom_option', 'fastor_apply_ebs_custom_option' );

// Filter for bootstrap.min.js url this filter is only applicable if you selected js inclusion from plugin in EBS Settings
function fastor_apply_ebs_bootstrap_js_url( $url ) {
    $ebs_js_url='';// write your desired bootstrap.min.js url here
    return $ebs_js_url;
}
add_filter( 'ebs_bootstrap_js_url', 'fastor_apply_ebs_bootstrap_js_url' );

// Filter for bootstrap.min.js CDN path this filter is only applicable if you selected js inclusion from CDN in EBS Settings
function fastor_apply_ebs_bootstrap_js_cdn( $url ) {
    $ebs_cdn_url='';// write your bootstrap.min.js cdn path here
    return $ebs_cdn_url;
}
add_filter( 'ebs_bootstrap_js_cdn', 'fastor_apply_ebs_bootstrap_js_cdn' );

// Filter for bootstrap.min.css urlthis filter is only applicable if you selected css inclusion from plugin in EBS Settings
function fastor_apply_ebs_bootstrap_css_url( $url ) {
    $ebs_css_url='';// write your bootstrap.min.css  url here
    return $ebs_css_url;
}
add_filter( 'ebs_bootstrap_css_url', 'fastor_apply_ebs_bootstrap_css_url' );

// Filter for bootstrap-icon.min.css url this filter is only applicable if you selected css inclusion from plugin or theme in EBS Settings
function fastor_apply_ebs_bootstrap_icon_css_url( $url ) {
    $ebs_icon_url='';// write your bootstrap-icon.min.css url here
    return $ebs_icon_url;
}
add_filter( 'ebs_bootstrap_icon_css_url', 'fastor_apply_ebs_bootstrap_icon_css_url' );

// After adding this code user will not be able to change the files location for EBS plugin as user can't see the EBS  Settings link of LHS menu in admin panel
update_option( 'EBS_CUSTOM_OPTION', 1 );
update_option( 'EBS_BOOTSTRAP_JS_LOCATION', 2 );
update_option( 'EBS_BOOTSTRAP_CSS_LOCATION', 2 );

// To give use the custom css for icons
update_option( 'EBS_CUSTOM_BOOTSTRAP_ICON_CSS', 1 );

// To give use the custom css for admin
update_option( 'EBS_CUSTOM_BOOTSTRAP_ADMIN_CSS', 1 );

