<?php

/**
 * Function To Register Portfolio Post Type
 * 
 *
 */
 $optionValues = get_option( 'fastor' );
 $slug = '';
 $cat_slug = '';
 if( isset( $optionValues[ 'w-portfolio-category-slug' ] ) ) {
	if( !empty( $optionValues[ 'w-portfolio-category-slug' ] ) ){
		$cat_slug = $optionValues[ 'w-portfolio-category-slug' ];
	}else{
		$cat_slug = 'portfolio-category';
	}	
 } else {
	$cat_slug = 'portfolio-category';
 }
 if( isset( $optionValues[ 'w-portfolio-slug' ] ) ) {
	if( !empty( $optionValues[ 'w-portfolio-slug' ] ) ){
		$slug = $optionValues[ 'w-portfolio-slug' ];
	}else{
		$slug = 'w-portfolio';
	}	
 } else {
	$slug = 'w-portfolio';
 }


// Adding Scripts To Admin Pages
add_action( 'admin_enqueue_scripts', 'fastor_plugin_load_scripts', 10 );

function fastor_plugin_load_scripts(){

    $fastor_screen = get_current_screen();

    if( $fastor_screen->post_type == 'portfolio' ){
        // Adding Color Picker Stylesheet
        wp_enqueue_style( 'wp-color-picker' );

        // Including Scripts To Page Editor Page
        wp_register_style( 'w-page-custom-css', FASTOR_PLUGIN_URL . '/content_types/assets/css/page.css' , array(), '1.0.0', 'all' );

        wp_enqueue_style( 'w-page-custom-css' );

        wp_register_script( 'w-portfolio-custom-js', FASTOR_PLUGIN_URL . '/content_types/assets/js/portfolio.js' , array(), '1.0.0', true );
        wp_enqueue_script( 'jquery-ui-datepicker' );

        wp_register_style( 'jquery-ui', FASTOR_PLUGIN_URL . '/content_types/assets/css/jquery-ui.css' , array(), '1.11.4', 'all' );
        wp_enqueue_style( 'jquery-ui' );

        // Localizing Scripts
        wp_localize_script( 'w-portfolio-custom-js', 'w_header_image', array(
            'title'     => esc_html__( 'Choose or Upload an Image', 'fastor' ),
            'button'    => esc_html__( 'Use This Image', 'fastor' )
        ));

        wp_enqueue_script( 'w-portfolio-custom-js' );
    }else if( $fastor_screen->post_type == 'page' ){
        wp_register_style( 'w-plugin-shortcode-custom-css', FASTOR_PLUGIN_URL . '/shortcodes/assets/css/ws-vc.css' , array(), '1.0.0', 'all' );
        wp_enqueue_style( 'w-plugin-shortcode-custom-css' );

        // Including Scripts To Page Editor Page
        wp_register_style( 'w-page-custom-css', FASTOR_PLUGIN_URL . '/content_types/assets/css/page.css' , array(), '1.0.0', 'all' );
        wp_enqueue_style( 'w-page-custom-css' );

    } else if( $fastor_screen->post_type == 'album' ) {
        wp_register_script( 'w-album-custom-js', FASTOR_PLUGIN_URL . '/content_types/assets/js/album.js' , array(), '1.0.0', true );
        // Localizing Scripts
        wp_localize_script( 'w-album-custom-js', 'w_header_image', array(
            'title'     => esc_html__( 'Choose or Upload an Image', 'fastor' ),
            'button'    => esc_html__( 'Use This Image', 'fastor' )
        ));
        wp_enqueue_script( 'w-album-custom-js' );
        // Including Scripts To Page Editor Page
        wp_register_style( 'w-page-custom-css', FASTOR_PLUGIN_URL . '/content_types/assets/css/page.css' , array(), '1.0.0', 'all' );
        wp_enqueue_style( 'w-page-custom-css' );
    }
}
 
 function wCustomPortfolioTaxonomy( $cat_slug ){
    $labels = array(
                'name'              => _x( 'Portfolio Category', 'taxonomy general name', 'fastor' ),
                'singular_name'     => _x( 'Portfolio Category', 'taxonomy singular name', 'fastor' ),
                'search_items'      => esc_html__( 'Search Portfolio', 'fastor' ),
                'all_items'         => esc_html__( 'All Portfolio', 'fastor' ),
                'parent_item'       => esc_html__( 'Parent Portfolio Category', 'fastor' ),
                'parent_item_colon' => esc_html__( 'Parent Portfolio Category:', 'fastor' ),
                'edit_item'         => esc_html__( 'Edit Portfolio Category', 'fastor' ),
                'update_item'       => esc_html__( 'Update Portfolio Category', 'fastor' ),
                'add_new_item'      => esc_html__( 'Add New Portfolio Category', 'fastor' ),
                'new_item_name'     => esc_html__( 'New Portfolio Category Name', 'fastor' ),
                'menu_name'         => esc_html__( 'Portfolio Category', 'fastor' ),
            );

    $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => $cat_slug ),
            );

    register_taxonomy( 'portfolio-category', array( 'portfolio' ), $args );
}

