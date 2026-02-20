<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://http://sentiplug.com
 * @since      1.0.0
 *
 * @package    Product_Variant_Dropdown_Radio_Button
 * @subpackage Product_Variant_Dropdown_Radio_Button/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Product_Variant_Dropdown_Radio_Button
 * @subpackage Product_Variant_Dropdown_Radio_Button/admin
 * @author     Sentiplug <admin@sentiplug.com>
 */
class Product_Variant_Dropdown_Radio_Button_Admin {

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
		 * defined in Product_Variant_Dropdown_Radio_Button_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Variant_Dropdown_Radio_Button_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/product-variant-dropdown-radio-button-admin.css', array(), $this->version, 'all' );

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
		 * defined in Product_Variant_Dropdown_Radio_Button_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Variant_Dropdown_Radio_Button_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/product-variant-dropdown-radio-button-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function sentiplug_variant_add_product_attribute_is_display_mode( $attribute, $i=0 ) {
        $value = $this->sentiplug_get_attribute_display_mode($attribute->get_name()); ?>
        <tr>
            <td>
                <div class="enable_display_mode">
                    <label for="attribute_display_mode_<?php echo esc_attr( $i ); ?>">
                        <?php esc_html_e( 'Display Mode', 'product-variant-dropdown-radio-button' ); ?>
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

    public function sentiplug_get_attribute_display_mode( $attribute_name ) {
        global $post;

        // ID for either from ajax or from post
        // phpcs:ignore WordPress.Security.NonceVerification.Missing
        $post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : $post->ID ;
        $attribute_name = strtolower( sanitize_title( $attribute_name ) );
        $val = get_post_meta( $post_id, 'attribute_' . $attribute_name . '_display_mode', true );

        return !empty( $val ) ? $val : '';
    }
    public function sentiplug_variant_ajax_woocommerce_save_attributes() {

        // 1️⃣ Verify nonce (AJAX security)
        check_ajax_referer( 'save-attributes', 'security' );

        // 2️⃣ Retrieve, unslash, and sanitize POSTed query string
        $raw_data = isset( $_POST['data'] ) ? sanitize_text_field( wp_unslash($_POST['data']) ) : '';
        // Sanitize raw query string to satisfy PHPCS and prevent malicious payloads

        $data = [];
        parse_str( $raw_data, $data );

        // 3️⃣ Sanitize post_id
        $post_id = isset( $_POST['post_id'] ) ? absint( wp_unslash( $_POST['post_id'] ) ) : 0;
        if ( ! $post_id ) {
            wp_send_json_error( 'Invalid post ID.' );
        }

        // 4️⃣ Ensure attribute_display_mode exists and is an array
        if ( ! empty( $data['attribute_display_mode'] ) && is_array( $data['attribute_display_mode'] ) ) {

            // 5️⃣ Sanitize all parsed data
            $data = map_deep( $data, 'sanitize_text_field' );

            foreach ( $data['attribute_display_mode'] as $i => $val ) {

                // Sanitize attribute name safely
                if ( ! isset( $data['attribute_names'][$i] ) ) {
                    continue;
                }

                $attr_name = sanitize_title( strtolower( $data['attribute_names'][$i] ) );

                // Save sanitized value to post meta
                update_post_meta( $post_id, 'attribute_' . $attr_name . '_display_mode', $val );
            }
        }

    }



}
