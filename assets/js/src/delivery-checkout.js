jQuery(document).ready(function($) {
	if ( ! $( 'body' ).hasClass( 'woocommerce-checkout' ) ) {
		return;
	}
	var update_delivery_price = function() {
		var id = $( 'ul#shipping_method input:checked' ).attr( 'id' );
		var $elem = $( 'label[for="' + id + '"] span' );
		var $delivery_elem = $( '.delivery span' );
		var $delivery_container = $( '.delivery' );
		if ( $elem.length > 0 ) {
			$delivery_elem.html( $elem.html() );
			$delivery_container.show( 800 )
		} else {
			$delivery_container.hide( 800 )
		}
	}
	update_delivery_price();

	$( 'ul#shipping_method input' ).on( 'click', function( e ){
		update_delivery_price();
	});
	$( document ).ajaxComplete(function( event, xhr, settings ) {
		$( '#checkout-total strong' ).html( $( '#update-totals strong' ).html() );
	});

} );
