<?php
	/**
	 * page.php
	 * The main post loop in loom
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

	<div class="post-content">
		<?php 
			the_title('<h2 class="post-title entry-title">', '</h2>');
			the_content(); 
		?>
	</div>

<?php
	/**
	 * Get Wrapper End - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','end'); 
	
	get_footer();



	