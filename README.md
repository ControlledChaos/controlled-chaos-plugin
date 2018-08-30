# Controlled Chaos Plugin

A feature-packed WordPress starter plugin for building custom-tailored websites.

![Gutenberg Ready](https://img.shields.io/badge/Gutenberg-ready-blue.svg)
![WordPress tested on verion 4.9.8](https://img.shields.io/badge/WordPress-tested%204.9.8-green.svg)
![PHP tested on version 7.2](https://img.shields.io/badge/PHP-tested%207.2-brightgreen.svg)

![](https://raw.githubusercontent.com/ControlledChaos/controlled-chaos-plugin/master/controlled-chaos-github-banner.jpg)

## Plugin Overview

This is a tool — a means to an end. It is not intended to be used as is, without further development, however it can be used as such.

### Introduction

Howdy, folks. My name is Greg Sweet. I am sole proprietor, chief cook and bottle washer at [Controlled Chaos Design](http://ccdzine.com/).

I built this plugin as a starter for client sites, including features that I use often, the code for which I repeatedly copied from my [gist library](https://gist.github.com/ControlledChaos). It is not intended to be a plug-and-play type of thing, although it can be used as such. This is more of a developer's tool. I have commented thouroughly on the code and documented the files to the best of my ability. I have learned by looking at the code of others so I have kept this in mind when writing the code for this plugin.

### Approach

Although this plugin comes with my business name incorporated into it, I am not trying to put my branding stink all over your project. It has to have a name so I used my own. However, since I need to rename the plugin for my clients' websites, I have made every effort to use a simple, uniform naming system that can be quicky renamed for your project.

Not every feature included with this plugin will be needed for my projects or yours. And one big reason for writing a site-specific plugin is to include only what the site needs and eliminate the overhead of plugins and themes that offer things that you don't need. So why have I packed so much into this plugin? Well, I find it to be much quicker and easier to remove unnecessary code that it is to write, or even copy & paste, new code into a project. And being that you will rename this plugin and that it will not update to overwrite your changes, modifications can be made ad libidum.

## Compatibility

* This plugin was written in a WordPress 4.9+ environment with no concern for backwards compatitbility.
* This plugin was written on a local server running PHP 7.1
* The short array syntax ( `[]` rather than `array()` ) requires PHP 5.4+
* Run a modern setup and you'll be fine.

Sample editor blocks are included in preparation for WordPress 5.0 with it's new user interface. Until that release, the [Gutenberg plugin](https://wordpress.org/plugins/gutenberg/) is required to use the blocks.

For a nicer user experience, this plugin is recommended for use with [Advanced Custom Fields PRO](https://www.advancedcustomfields.com/pro/) or the [free version of ACF](https://wordpress.org/plugins/advanced-custom-fields/) plus the [Options Page](https://www.advancedcustomfields.com/add-ons/options-page/) addon. However, most of the ACF features are duplicated, with identical field database names, using the [WordPress Settings API](https://developer.wordpress.org/plugins/settings/settings-api/) to reduce third-party dependencies.

## Functionality

So, what the heck does this thing do? Why might it be preferable to other plugin boilerplates?

### jQuery Plugins

I have included several frontend UI/UX plugins that I typically use on client sites. They are enqueued via opt-in checkboxes on the Script Options page, except for Fancybox, which is opted in on the Media Settings page.

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

One main page for website settings uses the Advanced Custom Fields options page method, if ACF Pro or ACF free plus the Options Page addon are active, otherwise it uses the default WordPress method. This site settings page can be extended with new tabbed content by adding it directly to your new version of this plugin, by implementing an addon plugin ([starter addon here](https://github.com/ControlledChaos/controlled-chaos-addon)), or by using Advanced Custom Fields Pro.

### Sample Custom Post Type and Taxonomy

Included is a sample post type and a related sample taxonomy, both with all of the current possible arguments in the arrays. With a simple search and replace they can be reworked for your needs.

### Sample Custom Editor (Gutenberg) Block

The sample editor block, being as basic as a block can be, is not included as reference. The primary reason for including it is to establish the directory infrastructure for further block development in your project.

### Clean Up the Admin

Admin interface options include:

* Remove dashboard widgets
* Make Menus and Widgets top level menu items
* Remove select admin menu items
* Remove WordPress logo from admin bar
* Remove access to theme and plugin editors

### Enchance the Admin

* Add three admin bar menus
* Custom welcome panel with three widget areas and loaded with hooks for adding content.
* Add custom post types to the At a Glance widget
* Custom admin footer message

### Drag & Drop Post Type Order

Option to add custom sort order functionality to blog index pages and post archive pages.

When posts types are selected for custom sort order functionality, the table rows on their respective admin management screen can be dragged up or down. The order you set on the admin management screens will automatically be set on the front end.

### Media Options

* Add option to hard crop the medium and/or large image sizes
* Add option to allow SVG uploads to the Media Library

### User Profiles

The local user avatar option included here is in development and not currently functioning properly. Will update here when it's ready to use.

Sample custom profile fields coming also.

### Developer tools

Included are a few tools to help in the early stages of site development, or that can be used for making improvements and debugging.

* Put WordPress into debug mode without FTP access (experimental)
* Live theme testing for theme development on a live site
* Right to left switcher for testing layouts with RTL languages.
* ACF tool to import the settings fields registered by this plugin so that they can be further developed.

## Extensibility

The settings pages are equipped with filters for addon plugins to integrate easily.

The [Controlled Chaos Addon](https://github.com/ControlledChaos/controlled-chaos-addon) plugin is built as a starter plugin for extending this plugin. This may be especially useful for multisite installations where this plugin established base functionality accross the network and the addon plugins supply functionality specific to the member sites.