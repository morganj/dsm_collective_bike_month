<?php 
	/**
	 * Find & assign the post format for this post
	 */
	$format = get_post_format(); 
	if( false === $format ) 
		$format = 'standard'; 
?>
  
<div class="row">

	<div class="col-md-8">
		<?php 
			/**
			 * Get the post format markup for this post
			 */
			if(!( post_password_required() ))
				get_template_part('postformats/format', $format); 
		?>
	</div>
	
	<div class="col-md-4 lp30 post-content">
		<?php 
			the_title('<h1 class="post-title entry-title">', '</h1>');
			the_content(); 
			wp_link_pages();
		?>
		<div class="divide5"></div>
		<?php 
			if(!( post_password_required() ))
				get_template_part('loop/content','metaportfolio'); 
		?>
	</div>

</div>