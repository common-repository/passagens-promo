<?php

/**

 *
 * @link       https://www.passagenspromo.com.br/
 * @since      1.0.0
 *
 * @package    Passagens_Promo
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$option_name = 'passagens_promo';

delete_option($option_name);