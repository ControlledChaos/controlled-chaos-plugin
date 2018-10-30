<?php
/**
 * Admin header template.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Admin
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Admin;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Site descrition, if any.
 */
$title       = get_bloginfo( 'name' );
$description = get_bloginfo( 'description' );

if ( ! empty( $title ) ) {
    $title = get_bloginfo( 'name' );
} else {
    $title = '';
}

if ( ! empty( $description ) ) {
    $description = get_bloginfo( 'description' );
} else {
    $description = __( 'Add a tagline in Settings > General or change this in', 'controlled-chaos-plugin' ) . ' <code>controlled-chaos-plugin/admin/partials/admin-header.php</code>';
} ?>
<header class="cct-admin-header">
    <div class="admin-site-title-description">
        <p class="admin-site-title" itemprop="name"><a href="<?php echo admin_url(); ?>"><?php echo $title; ?></a></p>
        <p class="admin-site-description"><?php echo $description; ?></p>
    </div>
    <nav class="admin-navigation">
        <?php wp_nav_menu(
            array(
                'theme_location'  => 'admin-header',
                'container'       => false,
                'menu_id'         => 'admin-navigation-list',
                'menu_class'      => 'admin-navigation-list',
                'before'          => '',
                'after'           => '',
                'fallback_cb'     => ''
            )
        ); ?>
    </nav>
</header>