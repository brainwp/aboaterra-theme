/* Change product quantity */
jQuery(document).ready(function($) {
	$( document ).on( 'click', '.woocommerce .buttons-qty span', function(e){
		var $input = $( this ).parent()[0];
		var $input = $( $input ).children( 'input' );
		if ( $( 'body' ).hasClass( 'woocommerce-cart' ) ) {
			$input = $( $input[0] );
		}
		var value = parseInt( $input.val() );
		if ( $( this ).html() == '+' ) {
			var value = value + 1;
		} else {
			var value = value - 1;
			if ( value < 1 ) {
				return;
			}

		}
		$input.val( value );
		$input.trigger( 'change' );
	});
	$( document ).on( 'change', '.woocommerce .buttons-qty input', function(e){
		if ( $( 'body' ).hasClass( 'woocommerce-cart' ) ) {
			var selector = 'select[name="' + $( this ).attr( 'data-id' ) + '"]';
			$( selector ).val( $( this ).val() );
		}

		if ( $( this ).hasClass( 'single-product' ) ) {
			$( 'input[name="quantity"]').val( $( this ).val() );
			return;
		}

		var $button_cart = $( '.woocommerce .products .post-' + $( this ).attr( 'data-id') + ' .ajax_add_to_cart' );
		$button_cart.attr( 'data-quantity', $( this ).val() );
	});
});
