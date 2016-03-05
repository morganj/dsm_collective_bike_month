=== IK Facebook Plugin ===
Contributors: richardgabriel, ghuger
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=V7HR8DP4EJSYN
Tags: facebook, facebook feed, facebook embed, facebook feed widget, facebook feed embed, like button widget, facebook events
Requires at least: 3.0.1
Tested up to: 4.4.2
Stable tag: 2.14.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

IK Facebook is an easy-to-use plugin for adding a Custom Facebook Feed of any Public Facebook Page to your site, with a shortcode or widget.

== Description ==

The IK Facebook Plugin is an **easy-to-use** plugin that allows users to add a **custom Facebook Feed widget** to the sidebar, as a widget, or to embed the custom Facebook Feed widget into a Page or Post using the shortcode, of any Public Facebook Page.  The IK Facebook Plugin also allows you to insert a Facebook Like Button widget into the Page, Post, or theme.  The IK Facebook Plugin allows you to add Facebook Events, Photos, and Galleries to your website, too!


_"I searched forever for a simple plugin to display a public Facebook page pictures on my site. This plugin worked perfectly, and even better is the great support. Thanks so much Richard."_


_"Looks great, easy to use. Better than any of the other Facebook feed plugins I've tried."_


= The IK Facebook Plugin is a great plugin for many uses, including: =

* Powering your blog with your Facebook Feed!
* Embed a Custom Facebook Feed Widget in your Sidebar or Footer
* Styling a Custom Facebook Feed, without the need for CSS!
* Custom HTML Options allow Facebook Feed to be displayed any way you like!
* Works with Facebook Groups and Facebook Pages!
* Adding a Facebook Like Button to your website!
* Showing Facebook Comments in your Feed!
* Adding a Facebook Photo Gallery!
* Show multiple different custom Facebook Feeds!
* Display Upcoming Facebook Events on your website!
* Use a Facebook Event instead of a Page - output a customized Feed from the Facebook Event's Wall!
* Custom Facebook Feed Widget allows user to override Site Wide Options
* Ability to Pass Page ID Via Shortcode and Widget Allows Multiple Facebook Feeds on One Page!

= Upgrade To WP Social PRO For Advanced Features and Email Support =

