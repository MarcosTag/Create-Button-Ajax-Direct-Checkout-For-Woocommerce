<?php

/**
 * Plugin Name: Create Button Ajax Direct Checkout For Woocommerce
 * Plugin URI: https://marcostag.com.br/plugins
 * Description: This plugin creates a button on the woocommerce single product page and in the store page's product loop, which when clicked directs the store customer directly to checkout with the chosen product and quantity, without the need to add it to the cart in advance or go through the cart page. Proceed to direct checkout!
 * Version: 1.0
 * Requires at least: 6.4.1
 * Requires PHP: 7.4
 * Author: MarcosTag
 * Author URI: https://marcostag.com.br/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mt-direct-checkout
 * Domain Path: /languages
 */

 /*
Create Button Ajax Direct Checkout For Woocommerce is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Create Button Ajax Direct Checkout For Woocommerce is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Create Button Ajax Direct Checkout For Woocommerce. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'MTDirectCheckout' ) ) {
    class MTDirectCheckout {
        function __construct() {
            $this->define_constants();

            $this->load_textdomain();

            require_once( MT_DIRECT_CHECKOUT_PATH . 'cbadcfw_settings_page.php' );
            $btn_controler = new CBADCFW_Settings_Page();

            require_once( MT_DIRECT_CHECKOUT_PATH . 'cbadcfw_settings.php' );
            $cbadcfw_settings = new CBADCFW_Settings();

            require_once( MT_DIRECT_CHECKOUT_PATH . 'btn_frontend.php' );
            $btn_frontend = new Buttons();

            add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), [ $this, 'plugin_action_links' ] );
        }

        public function define_constants() {
            define( 'MT_DIRECT_CHECKOUT_PATH', plugin_dir_path( __FILE__ ) );
            define( 'MT_DIRECT_CHECKOUT_URL', plugin_dir_url( __FILE__ ) );
            define( 'MT_DIRECT_CHECKOUT_VERSION', '1.0.0' );
        }

        public static function activate() {
            update_option( 'rewrite_rules', '' );
        }

        public static function deactivate() {
            flush_rewrite_rules();
        }

        public static function uninstall() {
            delete_option( 'mt_btn_buy_now_options' );
        }

        public function load_textdomain() {
            load_plugin_textdomain(
                'mt-direct-checkout',
                false,
                dirname( plugin_basename( __FILE__ ) ) . '/languages/'
            );
        }

        public function plugin_action_links( $links ) {
            $plugin_links   = array();
            $plugin_links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=mt_buy_now_settings_page' ) ) . '">' .esc_html__( 'Settings', 'mt-direct-checkout' ) . '</a>';
            $plugin_links[] = '<a href="' . esc_attr( 'https://www.paypal.com/donate/?business=5FC7PT8RV3KHS&no_recurring=0&item_name=Materializar+sua+gratid%C3%A3o+em+forma+de+doa%C3%A7%C3%A3o+de+qualquer+valor+%C3%A9+reconhecer+todo+esfor%C3%A7o+dedicado+nas+pequenas+causas' ) . '" " target="_blank" rel="noopener noreferrer">' . esc_html__( 'Donate with Credit', 'mt-direct-checkout' ) . '</a>';
            $plugin_links[] = '<a href="' . esc_attr( 'https://marcostag.com.br/#pix-qr' ) . '" target="_blank" rel="noopener noreferrer" style="color: green; font-weight: 700;">' . esc_html__( 'Donate Pix', 'mt-direct-checkout' ) . '</a>';
    
            return array_merge( $plugin_links, $links );
        }
    }
}

if( class_exists( 'MTDirectCheckout' ) ) {
    register_activation_hook( __FILE__, [ 'MTDirectCheckout', 'activate' ] );
    register_deactivation_hook( __FILE__, [ 'MTDirectCheckout', 'deactivate' ] );
    register_uninstall_hook( __FILE__, [ 'MTDirectCheckout', 'uninstall' ] );

    //instancia o objeto se o plugin woocommerce estiver ativo
    //instantiates the object if the woocommerce plugin is active
    add_action ( 'plugins_loaded', 'instance_MTDirectCheckout' ) ;
    function instance_MTDirectCheckout() { 
        if ( class_exists ( 'Woocommerce' ) ) {
            $mt_direct_checkout = new MTDirectCheckout();
        } 
    } 
}