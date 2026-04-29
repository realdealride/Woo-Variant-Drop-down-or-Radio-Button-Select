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

$product_variant_attribute_keys  = array_keys( $attributes );
$product_variant_variations_json = wp_json_encode( $available_variations );
$product_variant_variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $product_variant_variations_json ) : _wp_specialchars( $product_variant_variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

    <form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo esc_attr($product_variant_variations_attr) ; // WPCS: XSS ok. ?>">
        <?php do_action( 'woocommerce_before_variations_form' ); ?>

        <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
            <p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'product-variant-dropdown-radio-button' ) ) ); ?></p>
        <?php else : ?>
            <table class="variations" cellspacing="0" role="presentation">
                <tbody>
                <?php foreach ( $attributes as $product_variant_attribute_name => $product_variant_options ) :

                    $product_variant_sanitized_name = strtolower( sanitize_title( $product_variant_attribute_name ) );

                    $product_variant_display_mode   = get_post_meta(
                            $product->get_id(),
                            'attribute_' . $product_variant_sanitized_name . '_display_mode',
                            true
                    );

                    $product_variant_checked_value = '';
                    $product_variant_request_key   = 'attribute_' . $product_variant_sanitized_name;

                    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                    if ( isset( $_GET[ $product_variant_request_key ] ) ) {
                        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                        $product_variant_checked_value = sanitize_text_field( wp_unslash( $_GET[ $product_variant_request_key ] ));
                    } elseif ( isset( $selected_attributes[ $product_variant_sanitized_name ] ) ) {
                        $product_variant_checked_value = sanitize_text_field(
                                $selected_attributes[ $product_variant_sanitized_name ]
                        );
                    }
                    ?>
                    <tr>
                        <th class="label" style="width:20%; vertical-align:top">
                            <label for="<?php echo esc_attr( $product_variant_sanitized_name ); ?>">
                                <?php echo esc_html( wc_attribute_label( $product_variant_attribute_name ) ); ?>
                            </label>
                        </th>

                        <td class="value" style="width:80%; padding:5px 0">

                            <?php if ( 'radio_button' === $product_variant_display_mode ) : ?>

                                <?php
                                if ( ! empty( $product_variant_options ) ) {

                                    if ( taxonomy_exists( $product_variant_attribute_name ) ) {

                                        $product_variant_terms = wc_get_product_terms(
                                                $product->get_id(),
                                                $product_variant_attribute_name,
                                                array( 'fields' => 'all' )
                                        );

                                        foreach ( $product_variant_terms as $term ) {
                                            if ( ! in_array( $term->slug, $product_variant_options, true ) ) {
                                                continue;
                                            }

                                            product_variant_print_attribute_radio(
                                                    $product_variant_checked_value,
                                                    $term->slug,
                                                    $term->name,
                                                    $product_variant_sanitized_name
                                            );
                                        }

                                    } else {

                                        foreach ( $product_variant_options as $product_variant_option ) {

                                            product_variant_print_attribute_radio(
                                                    $product_variant_checked_value,
                                                    $product_variant_option,
                                                    $product_variant_option,
                                                    $product_variant_sanitized_name
                                            );
                                        }
                                    }
                                }
                                ?>

                            <?php else : ?>

                                <?php
                                wc_dropdown_variation_attribute_options(
                                        array(
                                                'options'   => $product_variant_options,
                                                'attribute' => $product_variant_attribute_name,
                                                'product'   => $product,
                                                'class'     => 'input-select',
                                        )
                                );
                                ?>

                            <?php endif; ?>

                            <?php
                            echo end( $product_variant_attribute_keys ) === $product_variant_attribute_name
                                    ? wp_kses_post(
                                            apply_filters(
                                                    'woocommerce_reset_variations_link',
                                                    '<a class="reset_variations" href="#">' .
                                                    esc_html__( 'Clear', 'product-variant-dropdown-radio-button' ) .
                                                    '</a>'
                                            )
                                    )
                                    : '';
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