function wPortfolioPost( $slug ){
    $portfolioLabels = array(
        'name'               => _x( 'Portfolio', 'post type general name', 'fastor' ),
        'singular_name'      => _x( 'Portfolio Category', 'post type singular name', 'fastor' ),
        'menu_name'          => _x( 'Portfolio', 'admin menu', 'fastor' ),
        'name_admin_bar'     => _x( 'Portfolio', 'add new on admin bar', 'fastor' ),
        'add_new'            => _x( 'New Portfolio', 'portfolio', 'fastor' ),
        'add_new_item'       => esc_html__( 'Add New Portfolio', 'fastor' ),
        'new_item'           => esc_html__( 'New Portfolio', 'fastor' ),
        'edit_item'          => esc_html__( 'Edit Portfolio', 'fastor' ),
        'view_item'          => esc_html__( 'View Portfolio', 'fastor' ),
        'all_items'          => esc_html__( 'All Portfolios', 'fastor' ),
        'search_items'       => esc_html__( 'Search Portfolios', 'fastor' ),
        'parent_item_colon'  => esc_html__( 'Parent Portfolio:', 'fastor' ),
        'not_found'          => esc_html__( 'No portfolios found.', 'fastor' ),
        'not_found_in_trash' => esc_html__( 'No portfolios found in Trash.', 'fastor' )
    );

    $portfolioArgs  = array(
        'labels'             => $portfolioLabels,
        'description'        => esc_html__( 'Description.', 'fastor' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => array( 'slug' => $slug ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'taxonomies'         => array( 'portfolio-category' ),
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt')
    );

    register_post_type( 'portfolio', $portfolioArgs );
}

add_filter( 'post_updated_messages', 'portfolio_updated_messages' );
/**
 * Portfolio update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function portfolio_updated_messages( $messages ) {
    $post             = get_post();
    $post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );

    $messages['portfolio'] = array(
            0  => '', // Unused. Messages start at index 1.
            1  => esc_html__( 'Portfolio Post updated.', 'fastor' ),
            2  => esc_html__( 'Portfolio Post updated.', 'fastor' ),
            3  => esc_html__( 'Portfolio Post deleted.', 'fastor' ),
            4  => esc_html__( 'Portfolio Post updated.', 'fastor' ),
            5  => isset( $_GET['revision'] ) ? sprintf( esc_html__( 'Portfolio restored to revision from %s', 'fastor' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6  => esc_html__( 'Portfolio Post published.', 'fastor' ),
            7  => esc_html__( 'Portfolio Post saved.', 'fastor' ),
            8  => esc_html__( 'Portfolio Post submitted.', 'fastor' ),
            9  => sprintf(
                esc_html__( 'Portfolio Post scheduled for: <strong>%1$s</strong>.', 'fastor' ),
                    date_i18n( esc_html__( 'M j, Y @ G:i', 'fastor' ), strtotime( $post->post_date ) )
            ),
            10 => esc_html__( 'Portfolio Post draft updated.', 'fastor' )
    );

    if ( $post_type_object->publicly_queryable ) {
		$screen	= get_current_screen();
		if( $screen->post_type == 'portfolio' ){
			$permalink = get_permalink( $post->ID );
		
			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), esc_html__( 'View Portfolio Post', 'fastor' ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), esc_html__( 'Preview Portfolio Post', 'fastor' ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}
    }

    return $messages;
}
wCustomPortfolioTaxonomy( $cat_slug );
wPortfolioPost( $slug );