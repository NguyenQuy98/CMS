jQuery( document ).ready( function( $ ){
    
    /* Date Picker */
    jQuery( '#w-portfolio-project-date' ).datepicker();
    
    /* Multiple Image Uploader */
    // Uploading files
    var file_frame;

    jQuery('#w-portfolio-image-uploader-button').live('click', function( event ){

        event.preventDefault();

        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: jQuery( this ).data( 'uploader_title' ),
            button: {
                text: jQuery( this ).data( 'uploader_button_text' ),
            },
            multiple: true  // Set to true to allow multiple files to be selected
        });

        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            var selection = file_frame.state().get('selection');
            //jQuery( '#w-portfolio-images-wrapper' ).empty();
            selection.map( function( attachment ) {

                attachment = attachment.toJSON();
                
                // Adding Input Field Having Image Url
                jQuery( '<span onclick="deleteImageUp( this )" >' ).attr({                                                           
                    id: attachment.id,
                    class: 'w-delete w-showHide'
                }).appendTo( '#w-portfolio-images-wrapper' );
                jQuery( '<input>' ).attr({
                    type: 'hidden',
                    id  : 'w-portfolio-images',
                    name: 'w-portfolio-images[]',
                    value: attachment.id,
					class: attachment.id
                }).appendTo( '#w-portfolio-images-wrapper' );
                jQuery( '<img onmouseover="showClose(this)" onmouseout="hideClose( this )">' ).attr({
                    class: 'w-page-header-image-loader' + ' ' + attachment.id,
                    src  : attachment.url,
					value: attachment.id,
                }).appendTo( '#w-portfolio-images-wrapper' );				
                // Do something with attachment.id and/or attachment.url here
            });
        });

        // Finally, open the modal
        file_frame.open();
    });
	
	/* Portfolio Image Close
	-------------------------*/
	
	
});

function showClose ( e ) {
    var eachID = e.value;
    jQuery( '#'+eachID ).css( 'visibility', 'visible' );
}
function hideClose( e ) {
    var eachID = e.value;
    jQuery( '#'+eachID ).css( 'visibility', 'hidden' );
}
function deleteImage( e ) {
   var eachID = e.id;
    //jQuery('.'+eachID ).remove();
    //jQuery( '#'+eachID ).css( 'display', 'none' );
    jQuery( '.'+eachID ).parent( '.w-test' ).remove();
}
jQuery(document).on("mouseover", ".w-delete", function() {
    jQuery( this ).css( 'visibility', 'visible' );		 
});
jQuery(document).on("mouseout", ".w-delete", function() {
    jQuery( this ).css( 'visibility', 'hidden' );		 
});
function deleteImageUp( e ) {
   var eachID = e.id;
    jQuery('.'+eachID ).remove();
    jQuery( '#'+eachID ).css( 'display', 'none' );
}