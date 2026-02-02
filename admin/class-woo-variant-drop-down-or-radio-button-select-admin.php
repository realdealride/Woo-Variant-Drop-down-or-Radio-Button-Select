<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://realdealride.com
 * @since      1.0.0
 *
 * @package    Woo_Variant_Drop_Down_Or_Radio_Button_Select
 * @subpackage Woo_Variant_Drop_Down_Or_Radio_Button_Select/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Variant_Drop_Down_Or_Radio_Button_Select
 * @subpackage Woo_Variant_Drop_Down_Or_Radio_Button_Select/admin
 * @author     Rakeybul Hasan <rakeybulhasan@gmail.com>
 */
class Woo_Variant_Drop_Down_Or_Radio_Button_Select_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-variant-drop-down-or-radio-button-select-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-variant-drop-down-or-radio-button-select-admin.js', array( 'jquery' ), $this->version, false );

	}

   public function woo_variant_add_product_attribute_is_display_mode( $attribute, $i=0 ) {
        $value = $this->get_attribute_display_mode($attribute->get_name()); ?>
        <tr>
            <td>
                <div class="enable_display_mode">
                    <label for="attribute_display_mode_<?php echo esc_attr( $i ); ?>">
                        <?php esc_html_e( 'Display Mode', 'product-variant-dropdown-radio-button-for-woocommerce' ); ?>
                    </label>
                    <select id="attribute_display_mode_<?php echo esc_attr( $i ); ?>" name="attribute_display_mode[<?php echo esc_attr( $i ); ?>]">
                        <option value="">Choose Options</option>
                        <option value="select_dropdown" <?php echo $value == "select_dropdown"?'selected="selected"':""?>>Drop Down</option>
                        <option value="radio_button" <?php echo $value == "radio_button"?'selected="selected"':""?>>Radio Button</option>
                    </select>
                </div>
            </td>
        </tr>
        <?php
    }

   public function get_attribute_display_mode( $attribute_name ) {
        global $post;

        // ID for either from ajax or from post
        $post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : $post->ID ;
        $attribute_name = strtolower( sanitize_title( $attribute_name ) );
        $val = get_post_meta( $post_id, 'attribute_' . $attribute_name . '_display_mode', true );

        return !empty( $val ) ? $val : '';
    }

    public function woo_variant_ajax_woocommerce_save_attributes() {

        check_ajax_referer( 'save-attributes', 'security' );

        parse_str( $_POST['data'], $data );
        $post_id = absint( $_POST['post_id'] );
        if( array_key_exists( 'attribute_display_mode', $data ) && is_array( $data['attribute_display_mode'] ) ) {
            foreach( $data['attribute_display_mode'] as $i => $val ) {
                $attr_name = sanitize_title( $data['attribute_names'][$i] );
                $attr_name = strtolower( $attr_name );
                update_post_meta( $post_id, 'attribute_' . $attr_name . '_display_mode', $val );
            }
        }
    }



}
