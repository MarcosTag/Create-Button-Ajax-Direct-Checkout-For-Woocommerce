jQuery( ($) => {

    //single product page
    $(document).on('click', '#mt-add-to-cart', (e) => {
        e.preventDefault();
        
        //verifica se a quantidade de itens foi modificada
        //checks if the quantity of items has been modified
        let qty = $('input[name="quantity"]').val();
        if (typeof qty ==='undefined' || qty === '' || qty < 1) {
            qty = 1;
        }

        //verifica se há um id de variação selecionado
        //checks if there is a variation id selectedt
        let id = $('input[name="variation_id"]').val();
        if (typeof id === "undefined") {
            id = $('button[name="add-to-cart"]').val()
        }

        //dados do objeto ajax
        //ajax object data
        let data = {
            action: 'mt_woocommerce_ajax_add_to_cart',
            product_id: id,
            quantity: qty,
        };

        direct_checkout_ajax_obj( data, $(e.target) );
    });

    //product archive page 
    $(document).on('click', '.btn-direct-checkout', (e) => {
        e.preventDefault();

        let id = $(e.target.offsetParent).children('a.button.add_to_cart_button').attr('data-product_id');
        
        //dados do objeto ajax
        let data = {
            action: 'mt_woocommerce_ajax_add_to_cart',
            product_id: id,
            quantity: 1,
        };

        direct_checkout_ajax_obj( data, $(e.target) );
    });

    //função para criar o objeto ajax
    //function to create the ajax object
    function direct_checkout_ajax_obj( data, element ) {
        $.ajax({
            type: 'post',
            url: wc_add_to_cart_params.ajax_url,
            data: data,
            beforeSend: (response) => {
                element.removeClass('added').addClass('loading');
            },
            complete: (response) => {
                element.addClass('added').removeClass('loading');
            }, 
            success: (response) => { 
                if (response.error & response.product_url) {
                    window.location = response.product_url;
                    return;
                } else { 

                    //verifica se o atributo id do objeto data é válido
                    //checks whether the id attribute of the data object is valid
                    if( data.product_id == 0 || data.product_id == '' ) {
                        return;
                    } else {
                        $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, element]);
                        window.location = URL_CHECKOUT.woo_checkout_url;
                    }
                } 
            }, 
        });
    };
});
