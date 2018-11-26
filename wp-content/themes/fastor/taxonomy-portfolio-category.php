<?php get_header(); ?>

<?php

	if( have_posts() ) : ?>

	<section>

		<!-- Main content start -->

		<?php get_template_part( 'template-parts/portfolio/content-style-1' ); ?>

		<!-- Main content end -->

	</section>

<?php

endif;

get_footer();?>
