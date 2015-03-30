=== Caldera Metaplate ===
Contributors: Desertsnowman, Shelob9
Tags: custom fields, pods, advanced custom fields, custom field suite, templating, meta fields
Requires at least: 3.9
Tested up to: 4.2-alpha
Stable tag: 0.3.1
License: GPLv2+
Donate Link: https://calderawp.com

Caldera Metaplate: WordPress Templating Tool For Custom Fields

== Description ==
<strong>Integrate Your Custom Fields With Any Theme Without Leaving The WordPress Admin!</strong>

Caldera Metaplate, by [CalderaWP](https://CalderaWP.com) gives you a simple, handlebars.php-based, template editor for WordPress posts, including custom post types. Provides an easy way to show your custom field values with almost any theme.

For more information on how to use this plugin, see: [https://calderawp.com/free-plugin/caldera-metaplate/](https://calderawp.com/free-plugin/caldera-metaplate/)

https://www.youtube.com/playlist?list=PLgeaHmX3MoiuxxCdHFbTFxlXlrlegBxCR

=== Works With ===

* Meta fields added by Advanced Custom Fields

* Meta fields added by Custom Field Suite

* Meta fields added to post type Pods.

* Custom fields added with the custom field UI.

* Probably any custom field. We have not tested beyond Pods, ACF and CFS, yet:)


== Installation ==
Install & Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==
= Can I Use Post Fields, Like Post Content? =
Yes you can. Use `{{content}}`
= Does It Work With Meta Fields Added With The Custom Field UI? =
Yep.

= What type of Pods Does It Work With? =
Post type Pods using the default meta storage method.

= Does It Work With Advanced Custom Fields Loop Field? =
Yes it does!

== What About Custom Field Suite Repeater Fields? =
Totally.

== Screenshots ==
1. **Template Editor** - Handlebars.php based templating.
2. **Set Your Post Types** - Choose which post types to use a metaplate with and where to output the template.


== Changelog ==

= 0.1.1 ( January, 2015 ) =
Initial release to WordPress.org

= 0.2.0 =
Bug fixes

= 0.3.0 =
Bug fixes.
ADDED: Ability to load metaplates from file system.
ADDED: Is conditionals for boolean template tags.
ADDED: Fixed. Shortcodes in metaplates not working when metaplate is outputted with a shortcode. #18

= 0.3.1 =
FIXED: Busted vendor dir on WPORG. #19
UPGRADED: magic-tags package, allowing auto-generated excerpts to be used.


== Upgrade Notice ==
still new, so nothing to upgrade.
