<?php
/* Adding Metabox For Portfolio Pages */
add_action( 'add_meta_boxes', 'fastor_portfolioMetaBoxes' );

/* Saving Post Data */
add_action( 'save_post', 'fastor_savePortfolioData' );

/**
 * Function To Load Portfolio MetaBoxes
 *
 */

function fastor_portfolioMetaBoxes() {
    add_meta_box(
            'w-portfolio-header',
            esc_html__( 'Portfolio Meta Data', 'fastor' ),
            'fastor_portfolioHeaderMetabox',
            'portfolio',
            'normal',
            'high'
        );
}

/**
 * Function Defining Portfolio Header Metaboxes
 * 
 *
 */

function fastor_portfolioHeaderMetabox() {
    global $post_id;
    wp_nonce_field( 'w-portfolio-header-options', 'w-portfolio-header-nonce' );

    // Getting Previously Saved Values
    $fastor_values             = get_post_custom( $post_id );
    
    $fastor_projectDate        = isset( $fastor_values['w-portfolio-project-date'][0] ) ? esc_attr( $fastor_values['w-portfolio-project-date'][0] ) : '';
    $fastor_projectClient      = isset( $fastor_values['w-portfolio-project-client'][0] ) ? esc_attr( $fastor_values['w-portfolio-project-client'][0] ) : '';
    $fastor_projectLink        = isset( $fastor_values['w-portfolio-project-link'][0] ) ? esc_attr( $fastor_values['w-portfolio-project-link'][0] ) : '';
    $fastor_portfolioImages    = isset( $fastor_values['w-portfolio-images'][0] ) ? unserialize( $fastor_values['w-portfolio-images'][0] ) : '';
    $fastor_portfolioStyle     = isset( $fastor_values['w-single-portfolio-style'][0] ) ? esc_attr( $fastor_values['w-single-portfolio-style'][0] ) : '';
        
    ?>
	
    <!-- Portfolio Project Date -->
    <div class="w-header-meta">
        <label for="w-portfolio-project-date"><?php esc_html_e( 'Portfolio Project Date', 'fastor' ) ?></label>
        <input type="date" name="w-portfolio-project-date" id="w-portfolio-project-date" value="<?php echo esc_attr($fastor_projectDate); ?>" />
    </div>
	
    <!-- Portfolio Project Client -->
    <div class="w-header-meta">
        <label for="w-portfolio-project-client"><?php esc_html_e( 'Portfolio Project Client', 'fastor' ) ?></label>
        <input type="textarea" name="w-portfolio-project-client" id="w-portfolio-project-client" value="<?php echo esc_attr($fastor_projectClient); ?>" />
    </div>
	
    <!-- Portfolio Project Link -->
    <div class="w-header-meta">
        <label for="w-portfolio-project-link"><?php esc_html_e( 'Portfolio Project Link', 'fastor' ) ?></label>
        <input type="textarea" name="w-portfolio-project-link" id="w-portfolio-project-link" value="<?php echo esc_attr($fastor_projectLink); ?>" />
    </div>

    <!-- Multiple Image Uploader -->
    <div class="w-header-meta">
        <label for="w-portfolio-images"><?php esc_html_e( 'Upload Portfolio Image', 'fastor' ) ?></label>
        <div id="w-portfolio-images" class="w-header-img-meta">
            <div id="w-portfolio-images-wrapper">
                <?php
                if( $fastor_portfolioImages ){
                    foreach( $fastor_portfolioImages as $fastor_images ){ ?>
						<small class="w-test">
						<span id="<?php echo esc_attr($fastor_images); ?>" class="w-delete w-delete-image" onclick="deleteImage( this )" ></span>
                        <input type="text" name="w-portfolio-images[]" id="w-portfolio-images" class="<?php echo esc_attr($fastor_images); ?>" value="<?php echo esc_attr($fastor_images); ?>" style="display: none;" />
                        <img class="w-page-header-image-loader <?php echo esc_attr($fastor_images); ?>" onmouseover="showClose(this)" onmouseout="hideClose( this )" value="<?php echo esc_attr($fastor_images); ?>" src="<?php echo wp_get_attachment_url( $fastor_images );?>" />
						</small>
                        <?php
                    }
                }
                ?> 
				<div class="w-clearfix"></div>
            </div>
            <input class="button" id="w-portfolio-image-uploader-button" type="button" value="<?php esc_html_e( 'Choose Or Upload An Image', 'fastor' )?>" />
        </div>
    </div>
    
    <!-- Select Portfolio Style -->
    <div class="w-header-meta">
        <label for="w-single-portfolio-style"><?php esc_html_e( 'Select Portfolio Style', 'fastor' ); ?></label>
        <select id="w-single-portfolio-style" name="w-single-portfolio-style">
            <option value="1" <?php selected( $fastor_portfolioStyle, '1' );?>><?php esc_html_e( '1', 'fastor' ); ?></option>
        </select>
    </div>
<?php
}

/**
 * Function to save user data
 * 
 * @param integer $post_id Current Post ID
 * 
 * @return
 */
function fastor_savePortfolioData( $post_id ){
    // Bail if doing auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    
    // Check for valib nonce
    if( !isset( $_POST['w-portfolio-header-nonce'] ) || !wp_verify_nonce( $_POST['w-portfolio-header-nonce'], 'w-portfolio-header-options' ) ) return;
    
    // If current user can't edit this post
    if( !current_user_can( 'edit_posts' ) ) return;
    // Saving portfolio meta data
    
    // Enable Disable portfolio Header
    $fastor_checkbox   = isset( $_POST['w-portfolio-header-checkbox'] ) ? 'on' : 'off';
    update_post_meta( $post_id, 'w-portfolio-header-checkbox', $fastor_checkbox );
    
    	
    // Portfolio Project Date
    if( isset( $_POST['w-portfolio-project-date'] ) )
        update_post_meta( $post_id, 'w-portfolio-project-date', $_POST['w-portfolio-project-date'] );
	
    // Portfolio Project Client
    if( isset( $_POST['w-portfolio-project-client'] ) )
        update_post_meta( $post_id, 'w-portfolio-project-client', $_POST['w-portfolio-project-client'] );
	
    // Portfolio Project Link
    if( isset( $_POST['w-portfolio-project-link'] ) )
        update_post_meta( $post_id, 'w-portfolio-project-link', $_POST['w-portfolio-project-link'] );
    
    /* For Multiple Image Uploader  */
    $fastor_images = array();
    if( isset( $_POST['w-portfolio-images'] ) ){
        foreach( $_POST['w-portfolio-images'] as $fastor_image ){
            $fastor_images['url'][]   = $fastor_image;
        }
        update_post_meta( $post_id, 'w-portfolio-images', $fastor_images['url'] );
    }else{
    	$fastor_images['url']	= '';
        delete_post_meta( $post_id, 'w-portfolio-images', $fastor_images['url'] );
    }
    
    // Single Portfolio Style
    if( isset( $_POST['w-single-portfolio-style'] ) )
        update_post_meta( $post_id, 'w-single-portfolio-style', $_POST['w-single-portfolio-style'] );
}