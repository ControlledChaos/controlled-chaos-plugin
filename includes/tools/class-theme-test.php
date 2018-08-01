<?php
/**
 * Live theme test.
 *
 * Uses the universal slug partial for admin pages. Set this
 * slug in the core plugin file.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\Tools
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @todo       Make this file object oriented.
 * @todo       Apply a filter to return true or false for
 *             hiding the Development Tools admin page.
 */

// namespace CC_Plugin\Includes\Tools;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function themedrive_is_enabled() {
    return get_option( 'td_themes' );
}

// Admin Panel
function themedrive_add_pages() {
    add_theme_page(
        __( 'Live Theme Test', 'controlled-chaos-plugin' ),
        __( 'Theme Test', 'controlled-chaos-plugin' ),
        'edit_theme_options',
        CCP_ADMIN_SLUG . '-theme-test',
        'themedrive_options_page' );
}
add_action( 'admin_menu', 'themedrive_add_pages' );

function themedrive_get_theme() {

    $gettheme = get_option( 'td_themes' );

    if ( ! empty( $gettheme ) ) {
        return $gettheme;
    } else {
        return '';
    }

}

function themedrive_get_level() {

    $getlevel = get_option( 'td_level' );

    if ( $getlevel!='' ) {
        return 'level_' . $getlevel;
    } else {
        return 'level_10';
    }
}

function themedrive_determine_theme() {

    if ( ! isset($_GET['theme'] ) ) {

        if ( ! current_user_can( themedrive_get_level() ) ) {
            // not admin
            return false;

        } else {

            $theme = themedrive_get_theme();

            if ( $theme == '' ) {
                // no admin-only theme defined, short-circuit out
                return false;
            }

        }
    }

    $all = $_GET + $_POST;

    if ( isset( $all['theme'] ) ) {
        $theme = $all['theme'];
    }

    $theme_data = wp_get_theme( $theme );

    if ( ! empty( $theme_data ) ) {
        // Don't let people peek at unpublished themes
        if ( isset( $theme_data['Status'] ) && $theme_data['Status'] != 'publish' ) {
            return false;
        }

        return $theme_data;

    }

    // perhaps they are using the theme directory instead of title
    $themes = wp_get_themes();

    foreach ( $themes as $theme_data ) {

        // use Stylesheet as it's unique to the theme - Template could point to another theme's templates
        if ( $theme_data['Stylesheet'] == $theme ) {
            // Don't let people peek at unpublished themes
            if ( isset( $theme_data['Status'] ) && $theme_data['Status'] != 'publish' ) {
                return false;
            }

            return $theme_data;
        }

    }

    return false;

}

function themedrive_get_template( $template ) {

    $theme = themedrive_determine_theme();

    if ($theme === false) {
        return $template;
    }

    return $theme['Template'];

}

function themedrive_get_stylesheet( $stylesheet ) {

    $theme = themedrive_determine_theme();

    if ( $theme === false ) {
        return $stylesheet;
    }

    return $theme['Stylesheet'];

}

function themedrive_switcher() {

    $themes = wp_get_themes();
    $default_theme = wp_get_theme();

    if ( count( $themes ) > 1 ) {

        $theme_names = array_keys( $themes );
        natcasesort( $theme_names );

        $select = '<select name="td_themes">' . "\n";

        if ( ! get_option( 'td_themes' ) ) {
            $select .= '<option value="" selected="selected">Select theme...</option>' . "\n";
        }

        foreach ( $theme_names as $theme_name ) {
            // Skip unpublished themes.
            if ( isset( $themes[$theme_name]['Status'] ) && $themes[$theme_name]['Status'] != 'publish' ) {
                continue;
            }

            if ( ( themedrive_get_theme() == $theme_name ) || ( ( themedrive_get_theme() == '' ) && ( $theme_name == $default_theme ) ) ) {
                $select .= '<option value="' . esc_attr( $theme_name ) . '" selected="selected">' . $themes[$theme_name]['Name'] . '</option>' . "\n";
            } else {
                $select .= '<option value="' . esc_attr( $theme_name ) . '">' . $themes[$theme_name]['Name'] . '</option>' . "\n";
            }

        }

        $select .= '</select>' . "\n\n";

    }
    //  echo $tp;

    echo $select;

    if ( themedrive_is_enabled() ) {
        $get_theme  = wp_get_theme();
        $theme_name = $get_theme->get( 'Name' );

        echo sprintf(
            '<p><strong><span style="color: #199e26"><span class="dashicons dashicons-visibility" style="vertical-align: text-top"></span> %1s %2s</span></strong></p>',
            __( 'Live Theme Test is enabled with', 'controlled-chaos-plugin' ),
            $theme_name
        );
    } else {
        $get_theme  = wp_get_theme();
        $theme_name = $get_theme->get( 'Name' );

        echo sprintf(
            '<p><strong><span style="color: #d00"><span class="dashicons dashicons-hidden" style="vertical-align: text-top"></span> %1s</span>. %2s %3s</strong></p>',
            __( 'Live Theme Test is disabled', 'controlled-chaos-plugin' ),
            __( 'The active theme is', 'controlled-chaos-plugin' ),
            $theme_name
        );
    }

}

