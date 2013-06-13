<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy 
 */

get_header();

if (have_posts() ): ?>
<div class="large-9 columns" role="main">	
		<h4><?php
		if ( is_day() ) {
			printf( __( 'Daily Archives: %s', 'circularculture' ), '<span>' . get_the_date() . '</span>' );
		} elseif ( is_month() ) {
			printf( __( 'Monthly Archives: %s', 'circularculture' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'circularculture' ) ) . '</span>' );
		} elseif ( is_year() ) {
			printf( __( 'Yearly Archives: %s', 'circularculture' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'circularculture' ) ) . '</span>' );
		} elseif ( is_tag() ) {
			printf( __( '%s', 'circularculture' ), '<span>' . single_tag_title( '', false ) . '</span>' );
					// Show an optional tag description
			$tag_description = tag_description();
			if ( $tag_description )
				echo apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );
		} elseif ( is_category() ) {
			printf( __( '%s', 'circularculture' ), '<span>' . single_cat_title( '', false ) . '</span>' );
					// Show an optional category description
			$category_description = category_description();
			if ( $category_description )
				echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
		} else {
			_e( 'Hemeroteca', 'circularculture' );
		}
		?></h4>
		<hr />
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'archive' ); ?>
		<?php endwhile; ?>
		
	<!-- pagination -->
	<div class="pagination-centered">
		<?php circularculture_pagination(); ?>
	</div>
<?php endif; ?>	
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>