<?php

class AQ_Testimonial_Carousel_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Testimonial Carousel',
			'size' => 'span12',
			'resizable' => 0,
			'block_description' => 'Add a carousel of<br />testimonials to the page.'
		);
		parent::__construct('aq_testimonial_carousel_block', $block_options);
	}//end construct
	
	function form($instance) {
		$defaults = array(
			'filter' => 'all'
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$args = array(
			'orderby'                  => 'name',
			'hide_empty'               => 0,
			'hierarchical'             => 1,
			'taxonomy'                 => 'testimonial-category'
		); 
			
		$filter_options = get_categories( $args );
	?>
	
		<p class="description">
			<label for="<?php echo $this->get_field_id('filter') ?>">
				Show Testimonials from a specific category?<br />
				<?php echo ebor_portfolio_field_select('filter', $block_id, $filter_options, $filter) ?>
			</label>
		</p>
	
	<?php
	}//end form
	
	function block($instance) {
		extract($instance);
	
		$query_args = array(
			'post_type' => 'testimonial',
			'posts_per_page' => -1
		);
		
		if (!( $filter == 'all' )) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'testimonial-category',
					'field' => 'id',
					'terms' => $filter
				)
			);
		}
	
		$testimonial_query = new WP_Query( $query_args );	
		
		$i = 0;
	?>
			
		<div class="text-center">
		  <div id="testimonials" class="tab-container">
		  
		    <div class="panel-container">
		    
		    	<?php 
		    		if ( $testimonial_query->have_posts() ) : while ( $testimonial_query->have_posts() ) : $testimonial_query->the_post(); 
		    		
		    			$i++;
		    			echo '<div id="tst'. $i .'">'. htmlspecialchars_decode( get_the_content() ) .'<span class="author">'. get_the_title() .'</span> </div>';

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
		    
		    <ul class="etabs">
		    	<?php
		    		if(!( $i == 1 )){
			    		for( $c = 1; $c <= $i; $c++ ){
			    			echo '<li class="tab"><a href="#tst'. $c .'"></a></li>';
			    		}
		    		}
		    	?>
		    </ul>
		    
		  </div>
		</div>
			
	<?php	
	}//end block
	
}//end class