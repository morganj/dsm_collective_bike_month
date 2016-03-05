=== FB Display Events Shortcode ===
Author: Krzysztof Kuziel KrzyKuStudio
Author URI: <http://www.krzykustudio.pl>
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=E6LKSXS2ZK432&lc=US&item_name=KrzyKuStudio&item_number=FB%20Display%20Events%20Shortcode&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: Facebook, shortcode, event, events, fb, list
Requires at least: 3.1
Tested up to: 4.3.1
Stable tag: 1.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display Facebook Events in your website using shortcode.

== Description ==

The FB Display Events Shortcode plugin allows you to display list of events from a Facebook on your website using shortcode.

Features:

*	Display facebook user's events by user name or user_id.
*	Display facebook single event by its ID
*	English, Deutsch and Polish translation included.

= Requirements =

* 	Facebook Developer Access Token

= Usage =

1. To display user's events by facebook user name use shortcode [fb_event_list] with attribute fb_user_name, example [fb_event_list fb_user_name="user_name"]
2. To display user's events by facebook user_id use shortcode [fb_event_list] with attribute fb_user_id, example [fb_event_list fb_user_id="342353464567"]
3. To display single event use shortcode [fb_event_list] with attribute fb_event_id, example [fb_event_list fb_event_id="4234464534534"]
4. Optional attributes:
	- fb_time="upcoming, past, all" - Display upcoming, past or all user's events
	- limit="value" - limits the number of displayed user's events to a given value

== Installation ==

= Automatic =

1. In the admin panel plugins page click Add New
2. Search for FB Display Events Shortcode
3. Find FB Display Events Shortcode in the list an click Install Now
4. Click OK when prompted
5. Click activate plugin when prompted
5. In the admin panel under Settings click on FB Event List. Paste your Facebook Developer Access Token in form and save it.
6. Enjoy!

= Manual =

1. Extract fb-display-events-shortcode.zip to your `wp-content/plugins` directory.
2. In the admin panel under plugins activate FB Display Events Shortcode.
5. In the admin panel under Settings click on FB Display Events. Paste your Facebook Developer Access Token in form and save it.
4. It should now be completely set up and functional
5. Enjoy!

== Frequently Asked Questions ==

= How to get Facebook Developer Access Token =

To get Facebook Developer Access Token, register at developers.facebook.com and create new App.
Simply go to <https://smashballoon.com/custom-facebook-feed/access-token/> and follow instructions.

= How to get Facebook User Name =

Go facebook page from you want get username, example https://www.facebook.com/happysadpl/?fref=nf In that case username is happysadpl
xxxxxx refers to the Facebook user's name: http://facebook.com/xxxxxxx/?otherCharacters 

= How to get Facebook User ID =

Paste that URL into browser https://graph.facebook.com/XXXXXX?access_token=YYYYY and replace XXXXXX with Facebook User Name, YYYYYY with your access_token
You will get json Response with id. 

= How to get Facebook Event ID =

Go to the facebook event from which you want to get an ID. Get the URL from the webbrowser. 
xxxxxx refers to the event id: https://www.facebook.com/events/xxxxxx/

Example https://www.facebook.com/events/923003774401481/
In that case fb_event_id=923003774401481

= Country name is not showing on local development using xampp on windows =

That is: cURL Error # 60: SSL certificate problem: unable to get local issuer certificate
Follow this link: http://curl.haxx.se/ca/cacert.pem Copy the entire page and save it in a: "cacert.pem". 
Then in your php.ini file insert or edit the following line: curl.cainfo = "[pathtothisfile]\cacert.pem"
example curl.cainfo = "c:\xampp\cacert.pem"

== Screenshots ==

1. Event List
2. Single Event in detail
3. Settings Page

== Changelog ==

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0 = 
Initial release