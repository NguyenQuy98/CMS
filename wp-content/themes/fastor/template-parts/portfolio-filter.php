
<!-- filter nav start -->
<div class="row portfolio-filters">
	<ul id="<?php echo esc_attr($fastor_portfolioFilterId); ?>" class="cbp-l-filters-button">
		<li data-filter="*" class="selected cbp-filter-item">
			<?php echo esc_html__( 'All', 'fastor' ); ?> <div class="cbp-filter-counter"></div>
		</li>
		<?php
			$profolio_post = array(
				'type'=> 'portfolio',
				'taxonomy'=> 'portfolio-category'
			);
			 $fastor_categories = get_categories($profolio_post);
		?>
		 <?php foreach($fastor_categories as $fastor_category):?>
			<li data-filter=".<?php echo esc_attr($fastor_category->slug); ?>" class="cbp-filter-item">
				<?php echo esc_attr($fastor_category->name) .' '; ?>
			</li>
		<?php endforeach;?>
	</ul>
</div>
<!-- filter nav end -->
