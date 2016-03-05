<?php 

global $post;

$attachments = get_post_meta( $post->ID, '_ebor_gallery_list', true );
$count = count($attachments);

if ( $attachments ){
	$i = 0;
	foreach( $attachments as $attachment ){
		
		if( is_single() ){
			echo '<figure><img src="'. esc_url($attachment) .'" alt="'. $post->title .'"></figure>';
			$i++;
			if(!( $i == $count ))
				echo '<div class="divide30"></div>';
		} else {
			echo '<figure><a href="'. get_permalink() .'"><div class="text-overlay"><div class="info">'. get_option('blog_read_more', 'Read More') .'</div></div><img src="'. esc_url($attachment) .'" alt="'. $post->title .'"></figure>';
		}
			
	}	
}