<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$woo_variant_attribute_keys  = array_keys( $attributes );
$woo_variant_variations_json = wp_json_encode( $available_variations );
$woo_variant_variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $woo_variant_variations_json ) : _wp_specialchars( $woo_variant_variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

    <form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo esc_attr($woo_variant_variations_attr) ; // WPCS: XSS ok. ?>">
        <?php do_action( 'woocommerce_before_variations_form' ); ?>

        <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
            <p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'product-variant-dropdown-radio-button-for-woocommerce' ) ) ); ?></p>
        <?php else : ?>
            <table class="variations" cellspacing="0" role="presentation">
                <tbody>
                <?php foreach ( $attributes as $woo_variant_attribute_name => $woo_variant_options ) :
                    $woo_variant_attribute_name_formatted = strtolower( sanitize_title( $woo_variant_attribute_name ) );

                    $woo_variant_val = get_post_meta( $product->get_id(), 'attribute_' . $woo_variant_attribute_name_formatted . '_display_mode', true );
                    ?>

                    <tr>
                        <th style="color: #000; width: 20%!important; vertical-align: top" class="label"><label for="<?php echo esc_attr( sanitize_title( $woo_variant_attribute_name ) ); ?>"><?php echo wc_attribute_label( $woo_variant_attribute_name ); // WPCS: XSS ok. ?></label></th>
                        <td style="width: 80%; padding-top: 5px; padding-bottom: 5px" class="value">
                            <?php
                            if ($woo_variant_val=='radio_button'){
                                $woo_variant_sanitized_name = sanitize_title( $woo_variant_attribute_name );
                                // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                                if ( isset( $_REQUEST[ 'attribute_' . $woo_variant_sanitized_name ] ) ) {
                                    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                                    $woo_variant_checked_value = sanitize_text_field(
                                            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                                            wp_unslash( $_REQUEST[ 'attribute_' . $woo_variant_sanitized_name ] )
                                    );
                                } elseif ( isset( $selected_attributes[ $woo_variant_sanitized_name ] ) ) {
                                    $woo_variant_checked_value = sanitize_text_field( $selected_attributes[ $woo_variant_sanitized_name ] );
                                } else {
                                    $woo_variant_checked_value = '';
                                }
                                if ( ! empty( $woo_variant_options ) ) {
                                    if ( taxonomy_exists( $woo_variant_attribute_name ) ) {
                                        // Get terms if this is a taxonomy - ordered. We need the names too.
                                        $woo_variant_terms = wc_get_product_terms( $product->get_id(), $woo_variant_attribute_name, array( 'fields' => 'all' ) );

                                        foreach ( $woo_variant_terms as $term ) {
                                            if ( ! in_array( $term->slug, $woo_variant_options ) ) {
                                                continue;
                                            }
                                            woo_variant_print_attribute_radio( $woo_variant_checked_value, $term->slug, $term->name, $woo_variant_sanitized_name );
                                        }
                                    } else {
                                        foreach ( $woo_variant_options as $woo_variant_option ) {
                                            woo_variant_print_attribute_radio( $woo_variant_checked_value, $woo_variant_option, $woo_variant_option, $woo_variant_sanitized_name );
                                        }
                                    }
                                }
                            }elseif ($woo_variant_val=='select_dropdown'){
                                wc_dropdown_variation_attribute_options(
                                        array(
                                                'options'   => $woo_variant_options,
                                                'attribute' => $woo_variant_attribute_name,
                                                'product'   => $product,
                                                'class'=> 'input-select'
                                        )
                                );
                            }else{
                                wc_dropdown_variation_attribute_options(
                                        array(
                                                'options'   => $woo_variant_options,
                                                'attribute' => $woo_variant_attribute_name,
                                                'product'   => $product,
                                                'class'=> 'input-select'
                                        )
                                );
                            }
                            echo end( $woo_variant_attribute_keys ) === $woo_variant_attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'product-variant-dropdown-radio-button-for-woocommerce' ) . '</a>' ) ) : '';

                            ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php do_action( 'woocommerce_after_variations_table' ); ?>

            <div class="single_variation_wrap">
                <?php
                /**
                 * Hook: woocommerce_before_single_variation.
                 */
                do_action( 'woocommerce_before_single_variation' );

                /**
                 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
                 *
                 * @since 2.4.0
                 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
                 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
                 */
                do_action( 'woocommerce_single_variation' );

                /**
                 * Hook: woocommerce_after_single_variation.
                 */
                do_action( 'woocommerce_after_single_variation' );
                ?>
            </div>
        <?php endif; ?>

        <?php do_action( 'woocommerce_after_variations_form' ); ?>
    </form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
