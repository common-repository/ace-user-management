<?php

/**
 * The plugin bootstrap file
 *
 * @link              http://acewebx.com
 * @since             1.0.0
 * @package           Ace_User_Management
 *
 * @wordpress-plugin
 * Plugin Name:       Ace User Management
 * Plugin URI:        http://acewebx.com/contact-us
 * Description:       This plugin help us to create registration form with unlimted custom fields, It also provide Captcha for prevent spamming in registration form.
 * Version:           1.0.6
 * Author:            AceWebx Team
 * Author URI:        http://acewebx.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ace-user-management
 * Domain Path:       /languages
 */
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ace-user-management-activator.php
 */
function activateAceUserManagement() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ace-user-management-activator.php';
	Ace_User_Management_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ace-user-management-deactivator.php
 */
function deactivateAceUserManagement() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ace-user-management-deactivator.php';
	Ace_User_Management_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activateAceUserManagement' );
register_deactivation_hook( __FILE__, 'deactivateAceUserManagement' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ace-user-management.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function runAceUserManagement() {

	$plugin = new Ace_User_Management();
	$plugin->run();

}
runAceUserManagement();
