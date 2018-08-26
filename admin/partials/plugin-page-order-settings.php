<?php
/**
 * Settings for drag & drop custom post and taxonomy orders.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\Post_Types_Taxes
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Includes\Post_Types_Taxes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Get the custom sort order options.
$ccp_order_options = get_option( 'ccp_order_options' );

// Set variable for array of registered public post types.
if ( isset( $ccp_order_options['objects'] ) ) {
    $ccp_order_post_types = $ccp_order_options['objects'];

// Return empty array if no registered public tpost types.
} else {
    $ccp_order_post_types = [];
}

// Set variable for array of registered public taxonomies.
if ( isset( $ccp_order_options['tags'] ) ) {
    $ccp_order_taxonomies = $ccp_order_options['tags'];

// Return empty array if no registered public taxonomies.
} else {
    $ccp_order_taxonomies = [];
} ?>
<div class="wrap">
    <h1><?php _e( 'Posts & Taxonomies Sort Orders', 'controlled-chaos-plugin' ); ?></h1>
    <?php if ( isset( $_GET['msg'] ) ) : ?>
        <div id="message" class="notice notice-success is-dismissible">
            <?php if ( $_GET['msg'] == 'update' ) {
                echo sprintf(
                    '<p>%1s</p>',
                    __( 'Orders Updated.', 'controlled-chaos-plugin' )
                );
            } ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <?php if ( function_exists( 'wp_nonce_field' ) ) { wp_nonce_field( 'nonce_scporder' ); } ?>
        <div id="scporder_select_objects">
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Check to Sort Post Types', 'controlled-chaos-plugin' ) ?></th>
                        <td>
                            <label><input type="checkbox" id="ccp_order_check_all_post_types"> <?php _e( 'Check All', 'controlled-chaos-plugin' ) ?></label><br>
                            <?php
                            // Get all registered public post types.
                            $post_types = get_post_types(
                                [
                                    'show_ui'      => true,
                                    'show_in_menu' => true,
                                ],
                                'objects'
                            );

                            // Add a checkbox for each post type found.
                            foreach ( $post_types as $post_type ) :

                                // Ignore the Attachment (media) post type.
                                if ( $post_type->name == 'attachment' ) {
                                    continue;
                                } ?>
                                <label><input type="checkbox" name="objects[]" value="<?php echo $post_type->name; ?>" <?php
                                    if ( isset( $ccp_order_post_types ) && is_array( $ccp_order_post_types ) ) {
                                        if ( in_array( $post_type->name, $ccp_order_post_types ) ) {
                                            echo 'checked="checked"';
                                        }
                                    }
                                    ?>>&nbsp;<?php echo $post_type->label; ?></label><br>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="scporder_select_tags">
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Check to Sort Taxonomies', 'controlled-chaos-plugin' ) ?></th>
                        <td>
                            <label><input type="checkbox" id="ccp_order_check_all_taxonomies"> <?php _e( 'Check All', 'controlled-chaos-plugin' ) ?></label><br>
                            <?php
                            // Get all registered public taxonomies.
                            $taxonomies = get_taxonomies(
                                [
                                    'show_ui' => true,
                                ],
                                'objects'
                            );

                            // Add a checkbox for each taxonomy found.
                            foreach ( $taxonomies as $taxonomy ) :

                                // Ignore the taxonomy used for post formats.
                                if ( $taxonomy->name == 'post_format' ) {
                                    continue;
                                } ?>
                                <label><input type="checkbox" name="tags[]" value="<?php echo $taxonomy->name; ?>" <?php
                                    if ( isset( $ccp_order_taxonomies ) && is_array( $ccp_order_taxonomies ) ) {
                                        if ( in_array( $taxonomy->name, $ccp_order_taxonomies ) ) {
                                            echo 'checked="checked"';
                                        }
                                    } ?>>&nbsp;<?php echo $taxonomy->label ?></label><br>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="submit">
            <input type="submit" class="button-primary" name="scporder_submit" value="<?php _e( 'Set Orders', 'controlled-chaos-plugin' ); ?>">
        </p>
    </form>
</div>
<script>
( function ($) {

    // Handle the Check All input for post types.
    $( '#ccp_order_check_all_post_types' ).on( 'click', function () {
        var items = $( '#scporder_select_objects input' );
        if ( $(this).is( ':checked' ) ) {
            $(items).prop( 'checked', true );
        } else {
            $(items).prop( 'checked', false );
        }
    });

    // Handle the Check All input for taxonomies.
    $( '#ccp_order_check_all_taxonomies' ).on( 'click', function () {
        var items = $( '#scporder_select_tags input' );
        if ( $(this).is( ':checked' ) ) {
            $(items).prop( 'checked', true );
        } else {
            $(items).prop( 'checked', false );
        }
    });
})(jQuery)
</script>