<?php
	/**
	 * archive-team.php
	 * The team archives used in Loom
	 * @author TommusRhodus
	 * @package loom
	 * @since 1.0.0
	 */
	get_header();
	
	/**
	 * Get Wrapper Start - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','start'); 
?>

	<div class="row">
		  
		<?php 
			if ( have_posts() ) : while ( have_posts() ) : the_post(); 
			global $post; 
		?>
		
			<div class="divide20"></div>
			
			<div id="team-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
			
			  <div class="col-sm-5 rp20">
			    <?php if( has_post_thumbnail() ) : ?>
			    	<figure>
			    		<a href="<?php the_permalink(); ?>">
			    			<div class="text-overlay">
			    				<div class="info"><?php the_title(); ?><br /><?php echo get_post_meta( $post->ID, '_ebor_the_job_title', true ); ?></div>
			    			</div>
			    			<?php the_post_thumbnail('index'); ?>
			    		</a>
			    	</figure>
			    <?php endif; ?>
			  </div>
			
			  <div class="col-sm-7">
			  
			    <?php 
			    	the_title('<h3>','</h3>');
			    	the_content(); 
			    ?>
			    
			    <div class="divide10"></div>
			    
			    <?php get_template_part('loop/loop','social'); ?>
			    
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
			
			/**
			 * Post pagination, use ebor_pagination() first and fall back to default
			 */
			echo function_exists('ebor_pagination') ? ebor_pagination() : posts_nav_link();
		?>
	
	</div>

<?php
	/**
	 * Get Wrapper End - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','end'); 
	
	get_footer();