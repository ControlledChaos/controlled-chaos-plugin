# Controlled Chaos Plugin

A feature-packed WordPress or ClassicPress starter plugin for building custom-tailored websites.

![WordPress tested on version 5.3.2](https://img.shields.io/badge/WordPress-5.3.2-0073aa.svg?style=flat-square)
![ClassicPress tested on version 1.1.2](https://img.shields.io/badge/ClassicPress-1.1.2-03768e.svg?style=flat-square)
![PHP tested on version 7.3](https://img.shields.io/badge/PHP-tested%207.3-8892bf.svg?style=flat-square)
![ACF Pro Ready](https://img.shields.io/badge/ACF%20Pro-ready-00d3ae.svg?style=flat-square)
![Beaver Builder Ready](https://img.shields.io/badge/Beaver%20Builder-ready-0e5a71.svg?style=flat-square)
![Elementor Ready](https://img.shields.io/badge/Elementor-ready-d30c5c.svg?style=flat-square)
![Gutenberg Ready](https://img.shields.io/badge/Gutenberg-ready-00a0d2.svg?style=flat-square)

![](https://raw.githubusercontent.com/ControlledChaos/controlled-chaos-plugin/master/assets/images/controlled-chaos-github-banner.jpg)

## Plugin Overview

Controlled Chaos Plugin is a tool — a means to an end. It is not intended to be used as is, without further development, however it can be used as such. I use it to build site-specific plugins for clients.

GitHub page for this plugin: [https://controlledchaos.github.io/controlled-chaos-plugin/](https://controlledchaos.github.io/controlled-chaos-plugin/)

### Introduction

Howdy, folks. My name is Greg Sweet. I am sole proprietor, chief cook and bottle washer at [Controlled Chaos Design](http://ccdzine.com/).

I built this plugin as a starter for client sites, including features that I use often, the code for which I repeatedly copied from my [gist library](https://gist.github.com/ControlledChaos). It is not intended to be a plug-and-play type of thing, although it can be used as such. This is more of a developer's tool. I have commented thouroughly on the code and documented the files to the best of my ability. I have learned by looking at the code of others so I have kept this in mind when writing the code for this plugin.

### Approach

Although this plugin comes with my business name incorporated into it, I am not trying to put my branding stink all over your project. It has to have a name so I used my own. However, since I need to rename the plugin for my clients' websites, I have made every effort to use a simple, uniform naming system that can be quicky renamed for your project.

Not every feature included with this plugin will be needed for my projects or yours. And one big reason for writing a site-specific plugin is to include only what the site needs and eliminate the overhead of plugins and themes that offer things that you don't need. So why have I packed so much into this plugin? Well, I find it to be much quicker and easier to remove unnecessary code that it is to write, or even copy & paste, new code into a project. And being that you will rename this plugin and that it will not update to overwrite your changes, modifications can be made ad libidum.

### Requests

If you would like to request development of a custom version of this plugin for your site, or to use as your own starter plugin, then contact Greg Sweet at [greg@ccdzine.com](mailto:greg@ccdzine.com).

## Compatibility

* This plugin was written in a WordPress 4.9+ environment with no concern for backwards compatitbility.
* This plugin was written on a local server running PHP 7.2
* The short array syntax ( `[]` rather than `array()` ) requires PHP 5.4+
* Run a modern setup and you'll be fine.

The plugin contains several compatibility functions. These check for WordPress 5.0 or higher (with the block editor), check if the site runs ClassicPress rather than WordPress, and several checks for Advanced Custom Fields, ACF Pro, and ACF 4.0 (old) plus the Options Page addon.

### Gutenberg Editor

A sample editor block is included for WordPress 5.0 with it's new user interface for creating posts. This block doesn't really do anyhing, it is simply included to establish the editor block directory and class for further development. See below for Gutenberg + ACF.

### Classic Editor

Included here is the option to disable the Gutenberg block editor and restore the classic TinyMCE editor. This is essentially a copy of WordPress' Classic Editor plugin with the option to activate on this plugin's Site Settings page.

@todo Add options to selectively disable the block editor by post type.

### Advanced Custom Fields

For a nicer user experience, this plugin is recommended for use with [Advanced Custom Fields PRO](https://www.advancedcustomfields.com/pro/) or the [free version of ACF](https://wordpress.org/plugins/advanced-custom-fields/) plus the [Options Page](https://www.advancedcustomfields.com/add-ons/options-page/) addon. However, most of the ACF features are duplicated, with identical field database names, using the [Settings API](https://developer.wordpress.org/plugins/settings/settings-api/) to reduce third-party dependencies.

Settings page with ACF activated...

![Custom welcome panel](https://raw.githubusercontent.com/ControlledChaos/controlled-chaos-plugin/master/assets/images/ccp-acf-settings-01.jpg)

### Gutenberg + ACF

@todo I will soon be testing the new Advanced Custom Fields method for registering Gutenberg blocks, and then build the directories in the plugin for adding your own custom blocks.

### Beaver Builder

Included here are the two example modules from the official Beaver Builder demo plugin for creating custom builder modules. The directory structure of the demo has been retained, inside a `beaver` directory in this plugin, however the the code has been modified slightly to adhere to that of the rest of this plugin (e.g. short array syntax).

### Elementor

Preliminary support for an example custom Elementor widget, taken from the docs but not working.

@todo Get my own widget working rather than copying the example from the Elementor docs.

## Functionality

So, what the heck does this thing do? Why might it be preferable to other plugin boilerplates?

### jQuery Plugins

I have included several frontend UI/UX plugins that I typically use on client sites. If you don't need them then you can easily remove them and their settings. If you would like to replace them with something similar then the infrastructure is ready for you to modify.

The plugins are enqueued via opt-in checkboxes on the Script Options page, except for Fancybox, which is opted in on the Media Settings page.

* Fancybox 3 - [https://github.com/fancyapps/fancybox](https://github.com/fancyapps/fancybox)
  *"Lightbox script for displaying images, videos and more."*
* Slick - [https://github.com/kenwheeler/slick](https://github.com/kenwheeler/slick)
  *"The last carousel you'll ever need."*
* Tabslet - [https://github.com/vdw/Tabslet](https://github.com/vdw/Tabslet)
  *"Yet another jQuery plugin for tabs."*
* Sticky-kit - [https://github.com/leafo/sticky-kit](https://github.com/leafo/sticky-kit)
  *"For creating smart sticky elements."*
* Tooltipster - [https://github.com/iamceege/tooltipster](https://github.com/iamceege/tooltipster)
  *"Flexible, extensible, and modern tooltips."*
* FitVids - [https://github.com/davatron5000/FitVids.js](https://github.com/davatron5000/FitVids.js)
  *"For fluid width video embeds."*

### Admin Pages & Help Tabs

The plugin comes with several admin pages for site administration and one demo admin page that can be used to include instructional information for clients, author credits adn upsells, whatever fills your project's needs. Demo contextual help tabs are included with the demo admin page.

One main page for website settings uses the Advanced Custom Fields options page method, if ACF Pro or ACF free plus the Options Page addon are active, otherwise it uses the default method. This site settings page can be extended with new tabbed content by adding it directly to your new version of this plugin, by implementing an addon plugin ([starter addon here](https://github.com/ControlledChaos/controlled-chaos-addon)), or by using Advanced Custom Fields Pro.

### Sample Custom Post Type and Taxonomy

Included is a sample post type and a related sample taxonomy, both with all of the current possible arguments in the arrays. With a simple search and replace they can be reworked for your needs.

### Sample Custom Editor (Gutenberg) Block

The sample editor block, being as basic as a block can be, is not included as reference. The primary reason for including it is to establish the directory infrastructure for further block development in your project.

### Clean Up the Admin

Admin interface options include:

* Remove dashboard widgets
* Make Menus and Widgets top level menu items
* Remove select admin menu items
* Remove WordPress or ClassicPress logo from admin bar
* Remove access to theme and plugin editors

### Enchance the Admin

* Add a header to admin pages, including site title, tagline, and a nav menu (the admin header currently does not play nice with Gutenberg block editor pages)
* Add three admin bar menus
* Custom welcome panel with three widget areas and loaded with hooks for adding content
* Add custom post types to the At a Glance widget
* Custom admin footer message

Dashboard with custom welcome panel and sample dashboard widget...

![Custom welcome panel](https://raw.githubusercontent.com/ControlledChaos/controlled-chaos-plugin/master/assets/images/ccp-custom-welcome.jpg)

### Post Types on Front Page

Select a custom post type to be displayed in place of latest posts on the front page.

@todo Move this functionality from the Customizer.

### Posts Per Archive Page

Set the number of posts displayed on the various archive pages, including custom post types.

### Drag & Drop Post Type Order

Option to add custom sort order functionality to blog index pages and post archive pages.

When posts types are selected for custom sort order functionality, the table rows on their respective admin management screen can be dragged up or down. The order you set on the admin management screens will automatically be set on the front end.

### Media Options

* Option to hard crop the medium and/or large image sizes
* Option to allow SVG uploads to the Media Library
* Option to disable the Fancybox stylesheet to use your own.

### User Profiles

The local user avatar option included here is in development and not currently functioning properly. Will update here when it's ready to use.

Sample custom profile fields coming also.

### Developer tools

Included are a few tools to help in the early stages of site development, or that can be used for making improvements and debugging.

* Put WordPress or ClassicPress into debug mode without FTP access (experimental).
* Database reset tool (experimental).
* Customizer reset tool.
* Live theme testing for theme development on a live site.
* Right to left switcher for testing layouts with RTL languages.
* ACF tool to import the settings fields registered by this plugin so that they can be further developed.

## Renaming the plugin

First change the name of the main plugin file to reflect the new name of your plugin.

Next change the information in the plugin header and either change the plugin name in the License & Warranty notice in the main plugin file, or remove it.

Following is a list of strings to find and replace in all plugin files.

1. **Plugin name:** Find `Controlled_Chaos_Plugin` and replace with your plugin name, include underscores between words. This will change the primary plugin class name and the package name in file headers.

2. **Namespace:** Find `CC_Plugin` and replace with something unique to your plugin name, include underscores between words.

3. **Text domain:** Find `controlled-chaos-plugin` and replace with the new name of your main plugin file, include dashes between words.

4. **Constants:** Find `CCP` and replace with something unique to your plugin name. Use only uppercase letters.

5. **General prefix:** Find `ccp` and replace with something unique to your plugin name. Use only lowercase letters. This will change the prefix of all filters and settings, and the prefix of functions outside of a class.

6. **Author:** Find `Greg Sweet <greg@ccdzine.com>` and replace with your name and email address or those of your organization.

Finally, remember to modify or remove the instructional information in admin pages, including contextual help tabs.

See admin\partials - Check all files.<br />
See admin\partials\help - Check all files.

## Extensibility

The settings pages are equipped with filters for addon plugins to integrate easily.

The [Controlled Chaos Addon](https://github.com/ControlledChaos/controlled-chaos-addon) plugin is built as a starter plugin for extending this plugin. This may be especially useful for multisite installations where this plugin establishes base functionality accross the network and the addon plugins supply functionality specific to each member site.