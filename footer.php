</div>
<!-- End Page -->


<div class="row">
	<hr />
	<div class="large-12 columns">
	<!-- Footer -->
	<footer>
		<div id="footer" class="row">

		<?php if ( dynamic_sidebar('Sidebar Footer')) : else : ?>
		
		<div class="large-12 columns">
			<ul class="inline-list">
			<?php wp_list_pages('title_li='); ?>
			</ul>
		</div>
		
		<?php endif; ?>
		</div>
	</footer>
	</div>
<!-- End Footer -->
</div>

<?php wp_footer(); ?>

</body>
</html>