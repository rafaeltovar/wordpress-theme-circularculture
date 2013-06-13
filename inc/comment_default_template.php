<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<article class="comment" id="comment-<?php comment_ID(); ?>">
		<header>
			<p><i class="icon-comment icon-3x pull-left"></i>
				<i class="icon-user"></i> <?php echo get_comment_author_link(); ?><br/>
				<i class="icon-calendar"></i> <?php echo get_comment_date(); ?>
			</p>		
		</header>

		<?php if ( '0' == $comment->comment_approved ) : ?>
			<p><?php _e( 'Your comment is awaiting moderation.', 'circularculture' ); ?></p>
		<?php endif; ?>

		<section>
			<?php comment_text(); ?>
		</section><!-- .comment-content -->

		<!-- <div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'circularculture' ), 'after' => ' &darr; <br><br>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div> -->
		<hr/>
	</article>
</li>