<?php

if( ! class_exists( 'CBADCFW_Settings_Page' ) ) {

    class CBADCFW_Settings_Page {

        function __construct() {
            add_action( 'admin_menu', [ $this, 'mt_create_menu_settings' ] );
        }

        //cria a página settings do plugin
        //create the plugin settings page
        public function mt_create_menu_settings() {

            add_submenu_page(
                'woocommerce',
                esc_html__('Create Button Ajax Direct Checkout For Woocommerce - Options', 'mt-direct-checkout'),
                'MT Buy Now',
                'manage_woocommerce',
                'mt_buy_now_settings_page',
                [ $this, 'mt_buy_now_settings' ]
            );
        }

        public function mt_buy_now_settings() {

            if( ! current_user_can( 'manage_woocommerce' ) ) {
                return;
            }

            //mostra as mensagens na página settings do plugin
            //shows messages on the plugin settings page
            if( isset( $_GET['settings-updated'] ) ) {
                add_settings_error( 'mt_btn_buy_now_options', 'mt_btn_buy_now_message', esc_html__( 'Settings Saved', 'mt-direct-checkout' ), 'success' );
            }
            settings_errors( 'mt_btn_buy_now_options' );

            require( MT_DIRECT_CHECKOUT_PATH . 'views/mt-settings-page.php' );
        }
    }
}