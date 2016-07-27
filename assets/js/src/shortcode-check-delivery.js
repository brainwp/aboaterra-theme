/* my account login page */
jQuery(document).ready(function($) {
	$( 'body').on( 'submit', 'form.brasa-check-delivery-container', function( e ) {
		e.preventDefault();
		var $form = $( this );
		var $elements_div = $( this ).children( '.elements' );
		var $submit_btn = $elements_div.children( 'button' );
		var default_text = $submit_btn.html();
		$submit_btn.html( $submit_btn.attr( 'data-load' ) );
		var data = {
			'action': 'brasa_check_delivery',
			'postcode': $elements_div.children( '[name="check-delivery"]' ).val()
		};

		$.post( odin.ajax_url, data, function(response) {
			$elements_div.children( '.response' ).html( response );
			$submit_btn.html( default_text );
		});
	});
	$( 'body').on( 'submit', '.register-check-delivery', function( e ) {
		e.preventDefault();
		var $form = $( this ).children( '.brasa-check-delivery-container' );
		var $elements_div = $form.children( '.elements' );
		var $submit_btn = $elements_div.children( 'button' );
		var default_text = $submit_btn.html();
		$submit_btn.html( $submit_btn.attr( 'data-load' ) );
		var data = {
			'action': 'brasa_check_delivery',
			'show_accept_message': 'true',
			'close_modal': 'true',
			'postcode': $elements_div.children( '[name="check-delivery"]' ).val()
		};
		$.ajax({
			type: 'POST',
			url: odin.ajax_url,
			data: data,
			complete: function( response ){
				if ( response.getResponseHeader( 'delivery-status' ) == 'false' ) {
					window.location = $form.attr( 'data-redirect-error' );
				}
				else {
					$elements_div.children( '.response' ).html( response.responseText );
				}
				$submit_btn.html( default_text );
			}
		});
	});
	$( 'body' ).on( 'click', '.close-modal', function( e ){
		e.preventDefault();
		$( '#reveal-modal-id .close-reveal-modal' ).trigger( 'click' );
	});
} );
