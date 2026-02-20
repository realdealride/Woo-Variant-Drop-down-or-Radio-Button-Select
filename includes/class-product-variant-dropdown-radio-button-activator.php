<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Fired during plugin activation
 *
 * @link       https://http://sentiplug.com
 * @since      1.0.0
 *
 * @package    Product_Variant_Dropdown_Radio_Button
 * @subpackage Product_Variant_Dropdown_Radio_Button/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Product_Variant_Dropdown_Radio_Button
 * @subpackage Product_Variant_Dropdown_Radio_Button/includes
 * @author     Sentiplug <admin@sentiplug.com>
 */
class Product_Variant_Dropdown_Radio_Button_Activator {

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
