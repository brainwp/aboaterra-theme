/* checkout coupon */
jQuery(document).ready(function($) {
	if ( ! $( 'body' ).hasClass( 'woocommerce-checkout' ) ) {
		return;
	}
	$( 'form.checkout #apply-coupon').on( 'click', function( e ){
		e.preventDefault();
		$elem = $(this);
		$( 'form.checkout_coupon [name="coupon_code"]').val( $( 'form.checkout [name="coupon_code"]' ).val() );
		$( 'html, body' ).animate({ scrollTop: $( '.woocommerce-info' ).top - 40 }, 300);
		$( 'form.checkout_coupon' ).trigger( 'submit' );
	});
} );
