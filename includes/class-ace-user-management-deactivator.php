<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://acewebx.com
 * @since      1.0.0
 *
 * @package    Ace_User_Management
 * @subpackage Ace_User_Management/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Ace_User_Management
 * @subpackage Ace_User_Management/includes
 * @author     Webbninja <webbninja2@gmail.com>
 */
class Ace_User_Management_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		$tableName = $wpdb->prefix.'ace_reset_password';
		$wpdb->query('DROP table IF EXISTS $tableName');

		if( !empty( get_option( 'ace_auto_page_create'))){
			$pageId = get_option( 'ace_auto_page_create' );

			foreach ($pageId as $key => $value) {
				wp_delete_post( $value );
			}
			delete_option( 'ace_auto_page_create' );
		}
	}
}
