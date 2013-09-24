<?php
/**
 * Content Single
 *
 * Loop content in single post template (single.php)
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 4.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header>
		<hgroup>
			<h5><?php the_category(', '); ?></h5>
			<h1><?php the_title(); ?></h1>
			<?php if( function_exists('do_sociable')): ?>
			<!--<div class="right"> -->
				<?php do_sociable(); ?>				
			<!-- </div> -->
			<?php endif; ?>
		</hgroup>
	</header>
	
	<?php the_content(); ?>
	
	<?php if ( function_exists( 'the_msls' ) ): ?><p><?php the_msls(); ?></p><?php endif; ?>

	<footer>
		<div class="meta panel radius">
			<p>
				<i class="icon-info-sign"></i> <?php _e('Written by', 'circularculture'); ?> <?php the_author_link(); ?> <?php _e('on', 'circularculture'); ?> <?php the_time(get_option('date_format')); ?>
			 <? if (comments_open()) : ?>
			 | <a href="<?php the_permalink(); ?>#comments"><i class="icon-comments-alt"></i> <?php echo get_comments_number(); ?></a>
			 <?php endif; ?>
			 <?php the_tags('<br/><i class="icon-tags"></i> <span class="radius secondary label">','</span> <span class="radius secondary label">','</span>'); ?>
			 </p>
		</div>

		<?php //get_template_part('author-box'); ?>
		<?php comments_template(); ?>

	</footer>

</article>
