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
<?php do_action( 'ccp_before_admin_header' ); ?>
<header class="ccp-admin-header">
    <?php do_action( 'ccp_before_admin_site_branding' ); ?>
    <div class="admin-site-branding">
        <p class="admin-site-title" itemprop="name"><a href="<?php echo admin_url(); ?>"><?php echo $title; ?></a></p>
        <p class="admin-site-description"><?php echo $description; ?></p>
    </div>
    <?php do_action( 'ccp_after_admin_site_branding' ); ?>
    <?php do_action( 'ccp_before_admin_navigation' ); ?>
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
    <?php do_action( 'ccp_after_admin_navigation' ); ?>
</header>
<?php do_action( 'ccp_after_admin_header' ); ?>