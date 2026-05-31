<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Fired during plugin activation
 *
 * @link       https://sentiplug.com
 * @since      1.0.0
 *
 * @package    Sentiplug_Pvdrb
 * @subpackage Sentiplug_Pvdrb/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Sentiplug_Pvdrb
 * @subpackage Sentiplug_Pvdrb/includes
 * @author     Sentiplug <admin@sentiplug.com>
 */
class Sentiplug_Pvdrb_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        if ( ! function_exists('is_plugin_active') ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        if (
            ! is_plugin_active('woocommerce/woocommerce.php') &&
            ! is_plugin_active_for_network('woocommerce/woocommerce.php')
        ) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(
                esc_html( __( 'This plugin requires WooCommerce to be active.', 'product-variant-dropdown-radio-button' ) ),
                esc_html( __( 'Dependency error', 'product-variant-dropdown-radio-button' ) ),
                [ 'back_link' => true ]
            );
        }

	}

}
