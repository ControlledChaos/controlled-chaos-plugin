Controlled Chaos
================
A WordPress starter/boilerplate plugin.

## Description
This plugin controls some chaos and provides a head start for site-specific plugins.

## Dependencies

Short array syntax requires PHP 5.4+

To take advantage of all of its features, this plugin is recommended for use with Advanced Custom Fields PRO.

## Includes
Following are some of the core functions and features offered.

### jQuery Plugins
UI & UX JS plugins enqueued

* Fancybox 3 - https://github.com/fancyapps/fancybox
* Slick - https://github.com/kenwheeler/slick
* Tabslet - https://github.com/vdw/Tabslet
* Tooltipster - https://github.com/iamceege/tooltipster
* FitVids - https://github.com/davatron5000/FitVids.js

### Starter Settings Pages
One settings page via the default WordPress method and one settings page using the ACF Options Page method (if ACF is active).

### Sample Custom Post Type
Rename and duplicate as needed.

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

### Renaming the plugin for your website.
To rename this plugin to convert it specifically for a single website, first rename this file and rename the plugin folder with the same name as this file. Then use a find & replace function to look for the following...
1. **Text Domain:** The text domain should be the same as this file and the plugin folder. Replace "controlled-chaos".
2. **Classes:** Classes are prefixed with the plugin name. Replace "Controlled_Chaos".
3. **Class Variables:** Class variables are prefixed with the plugin name. Replace "controlled_chaos".
4. **Functions:** There are a few functions prefixed with the plugin name. The above replace of "controlled_chaos" will have given them your new name.
5. **Filters:** Filters are prexixed with an abbreviation for the plugin name. Replace "ccp".
6. **Pages:** Admin page URLs are prexixed with an abbreviation for the plugin name. The above replace of "ccp" will have given them your new prefix.
7. **Options:** Options are prexixed with an abbreviation for the plugin name. The above replace of "ccp" will have given them your new prefix.
8. **Version:** The plugin version is all caps and is prexixed with an abbreviation for the plugin name. Replace "CCP".
9. **Plugin Name:** The plugin name is used in various places. Replace "Controlled Chaos".