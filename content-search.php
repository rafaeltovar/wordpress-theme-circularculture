<li> <!-- item -->
	<article class="row">
	<div class="small-2 large-2 columns">
		<a class="th radius" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
			<?php the_post_thumbnail("circularculture-home");?>
		</a>
	</div>
	<div class="small-10 large-10 columns">
		<a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><h2> <?php the_title();?></h2></a>
		<?php if(function_exists( 'circularculture_get_the_excerpt' )) echo circularculture_get_the_excerpt(10); ?>
	</div>
	</article>
	<hr/>
</li> <!-- end item -->