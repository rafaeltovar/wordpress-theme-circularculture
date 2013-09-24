<?php get_header(); ?>

    <!-- Main Content -->
    <div class="large-9 columns" role="main">
    <?php
 	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
 	if($paged==1)
 		$paged = (get_query_var('page')) ? get_query_var('page') : 1;
	
	$args = array(
	    'post_type' => 'work', 
		'caller_get_posts' => 1, 
		'posts_per_page' => 12,
		'paged' => $paged
	);
		
	query_posts($args);
	
	if ( have_posts() ) : ?>

		<ul class="grid small-block-grid-2 large-block-grid-4">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'works' ); ?>
			<?php endwhile; ?>
		</ul>
		
		<?php  circularculture_pagination(); ?>
	<?php else : ?>
		<h2><?php _e('No posts.', 'circularculture' ); ?></h2>
		<p class="lead"><?php _e('Sorry about this, I couldn\'t seem to find what you were looking for. :(', 'circularculture' ); ?></p>
	<?php endif; ?>
	
    </div>
    <!-- End Main Content -->

<?php get_sidebar('works'); ?>
<?php get_footer(); ?>