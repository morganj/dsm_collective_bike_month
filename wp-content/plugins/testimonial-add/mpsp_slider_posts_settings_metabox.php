<?php

function tss_mpsp_slider_posts_settings($post){
    // $post is already set, and contains an object: the WordPress post
    global $post;
 //////////////////////////////////////////////////////////////////////////
                                                                        //  
                               //START                                 //
                                                                      //  
                                                                     //
    ///////  MAIN SETTINGS var assign BOX Starts HERE!!! /////////////

    $mpsp_post_types = get_post_meta($post->ID,'mpsp_post_types',true);
    $mpsp_posts_visible = get_post_meta($post->ID,'mpsp_posts_visible',true);
    $mpsp_posts_Desc_limit = get_post_meta($post->ID,'mpsp_posts_Desc_limit',true);
    $mpsp_posts_order = get_post_meta($post->ID,'mpsp_posts_order',true);
    $mpsp_posts_orderby = get_post_meta($post->ID,'mpsp_posts_orderby',true);
    $mpsp_posts_key = get_post_meta($post->ID,'mpsp_posts_key',true);
    $mpsp_posts_value = get_post_meta($post->ID,'mpsp_posts_value',true);
    $mpsp_posts_img_size = get_post_meta($post->ID,'mpsp_posts_img_size',true);
    $mpsp_slide_layout_custom = get_post_meta($post->ID,'mpsp_slide_layout_custom',true);


    ?>

<div class='formLayout' id='post_form_layout'>

  <div id="mpsp_posts_settings">


      <br>
      <br>

      <label class='layout_label'  for="mpsp_posts_visible">No. of Testimonials In Slider :</label>
      <input type="number" name="mpsp_posts_visible" value="<?php echo $mpsp_posts_visible; ?>" min='1'>

      <br>
      <label class='layout_label'  for="mpsp_posts_order">Testimonials Order :</label>
      <select name="mpsp_posts_order">
        <option value="ASC"
<?php selected( "ASC", $mpsp_posts_order ); ?>


        >Ascending</option>
        <option value="DESC"
<?php selected( "DESC", $mpsp_posts_order ); ?>

        >Descending</option>

      </select>
      <br>
      <br>

      <label class='layout_label'  for="mpsp_posts_orderby"  title="Sort retrieved posts by.">Testimonials Order By :</label >
      <select name="mpsp_posts_orderby">
        <option selected value=""
        >Choose..</option>
        <option value="none" 

        <?php selected( 'none',$mpsp_posts_orderby ); ?>

        >None</option>
        <option value="rand"
        <?php selected( 'rand',$mpsp_posts_orderby ); ?>

        >Random</option>
        <option value="id"
        <?php selected( 'id',$mpsp_posts_orderby ); ?>

        >ID</option>
        <option value="title"
        <?php selected( 'title',$mpsp_posts_orderby ); ?>

        >Title</option>
        <option value="name"
        <?php selected( 'name',$mpsp_posts_orderby ); ?>
>Slug</option>
        <option value="date"
        <?php selected( 'date',$mpsp_posts_orderby ); ?>

        >Date - Default</option>
        <option value="modified"
        <?php selected( 'modified',$mpsp_posts_orderby ); ?>
        >Modified Date</option>
        <option value="parent"
        <?php selected( 'parent',$mpsp_posts_orderby ); ?>

        >Parent ID</option>
        <option value="menu_order" <?php selected( 'menu_order',$mpsp_posts_orderby ); ?>>Comment Count</option>>Menu Order</option>
        <option value="comment_count" <?php selected( 'comment_count',$mpsp_posts_orderby ); ?>>Comment Count</option>
        

      </select>
      <br>
      <br>
      <label class='layout_label'  for="mpsp_posts_value">Category Name to filter Testimonials :</label>
      <input type="text" name="mpsp_posts_value" value="<?php echo $mpsp_posts_value; ?>" placeholder="i.e category name" style="width:150px;">

      <br>
      <br>
      <div style="">
      <h2 align="center" style="color:#fff;">Select layout</h2>
      <label class='layout_label' for="mpsp_layout_1"><img src="<?php echo plugins_url('img/Temp-1.png',__FILE__); ?>"  style='width:100px; height:200px;' > </label>

      <input type="radio" name="mpsp_slide_layout_custom" id='mpsp_layout_1' value="templates/mpsp_slider_generator" style="width:15px;"  <?php checked( "templates/mpsp_slider_generator", $mpsp_slide_layout_custom ); ?>
   checked >
      <br>
      <label class='layout_label' for="mpsp_layout_6"><img src="<?php echo plugins_url('img/Temp-6.png',__FILE__); ?>"  style='width:200px;' > </label>

      <input disabled type="radio" name="mpsp_slide_layout_custom" id='mpsp_layout_6' value="templates/mpsp_slider_generator_5" style="width:15px;"  <?php checked( "templates/mpsp_slider_generator_5", $mpsp_slide_layout_custom ); ?>
    ><span style="color:red;"><a href="http://web-settler.com/testimonials-plugin/" target="_blank">(Premium version Only)</a></span>
   <br>

      <label class='layout_label' for="mpsp_layout_2"><img src="<?php echo plugins_url('img/Temp-2.png',__FILE__); ?>" width="200px" ></label>
      <input type="radio" disabled name="mpsp_slide_layout_custom" id='mpsp_layout_2'  value='templates/mpsp_slider_generator_1' style="width:15px;"

<?php checked( "templates/mpsp_slider_generator_1", $mpsp_slide_layout_custom ); ?>
      > <b><i><span style="color:red;"><a href="http://web-settler.com/testimonials-plugin/" target="_blank">(Premium version Only)</a></span>
          <br>

      <label class='layout_label' for="mpsp_layout_3"><img src="<?php echo plugins_url('img/temp-3.png',__FILE__); ?>" width="200px"></label>
      <input type="radio" name="mpsp_slide_layout_custom" id='mpsp_layout_3' disabled
      value='templates/mpsp_slider_generator_2'style="width:15px;" selected     
<?php checked( "templates/mpsp_slider_generator_2", $mpsp_slide_layout_custom ); ?>
      > <span style="color:red;"><a href="http://web-settler.com/testimonials-plugin/" target="_blank">(Premium version Only)</a></span>
          <br>
          <label class='layout_label' for="mpsp_layout_4"><img src="<?php echo plugins_url('img/temp-4.png',__FILE__); ?>" width="200px"></label>
      <input type="radio" name="mpsp_slide_layout_custom" id='mpsp_layout_4' disabled
      value='templates/mpsp_slider_generator_3'style="width:15px;" selected     
<?php checked( "templates/mpsp_slider_generator_3", $mpsp_slide_layout_custom ); ?>
      > <span style="color:red;"><a href="http://web-settler.com/testimonials-plugin/" target="_blank">(Premium version Only)</a></span>
          <br>
          <label class='layout_label' for="mpsp_layout_5"><img src="<?php echo plugins_url('img/temp-5.png',__FILE__); ?>" width="200px"></label>
      <input type="radio" name="mpsp_slide_layout_custom" id='mpsp_layout_5' disabled
      value='templates/mpsp_slider_generator_4'style="width:15px;" selected     
<?php checked( "templates/mpsp_slider_generator_4", $mpsp_slide_layout_custom ); ?>
      > <span style="color:red;"><a href="http://web-settler.com/testimonials-plugin/" target="_blank">(Premium version Only)</a></span> </i></b>
          <br>
          <br>
          <a href="http://web-settler.com/testimonials-plugin/" target="_blank" style="font-size:24px; ;" id="pr_msg_link"><i>Unlock All Templates and get more amazing features Click Here</i></a>


  </div>
  
</div>



<?php
  }


  ?>