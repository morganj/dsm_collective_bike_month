<?php 

for( $i = 0; $i < 5; $i++ ){
	if ( get_post_meta( $post->ID, "_ebor_the_video_$i", true ) ) 
		echo htmlspecialchars_decode( get_post_meta( $post->ID, "_ebor_the_video_$i", true ) );
}