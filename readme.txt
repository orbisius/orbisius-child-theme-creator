=== Child Theme Creator by Orbisius ===
Contributors: lordspace,orbisius
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7APYDVPBCSY9A
Tags: theme,child theme,childtheme,childthemes,parent theme,child themes,CSS,styling,resposive design,design,custom themeing, shared hosting,theme editor theme,themes,wp,wordpress,orbisius,theme creator,custom theme,theme generator,css,css editor
Requires at least: 3.4
Tested up to: 4.4
Stable tag: 1.3.0
License: GPLv2 or later

Create Child Themes quickly and easily from any theme that you have currently installed on your site/blog.

== Description ==

This plugin allows you to quickly create child themes from any theme that you have currently installed on your site/blog.
It also creates rtl.css if exists in the parent theme.

**Did you find this plugin helpful? Please consider [writing a review](https://wordpress.org/support/view/plugin-reviews/orbisius-child-theme-creator).**

= Child Theme Creator Features =
* Create a theme with a click of a button
* Never forget what files to copy and what to skip when creating child themes.
* Easy to use interface
* When moving through the themes the currently looked one will have a nice background & border
* Create *unlimited* child themes from a parent theme. The plugin will add Child 01, Child 02 etc.
* Edit theme files with our two theme editors.
* Automatically creates rtl.css if it exists in the parent theme
* The plugin uses minified css/js to make sure it loads quicker.

This plugin allows you to quickly edit theme files from Appearance &gt; Orbisius Theme Editor (entry added by the same plugin)
It features two editors and you can pick snippets from one theme and paste into another.

= Theme Editor Features =
* Edit two theme files at the same time
* Ajax -> No page refresh
* Easy to use interface
* Supports WordPress Multisite
* Create a New File (+ checks if the file exists)
* Delete file
* Respects the DISALLOW_FILE_EDIT constant, which if set to true will disable the Theme editor
* Since (v1.1.3) PHP syntax check
* Since (v1.1.3) Send selected theme and parent theme (if any) to yourself or a colleague.
* Since (v1.1.3) Implemented theme files to be listed recursively (i.e. all files from the selected theme)
* Since (v1.1.9) Both editors have the same buttons (in older versions only the left editor had all of the buttons).
* Since (v1.2.2) Can create a blank functions.php file (Thanks Tobias Kaupat for the suggestion)
 = Important Reasons to Create Child Themes =
* Keep your changes when the parent theme is updated.
* Reduce duplicated code i.e. you need to copy and customize only the files that need to be customized
* Child Themes are often very small in size and can easily be shared and used for another project.
* Lots of cool and professional people do it
* ... and a lot more

= Pro Addon is Now Available =
We've just released the
    <a href="http://club.orbisius.com/products/wordpress-plugins/orbisius-child-theme-creator-pro/?utm_source=orbisius-child-theme-creator&utm_medium=readme&utm_campaign=product"
                     target="_blank" title="[new window]" style="font-weight: bolder;color:red;">Pro Addon</a> which improves on the current functionality.

= Important =
> We have noticed that some child themes created by this plugin do not work as expected.
> This is not a bug in this plugin but could be caused by theme authors using custom theme frameworks and/or do not using WordPress' recommended functions for themes that support child themes.
> Please check with the created of the theme first to see if their theme supports child themes.

We have launched a **FREE** service that allows you to setup a test/sandbox WordPress site in seconds. No technical knowledge is required.
Join today and test themes and plugins before you actually put them on your live site. For more info go to:
<a href="http://qsandbox.com/?utm_source=orbisius-child-theme-creator&utm_medium=readme&utm_campaign=product" target="_blank" title="Free Test/Sandbox WordPress Site">http://qsandbox.com</a>

= Usage : To create a child theme go to =
Go to Admin > Appearance > Orbisius Child Theme Creator then click on the theme you like and the child theme will be created for you.

= Usage : To edit themes files go to =
Go to Admin > Appearance > Orbisius Theme Editor then click on the theme you like and the child theme will be created for you.

= Demo =
http://www.youtube.com/watch?v=BZUVq6ZTv-o

= Premium =
Do you want to be able to preview themes from within the 2 editors?
Get this <a href="http://club.orbisius.com/products/wordpress-plugins/orbisius-theme-switcher/?utm_source=orbisius-child-theme-creator&utm_medium=readme_description&utm_campaign=product" target="_blank" title="[new window]">Orbisius Theme Switcher</a> plugin

= Support =
> Support is handled on our site: <a href="http://club.orbisius.com/" target="_blank" title="[new window]">http://club.orbisius.com/</a>
> Please do NOT use the WordPress forums or other places to seek support.

= Author =

Do you need an amazing plugin created especially for your needs? Contact me.
Svetoslav Marinov (Slavi) | <a href="http://orbisius.com" title="Custom Web Programming, Web Design, e-commerce, e-store, Wordpress Plugin Development, Facebook and Mobile App Development in Niagara Falls, St. Catharines, Ontario, Canada" target="_blank">Custom Web and Mobile Programming by Orbisius.com</a>

= Hire Us =
Do you need any WordPress work done? e.g. WordPress tweaks, new plugin development or existing plugin improvements.

Do you need a trusted <a href="http://orbisius.com/page/free-quote/?utm_source=child-theme-creator&utm_medium=plugin-linksutm_campaign=plugin-update"
                     title="If you want a custom web/mobile app or a plugin developed contact us. This opens in a new window/tab">WordPress Developer</a> to hire?

== Upgrade Notice ==
n/a

== Screenshots ==
1. Plugin page after installation
2. Orbisius Child Theme Creator in Appearance > Orbisius Child Theme Creator - before creating a child theme
3. Orbisius Child Theme Creator in Appearance > Orbisius Child Theme Creator - after creating a child theme
4. Orbisius Theme Editor in Action from Admin > Appearance > Orbisius Theme Editor

== Installation ==

1. Unzip the package, and upload `orbisius-child-theme-creator` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How to use this plugin? =
Just install the plugin and activate it. Then go to Admin > Appearance > Orbisius Child Theme Creator.
Then click on a theme and the plugin will create a child theme for you.

= How to disable Orbisius Theme Editor Plugin? =
Just put this line right after the first <?php tag in the wp-config.php. This will also remove the WordPress' Theme/Plugin editors as well.

define('DISALLOW_FILE_EDIT', true);

= The child theme is created but doesn't have some styles or doesn't show the admin panel of the parent theme =
OK. Please contact the theme author if his/her theme is child theme friendly.
Also which files does the theme need in order to work well.

= My Site is Broken =
!@$@!$. Ok. Calm down. When you created the theme did you click on copy functions.php from advanced options?
Ok. You'll need to use FTP client and go to in the wordpress folder and then wp-content/themes/AAAAA-child-01/ and delete functions.php
AAAAA is of course  the directory of your parent theme.

= I want to be able to copy functions.php =
Please use Orbisius Theme Editor (part of this plugin)

= Troubleshooting =
If your site becomes broken due to a child theme (mis)configuration. Please check another plugin of ours:
<a href="http://club.orbisius.com/products/wordpress-plugins/orbisius-theme-fixer/?utm_source=orbisius-child-theme-creator&utm_medium=readme_troubleshooting&utm_campaign=product" target="_blank" title="[new window]">Orbisius Theme Fixer</a>

= What to do next? =
Go to http://club.orbisius.com and post suggestions in our forum for new features that you'd like to see in this plugin or its extensions.

= Need a custom plugin? =
Let's talk.
<a href="http://orbisius.com/page/free-quote/?utm_source=orbisius-child-theme-creator&utm_medium=plugin-readme-faq&utm_campaign=product"
                                   title="If you want a custom web/mobile app/plugin developed contact us. This opens in a new window/tab"
                                    class="button-primary" target="_blank">Get a Free Quote</a>

Todo
- Add buttons in the WP's Theme listing page near Customize
	- Orbisius Create
	- Orbisius Edit

== Changelog ==

= 1.3.0 =
* Happy new year!
* Copying parent theme's options (if any).
* Tested with WP 4.4.

= 1.2.9 =
* Added a link in the plugin's settings page to point to Appearance → Orbisius Child Theme Creator ( to save 1-2 seconds to the user :) )
* Removed the Free test from qSandbox as there is no longer a free plan.
* Tested with WP 4.3.1

= 1.2.8 =
* Improved security even more. Thanks Mika!

= 1.2.7 =
* Improved security.

= 1.2.6 =
* Fixed a wrong check for the Pro version.
* Tested with latest WP
* Added a call to action to ask users for write a review.

= 1.2.5 =
* Fixes
* Improvements
* Made some fixes so the Pro addon shines even more.

= 1.2.4 =
* Made the plugin more extendable (js).
* Added another Save button near the theme and file dropdowns (for lazy people).
* Added links to the Pro addon.
* Added a nice global wait for all ajax calls.
* Added an error message to be displayed when we're doing ajax and the user is not authenticated.

= 1.2.3 =
* Tested with WP 4.1

= 1.2.2 =
* Added: Create a blank functions.php file option (Thanks Tobias Kaupat for the suggestion).
* Added a link to edit theme after the child theme is created.
* Changed the UI. Parent and Child Themes are nicely separated.
* Added a sidebar in the screen where child themes are created
* Fixed some wrong call to action (left from another plugin).

= 1.2.1 =
* Fixed: A notice in the settings
* Fixed a typo
* Tested with WP 4.0.1

= 1.2.0 =
* Fixed: BUG - Deleting a file from Theme 1 deletes files from Theme 2. Ref: http://club.orbisius.com/forums/topic/bug-deleting-a-file-from-theme-1-deletes-files-from-theme-2/
* Fixes: CSS so the themes are showing up as 3 per row like they used to be.
* Added a link to a larger version of the theme's screenshot.
* Tested with WP 4

= 1.1.9 =
* Added the buttons under the 2nd editor
* Hid the plugin from the Tools menu
* Integrated with <a href="http://club.orbisius.com/products/wordpress-plugins/orbisius-theme-switcher/?utm_source=orbisius-child-theme-creator&utm_medium=readme_changelog&utm_campaign=product" target="_blank" title="[new window]">Orbisius Theme Switcher</a>


= 1.1.8 =
* Tested with WP 3.8.1

= 1.1.7 =
* Added Plugin's links to the admin nav bar.
* Added site preview button in the theme editor

= 1.1.6 =
* Added settings link in the Plugin listing.

= 1.1.5 =
* Added an option if the email couldn't be sent to offer the download links.
* Unsuccessful zip creation was showing as Sent.

= 1.1.4 =
* Minor tweaks after v1.1.3

= 1.1.3 =
* Updated CSS to add some top-margin above the update/save changed buttons
* Added php syntax check
* Added Send button so you can email the selected theme and parent theme (if any) to yourself or a colleague.
* Implemented theme files to be listed recursively (i.e. all files from the selected theme)
* Fixed JS error on Settings page.
* Added uninstall.php file to clean after itself
* Added a check and the notice that shows up on the plugins page won't show up after 24h
* Added Edit Themes link to the Plugin's -> Action links
* Improved and better organized the plugin's settings page

= 1.1.2 =
* Reduced the height of the editors (to 22 rows) so the save/delete buttons are visible
* Restricted the width of the dropdowns in the theme editor so they don't push the editor and the buttons down.
* Tweaked the position of the New File button and the new form that appears.
* Tested with WP 3.8

= 1.1.1 =
* Fix: The version 1.1.0 wasn't released properly.

= 1.1.0 =
* Added a new feature to Customize title, description etc of the new child theme

= 1.0.9 =
* Fixed: JS errors are cause errors with other plugins
* Loads plugin's JS/CSS files only on child theme creator pages (admin area)

= 1.0.8 =
* Tested with WP 3.7.1
* Added New File and Delete operations for Theme Editor #1 (left)
* Respects the DISALLOW_FILE_EDIT constant, which if set to true will disable the Theme editor
* Added a quick fix to use file modification time for the css and js assets.

= 1.0.7 =
* Added: Theme Editor
* - New File, checks for existing file are made on typing.
* - Delete File

= 1.0.6 =
* Tested with WP 3.7
* Loading current theme in the left editor if there is no theme selected yet.
* Reduced the font size of the links in the top right corner of Child Theme Creator and Theme Editor
* Separated Parent themes from Child ones
* Hid the advanced section. Was confusing and scaring people. If you really want to copy functions pass &orb_show_copy_functions parameter to the Child Plugin page.

= 1.0.5 =
* Tested under WordPress Multisite environment
* Added menus in WordPress Multisite environment
* Added an option for network wide theme activation (which is mutually exclusive with make theme active).
* Added double editor for easy theme editing.
* Added Orbisius: Edit to the theme list
* Show a notice in the plugins area to let the user know how to work with the plugin. On multisite the message is shown only on the network site.
* Aded minimized versions for main css and js

= 1.0.4 =
* Tested with wp 3.6.1
* Added a link in the Appearance
* Added header.php to the copied file list
* Added a checkbox in case the user wants to switch to the newly created theme
* Added a checkbox in case the user wants to copy the functions.php from the parent theme
* Removed parent theme's license from the copied list
* Removed the Create Child Theme From themes that are child themes already
* Skipping hidden files (files starting with a dot)
* Copying admin/ from the parent theme if it exists
* Added some security checks if the user actually has permission to install themes
* Fixed some notices

= 1.0.3 =
* Tested with wp 3.6
* Added settings page in case users want to check it.
* Added a few notices about <a href="http://qsandbox.com/?utm_source=orbisius-child-theme-creator&utm_medium=readme_changelog&utm_campaign=product" target="_blank" title="Free Test/Sandbox WordPress Site">http://qsandbox.com</a>

= 1.0.2 =
* Tested with wp 3.5.2

= 1.0.1 =
* Added links to video demo

= 1.0.0 =
* Initial release