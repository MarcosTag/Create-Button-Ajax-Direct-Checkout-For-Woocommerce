<?php

class Buttons {

    public $btn_add_to_cart = null;
    public $btn_buy_now = null;

    public function __construct() {

        //adiciona nome ao botão de adicionar ao carrinho
        //add name to add to cart button
        if( isset( CBADCFW_Settings::$options['mt_btn_add_to_cart_name'] ) ) {
            add_filter( 'woocommerce_product_single_add_to_cart_text', [ $this, 'mt_change_name_btn_add_to_cart' ] );
        }

        //adiciona o nome do botão buy now
        //add the name of the buy now button
        if( isset( CBADCFW_Settings::$options['mt_btn_buy_now_name'] ) ) {
            add_action( 'woocommerce_after_add_to_cart_button', [ $this, 'mt_woo_direct_checkout_ajax' ], 20 );
        }

        //adiciona o nome do botão de adicionar ao carrinho na página archive
        //add name to add to cart button in archive page
        if( isset( CBADCFW_Settings::$options['mt_btn_add_to_cart_name_archive'] ) ) {
            add_filter( 'woocommerce_product_add_to_cart_text', [ $this, 'mt_change_name_btn_add_to_cart_archive' ], 20 );
        }

        //adiciona o nome do botão buy now na página archive
        //add the name of the buy now button in archive page
        if( isset( CBADCFW_Settings::$options['mt_btn_buy_now_name_archive'] ) ) {
            add_action( 'woocommerce_after_shop_loop_item', [ $this, 'mt_woo_direct_checkout_archive_ajax' ], 20 );
        }

        //enfileira scripts
        //enqueue scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'mt_woocommerce_ajax_add_to_cart_js' ] );

        //adiciona o produto ao carrinho ajax
        //add product to cart ajax
        add_action( 'wp_ajax_mt_woocommerce_ajax_add_to_cart', [ $this, 'mt_woocommerce_ajax_add_to_cart' ] ); 
        add_action( 'wp_ajax_nopriv_mt_woocommerce_ajax_add_to_cart', [ $this, 'mt_woocommerce_ajax_add_to_cart' ] );  

    }

    //set method add to cart
    function mt_change_name_btn_add_to_cart( $text ) {
        if( isset( CBADCFW_Settings::$options['mt_btn_add_to_cart_name'] ) && CBADCFW_Settings::$options['mt_btn_add_to_cart_name'] != '' ) {
            $this->btn_add_to_cart = esc_html( CBADCFW_Settings::$options['mt_btn_add_to_cart_name'] );
            return $this->btn_add_to_cart;
        } else {
            return $text;
        }
        
    }

    //set method buy now
    function mt_change_name_btn_buy_now() {
        $this->btn_buy_now = esc_html( CBADCFW_Settings::$options['mt_btn_buy_now_name'] );
        return $this->btn_buy_now;
    }

    //set method add to cart archive
    function mt_change_name_btn_add_to_cart_archive( $text ) {
        $this->btn_add_to_cart = esc_html( CBADCFW_Settings::$options['mt_btn_add_to_cart_name_archive'] );

        if( isset( CBADCFW_Settings::$options['mt_btn_add_to_cart_name_archive'] ) && CBADCFW_Settings::$options['mt_btn_add_to_cart_name_archive'] != '' ) {

            //verifica se o input está vazio para afetar o nome do botão ou não.
            if( ! is_cart() && ! is_checkout() && wc_get_product()->is_type( 'simple' ) && wc_get_product()->get_stock_status() == 'instock' && ! wc_get_product()->get_price() == '' ) {
                return $this->btn_add_to_cart;
            } else {
                return $text;
            }

        } else {
            return $text;
        }
    }

    //set method buy now in archive
    function mt_change_name_btn_buy_now_archive() {
        $this->btn_buy_now = esc_html( CBADCFW_Settings::$options['mt_btn_buy_now_name_archive'] );
        return $this->btn_buy_now;
    }

    //print new button in single product page
    function mt_woo_direct_checkout_ajax() {
        //imprime o botão na página do produto
        if( isset( CBADCFW_Settings::$options['mt_btn_buy_now_name'] ) && CBADCFW_Settings::$options['mt_btn_buy_now_name'] != '' ) {
            echo '<a href="" id="mt-add-to-cart" class="single_add_to_cart_button button alt">' . esc_html( $this->mt_change_name_btn_buy_now() ) . '</a>';
        }
    }

    //print new button in archive page
    function mt_woo_direct_checkout_archive_ajax() {
        //imprime o botão na página de arquivo da loja
        if( isset( CBADCFW_Settings::$options['mt_btn_buy_now_name_archive'] ) && CBADCFW_Settings::$options['mt_btn_buy_now_name_archive'] != '' ) {
            if( wc_get_product()->is_type( 'simple' ) && wc_get_product()->get_stock_status() == 'instock' && ! wc_get_product()->get_price() == '' ) {
                echo '<button class="btn-direct-checkout">' . esc_html( $this->mt_change_name_btn_buy_now_archive() ) . '</button>';
            }
        }
    }

    //scripts
    function mt_woocommerce_ajax_add_to_cart_js() {
    
        //enfileira o script js
        //js script queueer
        if ( function_exists( 'is_product' ) ) {  
           wp_enqueue_script( 'cbadcfw_scripts', MT_DIRECT_CHECKOUT_URL . 'assets/js/mt_ajax_add_to_cart.js', array( 'jquery' ), MT_DIRECT_CHECKOUT_VERSION );
        }

        //cria a url do checkout para o objeto ajax jquery
        //create checkout url for jquery ajax object
        wp_localize_script( 'cbadcfw_scripts', 'URL_CHECKOUT', [ 'woo_checkout_url' => wc_get_checkout_url() ] );

    }

    //add to cart
    function mt_woocommerce_ajax_add_to_cart() {  

        WC()->cart->add_to_cart( $_POST[ 'product_id' ], $_POST[ 'quantity' ] );
        
    }
}