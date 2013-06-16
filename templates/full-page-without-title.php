<?php

/*
 * Template Name: Full Page Template withouth title
 */

get_header(); ?>

    <!-- Main Content -->
    <div class="large-12 columns" role="content">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
					
					<?php the_content(); ?>
				
				</article>
			<?php endwhile; ?>
			
		<?php endif; ?>

    </div>
    <!-- End Main Content -->

<?php get_footer(); ?>