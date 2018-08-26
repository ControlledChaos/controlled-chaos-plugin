<?php
/**
 * Field import page.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CC_Plugin\Fields_Import_Page;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$active_tab = 'ccp-registered-fields-import';
if ( isset( $_GET[ 'tab' ] ) ) {
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'ccp-registered-fields-import';
} ?>

<div class="wrap import-registered-field-groups">
    <h1><?php esc_html_e( 'Registered Fields', 'controlled-chaos-plugin' ); ?></h1>
    <p class="description"><?php esc_html_e( 'Tools for ACF fields registered by the Controlled Chaos plugin.', 'controlled-chaos-plugin' ); ?></p>
    <h2 class="nav-tab-wrapper">
        <a href="edit.php?post_type=acf-field-group&page=acf-theme-fields&tab=ccp-registered-fields-import" class="nav-tab <?php echo $active_tab == 'ccp-registered-fields-import' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Import', 'controlled-chaos-plugin' ); ?></a>
        <a href="edit.php?post_type=acf-field-group&page=acf-theme-fields&tab=ccp-registered-fields-activation" class="nav-tab <?php echo $active_tab == 'ccp-registered-fields-activation' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Activation', 'controlled-chaos-plugin' ); ?></a>
    </h2>
    <?php if ( $active_tab == 'ccp-registered-fields-import' ) :

        // Check the version of ACF.
        $acf_version = explode( '.', acf_get_setting( 'version' ) );
        if ( $acf_version[0] != '5' ) : ?>
        <div id="message" class="error below-h2">
            <p><?php printf( esc_html__( 'This tool was built for ACF version 5 and you have version %s.', 'controlled-chaos-plugin' ) ); ?></p>
        </div>
        <?php endif; ?>

        <?php if ( ! empty( $imported ) ) { ?>
        <div id="message" class="updated below-h2">
            <p><strong><?php esc_html_e( 'Field groups imported:', 'controlled-chaos-plugin' ); ?></strong></p>
            <ul>
            <?php foreach ( $imported as $import ) { ?>
                <li><?php edit_post_link( $import['title'], '', '', $import['id']); ?></li>
            <?php } ?>
            </ul>
        </div>
        <div class="notice notice-success is-dismissible">
            <p><strong><?php esc_html_e( 'Next step:', 'controlled-chaos-plugin' ); ?></strong></p>
            <?php printf(
                '<p><a href="%1s">%2s</a>%3s</p>',
                admin_url( '/edit.php?post_type=acf-field-group&page=acf-theme-fields&tab=ccp-registered-fields-activation' ),
                esc_html__( 'Disable', 'controlled-chaos-plugin' ),
                esc_html__( ' the imported field groups. The duplicate field IDs will interfere with the editing of fields.', 'controlled-chaos-plugin' )
            ); ?>
        </div>
        <?php }
        printf( '<p>%1s</p>', esc_html__( 'This tool imports any field groups registered outside the ACF plugin so that they can be edited.', 'controlled-chaos-plugin' ) ); ?>
        <?php if ( ! empty( $acf_local->groups ) ) : ?>

        <form method="POST">
            <table class="widefat">
                <thead>
                    <th><?php esc_html_e( 'Import', 'controlled-chaos-plugin' ); ?></th>
                    <th><?php esc_html_e( 'Registered Field Groups', 'controlled-chaos-plugin' ); ?></th>
                    <th><?php esc_html_e( 'Possible Existing Matches', 'controlled-chaos-plugin' ); ?></th>
                </thead>
                <tbody>
                    <?php
                    foreach( $acf_local->groups as $key => $field_group ): ?>
                    <tr>
                        <td><input type="checkbox" name="fieldsets[]" value="<?php echo esc_attr( $key ); ?>" /></td>
                        <td><?php echo $field_group['title']; ?></td>
                        <td><?php
                        $sql = "SELECT ID, post_title FROM $wpdb->posts WHERE post_title LIKE '%s' AND post_type='acf-field-group'";
                        // Set post status
                        $post_status = apply_filters( 'acf_recovery\query\post_status', '' );
                        if ( ! empty( $post_status ) ) {
                            $sql .= ' AND post_status="' . esc_sql( $post_status ) . '"';
                        }
                        $matches = $wpdb->get_results( $wpdb->prepare( $sql, '%' . $wpdb->esc_like( $field_group['title'] ) .'%' ) );
                        if ( empty( $matches ) ) {
                            echo '<em>' . esc_html__( 'No matches found.', 'controlled-chaos-plugin' ) . '</em>';
                        } else {
                            $links = array();
                            foreach ( $matches as $match ) {
                            $links[] = '<a href="' . get_edit_post_link( $match->ID ) . '">' . $match->post_title . '</a>';
                        }
                            echo implode( ', ', $links );
                        }
                        ?></td>
                    </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            <?php wp_nonce_field( 'acf_php_recovery' ); ?>
            <input type="hidden" name="acf_php_recovery_action" value="import" />
            <p class="submit">
                <input type="submit" value="<?php esc_html_e( 'Import', 'controlled-chaos-plugin' ); ?>" class="button-primary" />
            </p>
        </form>

        <h3><?php esc_html_e( 'Field groups found in files:', 'controlled-chaos-plugin' ); ?></h3>

        <pre class="import-registered-field-groups-arrays">
        <?php echo var_export( $acf_local->groups ); ?>
        </pre>

        <?php else : ?>

        <p><strong><?php _e( 'No field groups found in files.', 'controlled-chaos-plugin' ); ?></strong></p>

        <?php endif; ?>
    <?php elseif ( $active_tab == 'ccp-registered-fields-activation' ) : ?>
    <form action="options.php" method="post">
        <?php settings_fields( 'ccp-registered-fields-activate' );
        do_settings_sections( 'ccp-registered-fields-activate' ); ?>
        <p class="submit"><?php submit_button( __( 'Save Settings', 'controlled-chaos-plugin' ), 'primary', '', false, [] ); echo ' '; ?></p>
    </form>
    <?php endif; ?>
</div>