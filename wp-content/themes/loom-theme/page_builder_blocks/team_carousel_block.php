<?php

class AQ_Team_Carousel_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Team Carousel',
			'size' => 'span12',
			'resizable' => 0,
			'block_description' => 'Add a carousel of<br />team posts to the page.'
		);
		parent::__construct('aq_team_carousel_block', $block_options);
	}//end construct
	
	function form($instance) {
		$defaults = array(
			'pppage' => '6',
			'filter' => 'all',
			'post_content' => 0,
			'links' => 0
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$args = array(
			'orderby'                  => 'name',
			'hide_empty'               => 0,
			'hierarchical'             => 1,
			'taxonomy'                 => 'team-category'
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
				Show a specific Team Category?
				<?php echo ebor_portfolio_field_select('filter', $block_id, $filter_options, $filter) ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('post_content') ?>">
				Use post content rather than excerpt?
				<?php echo aq_field_checkbox('post_content', $block_id, $post_content) ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('links') ?>">
				Disable links to the single post?
				<?php echo aq_field_checkbox('links', $block_id, $links) ?>
			</label>
		</p>
		
	<?php
	}//end form
	
	function block($instance) {
		extract($instance);
		
		if(!( isset($post_content) ))
			$post_content = 0;
			
		if(!( isset($links) ))
			$links = 0;
		
		$query_args = array(
			'post_type' => 'team',
			'posts_per_page' => $pppage
		);
		
		if (!( $filter == 'all' )) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'team-category',
					'field' => 'id',
					'terms' => $filter
				)
			);
		}
	
		$team_query = new WP_Query( $query_args );	
	?>
			
		<div class="owl-team owlcarousel carousel-th">
		  
			<?php 
				if ( $team_query->have_posts() ) : while ( $team_query->have_posts() ) : $team_query->the_post(); 
				global $post; 
				
				$before = '<a href="'. get_permalink() .'">';
				$after = '</a>';
				
				if( $links == 1 ){
					$before = '';
					$after = '';	
				}
			?>
		  
				<div class="item">
				
					<?php if( has_post_thumbnail() ) : ?>
						<figure>
							<?php echo $before; ?>
								<?php if( $before ) : ?>
									<div class="text-overlay">
										<div class="info"><?php the_title(); ?><br /><?php echo get_post_meta( $post->ID, '_ebor_the_job_title', true ); ?></div>
									</div>
								<?php endif; ?>
								<?php the_post_thumbnail('index'); ?>
							<?php echo $after; ?>
						</figure>
					<?php endif; ?>
					
					<div class="image-caption text-center">
						<?php 
							the_title('<h4 class="post-title upper">' . $before, $after . '</h4>'); 
							echo '<div class="meta">'. get_post_meta( $post->ID, '_ebor_the_job_title', true ) .'</div>';
							($post_content == 1) ? the_content() : the_excerpt();
							get_template_part('loop/loop','social');
						?>
					</div>
					
				</div>
		  
			<?php 
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