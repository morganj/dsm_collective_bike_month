<?php 

for( $i = 0; $i < 5; $i++ ){
	if ( get_post_meta( $post->ID, "_ebor_the_video_$i", true ) ) 
		echo '<figure class="media-wrapper player portfolio">' . wp_oembed_get( esc_url( get_post_meta( $post->ID, "_ebor_the_video_$i", true ) ) ) . '</figure>';
}