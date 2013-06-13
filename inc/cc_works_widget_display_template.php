<?php echo $before_widget; ?>

<?php if($title) echo $before_title . $title . $after_title; ?>

<?php if (have_posts()): ?>
		<ul class="works-list large-block-grid-1">
		<?php while ( have_posts() ) : the_post(); ?>
			<li <?php echo ($current == get_the_ID()? 'class="active"': ''); ?>>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><span><?php the_title();?></span></a>
			</li>
		<?php endwhile; ?>
		</ul>		
<?php endif; ?>

<?php echo $after_widget; ?>