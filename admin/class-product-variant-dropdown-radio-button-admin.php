<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sentiplug.com
 * @since      1.0.0
 *
 * @package    Sentiplug_Pvdrb
 * @subpackage Sentiplug_Pvdrb/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sentiplug_Pvdrb
 * @subpackage Sentiplug_Pvdrb/admin
 * @author     Sentiplug <admin@sentiplug.com>
 */
class Sentiplug_Pvdrb_Admin {

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
		 * defined in Sentiplug_Pvdrb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sentiplug_Pvdrb_Loader will then create the relationship
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
		 * defined in Sentiplug_Pvdrb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sentiplug_Pvdrb_Loader will then create the relationship
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
                        <option value=""><?php esc_html_e( 'Choose Options', 'product-variant-dropdown-radio-button' ); ?></option>
                        <option value="select_dropdown" <?php selected( $value, 'select_dropdown' ); ?>><?php esc_html_e( 'Drop Down', 'product-variant-dropdown-radio-button' ); ?></option>
                        <option value="radio_button" <?php selected( $value, 'radio_button' ); ?>><?php esc_html_e( 'Radio Button', 'product-variant-dropdown-radio-button' ); ?></option>
                    </select>
                </div>
            </td>
        </tr>
        <?php
    }

    public function sentiplug_get_attribute_display_mode( $attribute_name ) {
        $post_id = 0;

        // When WooCommerce re-renders the attribute rows after AJAX save,
        // global $post is not set to the product being edited, so the
        // selected display-mode would otherwise come back blank. Fall back
        // to $_POST['post_id'] in that flow. The save-attributes nonce has
        // already been verified upstream (by both our own handler and
        // WooCommerce's WC_AJAX::save_attributes() before this code runs).
        if ( wp_doing_ajax() && isset( $_POST['post_id'] ) && isset( $_POST['security'] )
            && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['security'] ) ), 'save-attributes' )
        ) {
            $post_id = absint( wp_unslash( $_POST['post_id'] ) );
        } else {
            global $post;
            if ( $post instanceof WP_Post ) {
                $post_id = (int) $post->ID;
            } else {
                $post_id = (int) get_the_ID();
            }
        }

        if ( ! $post_id ) {
            return '';
        }

        $attribute_name = strtolower( sanitize_title( $attribute_name ) );
        $val            = get_post_meta( $post_id, 'attribute_' . $attribute_name . '_display_mode', true );

        return ! empty( $val ) ? $val : '';
    }
    public function sentiplug_variant_ajax_woocommerce_save_attributes() {

        // 1. Verify nonce.
        check_ajax_referer( 'save-attributes', 'security' );

        // 2. Validate post_id from the request.
        $post_id = isset( $_POST['post_id'] ) ? absint( wp_unslash( $_POST['post_id'] ) ) : 0;
        if ( ! $post_id ) {
            wp_send_json_error( 'Invalid post ID.' );
        }

        // 3. Capability check tied to the specific product being edited.
        if ( ! current_user_can( 'edit_product', $post_id ) ) {
            wp_send_json_error( 'Insufficient permissions.' );
        }

        // 4. Read the serialized form payload. parse_str() needs the raw string;
        //    every value is sanitized via map_deep() immediately after parsing.
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized via map_deep() below.
        $raw_data = isset( $_POST['data'] ) ? wp_unslash( $_POST['data'] ) : '';

        $data = array();
        if ( '' !== $raw_data ) {
            parse_str( $raw_data, $data );
            $data = map_deep( $data, 'sanitize_text_field' );
        }

        if ( ! empty( $data['attribute_display_mode'] ) && is_array( $data['attribute_display_mode'] ) ) {
            $allowed_modes = array( 'select_dropdown', 'radio_button', '' );

            foreach ( $data['attribute_display_mode'] as $i => $val ) {
                if ( ! isset( $data['attribute_names'][ $i ] ) ) {
                    continue;
                }

                $attr_name = sanitize_title( strtolower( $data['attribute_names'][ $i ] ) );
                if ( '' === $attr_name ) {
                    continue;
                }

                // Whitelist the display mode value — never trust input.
                $val = in_array( $val, $allowed_modes, true ) ? $val : '';

                update_post_meta( $post_id, 'attribute_' . $attr_name . '_display_mode', $val );
            }
        }

    }



}
