<?php 
	/**
	 * Find & assign the post format for this post
	 */
	$format = get_post_format(); 
	if( false === $format ) 
		$format = 'standard';
	
	/**
	 * Get the post format markup for this post
	 */
	if(!( post_password_required() ))
		get_template_part('postformats/format', $format);
	
	/**
	 * Display the post title
	 */
	the_title('<div class="divide20"></div><h1 class="post-title entry-title">', '</h1>'); 
?>
  
<div class="row">

	<div class="col-sm-8 post-content">
	  <?php 
	  	the_content(); 
	  	wp_link_pages();
	  ?>
	</div>
	
	<div class="col-sm-4 lp30">
		<?php 
			if(!( post_password_required() ))
				get_template_part('loop/content','metaportfolio'); 
		?>
	</div>

</div>