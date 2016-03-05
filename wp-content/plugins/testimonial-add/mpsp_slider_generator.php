
<?php echo get_post_meta($id,'mpsp_slide_nav_button_position',true); ?>
<style>
.owl-pagination{
}
.owl-buttons{
  color:<?php echo get_post_meta($id,'mpsp_slide_nav_button_color',true);?>
}



</style>



<div id="mpsp_wrapper" style= "padding:10px;border-radius:5px; width:<?php echo get_post_meta($id,'mpsp_slide_custom_width',true); ?>;  <?php echo $mpsp_slide_gradient; ?>    ">


    <h2 align="center"style="width:100%;

background: #ffffff;
background: -moz-linear-gradient(top,  #ffffff 0%, #e5e5e5 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#e5e5e5));
background: -webkit-linear-gradient(top,  #ffffff 0%,#e5e5e5 100%);
background: -o-linear-gradient(top,  #ffffff 0%,#e5e5e5 100%);
background: -ms-linear-gradient(top,  #ffffff 0%,#e5e5e5 100%);
background: linear-gradient(to bottom,  #ffffff 0%,#e5e5e5 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5',GradientType=0 );

 height:;    display:<?php echo get_post_meta($id,'mpsp_slide_main_head_bar',true); ?>;  border-radius:3px;">
     <?php echo get_post_meta($id,'mpsp_slide_main_heading',true); ?>
   </h2> 


<style type="text/css">
  #tss_warppper{
    background: <?php echo get_post_meta($id,'mpsp_posts_bg_color',true); ?>;
    width: 200px;
    text-align: center;
    margin: 0 auto;
    padding: 10px;
  }

  #tss_image{
    width: 100px;
    height: 100px;
    border-radius:100;
  }

  .tss_p{
    font-size: 14px;
    font-weight: 100;
    font-family: sans-serif,verdana,arial;
    color: <?php echo get_post_meta($id,'mpsp_posts_description_color',true); ?>;
  }
  #tss_name{
    font-weight: bold;
    font-size: 16px;
  }

  #tss_occupation{
    font-style: italic;

  }

  #tss_testimonial span{
    font-size: 29px;
    font-weight:bold;
    color: #dddddd;
  }
  #tss_testimonial{
    font-size: 15px;
    text-align: left;
  }
  </style>

  
             
              <div id="owl-demo" class="owl-carousel">
                
          <?php


$mpsp_posts_key = get_post_meta($id,'mpsp_posts_key',true);

              // WP_Query arguments
                  $args = array (
                    'post_type'              => 'tss_data', 
                    'posts_per_page'         => get_post_meta($id,'mpsp_posts_visible',true),
                    'order'                  => get_post_meta($id,'mpsp_posts_order',true),
                    'orderby'                => get_post_meta($id,'mpsp_posts_orderby',true),

                  );



// The Query
                  $the_query = new WP_Query( $args );

          while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
          

<div id='tss_warppper'>
  <div id='tss_content'>
    <img id='tss_image' src="<?php echo get_post_meta(get_the_ID(),'tss_image',true);  ?>">
    <p class='tss_p' id='tss_name'><?php echo get_post_meta(get_the_ID(),'tss_name',true);  ?></p>
    <p class='tss_p' id='tss_occupation'><?php echo get_post_meta(get_the_ID(),'tss_ocupation',true);  ?></p>
    <p class='tss_p' id='tss_testimonial'><span>"</span><?php echo get_post_meta(get_the_ID(),'tss_testimonial',true);  ?><span>"</span></p>
  </div>  
</div>


<?php endwhile;?>


               
            </div>

          </div>

            <script>

            jQuery(document).ready(function() {
 
         jQuery("#owl-demo").owlCarousel({
              autoPlay : <?php echo get_post_meta($id,'mpsp_slide_autoplay',true); ?>,
              stopOnHover : true,
              navigation: <?php echo  get_post_meta($id,'mpsp_slide_navigation',true); ?>,
              paginationSpeed : 1000,
              goToFirstSpeed : 2000,
              singleItem : <?php echo  get_post_meta($id,'mpsp_slide_single',true); ?>,
              autoHeight : true,
              transitionStyle: <?php echo  get_post_meta($id,'mpsp_slide_transistion',true); ?>,
              pagination : <?php echo  get_post_meta($id,'mpsp_slide_pagination',true); ?>,
              paginationNumbers :<?php echo  get_post_meta($id,'mpsp_slide_pagination_numbers',true); ?>,
              navigationText : ["<b><</b>", "<b>></b>"],

        });
       });

        </script>