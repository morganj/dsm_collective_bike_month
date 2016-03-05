<?php
function tss_data_front_end_form() {
 
?>
<form id="custom-post-type" name="custom-post-type" method="post" action="">
 
<p><label for="title">Name</label><br />
 
<input type="text" id="title" value="" tabindex="1" size="20" name="title"  />
 
</p>

<p><label for="tss_occupation">Occupation</label><br />
 
<input type="text" id="tss_occupation" value="" tabindex="1" name="tss_occupation"  />
 
</p>

<p><label for="tss_image_input">Image URL</label><br />
 
<input type="url" id="tss_image_input" value="" tabindex="1" name="tss_image_input" />
 
</p>
 
<p><label for="tss_testimonial">Testimonial</label><br />
 
<textarea id="tss_testimonial" tabindex="3" name="tss_testimonial" cols="50" rows="6"  ></textarea>
 
</p> 

<p align="right"><input type="submit" value="Publish" tabindex="6" id="submit" name="submit" /></p>
 
<input type="hidden" name="post-type" id="post-type" value="custom_posts" />
 
<input type="hidden" name="action" value="custom_posts" />
 
<?php wp_nonce_field( 'tss_action_name','tss_nonce_field_title' ); ?>
 
</form>
<?php
 
if($_POST){
ty_save_post_data();
}
 
}
add_shortcode('tss-front-end-form','tss_data_front_end_form');

function ty_save_post_data() {
 
if ( empty($_POST) || !wp_verify_nonce($_POST['tss_nonce_field_title'],'tss_action_name') )
{
print 'Sorry, your nonce did not verify.';
exit;
 
}else{
 
// Do some minor form validation to make sure there is content
if (!empty($_POST['title'])) {
$title =  $_POST['title'];
} else {
echo 'Please enter a Name';
exit;
}
if (!empty($_POST['tss_occupation'])) {
$tss_occupation =  $_POST['tss_occupation'];
} else {
echo 'Please enter occupation';
exit;
}
if (isset ($_POST['tss_image_input'])) {
$tss_image_input =  $_POST['tss_image_input'];
}
if (!empty($_POST['tss_testimonial'])) {
$tss_testimonial = $_POST['tss_testimonial'];
} else {
echo 'Please enter the testimonial';
exit;
}
 
$post = array(
'post_title' => wp_strip_all_tags( $title ),
'post_status' => 'publish',           
'post_type' => 'tss_data'  
);
 $post_id =  wp_insert_post($post);

 add_post_meta( $post_id, 'tss_name',wp_strip_all_tags( $title ));
 add_post_meta( $post_id, 'tss_ocupation',wp_strip_all_tags( $tss_occupation ));  
 add_post_meta( $post_id, 'tss_image',wp_strip_all_tags( $tss_image_input ));  
 add_post_meta( $post_id, 'tss_testimonial',wp_strip_all_tags( $tss_testimonial ));    
 
 
echo "Thanks - Your testimonial has been submitted."; exit;
} // end IF
 
}

?>