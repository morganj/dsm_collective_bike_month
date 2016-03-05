<?php
	/*
	Template Name: Page Builder Full-Width
	*/
	
	/**
	 * page_builder_full.php
	 * The page builder template for loom
	 * @author TommusRhodus
	 * @package loom
	 * @since 1.0.0
	 */
	get_header();
	the_post();
?>
	
	<div class="post-content">
		<?php the_content(); ?>
	</div>
	
<?php
	get_footer();