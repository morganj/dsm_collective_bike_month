<?php
	/**
	 * search.php
	 * The searched post loop in loom
	 * @author TommusRhodus
	 * @package loom
	 * @since 1.0.0
	 */
	get_header();
	
	global $wp_query;
	$total_results = $wp_query->found_posts;
	( $total_results == '1' ) ? $items = __('Item','loom') : $items = __('Items','loom'); 
	
	/**
	 * Get Wrapper Start - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','start');
?>

	<h2>
		<?php 
			echo sprintf( __('Your Search For','loom') . ': <em>%s</em>, ' . __( 'returned:', 'loom' ) . ' <em>%s %s</em> ', get_search_query(), $total_results, $items);
		?>
	</h2>
	
	<hr />
	 
<?php
	/**
	 * Get the blog layout
	 */
	get_template_part('loop/loop', get_option('blog_layout','blog') ); 

	/**
	 * Get Wrapper End - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','end'); 
	
	get_footer();