The GoldPlugins team does not provide direct support for IK Facebook plugin on the WordPress.org forums. However, one-on-one email support is available to people who have upgraded to the premium edition, [WP Social Pro](http://goldplugins.com/our-plugins/wp-social-pro/?utm_source=wp&utm_campaign=desc_learn_more). In addition to outstanding support, WP Social Pro includes all kinds of new customization options, such as the ability to hide third party posts, use custom image sizes, and more. You should [upgrade today!](http://goldplugins.com/our-plugins/wp-social-pro/upgrade-to-wp-social-pro/?utm_source=wp&utm_campaign=desc_upgrade "Upgrade to WP Social Pro")

[Upgrade To WP Social Pro](http://goldplugins.com/our-plugins/wp-social-pro/upgrade-to-wp-social-pro/?utm_source=wp&utm_campaign=desc_upgrade2)

= User Friendly Features =
The IK Facebook Plugin includes options to set the Title of the custom Facebook Feed widget, whether or not to show the Like Button above the custom Facebook Feed widget, and whether or not to show the Profile Picture.  The IK Facebook Plugin supports both the Light and Dark color schemes for the Like Button widget and has multiple color schemes for the custom Facebook Feed widget.  The IK Facebook Plugin allows you to pass the ID of the Facebook page via the shortcode - allowing you to display the feeds from multiple accounts on one page!  Many plugins require you to know CSS to style your custom Facebook Feed widget - ours gives you full control over the output of your custom Facebook Feed, with Themes, Colorpickers, Options, and more!

= Professional Development =

The IK Facebook Plugin is a free version of [WP Social Pro](http://http://goldplugins.com/our-plugins/wp-social-pro/ "WP Social Pro") - WP Social Pro is a professionally developed WordPress plugin that integrates your Facebook Feed into your WordPress website as a custom widget.  The IK Facebook Plugin receives regular updates.  With the IK Facebook Plugin, you can easily add **Search Engine Optimization friendly** content to your website -- the content exists on your site and is crawlable by search engines like Google!

= Powerful Customization =

The IK Facebook Plugin includes the option to set your own custom CSS for styling purposes or, if you prefer, the IK Facebook Plugin allows you to include a custom style sheet in your theme directory  -- either method is great for displaying a custom Facebook Feed widget. The IK Facebook Plugin also allows the user to select from a few pre-made Feed Themes, to help generate their custom Facebook Feed widget.  *Gone are the days of fighting with the Facebook Social Plugin!*

= More Than Just A Custom Facebook Feed - Events and Photo Galleries, too! =

The IK Facebook Plugin intends to support all types Facebook content - not just standard Feeds.  Currently, we have support for Facebook Events and Facebook Photo Galleries.  Show your Upcoming Facebook Events on your Website, and power your Photo Galleries with Facebook!

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the contents of `/ik-facebook/` to the `/wp-content/plugins/` directory
2. Activate the IK Facebook Plugin through the 'Plugins' menu in WordPress
3. [Click here](http://iksocialpro.com/installation-usage-instructions/configuration-options-and-instructions/ "Configuration Options and Instructions") for information on how to configure the plugin.

= How To Get an App ID and Secret Key From Facebook =

Watch this video to learn how to get an App ID and Secret Key for your Facebook Feed:
https://www.youtube.com/watch?v=JGY9mQkRxK0

You can also read our step-by-step tutorial on the process [here](http://goldplugins.com/documentation/wp-social-pro-documentation/how-to-get-an-app-id-and-secret-key-from-facebook/ "How To Get An App ID and Secret Key From Facebook")

Once you have your App ID and Secret Key, you will need to place them in the appropriate fields on the Settings page, for our plugin to work.

= Outputting the Facebook Event Feed =
* This is no different than outputting a normal Page Feed!  Just follow the instructions below and our plugin will detect what type of feed is being displayed.
* To Reverse the Order of Events, use the Reverse Event Order option on the Pro Event Options tab.  If you are using the Free version of the plugin, you'll need to [purchase WP Social Pro](http://goldplugins.com/our-plugins/wp-social-pro/ "Purchase WP Social Pro") first.

= Outputting the Facebook Feed =
* To output the custom Facebook Feed, place `[ik_fb_feed colorscheme="light" use_thumb="true" width="250" num_posts="5"]` in the body of a post, or use the Appearance section to add the The IK Facebook Plugin Widget to your Widgets area.  Valid choices for colorscheme are "light" and "dark"  If 'use_thumb' is set to true, the value of 'width' will be ignored.  If 'use_thumb' or 'width’ is not set, the values from the Options page will be used.  If id is not set, the shortcode will use the Page ID from your Settings page.  All of the options on the widget will use the defaults, drawn from the Settings page, if they aren't passed via the widget.
* You can also use the function `ik_fb_display_feed($colorscheme,$use_thumb,$width)` to display the custom facebook feed in your theme.

= Outputting the Facebook Like Button = 
* To output the Like Button, place `[ik_fb_like_button url="http://some_url" height="desired_iframe_height" colorscheme="light"]` in the body of a post.  Valid choices for colorscheme are "light" and "dark".
* You can also use the function `ik_fb_display_like_button($url_to_like,$height_of_iframe,$colorscheme)` to output a like button in your theme.

= Outputting a Facebook Photo Gallery = 
* To output a Photo Gallery, place `[ik_fb_gallery id="539627829386059" num_photos="25" size="130x73" title="Hello World!"]` in the body of a post.  If no size is passed, it will default to 320 x 180.  Size options are 2048x1152, 960x540, 720x405, 600x337, 480x270, 320x180, and 130x73.  If num_photos is not passed, the Gallery will default to the amount set on the Dashboard - if no amount is set there, it will display up to 25 photos.  The ID number is found by looking at the URL of the link to the Album on Facebook

== Frequently Asked Questions ==

= Help!  I need a Facebook App ID / Facebook Secret Key! =

OK!  We have a great page with some helpful information [here](goldplugins.com/documentation/wp-social-pro-documentation/how-to-get-an-app-id-and-secret-key-from-facebook/ "Configuration Options and Instructions").

Follow the information on that page to create a Simple Facebook App - you'll be guided along the way to get your App ID, Secret Key, and any other info you may need.

= Ack!  All I see is 'IK FB: Please check your settings.' - What do I do? =

It's all good!  This just means there is no feed data - this could be due to bad settings, including a bad Page ID, App ID, or Secret Key, or it could be due to some other error.  Be sure to check your Facebook Page's Privacy Settings, too!  Check the plugin instructions for help (or send us a message if you think it's an error.)

Some people have options enabled that hide any items from being shown, such as Show Only Events.  If you have no future events scheduled and Show Only Events is enabled, you will see no feed items and an error message on the Help & Status screen.

= So what's up with this 'Publicly Accessible Page' thing? =

OK, so here's the deal:

Your Facebook Feed needs to come from a Publicly Accessible Facebook page.  If your page is Private, if it’s a Personal Profile and not a Page, or if you have an Age Limit set that thus requires the user to login, the plugin won't be able to display the feed data (it will instead just display the page title, like button, and profile pic - even that can be dependent upon your settings.)

Here's how to test if your page is Public or Private:

Logout of Facebook and then try to visit the Facebook Page in question.  If Facebook wants you to login to be able to view the Feed, then this page is not Publicly Accessible.  You just need to update the Page's relevant settings so that it is.

= Yo!! My Photos aren't showing up in my Feed.  What gives?? =

Check it - this typically occurs due to either the Show Photos in my Feed option not being checked or due to the App ID and Secret Key being in development mode, or being rate limited.  If you suspect the App ID and Secret Key are the issue, go ahead and generate a new pair to use on this site.

= I've set an image width on the options page, but it isn't working! =

No worries!  Did you include any non-integer characters?  Be sure the width is just something like "250" (ignore the quotes) - you don't need to include "px".

= Instead of a Like Button, all I see is "Error"! =

That probably means the URL you've given the Like Button is invalid.  Sometimes this happens in the feed widget, if the URL isn't a valid Facebook Page.

= Other people's posts are showing up on my wall!  How do I stop it? =

If you are using the Free version of the plugin, you'll need to [purchase WP Social Pro](http://goldplugins.com/our-plugins/wp-social-pro/ "Purchase WP Social Pro") first.  Once installed, look for the option titled "Only Show Page Owner's Posts".  When that is checked, these posts will be hidden from view.

= Hey!  I need more control over the styling of my feed, but I don't know CSS! =

If you are using the Free version of the plugin, you'll need to [purchase WP Social Pro](http://goldplugins.com/our-plugins/wp-social-pro/ "Purchase WP Social Pro") first.  Once installed, look for the long list of options under the heading "Display Options".  You will be able to use these to control font size and color for all of the different text elements, feed width and height for the in page and sidebar versions each, and more being added all the time!

= I see this plugin uses caching. Do I need to do anything for this? =

Nope!  Thanks to the WordPress Transient API, all you have to do is sit back and relax and we'll do the rest!

= I think I broke my date formatting!  Help! =

It's OK!  Just place %B %d in the field, and you'll be back to default!

= I Want All Of My Posts Visible -- Not Contained In A Box! =

Try using the "No Style" theme -- this will output everything in a list.  You can also turn off the Like Button, Feed Title, and Profile Pic to have it look more like a list of posts.

= I Want Even More Themes To Choose From For My Feed =

The Pro version of IK Facebook has tons of themes!  [purchase WP Social Pro](http://goldplugins.com/our-plugins/wp-social-pro/ "Purchase WP Social Pro")

= I Want All To Show The Number of Likes In My Facebook Feed! =

The Pro version of IK Facebook has this functionality - [purchase WP Social Pro](http://goldplugins.com/our-plugins/wp-social-pro/ "Purchase WP Social Pro")

= I Want All To Show Avatars In My Facebook Feed! =

The Pro version of IK Facebook has this functionality - [purchase WP Social Pro](http://goldplugins.com/our-plugins/wp-social-pro/ "Purchase WP Social Pro")

= I Want All To Show Comments In My Facebook Feed! =

The Pro version of IK Facebook has this functionality - [purchase WP Social Pro](http://goldplugins.com/our-plugins/wp-social-pro/ "Purchase WP Social Pro")

= Urk!  How to find my Album's ID for outputting a photo gallery? =

OK, try this: looking at the following URL, you want to grab the number that appears directly after "set=a." and before the next period - 
facebook.com/media/set/?set=a.**539627829386059**.148135.322657451083099&type=3

In this case, the Facebook Album ID is '539627829386059'.

== Screenshots ==

1. This is the Plugin Status & Help Tab.  This tab provides example shortcodes, a quick summary of settings, and other means of help and support.
2. This is the Configuration Options Settings page of the IK Facebook Plugin.
3. This is the Style Options Settings page of the IK Facebook Plugin.  These settings help you control the visible appearance of your custom facebook feed.
4. This is the Display Options Settings page of the IK Facebook Plugin.  These settings help you control what content appears in your custom facebook feed.
5. This is the Facebook Feed Widget and the Facebook Like Button Widget of the IK Facebook Plugin.  The options on this widget allow you to override the settings you have selected on your Settings panel.

== Changelog ==

= 2.14.1 =
* Address issue with $this being called in non-object context in two public functions.

= 2.14 =
* Minor fixes.
* Codebase cleanup, performance enhancements.
* Compatible with WP 4.4.2.

= 2.13 =
* Update: adds text-domain and sets up for proper translation, adds partial Spanish translation, removes instances of deprecated WPLANG usage.
* Update: arranges Options in a more logical manner.
* Update: clean up redundant functions.

= 2.12.9 =
* Fix: address issue with html tags being displayed or truncated incorrectly.

= 2.12.8 =
* Fix: address issue with message not being properly truncated in certain situations.

= 2.12.7 =
* Update widgets for WordPress 4.3 compatibility
* Fix: output nothing when no settings have been entered (page id, app id, secret key), but the widget is displayed anyway

= 2.12.6 =
* Fix: address issue with bad photo read more links in FB Groups.

= 2.12.5 = 
* Fix: Bust cache when options change

= 2.12.4 = 
* Fix: Bust cache when options change
* Fix: Default to "no selection" on typography options
* Fix: Update method for loading user profile photos

= 2.12.3 = 
* Update: fix issue with settings not taking on widgets

= 2.12.2 =
* Bugfix: use HTTPS to embed Google webfonts when needed

= 2.12.1 =
* Update: lowers cache time on feeds to 15 mins
* Bugfix: handle caching of multiple feeds properly
* Bugfix: address issue with incorrect truncating of item message
* Bugfix: address character encoding with non-US character sets in Comments.
* Compatible with WP 4.2

= 2.12 =
* Update: adds caching to ik_fb_feed shortcode to improve load times
* Compatible with WP 4.1.2

= 2.11.1 =
* Update: sets timezone to local time (as configured on the site) before outputting event dates.

= 2.11 =
* Update: allows setting of date range window for displaying Posts and Events
* Update: compatible with Graph API v2.3
* Update: Adds many more example shortcodes and improves setup process
* Fix: various minor fixes.

= 2.10 =
* Update: Adds Support For Multi-Photo Posts, Facebook Stories, Shared Posts, and More!

= 2.9.6 =
* Fix: address issue with undefined constant WP_LANG

= 2.9.5 =
* Fix: address 400 error generated when a Google Font wasn't selected in the Typography options.
* Update compatibility to WP 4.1.1

= 2.9.4 =
* Feature: Adds shortcode generator.
* Notice: George is bad at Mario Kart.

= 2.9.3 =
* Update: Exposes many more attributes via shortcode.
* Fix: Correct Alt Text on Success / Fail checkboxes on status page.
* Fix: Address undefined index notices and php shorttag issue with Bikeshed.
* Fix: Address issue where some Graph queries were timing out, throwing various Feed Not Loading errors.

= 2.9.2 =
* Update: compatibility to WP 4.1
* Update: enhanced error reporting for assistance troubleshooting
* Fix: address jQuery issue in Bikeshed.

= 2.9.1 =
* Fix: address issue caused by introducing PHP namespaces.

= 2.9 =
* Feature: Add Typography inputs to the Feed Style Options.
* Upgrade: Clean up styling and layout of various options.

= 2.8.4 =
* Change the way we query FB Events API to no longer grab events that occurred in the past and to no longer limit events to those within the next two weeks.
* Pro Feature: Events Options - Event Date Range and Event Image Size options.

= 2.8.3 =
* Fix: stop outputting br's in img alt text.
* Fix: address incorrect error message on feed status screen.

= 2.8.2 =
* Fix: address warning with nl2br when empty string was being passed.

= 2.8.1 =
* Pro Option: Add Date Formatting Control to the Event Options.
* Fix: correctly parse newlines into br's
* Fix: make links clickable

= 2.8 =
* Pro Feature: Events Options tab with option to reverse the order of events in your events only feed.
* Update: address some user reported issues with the event feed.

= 2.7.7 =
* Update: Adds new status widget to Plugin Status & Help Page.
* Update: Cleans up messaging on Status & Help page.

= 2.7.6 =
* Increase timeout on wp_remote_get to account for occasionally slow FB API responses.
* Fix typo causing a PHP Notice to appear.

= 2.7.5 =
* Adds API Key registration method.

= 2.7.4 =
* Adds notifications if required settings are not present.

= 2.7.3 =
* Fix unset var notice.
* Fix issue where page owner only queries are limited by FB to 100 returned posts, causing an issue when trying to load more than 100 at a time.
* Speed up page owner only query load times.

= 2.7.2 =
* Address issue where certain feed items, such as stories about a user liking their own post, were taking up space in the feed object, thus making it appear as if no items or less items than requested are actually loading.

= 2.7.1 =
* Address issue where height and width of the feed window are backwards.

= 2.7 =
* Updates compatibility to WP 4.0.
* Codebase upgrade.

= 2.6.4.4 =
* Address issue where page ID wasn't properly set on photo links.
* Update compatibility for WordPress 3.9.2.

= 2.6.4.3 =
* Address issue where blank line items might appear in your feed.

= 2.6.4.2 =
* Address issue with Posted Date not displaying if Show Posted By was not checked.

= 2.6.4.1 =
* Address some reports of feed not loading.

= 2.6.4 =
* Update: allow users to control whether the Picture appears before or after the Message, via the Custom HTML options.
* Fix: address error in setting custom image size for feed images.

= 2.6.3.8 =
* Update: Address some feed loading errors.
* Update: Change how feed is loaded when showing page owner posts only, preventing multiple different errors and improving performance.

= 2.6.3.7 =
* Update: Add better error handling to prevent some user reported errors.

= 2.6.3.6 =
* Update: Add mb_substr support for users with different character sets, such as Korean.
* Update: Output photo description or caption with thumbnails as well as with full sized photos.

= 2.6.3.5 =
* Update: Fix logic to accurately reflect the number of likes and comments on feed items.

= 2.6.3.4 =
* Update: alter photo gallery output to address sizing issues with image containers.

= 2.6.3.3 =
* Update: a few more markup tweaks.

= 2.6.3.2 =
* Update: addresses some markup validation errors and warnings.

= 2.6.3.1 =
* Update: replaces some deprecated functions.
* Update: addresses some markup validation errors and warnings.

= 2.6.3 =
* Update: change various links / wording to match new website
* Feature: adds ability to control the color and font size of the Posted On Date in the Facebook Feed.

= 2.6.2.2 =
* Fix: Address issue with improperly set default feed item limit affecting multiple different situations.

= 2.6.2.1 =
* Fix: Address issue with error handling and WP HTTP API.

= 2.6.2 =
* Update: replaces PHP's Curl library with WordPress' HTTP API
* Fix: updates feed parser to address some issues.

= 2.6.1 =
* Feature: adds ability to control the format of the post date.
* Fix: addresses various minor items.

= 2.6 =
* Feature: adds multi language and regional support!  We will add new language options to the plugin as we complete our translations!
* Feature: adds ability to filter feed to only show Events!
* Fix: miscellaneous fixes.

= 2.5.8 =
* Fix: address issue with image link title being output incorrectly, causing broken HTML in the feed.

= 2.5.7 =
* Fix: address issue with Height in Like Button shortcode.

= 2.5.6 =
* Feature: adds Like Button Widget for Sidebar.
* Update: add some sanitation to various Options.
* Update: format Style Options screen to be more user-friendly.  Add ability to set height of images and feed window to 100%, as well as specific pixel sizes.
* Update: modify output of title attribute on photo links for compatibility with some lightbox javascripts, such as foobox

= 2.5.5.1 =
* Fix: address issue where non-thumbnail images had broken sources if the link to facebook item option was enabled.

= 2.5.5 =
* Feature: ability to control where photos link.

= 2.5.4 =
* Fix: address CSS issue in Blue Theme.

= 2.5.3 =
* Feature: Expands Event Support - now allowed to embed the Feed specifically from an Event's Page!  Plugin will automatically detect if this is an Event Feed.

= 2.5.2 =
* Minor Fix: Remove duplicate theme.
* Fix: Address conflict preventing custom styling options from working correctly.

= 2.5.1 =
* Quick Fix: Fix bad path to Dark Theme stylesheet.

= 2.5 =
* Pro Feature: Adds tons of new themes!  Including the Pro Halloween theme - just in time!
* Feature: Many Styling Options have been added - and more will come!  No need to know CSS.
* Update: Use WordPress Language Setting for outputting time formats.
* Update: Reorganize options to be easier to find.  Update descriptions to be easier to understand.
* Fix: Link Read More to individual object on Facebook.

= 2.4.1 =
* Fix: Address issue with Shared Images not coming through in the feed correctly.
* Fix: Address issue where shared links with text were only outputting the URL of the link and not the shared text.

= 2.4 =
* Feature: Ability to set number of photos displayed in a gallery via the Shortcode or Dashboard.
* Feature: Much improved configuration error reporting - no more public facing IK FB messages in your feed.
* Feature: Plugin Settings & Help Screen.  This screen will show you your settings, help you troubleshoot what may be wrong (if you're having trouble), and will show you example shortcodes to use.
* Fix: Allow more than 25 items to be displayed in the Feed.
* Fix: Address issue where Thumbnail sized photos were always displayed in the feed, regardless of Settings.
* Minor Fix: Allow more than 25 photos to be displayed in a Photo Gallery.
* Minor Fix: Compute Event Date times differently.
* Minor Fix: Update caching method to speed up page load times.

= 2.3.1 =
* Fix: Address end date and time zone issues with Events.

= 2.3 =
* Feature: adds support for Events.

= 2.2.6 =
* Fix: address issue where number of items displayed was defaulting to 2, if not limit had ever been set previously.
* Fix: address CSS issue with Powered By output.

= 2.2.5 =
* Bug Fix: fix issue where site-wide image width settings were being ignored in the Widget version of the feed.
* Minor Feature: add option to control the width of images in the Widget, via Widget settings.

= 2.2.4 =
* Minor Update: Adds Full List of Options to Widget

= 2.2.3 =
* Bug Fix: Address issue where the absolute path to the custom stylesheet (if you were using one in your theme directory) was being used instead of the URI, causing the stylesheet not to load.

= 2.2.2 =
* New Feature: Ability to pass the Page ID of the Facebook Page via the shortcode - this allows you to add more than one Facebook account to a given page!
* Bug Fix: Address PHP error with unset data when using the Template Function to add the facebook feed.

= 2.2.1 =
* Minor Update: adds support for new feature - limit number of posts displayed via the shortcode.

= 2.2 =
* New Feature: Ability to Embed Facebook Photo Galleries into your Website!
* Fix: when no full-sized photo is parsed from the feed, fallback to using the thumbnail photo.
* Minor Fix: CSS adjustments.

= 2.1.2 =
* Bug Fix: addresses issue where thumbnail sized photos were always being sourced, leading to blurry photos when trying to display larger versions in the feed.

= 2.1.1 =
* Minor Fix: addresses a spacing issue in the number of likes for comments.

= 2.1 =
* Feature: Adds ability to display comments in the feed.  Comments also support other IK Facebook options, such as Posted on Date, Avatars, and Number of Likes.

= 2.0 =
* Update: Upgraded feature set and interface to integrate IK Social Pro and IK Facebook.
* Feature: Adds ability to display user avatars in the feed.
* Feature: Adds ability to show number of comments in the feed.
* Feature: Adds ability to show number of likes in the feed.
* Minor Feature: Adds ability to disable pro styling options

= 1.9.1 =
* Update: Compatible with 3.6
* Update: Adjust Settings Output for New Pro Options

= 1.9 =
* Update: cleans up the layout of the Settings screen
* Update: reposition "Read More" text to a logical place

= 1.8.8 =
* Interface Updates
* Feature: Images in Feed Link to Full Sized Versions
* Feature: Updates Themes to include No Style and Default Style.  The No Style Theme includes no CSS at all -- everything fully inherits from your website.  The Default Theme includes basic styles to adjust the layout of the items of the feed - no colors are applied.
* Fix: No longer upsize thumbnails in the feed to larger than their starting size, when the options to fix the Feed Image height or width are set.

= 1.8.7 =
* Minor Updates

= 1.8.6 =
* Minor Change: Update some wording and buttons on the Settings screen.

= 1.8.5 =
* Feature: Adds Option to display date of post in feed.

= 1.8.4 =
* Feature: Option to Limit the Number of Displayed Characters in Parts of Feed.  Read More is displayed if Post is shortened.

= 1.8.3 =
* Update: change default Feed Title link to go to Feed's FB Page

= 1.8.2 =
* Fix: addressed issue where some URLs were being output relative to the site URL, leading to some broken links.

= 1.8.1 =
* Feature: Adds option to hide Facebook Page Title from the top of the feed.

= 1.8 =
* Feature: Adds Request Caching using the WordPress Transient API, significantly decreasing page load time.
* Update some language on the settings screen, readme file, and screenshot.

= 1.7.1 =
* Feature: Adds option to set the Height of images that are displayed in the Feed.
* Fix: Change Page Title of Settings Page to 'Social Plugin Settings' instead of 'IK Facebook Plugin Settings', when unbranded option is enabled.
* Fix: Address typo on Settings page.

= 1.7 =
* Feature: Adds support for new Pro Features - Individual Font and Feed Styling Options.
* Feature: Adds option to display "Powered By" link.
* Fix: Adds logic to prevent outputting custom CSS multiple times in footer.

= 1.6.5 =
* Feature: Adds Option to Output "Posted By Author" in the feed.

= 1.6.4 =
* Feature: Adds Option to Limit Number Of Displayed Posts.

= 1.6.3 =
* Minor Update: Remove "on Facebook" hardcoded text from Feed Title.

= 1.6.2 =
* Fix: Properly Adds Blue Style.

= 1.6.1 =
* Feature: Adds Blue Style Pre-made Theme.

= 1.6 =
* Feature: Adds Optional Pre-made Feed Themes.

= 1.5.2 =
* Fix: fix order that Custom CSS is loaded to guarantee that the custom styles are used
* Fix: remove inline styling from Like Button and place it in CSS file, instead.

= 1.5.1 =
* Fix: fix issue where the graph data didn't contain a properly formed link, leading to an Error message being output instead of the Like Button.

= 1.5 = 
* Feature: Adds support for new Pro Feature - Custom HTML.
* Update: remove branding from Settings Updated message.
* Update: update method of building and outputting the feed.
* Update: Change some wording throughout.
* Fix: fix bad image output when URL to full-sized photo was not set.

= 1.4 = 
* Feature: Adds support for new Pro Feature - Unbranded Dashboard
* Update: Output options more efficiently

= 1.3.4 =
* Fix: output already started error.

= 1.3.3 =
* Fix: fix shortcode output always appearing at the top of the_content()

= 1.3.2 =
* Fix: Fix issue when The IK Facebook Plugin Pro package was deactivated.

= 1.3.1 =
* Readme Update

= 1.3 =
* Feature: Introduces support for the IK Social Plugin Pro, a premium enhancement plugin that provides additional useful features.
* Updates plugin to be compatible with WordPress 3.5.1.

= 1.2.1 =
* Fix: Fix issue that was causing Profile Photo to not load for some Facebook Profiles.

= 1.2 =
* Feature: Adds option to set width of images displayed in feed.  Will use high-res images if this option is enabled, otherwise output thumbnails.
* Feature: Adds ability to output the Dark or Light color scheme for the Like Button, both in the Feed, Widget and the standalone Like Button.

= 1.1.2 =
* Only load custom style sheet if one exists.

= 1.1.1 =
* Adds Option to Show / Hide Profile Picture.

= 1.1 = 
* Feature: Adds ability to embed Like Button, without Feed.
* Feature: Adds functions to output Feed and / or Like Button in theme files.
* Clarifies installation instructions.
* Simplifies setup process.

= 1.0.9 =
* CSS compatibility adjustment.

= 1.0.8 =
* Feature: can now create a CSS file in your theme directory titled 'ik_fb_custom_style.css' - these styles will automatically be loaded by the plugin.

= 1.0.7 =
* Bug fix: remove double output of wrapping widget tag.
* Feature: added option to show or hide the Like Button (hidden by default).

= 1.0.6 = 
* Cleanup Widget markup, using WordPress $before and $after markup.

= 1.0.5 =
* Adds Title Field to Widget.
* Allows multiple Widgets to be active on the site at once.

= 1.0.4 =
* Pull Page Link, Page Name, from Open Graph instead of user options.

= 1.0.3 =
* Readme Updated (again).

= 1.0.2 =
* Readme Updated.

= 1.0.1 =
* Typo fix.

= 1.0 =
* Released!

== Upgrade Notice ==

* 2.14.1: Priority bug fix!