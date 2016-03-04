<?php
	/**
	 * 404.php
	 * Error Page in loom
	 * @author TommusRhodus
	 * @package loom
	 * @since 1.0.0
	 */
	get_header();
	
	/**
	 * Get Wrapper Start - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','start'); 
?>

	<div class="whoopsie-daisy-wrapper">
		<h1 class="whoopsie-daisy">
			<small><?php _e('Uh, Oh.','loom'); ?></small>
			<?php _e('404','loom'); ?>
		</h1>
		<a href="<?php echo home_url(); ?>"><?php _e('&larr; Head Home','loom'); ?></a>
	</div>

<?php
	/**
	 * Get Wrapper End - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','end'); 
	
	get_footer();