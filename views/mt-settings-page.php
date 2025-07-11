<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
        <?php
            settings_fields( 'mt_btn_buy_now_group' );
            do_settings_sections( 'mt_btn_buy_now_page1' );
            echo '<hr>';
            echo '<strong>' . esc_html__( '* To disregard the configuration of any field, simply leave it empty', 'mt-direct-checkout' ) . '</strong>';
            submit_button( esc_html__( 'Save Setings', 'mt-direct-checkout' ) );
        ?>
    </form>
</div>