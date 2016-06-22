jQuery(document).ready(function($) {
	$( document ).ajaxComplete( function( e ) {
		var $content = $( '#reveal-modal-id' );
		if ( $content.find( '.woocommerce').length > 0 ) {
			$content.addClass( 'modal-bigger' );
		} else {
			$content.removeClass( 'modal-bigger' );
		}
	});
	$( 'body' ).on( 'click', '#reveal-modal-id a', function( e ){
		var _href = $(this).attr('href');
		var reveal_str = $( 'meta[name=reveal-modal-cfg-str]' ).attr('content');

		if ( _href !== undefined && _href.lastIndexOf(reveal_str) != -1 ) {
			e.preventDefault();
			console.log( 'ahhhhhhuu' );
			$( '#reveal-modal-id' ).find( '.close-reveal-modal').trigger( 'click' );
			$.get( _href + '?reveal-modal-ajax=true', {}, function( response ){
				var html = '<a class="close-reveal-modal">&#215;</a>' + response;
				$( '#reveal-modal-id' ).html( html );
				 setTimeout( function(){
				 	$( '#reveal-modal-id' ).foundation('reveal', 'open');
				 }, 500 );
			});
		} else {
			e.preventDefault();
			console.log( 'ooooooooooooooH NAO!');
		}
	} );
});
