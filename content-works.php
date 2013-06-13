<?php // variables
$thum_size = "circularculture-home";
$thum_attr = array(); ?>
<li class="<?php post_class(); ?>">
	<article class="work-small"> 
		<header>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php the_post_thumbnail($thum_size);?>			
			</a>
		</header>
		<section>
			<h4>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
					<?php the_title();?>
				</a>
			</h4>
			<?php the_excerpt(); ?>
		</section>
	</article>
</li>
