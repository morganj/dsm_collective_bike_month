<?php
	/*
	Template Name: Page Builder
	*/
	
	/**
	 * page_builder.php
	 * The page builder template for loom
	 * @author TommusRhodus
	 * @package loom
	 * @since 1.0.0
	 */
	get_header();
	the_post();
	
	/**
	 * Get Wrapper Start - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','start'); 
?>
	
	<div class="row post-content">
	
		<?php the_content(); ?>
	
	</div>
	
<?php
	/**
	 * Get Wrapper End - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','end'); 
	
	get_footer();