<?php

	$fastor_terms = get_the_terms( $post->ID, 'portfolio-category' );
	if( $fastor_terms ) {
		foreach( $fastor_terms as $fastor_term ) {
			$fastor_termLink	= get_term_link( $fastor_term->term_id, 'portfolio-category' );?>
			<a href="<?php echo esc_attr($fastor_termLink);?>"><?php echo esc_attr($fastor_term->name);?></a>
<?php   }
    } ?>
