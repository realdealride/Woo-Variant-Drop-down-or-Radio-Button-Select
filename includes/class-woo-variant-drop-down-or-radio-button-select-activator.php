<?php

/**
 * Fired during plugin activation
 *
 * @link       https://realdealride.com
 * @since      1.0.0
 *
 * @package    Woo_Variant_Drop_Down_Or_Radio_Button_Select
 * @subpackage Woo_Variant_Drop_Down_Or_Radio_Button_Select/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Variant_Drop_Down_Or_Radio_Button_Select
 * @subpackage Woo_Variant_Drop_Down_Or_Radio_Button_Select/includes
 * @author     Rakeybul Hasan <rakeybulhasan@gmail.com>
 */
class Woo_Variant_Drop_Down_Or_Radio_Button_Select_Activator {

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
                __('This plugin requires WooCommerce to be active.', 'my-plugin'),
                __('Dependency error', 'my-plugin'),
                ['back_link' => true]
            );
        }
	}

}
