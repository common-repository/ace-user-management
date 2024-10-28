<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://acewebx.com
 * @since      1.0.0
 *
 * @package    Ace_User_Management
 * @subpackage Ace_User_Management/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ace_User_Management
 * @subpackage Ace_User_Management/includes
 * @author     Webbninja <webbninja2@gmail.com>
 */
class Ace_User_Management {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ace_User_Management_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $pluginName    The string used to uniquely identify this plugin.
	 */
	protected $pluginName;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ace-user-management';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ace_User_Management_Loader. Orchestrates the hooks of the plugin.
	 * - Ace_User_Management_i18n. Defines internationalization functionality.
	 * - Ace_User_Management_Admin. Defines all hooks for the admin area.
	 * - Ace_User_Management_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ace-user-management-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ace-user-management-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ace-user-management-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ace-user-management-public.php';

		/**
		 * The class responsible for defining all the static function
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ace-user-management-function.php';

		$this->loader = new Ace_User_Management_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ace_User_Management_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Ace_User_Management_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$pluginAdmin = new Ace_User_Management_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $pluginAdmin, 'aceEnqueueStyles');
		$this->loader->add_action( 'admin_enqueue_scripts', $pluginAdmin, 'aceEnqueueScripts');
		$this->loader->add_action( 'admin_menu', $pluginAdmin, 'aceRegisterOptionsPage' );

		// $this->loader->add_action( 'show_user_profile', $pluginAdmin,'aceAdditionalProfileFields' );
		// $this->loader->add_action( 'edit_user_profile', $pluginAdmin,'aceAdditionalProfileFields' );
		$this->loader->add_action( 'personal_options_update',$pluginAdmin, 'aceUserInterestsFieldsSave');

        $this->loader->add_action( 'wp_ajax_delete_user',$pluginAdmin, 'aceDeleteUser' );
        $this->loader->add_action( 'wp_ajax_nopriv_delete_user',$pluginAdmin, 'aceDeleteUser' );
        $this->loader->add_action( 'init', $pluginAdmin, 'languageLoadTextdomain');
  	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$pluginPublic = new Ace_User_Management_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $pluginPublic, 'aceEnqueueStyles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $pluginPublic, 'aceEnqueueScripts' );
		$this->loader->add_action( 'wp_logout', $pluginPublic, 'aceCustomLogoutPage' );

		$this->loader->add_filter( 'login_redirect', $pluginPublic, 'aceMyLoginRedirect', 10, 3);
		$this->loader->add_action( 'wp', $pluginPublic, 'acePageLoadActionHooks' );
		$this->loader->add_action( 'init', $pluginPublic, 'aceSubscriberLogin' );
		
		$this->loader->add_action( 'template_redirect', $pluginPublic, 'aceRedirectToSpecificPage' );
		$this->loader->add_filter( 'register',$pluginPublic,'aceRegisterUrl' );
		
		$this->loader->add_filter( 'wp_nav_menu_items',$pluginPublic, 'aceLoginoutMenuLink', 10, 2);
		$this->loader->add_action( 'wp_authenticate', $pluginPublic, 'aceCatchEmptyUser', 1, 2 );
		$this->loader->add_filter( 'show_admin_bar', $pluginPublic, 'aceShowAdminBarStatus' );
		$this->loader->add_action( 'parse_query', $pluginPublic, 'acePagesPermalink' );

	}  
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ace_User_Management_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}