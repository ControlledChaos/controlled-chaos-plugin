/**
 * Admin scripts.
 *
 * This file is enqueued only on the backend of your site.
 * Remember to minify this and change the file reference in
 * admin > admin.php.
 */

/**
 * Tabify the .backend-tabbed-content wrapper.
 *
 * @since  1.0.0
 */
jQuery(document).ready( function ($) {

	// Add tab switching to the `backend-tabbed-content` class.
	$( '.backend-tabbed-content' ).tabs();

	// Add tooltips to the `tooltip` class.
	$( '.tooltip' ).tooltip();

});