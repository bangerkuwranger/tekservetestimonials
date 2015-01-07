Tekserve Testimonials
====================

Wordpress plugin to create a custom post type for Press Mentions. Includes custom fields for the source's name and company, and a shortcode to display testimonials in Genesis themes.


Contributors: bangerkuwranger

Donate link: http://www.chadacarino.com/burnallmoney.html

Tags: custom post type, custom fields, testimonials, quotes

Requires at least: 3.1

Tested up to: 4.1

Stable tag: 1.1

License: MIT

License URI: http://www.chadacarino.com/license-mit.html

Wordpress plugin to create a custom post type for Testimonials. Includes custom fields for name and organization of the quote source.

== Description ==

It's easy to create simple custom post types, and create functional dependencies in your theme while doing so. Skip it! Use this plugin to create a theme-independent custom post type for your site to maintain a collection of testimonials. We use it for storing all of our awesome customers' feedback in on our site, but you can store and call any type of quotations in your site with this plugin. Easy.

== Installation ==

1. Upload the `tekservetestimonials` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Start creating your collection of quotes in the 'Quotes and Testimonials' item in WordPress

== Frequently Asked Questions ==

= How do I show my quotes on a page? =

It's pretty easy to call custom post types in the loop, and you can display a single post with some code for a custom shortcode. This plugin includes a shortcode that is compatible with the Genesis framework; if enough people ask I can do a little more to add compatibility outside of the Genesis framework.

= Can I display a section with rotating quotes? =

Sure! You'll have to write the rotator, and you can set up an admin panel to select the quotes, or just use shortcode attributes. However, there are already many existing plugins that already provide this function, and that may be easier for you to implement. This was written to provide a lightweight implementation of a specific function: to enter, store, and display a single quote at a time.

= Can I display more than one quote on a page? =

Yep. You can either use the shortcode several times to display multiple specific quotes:

`[tekserve-testimonial id="1"] [tekserve-testimonial id="2"] [tekserve-testimonial id="3"]`

Or assign a Testimonial Type to a set of quotes and display them in an unordered list with a single shortcode:

`[tekserve-testimonial type="just-these"]`

= How do I find a quote in the Testimonials list? There's no title! =

Actually, there is a title, you just don't choose it yourself. This plugin automatically assigns your testimonial a title that shows you the quote, source, and id (for the shortcode).


== Changelog ==

= 1.0 =
* added custom taxonomy for testimonial type to allow for sorting and displaying sets of quotes
* added Genesis compatible shortcode to display a quote or set of quotes on a page or post
* added sort by Testimonial Type to admin
* fixed display code and save action
* added auto-title

= 1.0a =
* added custom post type
* added fields

== Upgrade Notice ==

= 1.0 =
Make sure that you are using the Genesis framework if you'd like to use this shortcode; otherwise the custom fields won't display on your page!