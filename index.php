<?php
 
/**
 * Plugin Name: Password Reset Template
 * Plugin URI: https://github.com/theandrew168/wordpress-password-reset-template
 * Description: Simple plugin for customizing the WordPress password reset email
 * Version: 1.0
 * Author: Andrew Dailey
 * Author URI: https://github.com/theandrew168
 * License: MIT
 *
 * References:
 * https://webdesign.tutsplus.com/tutorials/create-a-custom-wordpress-plugin-from-scratch--net-2668
 * https://deliciousbrains.com/create-wordpress-plugin-settings-page/
 */

add_filter('retrieve_password_message', 'password_reset_template', 10, 4);
function password_reset_template($message, $key, $user_login, $user_data) {
    $options = get_option('prt_settings');
    if ($options == false) {
        return default_password_reset_email($message, $key, $user_login, $user_data);
    }

    $message = $options['prt_textarea_field_0'];
    if (empty($message)) {
        return default_password_reset_email($message, $key, $user_login, $user_data);
    }

    $reseturl = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login));
    return str_replace('%reseturl%', $reseturl, $message);
}

function default_password_reset_email($message, $key, $user_login, $user_data) {
    $site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
    $message = __( 'Someone has requested a password reset for the following account:' ) . "\r\n\r\n";
    $message .= sprintf( __( 'Site Name: %s' ), $site_name ) . "\r\n\r\n";
    $message .= sprintf( __( 'Username: %s' ), $user_login ) . "\r\n\r\n";
    $message .= __( 'If this was a mistake, just ignore this email and nothing will happen.' ) . "\r\n\r\n";
    $message .= __( 'To reset your password, visit the following address:' ) . "\r\n\r\n";
    $message .= network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n";

    return $message;
}

add_action('admin_menu', 'prt_add_admin_menu');
function prt_add_admin_menu() { 
	add_options_page('Password Reset Template', 'Password Reset Template', 'manage_options', 'password_reset_template', 'prt_options_page');
}

add_action('admin_init', 'prt_settings_init');
function prt_settings_init() { 
	register_setting('pluginPage', 'prt_settings');
	add_settings_section(
		'prt_pluginPage_section', 
		__('Notes:', 'email'), 
		'prt_settings_section_callback', 
		'pluginPage'
	);
	add_settings_field( 
		'prt_textarea_field_0', 
		__('Setup template', 'email'), 
		'prt_textarea_field_0_render', 
		'pluginPage', 
		'prt_pluginPage_section' 
	);
}


function prt_textarea_field_0_render() { 
	$options = get_option('prt_settings');
	?>
	<textarea cols='80' rows='10' name='prt_settings[prt_textarea_field_0]'><?php echo $options['prt_textarea_field_0']; ?></textarea>
	<?php
}


function prt_settings_section_callback() { 
	echo __('Use <b>%reseturl%</b> as a placeholder for the actual reset link.', 'email');
}

function prt_options_page() { 
    ?>
    <form action='options.php' method='post'>
    	<h2>Password Reset Template</h2>
    	<?php
    	settings_fields('pluginPage');
    	do_settings_sections('pluginPage');
    	submit_button();
    	?>
    </form>
    <?php
}
