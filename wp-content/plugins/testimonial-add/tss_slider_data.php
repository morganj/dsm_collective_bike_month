<?php

function tss_slider_data($post){
    // $post is already set, and contains an object: the WordPress post
    global $post;
 //////////////////////////////////////////////////////////////////////////
                                                                        //  
                               //START                                 //
                                                                      //  
                                                                     //
    ///////  MAIN SETTINGS var assign BOX Starts HERE!!! /////////////

   // $example = get_post_meta($post->ID,'example',true);

    $tss_name = get_post_meta($post->ID,'tss_name',true);
    $tss_ocupation = get_post_meta($post->ID,'tss_ocupation',true);
    $tss_image = get_post_meta($post->ID,'tss_image',true);
    $tss_testimonial = get_post_meta($post->ID,'tss_testimonial',true);
 



    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

?>
<style type="text/css">
    #post-preview,#edit-slug-box{
        display: none;
    } 

    </style>
<div class='formLayout'>
<div id="mpsp_posts_settings">

<br>
<br>
 <label> Clients Name :  </label>
 <input type="text" style="width:200px;" name="tss_name" value="<?php echo $tss_name;  ?>">

<br>
<br>
<label> Clients Position : </label>
<input type="text" style="width:200px;" name="tss_ocupation" value="<?php echo $tss_ocupation;  ?>">

<br>
<br>
<label> Clients Image URL :  </label>
  <input type="text" class="upload_image_button" name="tss_image"  value="<?php echo $tss_image;  ?>" style='width:200px;' /> 
  <input type="button" class="upload_bg" value="Upload" />

<br>
<br>
<label> Clients Testimonial :  </label>
<textarea rows="15" cols="30" name="tss_testimonial"><?php echo $tss_testimonial; ?></textarea>

 </div>
 </div>
 <?php

 } 


 ?>