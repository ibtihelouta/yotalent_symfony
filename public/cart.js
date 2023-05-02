$(function() {
    $('.add-to-cart').click(function() {
        var productId = $(this).data('product-id');

        $.ajax({
            url: '/produit/panier/' + productId,
            method: 'POST',
            success: function(response) {
                alert(response.message);
            }
        });
    });
});