<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Visual-only presets; pagination URLs and saved manual styles remain native. */
class BeRocket_Pagination_Presets {
    public static function choices() {
        return array(
            'soft-pills' => __( 'Soft pills', 'pagination-styler-for-woocommerce' ),
            'outline' => __( 'Outline', 'pagination-styler-for-woocommerce' ),
            'high-contrast' => __( 'High contrast', 'pagination-styler-for-woocommerce' ),
            'rounded-cards' => __( 'Rounded cards', 'pagination-styler-for-woocommerce' ),
            'square-blocks' => __( 'Square blocks', 'pagination-styler-for-woocommerce' ),
            'underline' => __( 'Underline', 'pagination-styler-for-woocommerce' ),
            'minimal' => __( 'Minimal', 'pagination-styler-for-woocommerce' ),
            'elevated' => __( 'Elevated', 'pagination-styler-for-woocommerce' ),
            'ocean' => __( 'Ocean', 'pagination-styler-for-woocommerce' ),
            'forest' => __( 'Forest', 'pagination-styler-for-woocommerce' ),
            'warm-sand' => __( 'Warm sand', 'pagination-styler-for-woocommerce' ),
        );
    }

    public static function normalize( $value ) {
        return is_string( $value ) && array_key_exists( $value, self::choices() ) ? $value : 'manual';
    }

    public static function selected( $options ) {
        return self::normalize( $options['pagination_design'] ?? 'manual' );
    }

    public static function classes( $options ) {
        $design = self::selected( $options );
        if ( 'manual' === $design ) { return ''; }
        $vertical = 'none' === ( $options['style_settings']['ul_li_style']['float'] ?? 'left' );
        return ' br-pagination-preset br-pagination-preset--' . $design . ( $vertical ? ' br-pagination-preset--vertical' : '' );
    }

    public static function enqueue() {
        wp_enqueue_style( 'berocket-pagination-presets', plugins_url( '../css/presets.css', __FILE__ ), array( 'berocket_pagination_style' ), BeRocket_pagination_version );
    }

    public static function field( $options ) {
        $design = self::selected( $options );
        ob_start(); ?>
        <th scope="row"><label for="br-pagination-design"><?php esc_html_e( 'Pagination design', 'pagination-styler-for-woocommerce' ); ?></label></th>
        <td><div class="br_field br-pagination-design-field">
            <select id="br-pagination-design" name="br-pagination-options[pagination_design]" aria-describedby="br-pagination-design-help">
                <?php foreach ( self::choices() as $value => $label ) { ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $design, $value ); ?>><?php echo esc_html( $label ); ?></option>
                <?php } ?>
                <optgroup label="<?php esc_attr_e( 'Existing appearance', 'pagination-styler-for-woocommerce' ); ?>">
                    <option value="manual" <?php selected( $design, 'manual' ); ?>><?php esc_html_e( 'Manual/Default', 'pagination-styler-for-woocommerce' ); ?></option>
                </optgroup>
            </select>
            <p class="description" id="br-pagination-design-help"><?php esc_html_e( 'Ready-made designs keep your manual colours and borders. Select Manual/Default to edit and use them again. Position, orientation and navigation settings still apply.', 'pagination-styler-for-woocommerce' ); ?></p>
            <div id="br-pagination-design-preview" <?php echo 'manual' === $design ? 'hidden' : ''; ?>>
                <nav class="woocommerce-pagination berocket_pagination br-pagination-preset br-pagination-preset--<?php echo esc_attr( 'manual' === $design ? 'soft-pills' : $design ); ?>" aria-hidden="true">
                    <ul class="page-numbers">
                        <li class="prev"><a href="#" tabindex="-1"><?php esc_html_e( 'Previous', 'pagination-styler-for-woocommerce' ); ?></a></li>
                        <li class="other"><a href="#" tabindex="-1">1</a></li>
                        <li class="current"><span class="page-numbers current">2</span></li>
                        <li class="other"><a href="#" tabindex="-1">3</a></li>
                        <li class="dots"><span class="page-numbers dots">…</span></li>
                        <li class="other"><a href="#" tabindex="-1">10</a></li>
                        <li class="next"><a href="#" tabindex="-1"><?php esc_html_e( 'Next', 'pagination-styler-for-woocommerce' ); ?></a></li>
                    </ul>
                </nav>
            </div>
        </div></td>
        <?php return ob_get_clean();
    }
}
