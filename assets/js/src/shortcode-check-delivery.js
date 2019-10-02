/* my account login page */
jQuery(document).ready(function($) {
	$('.donate_button_div input[type=radio]').change(function(e) {
		console.log('mudou');
		escolha = $( this ).attr('id');
		console.log(escolha);
		var data = {
			'action': 'donation_checkout_field_ajax',
			'instituicao': escolha
		};
		$.ajax({
			type: 'POST',
			url: odin.ajax_url,
			data: data,
			complete: function( response ){
				console.log(response.responseText)
			}
		});
	});
	$( 'body').on( 'submit', 'form.brasa-check-delivery-container', function( e ) {
		e.preventDefault();
		var $form = $( this );
		var $elements_div = $( this ).children( '.elements' );
		var $submit_btn = $elements_div.children( 'button' );
		if ( $elements_div.children( '[name="check-delivery"]' ).val().replace(/\s+/g, '' ) == '' ) {
			return;
		}
		var default_text = $submit_btn.html();
		$submit_btn.html( $submit_btn.attr( 'data-load' ) );

		var data = {
			'action': 'brasa_check_delivery',
			'postcode': $elements_div.children( '[name="check-delivery"]' ).val()
		};
		$.ajax({
			type: 'POST',
			url: odin.ajax_url,
			data: data,
			complete: function( response ){
				if ( response.getResponseHeader( 'delivery-status' ) == 'false' ) {
					window.location = $form.attr( 'data-redirect-error' );
				} else {
					$elements_div.children( '.response' ).html( response.responseText );
					if( $form.attr( 'data-redirect-success' ) && $form.attr( 'data-redirect-success' ) != '' ) {
						 setTimeout( function(){
						 	window.location = $form.attr( 'data-redirect-success' );
						 }, 4000);
					}
				}
				$submit_btn.html( default_text );
			}
		});
	});
	$( 'body').on( 'submit', '.register-check-delivery', function( e ) {
		e.preventDefault();
		var $form = $( this ).children( '.brasa-check-delivery-container' );
		var $elements_div = $form.children( '.elements' );
		var $submit_btn = $elements_div.children( 'button' );
		if ( $elements_div.children( '[name="check-delivery"]' ).val() == '' ) {
			return;
		}

		var data = {
			'action': 'brasa_check_delivery',
			'show_accept_message': 'true',
			'close_modal': 'true',
			'postcode': $elements_div.children( '[name="check-delivery"]' ).val(),
			'email': $( 'input[name="email"]' ).val(),
			'phone': $( 'input[name="phone"]' ).val()

		};
		if ( $elements_div.children( '[name="check-delivery"]' ).val().replace(/\s+/g, '') == '' ) {
			return;
		}
		var default_text = $submit_btn.html();
		$submit_btn.html( $submit_btn.attr( 'data-load' ) );

		$.ajax({
			type: 'POST',
			url: odin.ajax_url,
			data: data,
			complete: function( response ){
				if ( response.getResponseHeader( 'delivery-status' ) == 'false' ) {
					window.location = $form.attr( 'data-redirect-error' );
				} else {
					$elements_div.children( '.response' ).html( response.responseText );
					if( $form.attr( 'data-redirect-success' ) && $form.attr( 'data-redirect-success' ) != '' ) {
						 setTimeout( function(){
						 	window.location = $form.attr( 'data-redirect-success' );
						 }, 4000);
					}
				}
				$submit_btn.html( default_text );
			}
		});
	});
	$( 'body' ).on( 'click', '.close-modal', function( e ){
		e.preventDefault();
		$( '#reveal-modal-id .close-reveal-modal' ).trigger( 'click' );
	});
	$( 'body' ).on( 'click', '.btn-show-element', function( e ){
		e.preventDefault();
		var $elem = $( $( this ).attr( 'data-element' ) );
		$elem.show( 1000 );
	});

// mudar mensagem do frete quando atualiza o checkout
	jQuery( document.body ).on( 'update_checkout', function() {
		if ( $('#ship-to-different-address-checkbox').is(':checked') ){
			$cep = $('#shipping_postcode').val()
		}
		else{
			$cep = $('#billing_postcode').val();
		}
		var data = {
			'action': 'brasa_checkout_check_delivery',
			'postcode': $cep,
		};
		$.ajax({
			type: 'POST',
			url: odin.ajax_url,
			data: data,
			complete: function( response ){
				$( "#shipping-status-container" ).empty();
				$( "#shipping-status-container" ).append(response.responseText);
				// if ( response.getResponseHeader( 'delivery-status' ) == 'false' ) {
				// 	window.location = $form.attr( 'data-redirect-error' );
				// } else {
				// 	$elements_div.children( '.response' ).html( response.responseText );
				// 	if( $form.attr( 'data-redirect-success' ) && $form.attr( 'data-redirect-success' ) != '' ) {
				// 		 setTimeout( function(){
				// 		 	window.location = $form.attr( 'data-redirect-success' );
				// 		 }, 4000);
				// 	}
				// }
				// $submit_btn.html( default_text );
			}
		});
	} );

	if ( $( 'body').hasClass( 'woocommerce-checkout' ) ) {
		$( document ).ajaxComplete( function() {
			if ( $( '#shipping-status' ).attr( 'data-value' ) == 'true' ) {
				$( '#place_order' ).show();
				$( 'form.woocommerce-checkout' ).removeAttr( 'onsubmit' );
			} else {
				$( '#place_order' ).hide();
				$( 'form.woocommerce-checkout' ).attr('onsubmit', 'return false');
			}
		});
		$( 'form.woocommerce-checkout' ).on( 'submit', function( e ) {
			if ( $( '#shipping-status' ).attr( 'data-value' ) == 'false' ) {
				e.preventDefault();
			}
		});
	}
} );
