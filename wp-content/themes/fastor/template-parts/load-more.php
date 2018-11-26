<?php $fastor_optionValues = get_option( 'fastor' ); ?>
<!-- start load more -->
<div class="portfolio-load-more-wrapper text-center">
	<div class="wl-link-to">
		<span class="wl-direction-left" data-icon=&#x45;></span>
		<a href="javascript:void(0);"  id="portfolio-load-more" data-nomore-label="<?php echo esc_html__( 'No more portfolios', 'fastor' ) ?>" data-loading-label="<?php echo esc_html__( 'Loading', 'fastor' ) ?>">
		<?php
			echo esc_html__( 'load more', 'fastor' );
		?>
		</a>
		<span class="wl-direction-right" data-icon=&#x44;></span>
	</div>
</div>
