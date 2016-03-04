<?php 
	/**
	 * footer.php
	 * The footer used in loom
	 * @author TommusRhodus
	 * @package loom
	 * @since 1.0.0
	 */
	
	/**
	 * Define chosen footer style
	 */
	$footer = get_option('footer_layout', 'multiwidget');
	
	if( isset($post->ID) ){
		( get_post_meta($post->ID, '_ebor_single_footer', 1) ) ? $footer = 'singlewidget' : $footer = get_option('footer_layout', 'multiwidget');
	}
	
	/**
	 * Get chosen footer style
	 */
	get_footer( $footer );
?>
  
</div><!-- /.body-wrapper --> 

<?php 
	if( get_option('slideout_shortcode') )
		get_template_part('inc/content','slideout'); 
		
	wp_footer();
?>

</body>
</html>