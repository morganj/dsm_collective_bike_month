<?php
function tss_mpsp_tslider_posts_shortcode($post){
    // $post is already set, and contains an object: the WordPress post
    global $post;
 //////////////////////////////////////////////////////////////////////////
                                                                        //  
                               //START                                 //
                                                                      //  
                                                                     //
    ///////  MAIN SETTINGS var assign BOX Starts HERE!!! /////////////

    $postid = $post->ID;

    ?>
    <style type="text/css">
      #mpsp_slider_posts_shortcode{
      border-top: 5px solid #A7D476;
    }
    </style>
    <p>For Testimonial slider use following shortcode :</p>
    <p style='font-weight:bold; font-size:20px;'>[tss_slider id='<?php echo $postid; ?>']</p>
    <p>For Testimonial list use following shortcode : <b>(Only Available for premium version users)</b></p>
    <p style='font-weight:bold; font-size:20px;'>[tss_list id='<?php echo $postid; ?>']</p>

    <a href="http://web-settler.com/testimonials-plugin/" target="_blank" style="font-size:17px;" id="pr_msg_link"><i>To unlock list showcase Click Here</i></a>
    

    <?php


 }


 ?>