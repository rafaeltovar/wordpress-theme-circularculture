<?php // variables
$thum_size = "circularculture-home";
$thum_attr = array(); ?>
	<article class="row <?php post_class(); ?>"> 
		<header class="large-4 small-3 columns">
			<a class="th" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php the_post_thumbnail($thum_size);?>			
			</a>
		</header>
		<section class="large-8 small-9 columns">
			<h4>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
					<?php the_title();?>
				</a>
			</h4>
			<?php the_excerpt(); ?>
		</section>
		<hr />
	</article>
