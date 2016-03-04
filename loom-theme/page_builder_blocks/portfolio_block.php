<?php

class AQ_Portfolio_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Portfolio',
			'size' => 'span12',
			'resizable' => 0,
			'block_description' => 'Add your portfolio items<br />straight to the page.'
		);
		parent::__construct('aq_portfolio_block', $block_options);
	}//end construct
	
	function form($instance) {
		$defaults = array(
			'wpautop' => '',
			'type' => 'full-portfolio',
			'pppage' => '999',
			'filter' => 'all',
			'lightbox' => 0
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$args = array(
			'orderby'                  => 'name',
			'hide_empty'               => 0,
			'hierarchical'             => 1,
			'taxonomy'                 => 'portfolio-category'
		); 
			
		$filter_options = get_categories( $args );
		
		$portfolio_types = array(
			'full-portfolio' => 'Fullscreen Portfolio',
			'fix-portfolio' => 'Classic Portfolio',
			'fix-portfolio-alt' => 'Classic Portfolio (3 Columns)'
		);
	?>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('wpautop') ?>">
				Center Filters?
				<?php echo aq_field_checkbox('wpautop', $block_id, $wpautop) ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('lightbox') ?>">
				Disable Single Posts and use Image Lightbox instead?
				<?php echo aq_field_checkbox('lightbox', $block_id, $lightbox) ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('type') ?>">
				Portfolio Style
				<?php echo aq_field_select('type', $block_id, $portfolio_types, $type) ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('pppage') ?>">
				Load how many items? 999 for all. <code>Note: The Portfolio is not Paged</code>
				<?php echo aq_field_input('pppage', $block_id, $pppage, $size = 'full', $type = 'number') ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('filter') ?>">
				Show a specific portfolio category?
				<?php echo ebor_portfolio_field_select('filter', $block_id, $filter_options, $filter) ?>
			</label>
		</p>
		
	<?php
	}//end form
	
	function block($instance) {
		extract($instance);
		
		$query_args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => $pppage
		);
		
		if (!( $filter == 'all' )) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio-category',
					'field' => 'id',
					'terms' => $filter
				)
			);
		}
	
		$portfolio_query = new WP_Query( $query_args );
		
		if( $type == 'fix-portfolio' ){ 
			$wrapper_styles = 'col4';
		} elseif( $type == 'fix-portfolio-alt' ){ 
			$type = 'fix-portfolio';
			$wrapper_styles = 'col3';
		} else {
			$wrapper_styles = '';	
		}
		
		( $lightbox ) ? $lightbox = 'lightbox' : $lightbox = '';
		
		if( $filter == 'all' ){
			$cats = get_categories('taxonomy=portfolio-category');
		} else {
			$cats = get_categories('taxonomy=portfolio-category&exclude='. $filter .'&child_of='. $filter);
		}
	?>
		
		<div class="light-wrapper">
			
			<div class="portfolio <?php echo $type; ?>">
			
				<?php 
					if($wpautop)
						echo '<div class="text-center">';
					
					if ( $filter == 'all' && !( empty($cats) ) ) :
				?>
						
						<div class="container">
							<ul class="filter">
								<li><a class="active" href="#" data-filter="*"><?php _e('All','loom'); ?></a></li>
								<?php 
									foreach ($cats as $cat){
										echo '<li><a href="#" data-filter=".' . $cat->slug . '">' . $cat->name . '</a></li>';
									} 
								?>
							</ul>
						</div>
						
				<?php 
					elseif(!( empty($cats) )) :
				?>
					
					<div class="container">
						<ul class="filter">
							<li><a class="active" href="#" data-filter="*"><?php _e('All','loom'); ?></a></li>
							<?php 
								foreach ($cats as $cat){
									echo '<li><a href="#" data-filter=".' . $cat->slug . '">' . $cat->name . '</a></li>';
								} 
							?>
						</ul>
					</div>
					
				<?php
					endif;
					
					if($wpautop)
						echo '</div>';
				?>
			  
				<ul class="items <?php echo $wrapper_styles; ?>">
				
					<?php 
						if ( $portfolio_query->have_posts() ) : while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
							
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
						wp_reset_query();
					?>
				
				</ul>
			  
			</div>
		
		</div>
			
	<?php	
	}//end block
	
}//end class