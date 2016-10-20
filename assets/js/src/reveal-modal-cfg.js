jQuery(document).ready(function($) {
	var reveal_str = $( 'meta[name=reveal-modal-cfg-str]' ).attr('content');
	$( document ).ajaxComplete( function( e ) {
		var $content = $( '#reveal-modal-id' );
		if ( $content.find( '.woocommerce').length > 0 || ! $( 'body' ).hasClass( 'woocommerce-checkout' ) ) {
			$content.addClass( 'modal-bigger' );
			if ( $content.find( '.woocommerce').length > 0 ) {
				$content.find( 'h1').first().remove();
			}
		} else {
			$content.removeClass( 'modal-bigger' );
		}
	});
	$( 'body' ).on( 'click', '#reveal-modal-id a', function( e ){
		var _href = $(this).attr('href');

		if ( _href !== undefined && _href.lastIndexOf(reveal_str) != -1 ) {
			e.preventDefault();
			$( '#reveal-modal-id' ).find( '.close-reveal-modal').trigger( 'click' );
			$.get( _href + '?reveal-modal-ajax=true', {}, function( response ){
				var html = '<a class="close-reveal-modal">&#215;</a>' + response;
				$( '#reveal-modal-id' ).html( html );
				 setTimeout( function(){
				 	$( '#reveal-modal-id' ).foundation('reveal', 'open');
				 }, 500 );
			});
		}
	} );
	$( 'body.unlogged-user .add_to_cart_button, body.unlogged-user .single_add_to_cart_button' ).on( 'click', function( e ){
		$modal_link = $( '.prices-warn .pull-left a' );

		if ( $modal_link.length && $modal_link.attr( 'href' ).lastIndexOf(reveal_str) != -1 ) {
			$modal_link.trigger( 'click' );
			e.preventDefault();
		}
	} );
	$( 'body.unlogged-user' ).on( 'closed.fndtn.reveal', '#reveal-modal-id', function( e ){
		setTimeout( function(){
			location.reload();
		}, 120 );
	} );
});
