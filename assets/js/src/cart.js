/**
 Cart scripts
*/
jQuery(document).ready(function($) {
	/**
	 * Box de confirmação antes de deletar todo o cart
	*/
	$( document ).on( 'click', '#cart-empty-link', function( e ) {
		if ( ! confirm( $( this ).attr( 'data-confirm' ) ) ) {
			e.preventDefault();
		}
	});
	/**
	 * Atualiza o cart (Pagina cart) automaticamente no desktop
	*/
	$( document ).on( 'change', 'body.woocommerce-cart .buttons-qty input', function( e ) {
		$( this ).parent( '.buttons-qty' ).on( 'mouseout', function(){
			$( 'button[name="update_cart"]' ).trigger( 'click' );
		});
	});
	/**
	 * Atualiza o cart (Pagina cart) automaticamente no mobile
	*/
	$( document ).on( 'change', 'body.woocommerce-cart .product-quantity select', function( e ) {
		if ( $( window ).width() <= 728 ) {
			$( 'button[name="update_cart"]' ).trigger( 'click' );
		}
	});

} );
