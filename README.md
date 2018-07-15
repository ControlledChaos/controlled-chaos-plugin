# Controlled Chaos Plugin

A feature-packed WordPress starter plugin for building custom-tailored websites.

![Gutenberg Ready](https://img.shields.io/badge/Gutenberg-ready-blue.svg)
![WordPress](https://img.shields.io/wordpress/v/akismet.svg?style=flat-square)
![PHP version](https://img.shields.io/php-eye/symfony/symfony.svg?style=flat-square)

## Plugin Overview

This is a tool — a means to an end. Not intended to be used as is, without further development.

### Introduction

Howdy, folks. My name is Greg Sweet. I am sole proprietor, chief cook and bottle washer at [Controlled Chaos Design](http://ccdzine.com/).

I built this plugin as a starter for client sites, including features that I use often, the code for which I repeatedly copied from my [gist library](https://gist.github.com/ControlledChaos). It is not intended to be a plug-and-play type of thing, although it can be used as such. This is more of a developer's tool. I have commented thouroughly on the code and documentec the files to the best of my ability. I have learned by looking at the code of others so I have kept this in mind when writing the code for this plugin.

### Approach

Although this plugin comes with my business name incorporated into it, I am not trying to put my branding stink all over your project. It has to have a name so I used my own. However, since I need to rename the plugin for my clients' websites, I have made every effort to use a simple, uniform naming system that can be quicky renamed for your project.

Not every feature included with this plugin will be needed for my projects or yours. And one big reason for writing a site-specific plugin is to include only what the site needs and eliminate the overhead of plugins and themes that offer things that you don't need. So why have I packed so much into this plugin? Well, I find it to be much quicker and easier to remove unnecessary code that it is to write, or even copy & paste, new code into a project. And being that you will rename this plugin and that it will update to overwrite your changes, modifications can be made ad libidum.

## Compatibility

* This plugin was written in a WordPress 4.9+ environment with no concern for backwards compatitbility.
* This plugin was written on a local server running PHP 7.0
* The short array syntax ( "[]" rather than "array()" ) requires PHP 5.4+
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

One settings page via the default WordPress method and one settings page using the Advanced Custom Fields Options Page method (if ACF is active).

### Sample Custom Post Type

Rename and duplicate as needed.

### Sample Custom Taxonomy

Rename and duplicate as needed.

### Sample Editor (Gutenberg) Block

Supplied as reference. More to come.

### Clean Up the Admin

* Remove dashboard widgets: WordPress news, quick press
* Make Menus and Widgets top level menu items
* Remove select admin menu items
* Remove WordPress logo from admin bar
* Remove access to theme and plugin editors

### Enchance the Admin

* Add three admin bar menus
* Add custom post types to the At a Glance widget
* Custom admin footer message

### Custom Welcome Panel

An optional welcome panel with three widget areas and loaded with hooks for adding content.

### Advanced Custom Fields

The Site Settings page for managing various features of this plugin has been duplicated as an ACF options page. This page will be used instead of the native settings page if the Advanced Custom Fields PRO plugin is active, or Advanced Custom Fields free plus the Options Page addon.

Included is a tool to import the ACF settings fields registered by this plugin so that you can add to them or edit them.

### Media Options

* Add option to hard crop the medium and/or large image sizes
* Add option to allow SVG uploads to the Media Library

## Extensibility

The settings pages are equipped with filters for addon plugins to integrate easily.

The [Controlled Chaos Addon](https://github.com/ControlledChaos/controlled-chaos-addon) plugin is built as a starter plugin for extending this plugin.