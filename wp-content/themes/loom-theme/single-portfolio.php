<?php
	get_header();
	the_post();
		
	$layout = get_post_meta( $post->ID, '_ebor_layout_checkbox', true );
	if( $layout == '-1' || $layout == 'on' )
		$layout == 'full';
			
	/**
	 * Get Wrapper Start - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','start'); 
?>
    
	<div class="page-title">
	
		<div class="pull-left">
			<?php 
				if( get_option('portfolio_share','1') == 1 )
					get_template_part('inc/content','sharing'); 
			?>
		</div>
		
		<div class="navigation pull-right"> 
			<?php
				previous_post_link('%link', "<i class='icon-left-open'></i>" );
				echo ' ';
				next_post_link('%link', "<i class='icon-right-open'></i>" ); 
			?>
		</div>
	
	</div>
	 
<?php 
	/**
	 * Get the layout of this post depending on post meta
	 */
	get_template_part('inc/content', 'portfolio' . $layout);
	
	/**
	 * Get the related portfolio posts for this
	 */
	if( get_option('portfolio_related', '1') == '1' )
		get_template_part('loop/loop','related');

	/**
	 * Get Wrapper End - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','end'); 
	
	get_footer();