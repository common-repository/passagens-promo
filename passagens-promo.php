<?php

/**
 *
 * @link              https://www.passagenspromo.com.br/
 * @since             1.0.0
 * @package           Passagens_Promo
 *
 * @wordpress-plugin
 * Plugin Name:       Passagens Promo
 * Plugin URI:        https://wordpress.org/plugins/passagens-promo/
 * Description:       Este é um plugin para afiliados do Passagens Promo. Você poderá enriquecer matérias com preços de voos que são atualizados o tempo todo
 * Version:           1.6.8
 * Author:            2XT
 * Author URI:        https://www.passagenspromo.com.br/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       passagens-promo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PASSAGENS_PROMO_VERSION', '1.6.8' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-passagens-promo-activator.php
 */
function activate_passagens_promo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-passagens-promo-activator.php';
	Passagens_Promo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-passagens-promo-deactivator.php
 */
function deactivate_passagens_promo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-passagens-promo-deactivator.php';
	Passagens_Promo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_passagens_promo' );
register_deactivation_hook( __FILE__, 'deactivate_passagens_promo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-passagens-promo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_passagens_promo() {
	$plugin = new Passagens_Promo();
	$plugin->run();
}
run_passagens_promo();
