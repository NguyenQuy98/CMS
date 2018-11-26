<?php $fastor_metaData	= get_post_meta( $post->ID, '', false );  ?>
<div class="row">
	<div class="col-md-4 meta-wrapper">
		<div class="meta-desc">
			<?php the_content(); ?>
		</div>
		<?php if( isset( $fastor_metaData['w-portfolio-project-date'] ) ) {?>
		<div class="meta meta-table meta-date">
			<div class="meta-label"><?php esc_html_e( 'Project Date', 'fastor' ); ?>:</div>
			<div class="meta-value">
				<?php echo esc_attr( $fastor_metaData['w-portfolio-project-date'][0] ); ?>
			</div>
		</div>
		<?php }?>
		<?php if( isset( $fastor_metaData['w-portfolio-project-client'] ) ) {?>
		<div class="meta meta-table meta-client">
			<div class="meta-label"><?php esc_html_e( 'Author', 'fastor' ); ?>:</div>
			<div class="meta-value">
				<?php echo esc_attr( $fastor_metaData['w-portfolio-project-client'][0] ); ?>
			</div>
		</div>
		<?php }?>
		<div class="meta meta-table meta-category">
			<div class="meta-label"><?php esc_html_e( 'Category', 'fastor' ); ?>:</div>
			<div class="meta-value">
				<?php

				$fastor_category = get_the_terms( $post->ID , 'portfolio-category' );
				$fastor_terms = '';
				for( $fastor_count = 0 ; $fastor_count < count( $fastor_category ) ; $fastor_count++ ) {
					$fastor_terms .= $fastor_category[ $fastor_count ]->slug . ' ';
				}

				if( $fastor_terms ) {

					for( $fastor_count = 0 ; $fastor_count < count( $fastor_category ) ; $fastor_count++ ) {
						if( $fastor_count != ( count( $fastor_category ) - 1 ) ) {
							?>
							<a href="<?php echo get_term_link( $fastor_category[ $fastor_count ]->term_id , 'portfolio-category' ) ?>"><?php echo esc_attr( $fastor_category[ $fastor_count ]->name ) . ', '; ?></a>
						<?php
						} else {
							?>
							<a href="<?php echo get_term_link( $fastor_category[ $fastor_count ]->term_id , 'portfolio-category' ) ?>"><?php echo esc_attr( $fastor_category[ $fastor_count ]->name ); ?></a>
						<?php
						}
					}

				} ?>

			</div>
		</div>
		<?php if( isset( $fastor_metaData['w-portfolio-project-link'] ) ){ ?>
		<div class="meta-link">
				<a href="<?php echo esc_url( $fastor_metaData['w-portfolio-project-link'][0] ); ?>" class="btn btn-black">
					<?php esc_html_e( 'View the project', 'fastor' ); ?>
				</a>
		</div>
		<?php }?>
	</div>


	<div class="col-md-8">

		<?php if( isset( $fastor_metaData['w-portfolio-images'] ) ) { ?>

			<!-- portfolio main content start -->

			<?php $fastor_images = unserialize( $fastor_metaData['w-portfolio-images'][0] ); ?>
				<div class="cbp cbp-l-grid-mosaic portfolio-wrapper">
					<div class="portfolio-slick">
						<?php $fastor_counts = 0; foreach( $fastor_images as $fastor_image ) : ?>
							<?php $fancy = wp_get_attachment_image_src( $fastor_image, 'large' ); ?>
							<a href="<?php echo $fancy[0] ?>" rel="prettyPhoto[portfolio-gallery]" class="slick-item wrapper-padding" style="background-image: url(<?php echo esc_url( $fancy[0] ); ?>)">
							</a>
						<?php endforeach; ?>
					</div>
					<div class="portfolio-slick-nav" data-prev-text="<?php esc_html_e( 'Prev', 'fastor' ); ?>" data-next-text="<?php esc_html_e( 'Next', 'fastor' ); ?>">
						 <?php foreach( $fastor_images as $fastor_image ) : ?>
							<div class="slick-nav-item">
								<?php $thumb = wp_get_attachment_image_src( $fastor_image, 'thumbnail' ); ?>
								<img src="<?php echo esc_url( $thumb[0] ); ?>" />
							</div>
						<?php endforeach; ?>
					</div>
				</div>

			<!-- portfolio main content end -->

		<?php } ?>
	</div>
</div>