add_action( 'plugins_loaded', 'TTD_filters' ); // because filters call current_user_can and other plugins need raw value from options

function TTD_filters () {
    // 	if ( !is_admin() ) { // not needed in admin side
    add_filter( 'template', 'themedrive_get_template' );
    add_filter( 'stylesheet', 'themedrive_get_stylesheet' );
    //	}
}

// Options Page
function themedrive_options_page() {

    global $themedrive_localversion;
    global $wp_themedrive_plugin_url;

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' && ! wp_verify_nonce( @$_POST['_wpnonce'], 'theme-drive' ) ) {
        wp_die( 'Nonce invalid. Please re-submit the form.' );
        exit;
    }


    if ( isset( $_POST['button'] ) && 'Enable Theme Drive' == $_POST['button'] ) {

        check_admin_referer( 'theme-drive' );
        $themedrive = $_POST['td_themes'];
        update_option( 'td_themes', $themedrive );

        $access_level = (int)$_POST['access_level'];
        update_option( 'td_level', $access_level );

        $get_theme      = wp_get_theme();
        $get_theme_name = $get_theme->get( 'Name' );

        $msg_status = sprintf(
            '%1s %2s %3s. <a href="%4s" target="_blank">%5s</a>',
            __( 'Live theme test is enabled with', 'controlled-chaos-plugin' ),
            $get_theme_name,
            __( 'theme', 'controlled-chaos-plugin' ),
            esc_url( site_url() ),
            __( 'View Site', 'controlled-chaos-plugin' )
        );

        // Show message
        echo '<div id="setting-error-settings_updated" class="notice notice-success is-dismissible"><p>' . $msg_status . '</p></div>';

    } elseif ( isset( $_POST['button'] ) && 'Disable Theme Drive' == $_POST['button'] ) {

        check_admin_referer( 'theme-drive' );
        // Delete the option from the DB if it's empty
        delete_option( 'td_themes' );

        $msg_status = __( 'Live theme test has been disabled.', 'controlled-chaos-plugin' );

        // Show message
        echo '<div id="setting-error-settings_updated" class="notice notice-success is-dismissible"><p>' . $msg_status . '</p></div>';

    }

    $access_level = get_option( 'td_level' );

    if ( empty( $access_level ) ) {
        $access_level = '10';
    }

    $imgpath = $wp_themedrive_plugin_url . 'i';

?>
<div class="wrap" >
    <h2><?php _e( 'Live Theme Test', 'controlled-chaos-plugin' ); ?></h2>
    <?php $action_url; ?>
    <?php if ( ! isset( $action_url) )
        $action_url = '';
    ?>
    <form name="form_apu" method="post" action="<?php echo $action_url ?>">
    <?php wp_nonce_field( 'theme-drive' ); ?>
        <h2><?php _e( 'Instructions', 'controlled-chaos-plugin' ); ?></h2>
        <ol>
            <li><?php _e( 'Select a theme to preview live on the site from the select box below (lists all installed themes).', 'controlled-chaos-plugin' ); ?></li>
            <li><?php _e( 'Enable theme test', 'controlled-chaos-plugin' ); ?></li>
            <li><?php _e( 'Once the theme is ready to go live, disable theme test and activate the theme on the Themes page.', 'controlled-chaos-plugin' ); ?></li>
        </ol>
   	    <p><?php _e( 'Additionally you may add "?theme=xxx" to a URL, where xxx is the slug of the theme you want to test.', 'controlled-chaos-plugin' ); ?></p>
        <?php themedrive_switcher(); ?>
        <h2><?php _e( 'User Role', 'controlled-chaos-plugin' ); ?></h2>
        <p><?php _e( 'Specify the level of users to have access to the selected theme preview.', 'controlled-chaos-plugin' ); ?></p>
        <p><?php _e( 'By default it is set to 10 (admin only). Level 7 are editors, level 4 are authors and level 1 are contributors.', 'controlled-chaos-plugin' ); ?></p>
        <p><?php _e( 'The access level is ignored for accessing the site with ?theme=xxx paramaeter.', 'controlled-chaos-plugin' ); ?></p>
        <p><input style="border-width: inherit; border-style: inherit; border-color: inherit; width: 30px;" name="access_level" id="access_level" value="<?php echo esc_attr( $access_level ); ?>" /> <label for="access_level"><?php _e( 'Access level', 'controlled-chaos-plugin' ); ?></label></p>
        <p class="submit">
            <input type="submit" name="button" value="Disable Theme Drive" class="button-primary" />
            <input type="submit" name="button" value="Enable Theme Drive" class="button-primary" />
        </p>
    </form>
</div>
<?php } // End admin page output.