<?php
	get_header();
	
	$wrapper_styles = '';	
	$lightbox = '';	
	$before = '<div class="divide60"></div>';
	$after = '';
	$type = get_option('portfolio_layout', 'full-portfolio');
	$check = $type;
	
	if( $check == 'fix-portfolio' || $check == 'fix-portfolio lightbox' ){
		 $wrapper_styles = 'col4';
		 $before = '<div class="container inner"><div class="row"><div class="col-sm-12">';
		 $after = '</div></div></div>';
	}
	
	if( $check == 'fix-portfolio-alt' || $check == 'fix-portfolio-alt lightbox' ){
		 $wrapper_styles = 'col3';
		 $before = '<div class="container inner"><div class="row"><div class="col-sm-12">';
		 $after = '</div></div></div>';
		 $type = 'fix-portfolio';
	}
	
	if( $check == 'full-portfolio lightbox' || $check == 'fix-portfolio lightbox' || $check == 'fix-portfolio-alt lightbox' )
		 $lightbox = 'lightbox';
?>
	
	<div class="light-wrapper">
		
		<?php echo $before; ?>
			
			<div class="portfolio <?php echo $type; ?>">
			
				<?php 
					if(!( is_tax() ))
						get_template_part('inc/content','filters'); 
				?>
			  
				<ul class="items <?php echo $wrapper_styles; ?>">
				
					<?php 
						if ( have_posts() ) : while ( have_posts() ) : the_post();
							
							/**
							 * Get blog posts by blog layout.
							 */
							get_template_part('loop/content', 'portfolio' . $lightbox);
						
						endwhile;	
						else : 
							
							/**
							 * Display no posts message if none are found.
							 */
							get_template_part('loop/content','none');
							
						endif;
					?>
				
				</ul>
			  
			</div>
		
		<?php echo $after; ?>
	
	</div>

<?php 
	get_footer();