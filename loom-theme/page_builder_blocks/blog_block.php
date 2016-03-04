<?php

class AQ_Blog_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Blog Feed',
			'size' => 'span12',
			'resizable' => 0,
			'block_description' => 'Add a feed of<br />blog posts to the page.'
		);
		parent::__construct('aq_blog_block', $block_options);
	}//end construct
	
	function form($instance) {
		$defaults = array(
			'pppage' => '6',
			'filter' => 'all',
			'type' => 'blog'
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$args = array(
			'orderby'                  => 'name',
			'hide_empty'               => 0,
			'hierarchical'             => 1,
			'taxonomy'                 => 'category'
		); 
			
		$filter_options = get_categories( $args );
		
		$blog_types = array(
			'blog' => 'Grid Blog',
			'blogsidebar' => 'Grid Blog & Sidebar',
			'blogclassic' => 'Classic Blog Feed'
		);
	?>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('type') ?>">
				Blog Style
				<?php echo aq_field_select('type', $block_id, $blog_types, $type) ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('pppage') ?>">
				Posts Per Page
				<?php echo aq_field_input('pppage', $block_id, $pppage, $size = 'full', $type = 'number') ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('filter') ?>">
				Show posts from a specific category?<br />
				<?php echo ebor_portfolio_field_select('filter', $block_id, $filter_options, $filter) ?>
			</label>
		</p>
		
	<?php
	}//end form
	
	function block($instance) {
		extract($instance);
		
		// Fix for pagination
		if( is_front_page() ) { 
			$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; 
		} else { 
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; 
		}
		
		/**
		 * Setup post query
		 */
		$query_args = array(
			'post_type' => 'post',
			'posts_per_page' => $pppage,
			'paged' => $paged
		);
		
		/**
		 * Set up category query if needed
		 */
		if (!( $filter == 'all' )) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'id',
					'terms' => $filter
				)
			);
		}
	
		$blog_query = new WP_Query( $query_args );
	?>
	
		<?php if( $type == 'blog' ) : ?>
		
			<div class="grid-blog col3">
			
				<?php 
					if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
						
						/**
						 * Get blog posts by blog layout.
						 */
						get_template_part('loop/content', 'post');
					
					endwhile;	
					else : 
						
						/**
						 * Display no posts message if none are found.
						 */
						get_template_part('loop/content','none');
						
					endif;
				?>
			
			</div>
			
			<?php
				
				/**
				 * Post pagination, use ebor_pagination() first and fall back to default
				 */
				echo function_exists('ebor_pagination') ? ebor_pagination($blog_query->max_num_pages) : posts_nav_link();
				wp_reset_query();
			?>
			
		<?php elseif( $type == 'blogsidebar' ) : ?>
		
			<div class="row">
			
				<div class="col-sm-8 content">
				
					<div class="grid-blog col2">
					
						<?php 
							if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
								
								/**
								 * Get blog posts by blog layout.
								 */
								get_template_part('loop/content', 'post');
							
							endwhile;	
							else : 
								
								/**
								 * Display no posts message if none are found.
								 */
								get_template_part('loop/content','none');
								
							endif;
						?>
					
					</div>
					
					<?php
						/**
						 * Post pagination, use ebor_pagination() first and fall back to default
						 */
						echo function_exists('ebor_pagination') ? ebor_pagination($blog_query->max_num_pages) : posts_nav_link();
						wp_reset_query();
					?>
				
				</div>
				
				<?php get_sidebar(); ?>
			
			</div>
			
		<?php else : ?>
		
			<div class="row">
			
				<div class="col-sm-8 content">
				  <div class="classic-blog">
				  
				    <?php 
				    	if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
				    		
				    		/**
				    		 * Get blog posts by blog layout.
				    		 */
				    		get_template_part('loop/content', 'postclassic');
				    	
				    	endwhile;	
				    	else : 
				    		
				    		/**
				    		 * Display no posts message if none are found.
				    		 */
				    		get_template_part('loop/content','none');
				    		
				    	endif;
				    	
				    	/**
				    	 * Post pagination, use ebor_pagination() first and fall back to default
				    	 */
				    	echo function_exists('ebor_pagination') ? ebor_pagination($blog_query->max_num_pages) : posts_nav_link();
				    	wp_reset_query();
				    ?>
				
				  </div>
				</div>
				
				<?php get_sidebar(); ?>
			
			</div>
			
		<?php endif; ?>
			
	<?php	
	}//end block
	
}//end class