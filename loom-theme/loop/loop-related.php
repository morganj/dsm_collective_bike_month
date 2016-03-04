<?php
	/**
	 * First, grab post terms.
	 */
	$terms = get_the_terms( $post->ID , 'portfolio-category', 'string');
	
	/**
	 * Return if this post has no terms
	 */
	if(!( $terms ))
		return false;
	
	/**
	 * Now we know that we definitely have terms to work with, build and array of term id's
	 */	
	$term_ids = array_values( wp_list_pluck( $terms, 'term_id' ) );
	
	/**
	 * Set our arguments for finding related posts
	 */
	$related_args = array(
		'post_type' => 'portfolio',
		'tax_query' => array(
			array(
				 'taxonomy' => 'portfolio-category',
				 'field' => 'id',
				 'terms' => $term_ids,
				 'operator'=> 'IN'
			)
		),
		'posts_per_page' => '6',
		'ignore_sticky_posts' => 1,
		'orderby' => 'rand',
		'post__not_in'=> array(
			$post->ID
		)
	);
	
	/**
	 * Build the related posts query based on what we've grabbed above
	 */
	$related_query = new WP_Query( $related_args );
	
	if ( $related_query->have_posts() ) :
?>

	<div class="divide70"></div>
	      
	<div class="section-title-wrapper">
		<h3 class="section-title"><?php echo get_option('portfolio_related_title','Related Works'); ?></h3>
	</div>
	
	<div class="owl-portfolio owlcarousel carousel-th related">
	
		<?php 
			if ( $related_query->have_posts() ) : while ( $related_query->have_posts() ) : $related_query->the_post(); 
				
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
	endif;