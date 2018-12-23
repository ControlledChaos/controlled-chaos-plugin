<?php

/**
 * Content for the Inline jQuery help tab.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CC_Plugin\Settings\Help\Inline_jQuery;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} ?>
<div>
	<h3><?php _e( 'Inline jQuery', 'controlled-chaos-plugin' ); ?></h3>
	<p><?php _e( 'Choose whether to deregister the jQuery that is included with WordPress/ClassicPress then add it as inline script in the footer.' ); ?></p>
	<p><?php _e( 'It is possible that simply checking this option will interfere with the functionality of other plugins or themes, if the scripts depend upon jQuery. However, the same method used here to deregister jQuery and add it later could be used in your mofified version of this plugin to affect the scripts of other plugins. And the method can be used in custom themes or child themes to add inline scripts after jQuery.' ); ?></p>
</div>