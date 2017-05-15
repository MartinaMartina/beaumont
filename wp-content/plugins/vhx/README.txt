=== VHX Checkout Embed ===
Contributors: VHX
Tags: vhx,movies,video,commerce,e-commerce,widget
Requires at least: 1.2
Tested up to: 4.3
Stable tag: trunk
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds the VHX Checkout Embed to your site to enable a seamless checkout experience.

== Description ==
Any link on any page pointing to http://yoursubdomain.vhx.tv/buy or http://yourfulldomain.com/buy will be picked up by the checkout embed. Whenever someone clicks on those links will automatically slide out the checkout form to purchase on your site.

Additionally, you can additionally set specific data-vhx-site attributes on individual links to override your primary one set on the script tag. It looks like this:

&lt;a href="http://drafthouse.vhx.tv/buy/the-final-member" data-vhx-site&gt;Buy This Movie&lt;/a&gt;

== Installation ==
1. Download the plugin
2. Unzip the plugin
3. Upload the entire `vhx-buy-widget` directory into your to the `/wp-content/plugins/` folder
4. Visit your 'Plugins' page inside your Wordpress Admin and Activate the VHX plugin
5. Visit the new "VHX Widget" panel in your sidebar
6. Add your primary VHX subdomain and click Save
7. You're done!

== Frequently Asked Questions ==

= I need help! Can you help me? =

Yep, just shoot us an email at sell@vhx.tv

= I want to link to another VHX site other than my primary domain? Can I do that? =

Yep! Just add "data-vhx-site" on any link to have it trigger the sliding action. Be advised, this may require entering into your Advanced HTML view!

== Screenshots ==

1. The VHX Purchase Widget in action!

== Changelog ==
= 1.2 =
Removed option for displaying 'tabs', always off now

= 1.0  =
Sliding VHX Purchase Widget Launch!

== Changelog ==
No known issues
