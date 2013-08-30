<?php get_header(); ?>

<!-- Row for main content area -->
	<div class="row">
		<div class="small-8 large-centered columns">
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<header>
					<h1 class="entry-title"><?php _e('Error 404', 'circularculture'); ?></h1>
					<h3 class="entry-title"><?php _e('Address not found :(', 'circularculture'); ?></h3>
				</header>
				<p class="bottom"><?php _e('The page you are looking for does not exist, has been deleted or changed direction..', 'circularculture'); ?></p>
				<p><?php printf(__('Return to <a href="%s">main page</a>', 'circularculture'), home_url()); ?></p>
				
			</article>
		</div>
	</div>
<?php // get_footer(); ?>