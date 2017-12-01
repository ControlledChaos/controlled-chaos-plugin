<?php
/**
 * Field import page.
 *
 * @package WordPress
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace Controlled_Chaos;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap import-registered-field-groups">
    <h2><?php esc_html_e( 'Import Registered Fields', 'controlled-chaos' ); ?></h2>

    <?php
    // Check the version of ACF.
    $acf_version = explode( '.', acf_get_setting( 'version' ) );
    if ( $acf_version[0] != '5' ) : ?>
    <div id="message" class="error below-h2">
        <p><?php printf( esc_html__( 'This tool was built for ACF version 5 and you have version %s.', 'controlled-chaos' ) ); ?></p>
    </div>
    <?php endif; ?>

    <?php if ( ! empty( $imported ) ) { ?>
    <div id="message" class="updated below-h2">
        <p><strong><?php esc_html_e( 'Field groups imported:', 'controlled-chaos' ); ?></strong></p>
        <ul>
        <?php foreach ( $imported as $import ) { ?>
            <li><?php edit_post_link( $import['title'], '', '', $import['id']); ?></li>
        <?php } ?>
        </ul>
    </div>
    <div class="notice notice-warning is-dismissible below-h2">
        <p><strong><?php esc_html_e( 'Next step:', 'controlled-chaos' ); ?></strong></p>
        <p><?php printf( '<p>%1s<a href="%2s">%3s</a>%4s</p>', esc_html__( 'Go to ', 'controlled-chaos' ), admin_url( '/options-general.php?page=controlled-chaos' ), esc_html__( 'the Controlld Chaos settings page', 'controlled-chaos' ), esc_html__( ' and disable the imported field groups. The duplicate field IDs will interfere with the editing of fields.', 'controlled-chaos' ) ); ?>
    </div>
    <?php }
    printf( '<p>%1s</p>', esc_html__( 'This tool imports any field groups registered outside the ACF plugin so that they can be edited.', 'controlled-chaos' ) ); ?>
    <?php if ( ! empty( $acf_local->groups ) ) : ?>

    <form method="POST">
        <table class="widefat">
            <thead>
                <th><?php esc_html_e( 'Import', 'controlled-chaos' ); ?></th>
                <th><?php esc_html_e( 'Registered Field Groups', 'controlled-chaos' ); ?></th>
                <th><?php esc_html_e( 'Possible Existing Matches', 'controlled-chaos' ); ?></th>
            </thead>
            <tbody>
                <?php
                foreach( $acf_local->groups as $key => $field_group ): ?>
                <tr>
                    <td><input type="checkbox" name="fieldsets[]" value="<?php echo esc_attr( $key ); ?>" /></td>
                    <td><?php echo $field_group['title']; ?></td>
                    <td><?php
                    $sql = "SELECT ID, post_title FROM $wpdb->posts WHERE post_title LIKE '%s' AND post_type='" . ACFPR_GROUP_POST_TYPE . "'";
                    // Set post status
                    $post_status = apply_filters( 'acf_recovery\query\post_status', '' );
                    if ( ! empty( $post_status ) ) {
                        $sql .= ' AND post_status="' . esc_sql( $post_status ) . '"';
                    }
                    $matches = $wpdb->get_results( $wpdb->prepare( $sql, '%' . $wpdb->esc_like( $field_group['title'] ) .'%' ) );
                    if ( empty( $matches ) ) {
                        echo '<em>' . esc_html__( 'No matches found.', 'controlled-chaos' ) . '</em>';
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
            <input type="submit" value="<?php esc_html_e( 'Import', 'controlled-chaos' ); ?>" class="button-primary" />
        </p>
    </form>

    <h3><?php esc_html_e( 'Field groups found in files:', 'controlled-chaos' ); ?></h3>

    <pre class="import-registered-field-groups-arrays">
    <?php echo var_export( $acf_local->groups ); ?>
    </pre>
    
    <?php else : ?>

    <p><strong><?php _e( 'No field groups found in files.', 'controlled-chaos' ); ?></strong></p>

    <?php endif; ?>
</div>