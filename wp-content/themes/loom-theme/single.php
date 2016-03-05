<?php 
	/**
	 * single.php
	 * The single blog post template in loom
	 * @author TommusRhodus
	 * @package loom
	 * @since 1.0.0
	 */
	get_header();
	the_post();
	
	$format = get_post_format(); 
	if( false === $format ) 
		$format = 'standard';
		
	( is_active_sidebar('primary') && get_post_meta( $post->ID, '_ebor_disable_sidebar', true ) !=='on' ) ? $sidebar = 'col-sm-8' : $sidebar = '';
		
	/**
	 * Get Wrapper Start - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','start'); 
?>
	
	<div class="row">
	
		<div class="<?php echo $sidebar; ?> content">
		
			<div class="classic-blog">
			
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<?php 
						if(!( post_password_required() ))
							get_template_part('postformats/format', $format); 
					?>
					
						<div class="post-content image-caption">
						
							<?php 
								the_title('<h2 class="post-title entry-title">', '</h2>'); 
								get_template_part('loop/content','metasingle');
								the_content();
								wp_link_pages();
							?>
							
							<div class="meta tags"><?php the_tags('', ', ', ''); ?></div>
							
							<div class="divide10"></div>
							
							<div class="pull-left">
								<?php
									if( get_option('blog_social','1') == 1 )
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
							
							<div class="clear"></div>
						
						</div><!--post-content-->
					
					</div><!--post-id-->
				
				<hr />
			
			</div><!--classic blog-->
			
			<?php 
				if( get_option('blog_author','1') == 1 )
					get_template_part('inc/content','author'); 
			
				if( comments_open() ) 
					comments_template(); 
			?>
		
		</div><!--col-sm-8 content-->
		
		<?php 
			if( is_active_sidebar('primary') && get_post_meta( $post->ID, '_ebor_disable_sidebar', true ) !=='on' )
				get_sidebar();
		?>
	
	</div><!--row-->

<?php 
	/**
	 * Get Wrapper End - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','end'); 
	
	get_footer();