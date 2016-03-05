<?php

class AQ_Portfolio_Carousel_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Portfolio Carousel',
			'size' => 'span12',
			'resizable' => 0,
			'block_description' => 'Add a carousel of<br />portfolio posts to the page.'
		);
		parent::__construct('aq_portfolio_carousel_block', $block_options);
	}//end construct
	
	function form($instance) {
		$defaults = array(
			'pppage' => '6',
			'filter' => 'all'
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
	?>
	
		<p class="description">
			<label for="<?php echo $this->get_field_id('pppage') ?>">
				Load how many posts?
				<?php echo aq_field_input('pppage', $block_id, $pppage, $size = 'full', $type = 'number') ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('filter') ?>">
				<?php _e('Show a specific portfolio category?', 'loom'); ?><br/>
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
	?>
		
		<div class="owl-portfolio owlcarousel carousel-th">
		
			<?php 
				if ( $portfolio_query->have_posts() ) : while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post(); 
					
					/**
					 * Get blog carousel post markup
					 */
					get_template_part('loop/content','carouselportfolio');
			
				endwhile;
				else : 
					
					/**
					 * Display no posts message if none are found.
					 */
					get_template_part('loop/content','none');
					
				endif;
				wp_reset_query();
			?>
		
		</div>
			
	<?php	
	}//end block
	
}//end class