<?php 
	global $post;
	
	$attachments = get_post_meta( $post->ID, '_ebor_gallery_list', true );
	
	if ( $attachments ) : 
?>

	<div class="owl-slider-wrapper main">
	  <div class="owl-portfolio-slider owl-carousel">
	  
	  	<?php foreach( $attachments as $key => $attachment ) : ?>
	  	  <div class="item"> 
	  	  	<img src="<?php echo esc_url($attachment); ?>" alt="<?php echo $post->title; ?>" /> 
	  	  </div>
	  	<?php endforeach; ?>
	  	
	  </div>
	  <div class="owl-custom-nav"> <a class="slider-prev"></a> <a class="slider-next"></a> </div>
	</div>

<?php 
	endif;