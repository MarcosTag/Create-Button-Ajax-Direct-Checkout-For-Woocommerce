<?php

if( ! class_exists( 'CBADCFW_Settings' ) ) {
    class CBADCFW_Settings {
        public static $options;

        public function __construct() {
            self::$options = get_option( 'mt_btn_buy_now_options' );
            add_action( 'admin_init', [ $this, 'admin_init' ] );
        }

        public function admin_init() {
            register_setting( 'mt_btn_buy_now_group', 'mt_btn_buy_now_options', [ $this, 'mt_inputs_validate' ] );

            //adiciona a sessão de alteração dos botões na página settings no admin
            //Add the button change section to the settings page in the admin
            add_settings_section(
                'mt_btn_buy_now',
                esc_html__( 'Change button names in single product page', 'mt-direct-checkout' ),
                null,
                'mt_btn_buy_now_page1'
            );

            //adiciona a sessão de alteração dos botões na página settings no admin
            //Add the button change section to the settings page in the admin
            add_settings_section(
                'mt_btn_buy_now_archive',
                esc_html__( 'Change button names in product archive page', 'mt-direct-checkout' ),
                null,
                'mt_btn_buy_now_page1'
            );

            //adiciona o campo do nome do botão de adicionar ao carrinho
            //add add to cart button name field
            add_settings_field(
                'mt_btn_add_to_cart_name',
                esc_html__( 'New name for the Add to Cart button - single product page', 'mt-direct-checkout' ),
                [ $this, 'mt_buy_now_add_to_cart_input' ],
                'mt_btn_buy_now_page1',
                'mt_btn_buy_now',
                [
                    'label_for' => 'mt_btn_add_to_cart_name'
                ]
            );

            //adiciona o campo do nome do botão buy now no admin
            //add the name field for the buy now button in the admin
            add_settings_field(
                'mt_btn_buy_now_name',
                esc_html__( 'New name for the Buy Now button - single product page', 'mt-direct-checkout' ),
                [ $this, 'mt_buy_now_checkout_input' ],
                'mt_btn_buy_now_page1',
                'mt_btn_buy_now',
                [
                    'label_for' => 'mt_btn_buy_now_name'
                ]
            );

            //adiciona o campo do nome do botão de adicionar ao carrinho em product archive page
            //add add to cart button name field to product archive page
            add_settings_field(
                'mt_btn_add_to_cart_name_archive',
                esc_html__( 'New name for the Add to Cart button - product archive page', 'mt-direct-checkout' ),
                [ $this, 'mt_add_to_cart_checkout_input_archive' ],
                'mt_btn_buy_now_page1',
                'mt_btn_buy_now_archive',
                [
                    'label_for' => 'mt_btn_add_to_cart_name_archive'
                ]
            );

            //adiciona o campo do nome do botão botão buy now archive no admin
            //add the name field for the buy now archive button in the admin
            add_settings_field(
                'mt_btn_buy_now_name_archive',
                esc_html__( 'New name for the Buy Now button - product archive page', 'mt-direct-checkout' ),
                [ $this, 'mt_buy_now_checkout_input_archive' ],
                'mt_btn_buy_now_page1',
                'mt_btn_buy_now_archive',
                [
                    'label_for' => 'mt_btn_buy_now_name_archive'
                ]
            );
        }   

        public function  mt_buy_now_add_to_cart_input( $args ) { ?>
            <input type="text" name="mt_btn_buy_now_options[mt_btn_add_to_cart_name]" id="mt_btn_add_to_cart_name" placeholder="<?php esc_attr_e( 'Add to Cart button', 'mt-direct-checkout' ); ?>" value="<?php echo isset( self::$options['mt_btn_add_to_cart_name'] ) ? esc_attr( self::$options['mt_btn_add_to_cart_name'] ) : '' ; ?>">
        <?php }

        public function  mt_buy_now_checkout_input( $args ) { ?>
            <input type="text" name="mt_btn_buy_now_options[mt_btn_buy_now_name]" id="mt_btn_buy_now_name" placeholder="<?php esc_attr_e( 'Buy Now button', 'mt-direct-checkout' ); ?>" value="<?php echo isset( self::$options['mt_btn_buy_now_name'] ) ? esc_attr( self::$options['mt_btn_buy_now_name'] ) : '' ; ?>">
        <?php }

        public function  mt_add_to_cart_checkout_input_archive( $args ) { ?>
            <input type="text" name="mt_btn_buy_now_options[mt_btn_add_to_cart_name_archive]" id="mt_btn_add_to_cart_name_archive" placeholder="<?php esc_attr_e( 'Add to Cart button', 'mt-direct-checkout' ); ?>" value="<?php echo isset( self::$options['mt_btn_add_to_cart_name_archive'] ) ? esc_attr( self::$options['mt_btn_add_to_cart_name_archive'] ) : '' ; ?>">
        <?php }

        public function  mt_buy_now_checkout_input_archive( $args ) { ?>
            <input type="text" name="mt_btn_buy_now_options[mt_btn_buy_now_name_archive]" id="mt_btn_buy_now_name_archive" placeholder="<?php esc_attr_e( 'Buy Now button', 'mt-direct-checkout' ); ?>" value="<?php echo isset( self::$options['mt_btn_buy_now_name_archive'] ) ? esc_attr( self::$options['mt_btn_buy_now_name_archive'] ) : '' ; ?>">
        <?php }

        //sanitiza os campos imputs
        //sanitizes input fields
        public function mt_inputs_validate( $input ) {
            $new_input = [];
            foreach ( $input as $key => $value ) {
                $new_input[$key] = sanitize_text_field( $value );
            }
            return $new_input;
        }
    }
}