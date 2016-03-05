<?php

/********************************
** adamrob.co.uk - 2FEB2015
** Parallax Scroll Wordpress Plugin
**
** For Help and Support please visit www.adamrob.co.uk
**
** Help
********************************/


function parallaxscroll_help_get_whatsnew(){
    //Returns whats new help text
    $text='';
    $text.="<H1>Parallax Scroll by adamrob.co.uk</H1>";
    $text.="<H3>What's New?</H3>";
    $text.="<p>";
    $text.="<ul>";
    $text.="<li>New help menus! To help improve the look and feel of the plugin-in, help text has now been moved to the help menus</li>";
    $text.="<li>New image size property for users who want more control on the size of their parallax image</li>";
    $text.="<li>Fixed - When a user visits on a mobile device, the image will no longer appear too large.</li>";
    $text.="<li>New image size property for mobile devices. Specify a size when a user visits on a mobile device</li>";
    $text.="<li>More DIVS have been given IDs; so you can customise the CSS better.</li>";
    $text.="</ul>";
    $text.="Please visit <a href='http://www.adamrob.co.uk/parallax-scroll' target='blank'> adamrob.co.uk</a> for more information and support.";
    $text.="</p>";

    return $text;
}

function parallaxscroll_help_get_creating(){
    //Returns whats new help text
    $text='';
    $text.="<H1>Parallax Scroll by adamrob.co.uk</H1>";
    $text.="<H3>Creating a new Parallax</H3>";
    $text.="<p>";
    $text.="Parallax scroll use's the information in the post screen to build a parallax element for your site. This element can then be used in any page/post on your site by using a shortcode.";
    $text.="<br/>Follow the steps to get started:";
    $text.="<ul>";
    $text.="<li><b>Enter a post title</b><br/>This will be the main title which is displayed over the parallax background. The title can also be hidden. See header style point below.</li>";
    $text.="<li><b>Enter some content</b> <i>optional</i><br/>Add some content if required, just like any other post/page.</li>";
    $text.="<li><b>Add Feature Image</b><br/>The feature image is your parallax background</li>";
    $text.="<li><b>Parallax Height</b><i>optional</i><br/>Enter a height in pixels you would like the parallax to be. Setting this option will aut-size the parallax based on the content entered. Minimum height is always 100px</li>";
    $text.="<li><b>Parallax Image Size</b><i>optional</i><br/>The parallax image will be scaled based on this value. Specify the width in pixels. Set to 0 to auto set the size of the image (recommended)</li>";
    $text.="<li><b>Horizontal Position</b><br/>The horizontal position of the header on the parallax background.</li>";
    $text.="<li><b>Vertical Position</b><br/>The vertical position of the header on the parallax background. This setting is ignored if post content is specified.</li>";
    $text.="<li><b>Header Style</b><i>optional</i><br/>Enter the inline CSS style required for the header eg. font-weight: bold; font-size: large;<br>If you would like to hide the header, type: display: none; </li>";
    $text.="<li><b>Full Width</b><i>optional</i><br/>Display the parallax across the full width of the page. This is a work around to get a full width parallax if its not already. This may not work on some themes. Please see the note below for more information.</li>";
    $text.="<li><b>Mobile: Disable Image</b><i>optional</i><br/>Parallax Scroll can only render the background image on mobile devices with no animation. Select this option if you would rather the background image not display at all on mobile devices.</li>";
    $text.="<li><b>Mobile: Disable Parallax</b><i>optional</i><br/>Parallax Scroll can only render the background image on mobile devices with no animation. Select this option if you would rather not show the entire parallax (including content) when on a mobile device.</li>";
    $text.="<li><b>Mobile: Image Size</b><i>optional</i><br/>Set a size here to scale the image size when on a mobile device. Specify the width in pixels. Set to 0 to auto set the size of the image.</li>";
    $text.="</ul>";
    $text.="<b>Note:</b> The parallax is always full width. It will size to the full width of your post. If this doesnt give you the effect required, selecting the full width option will resize the parallax to the content area of the page/post. If this still does not give the required effect, its because your theme's content area is not full width. This is not a fault of the plugin, but your theme.";
    $text.="</p>";




    return $text;
}


/***
** Help Tabs
***/
function parallaxscroll_help_add_tabs() {

  $screen = get_current_screen();

  // Return early if we're not on the book post type.
  if ( PARALLAX_POSTTYPE != $screen->post_type )
    return;

  // Setup help tab args.
  $maintab = array(
    'id'      => 'parallaxscroll_help_main', //unique id for the tab
    'title'   => "What's New", //unique visible title for the tab
    'content' => parallaxscroll_help_get_whatsnew(),  //actual help text
  );
  $createtab = array(
    'id'      => 'parallaxscroll_help_create', //unique id for the tab
    'title'   => "Create", //unique visible title for the tab
    'content' => parallaxscroll_help_get_creating(),  //actual help text
  );
  
  // Add the help tab.
  $screen->add_help_tab( $maintab );
  $screen->add_help_tab( $createtab );

}
add_action('admin_head', 'parallaxscroll_help_add_tabs');



?>