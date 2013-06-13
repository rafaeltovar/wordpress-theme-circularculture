<?php
/**
 * Content Single
 *
 * Loop content in single post template (single.php)
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header>
		<hgroup>
			<h1><?php the_title(); ?></h1>
		</hgroup>
	</header>
	
	<?php the_content(); ?>
	<hr/>
	<div class="row">
		<!-- description -->
		<div class="large-6 columns wdescription">
			<h3><?php _e('Description', 'circularculture' );?></h3>
			<?php echo(types_render_field( "wdescription",  array('output' => 'html'))); ?>
			<?php if ( function_exists( 'the_msls' ) ) the_msls(); ?>
			<hr class="show-for-small"/>
		</div>
		<!-- technical details -->
		<div class="large-6 columns wtdetails">
			<h3><?php _e('Technical details', 'circularculture' );?></h3>
			<?php echo(types_render_field( "wtdetails", array('output' => 'html'))); ?>
		</div>

	<footer>

	</footer>

</article>
