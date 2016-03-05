<?php
	get_header();
	the_post();
		
	/**
	 * Get Wrapper Start - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','start'); 
?>
      
	<div class="row">
		
		<div class="col-sm-4 rp30">
			<figure>
				<?php
					the_post_thumbnail('full');
				?>
			</figure>
		</div>
		
		<div class="col-sm-8">
			<?php the_title('<h1 class="post-title bm0">', '</h1>'); ?>
				<div class="meta bm20">
					<?php echo get_post_meta( $post->ID, '_ebor_the_job_title', true ); ?>
				</div>
			<?php
				the_content(); 
				wp_link_pages();
				get_template_part('loop/loop', 'social');
			?>
		</div>
	
	</div>
      
<?php 
	/**
	 * Get Wrapper End - Uses get_template_part for simple child themeing.
	 */
	get_template_part('inc/wrapper','end'); 
	
	get_footer();