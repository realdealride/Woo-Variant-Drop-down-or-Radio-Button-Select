<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://realdealride.com
 * @since      1.0.0
 *
 * @package    Woo_Variant_Drop_Down_Or_Radio_Button_Select
 * @subpackage Woo_Variant_Drop_Down_Or_Radio_Button_Select/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Variant_Drop_Down_Or_Radio_Button_Select
 * @subpackage Woo_Variant_Drop_Down_Or_Radio_Button_Select/public
 * @author     Rakeybul Hasan <rakeybulhasan@gmail.com>
 */
class Woo_Variant_Drop_Down_Or_Radio_Button_Select_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Variant_Drop_Down_Or_Radio_Button_Select_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Variant_Drop_Down_Or_Radio_Button_Select_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-variant-drop-down-or-radio-button-select-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Variant_Drop_Down_Or_Radio_Button_Select_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Variant_Drop_Down_Or_Radio_Button_Select_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-variant-drop-down-or-radio-button-select-public.js', array( 'jquery' ), $this->version, false );

        if ( ! ( wc_get_product() && wc_get_product()->is_type( 'bundle' ) ) ) {
            wp_deregister_script( 'wc-add-to-cart-variation' );

            wp_register_script(
                'wc-add-to-cart-variation',
                plugin_dir_url( __FILE__ ) . '../assets/js/frontend/add-to-cart-variation.js',
                array( 'jquery', 'wp-util' ),
                $this->version,
                true // Load in footer (required to fix warning)
            );
        }

	}

    public function woo_variant_locate_template( $template, $template_name, $template_path ) {
        global $woocommerce;

        $_template = $template;

        if ( ! $template_path ) {
            $template_path = $woocommerce->template_url;
        }

        $plugin_path = plugin_dir_path(__FILE__) . 'templates/';

        // Look within passed path within the theme - this is priority
        $template = locate_template( array(
            $template_path . $template_name,
            $template_name
        ) );

        // Modification: Get the template from this plugin, if it exists
        if ( ! $template && file_exists( $plugin_path . $template_name ) ) {
            $template = $plugin_path . $template_name;
        }

        // Use default template
        if ( ! $template ) {
            $template = $_template;
        }

        return $template;
    }


}
