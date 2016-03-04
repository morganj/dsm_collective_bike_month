<?php
	global $post;
	
	$url[] = '';
	$url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
?>

<div class="share"> 
	<a href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" target="_blank" onClick="return ebor_fb_like()" class="btn share-facebook">Like</a> 
	<a href="https://twitter.com/share?url=<?php the_permalink(); ?>" target="_blank" onClick="return ebor_tweet()" class="btn share-twitter">Tweet</a> 
	<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank" onClick="return ebor_plus_one()" class="btn share-googleplus">+1</a> 
	<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" onClick="return ebor_pin()" target="_blank" class="btn share-pinterest">Pin It</a>
</div>

<script type="text/javascript">
	function ebor_fb_like() {
		window.open('http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
		return false;
	}
	function ebor_tweet() {
		window.open('https://twitter.com/share?url=<?php the_permalink(); ?>&t=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
		return false;
	}
	function ebor_plus_one() {
		window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>&t=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
		return false;
	}
	function ebor_pin() {
		window.open('http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $url[0]; ?>&description=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
		return false;
	}
</script>