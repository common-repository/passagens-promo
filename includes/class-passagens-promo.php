<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.passagenspromo.com.br/
 * @since      1.0.0
 *
 * @package    Passagens_Promo
 * @subpackage Passagens_Promo/includes
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
 * @package    Passagens_Promo
 * @subpackage Passagens_Promo/includes
 * @author     2XT <plugins@2xt.com.br>
 */
class Passagens_Promo {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Passagens_Promo_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

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

		if ( defined( 'PASSAGENS_PROMO_VERSION' ) ) {
			$this->version = PASSAGENS_PROMO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'passagens-promo';

		$this->load_dependencies();
		$this->set_locale();

		if(is_admin())
			$this->define_admin_hooks();
		else
			$this->define_public_hooks();

	}

	/**
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-passagens-promo-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-passagens-promo-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-passagens-promo-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-passagens-promo-public.php';

		$this->loader = new Passagens_Promo_Loader();

	}

	/**
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Passagens_Promo_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Passagens_Promo_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'passagens_promo_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'passagens_promo_admin_enqueue_scripts' );

		// CONFIG PAGE
		$this->loader->add_action('admin_menu', $plugin_admin, 'passagens_promo_admin_add_options_page');
		$this->loader->add_action('admin_init', $plugin_admin, 'passagens_promo_admin_register_setting' );
		$this->loader->add_filter('plugin_action_links_passagens-promo/passagens-promo.php', $plugin_admin, 'passagens_promo_admin_add_settings_link');

        // TINYMCE
        $this->loader->add_filter("mce_external_plugins", $plugin_admin, 'passagens_promo_add_buttons');
		$this->loader->add_filter('mce_buttons', $plugin_admin, 'passagens_promo_register_buttons');


	}

	/**
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Passagens_Promo_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_public, 'passagens_promo_public_add_shortcodes' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'passagens_promo_public_enqueue_styles' );

		if ((isset($_GET['amp']) && $_GET['amp'] == 1) || (preg_match('/\/amp\//', $_SERVER['REQUEST_URI']))){

			$this->loader->add_action('amp_css', $plugin_public, 'amp_inline_css');
			$this->loader->add_action('amp_css', $plugin_public, 'amp_inline_css');
			$this->loader->add_action('amp_post_template_css', $plugin_public, 'amp_inline_css');

		} else
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'passagens_promo_public_enqueue_scripts' );
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
	 *
	 * @since     1.0.0
	 * @return    Passagens_Promo_Loader    Orchestrates the hooks of the plugin.
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
