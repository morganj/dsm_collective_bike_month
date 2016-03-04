<?php
	$format = get_post_format(); 
	if( false === $format ) 
		$format = 'standard';
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
	<?php 
		if(!( post_password_required() ))
			get_template_part('postformats/format', $format); 
	?>
  
  <div class="post-content image-caption">
  
  	<?php 
  		the_title('<h2 class="post-title entry-title"><a href="'. get_permalink() .'">', '</a></h2>');
  		get_template_part('loop/content','metasingle');
  		
  		if( $format == 'chat' || $format == 'quote' || post_password_required() ){
  			the_content();
  		} else {
  			echo wpautop( wp_trim_words( get_the_content(), 40) );
  			echo '<a href="'. get_permalink() .'" class="more">'. get_option('blog_continue', 'Continue Reading') .' →</a>';
  		}
  	?>
  	
  </div>

</div>

<hr />