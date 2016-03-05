=== Parallax Scroll ===
Contributors: adamrob
Tags: parallax, scroll, image, header, adamrob
Requires at least: 4.0
Tested up to: 4.1.1
Stable tag: 1.4
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create a header, or even a custom post/page with a scrolling parallax background. All with a simple shortcode.

== Description ==

Parallax Scroll; the easiest way to get a parallax scrolling background image for an element on your page/posts.

**Examples include:**

* Create a page/post header text with a parallax scrolling background. Ideal for single page sites, or pages with sections.
* Create a full page/post with a parallax scrolling background. Ideal for single page sites, or pages with sections where you can have more than one page/post.
* Give single elements of your pages a parallax scrolling background.

**How?**

* Simply create the content required in the custom Parallax Scroll post type.
* The Parallax Scroll admin page will display the shortcode required for all Parallax Scroll post types defined. Copy this shortcode, and paste it into any page or post.
* Thats it!

**New:**

You can now use parallax scroll in your themes, using PHP. Using this method, there is no need to add a shortcode to a page or post; just simply paste the following PHP code into your PHP page where you would like your parallax to display. This method is especially usefull if you are having trouble with full width, or you would like to build it into your theme.

	echo do_shortcode('[parallax-scroll id="#"]')

*Where # = parallax ID number*

**Please note**

>	The parallax will size automatically to the width of your themes content area. If your theme's content area is not full width, then the parallax will not be full width. This is an issue with your theme and not the plugin. As a work around, I have added a full width option that will ignore the content area of your theme and resize to your themes post section. Again this may not work if your themes post section is not full width. If the plugin does not work as you would have hoped; please contact me and I can advise further.

== Installation ==

No special steps required for installation.

Auto Install:

1. Navigate to plugins page in your WordPress admin section.
1. Search for Parallax Scroll by adamrob.co.uk.
1. Download and activate.
1. You will now have the Parallax Scroll menu item in your WordPress admin

Manual Install:

1. Download the plugin files.
1. Copy/upload the plugin folder to your WordPress Content/plugins directory.
1. Navigate to WordPress plugin page in your WordPress admin page. The plugin will be displayed.
1. Click activate. You will now have the Parallax Scroll menu item in your WordPress admin.

== Frequently Asked Questions ==

= Where can i get support? =

Please visit [adamrob.co.uk](http://adamrob.co.uk/parallax-scroll "my website") for support and/or suggestions.


== Screenshots ==

1. The options availble on the Parallax Scroll post page.
2. An example of parallax scroll being used for header text.
3. An example of parallax scroll being used as part of the page, in this instance it contains text and a google maps element.


== Changelog ==

= 0.1 =
* Initial release.

= 0.2 =
* Added header CSS style parameter to custom post type.

= 0.3 =
* Fixed - Fixed an issue where some themes would not render the parallax background image (such as the default themes).
* Added - Screenshots on Wordpress plugins directory.

= 0.4 =
* Added - Two new options to add the ability of disabling parallax scroll image or content when on mobile device.
* Added - Full width option. This option will over-ride the themes content area style and make the parallax full width.
* Fixed - Shortcodes in the parallax scroll post content now work correctly.

= 1.0 =
* Updated - Parallax.js has now been removed. The parallax is now driven from CSS. This will improve browser compatability, in particular with internet explorer.

= 1.1 =
* Fixed - Fixed full width issue where if more than one parallax was used in a single post/page they would not size correctly

= 1.2 =
* Added - New help menu's
* Added - Parallax image size option

= 1.3 =
* Fixed - Menu Position Bug

= 1.4 =
* Fixed - Images should appear better on mobile devices
* Added - Image size option just for mobile devices
* Added - Additional Div IDs


== Upgrade Notice ==

= 0.3 =
Fixed issue where parallax background image would not display on some themes.

= 0.4 =
New options added including full width. Shortcodes now work in the post content.

= 1.0 =
Parallax.js has now been removed. The parallax is now driven from CSS. This will improve browser compatability, in particular with internet explorer.
PLEASE NOTE: Make a backup of parallax scroll plugin before upgrading. The plugin has been fundamentally changed by changing how the parallax works. This may mean that the new version does not appear as it use to.

= 1.1 =
Fixed full width issue where if more than one parallax was used in a single post/page they would not size correctly.

= 1.2 =
Added help menu's and an option to specify parallax image size.

= 1.3 =
Fixed Menu Position Bug

= 1.4 =
Images should appear better on mobile devices plus Image size option just for mobile devices.