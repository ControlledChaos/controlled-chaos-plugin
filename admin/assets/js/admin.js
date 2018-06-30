/**
 * Admin scripts.
 * 
 * This file is enqueued only on the backend of your site.
 * Remember to minify this and change the file reference in
 * admin > admin.php.
 */

/**
 * Tabify the .ccp_tabbed-content wrapper.
 * 
 * @since  1.0.0
 * @access public
 */
jQuery(document).ready( function ($) {
	$( '.ccp_tabbed-content' ).tabs();
});