<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sentiplug.com
 * @since             1.0.0
 * @package           Sentiplug_Pvdrb
 *
 * @wordpress-plugin
 * Plugin Name:       Product Variant Dropdown or Radio Button for WooCommerce
 * Plugin URI:        https://github.com/realdealride/Woo-Variant-Drop-down-or-Radio-Button-Select
 * Description:       Switch WooCommerce variation dropdowns to clean radio buttons or improved dropdowns for clearer, faster product option selection.
 * Version:           1.0.0
 * Author:            Sentiplug
 * Author URI:        https://sentiplug.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       product-variant-dropdown-radio-button
 * Domain Path:       /languages
 * Requires Plugins:  woocommerce
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
define( 'SENTIPLUG_PVDRB_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-product-variant-dropdown-radio-button-activator.php
 */
function sentiplug_pvdrb_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-variant-dropdown-radio-button-activator.php';
	Sentiplug_Pvdrb_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-product-variant-dropdown-radio-button-deactivator.php
 */
function sentiplug_pvdrb_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-variant-dropdown-radio-button-deactivator.php';
	Sentiplug_Pvdrb_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'sentiplug_pvdrb_activate' );
register_deactivation_hook( __FILE__, 'sentiplug_pvdrb_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-product-variant-dropdown-radio-button.php';

function sentiplug_pvdrb_print_attribute_radio( $checked_value, $value, $label, $name ) {
    global $product;

    $input_name     = 'attribute_' . esc_attr( $name );
    $esc_value      = esc_attr( $value );
    $id             = esc_attr( $name . '_v_' . $value . $product->get_id() );
    $checked        = checked( $checked_value, $value, false );
    $filtered_label = apply_filters( 'woocommerce_variation_option_name', $label, esc_attr( $name ) );
    printf(
        '<div><input type="radio" name="%1$s" value="%2$s" id="%3$s" %4$s> <label class="ml-sm" for="%3$s">%5$s</label></div>',
        esc_attr( $input_name ),
        esc_attr( $esc_value ),
        esc_attr( $id ),
        wp_kses_post( $checked ),
        esc_html( $filtered_label )
    );
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function sentiplug_pvdrb_run() {

	$plugin = new Sentiplug_Pvdrb();
	$plugin->run();

}
sentiplug_pvdrb_run();
