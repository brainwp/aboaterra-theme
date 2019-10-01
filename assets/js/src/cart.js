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
	// if ($('body').hasClass('admin-bar') ) {
	// 	alert('js novo')
	//
	// }
	// mascara do telefone
	if ($('body').hasClass('unlogged-user')) {
		$(document).on( 'blur',"#billing_phone", function(event) {
			if($(this).val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
			  $('body #billing_phone').mask('(00) 00000-0009');
			} else {
			  $('body #billing_phone').mask('(00) 0000-00009');
			}
		});
	};
	if ($('body').hasClass('woocommerce-checkout') || $('body').hasClass('woocommerce-account') || $('body').hasClass('unlogged-user')) {
		if (typeof $('#billing_phone').val() !== 'undefined') {
			if($('#billing_phone').val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
			  $('#billing_phone').mask('(00) 00000-0009');
			} else {
			  $('#billing_phone').mask('(00) 0000-00009');
			}
			$(document).on( 'blur',"#billing_phone", function(event) {
				if($(this).val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
				  $('#billing_phone').mask('(00) 00000-0009');
				} else {
				  $('#billing_phone').mask('(00) 0000-00009');
				}
			});
		}
		if (typeof $('#billing_cellphone').val() !== 'undefined') {
			if($('#billing_cellphone').val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
			  $('#billing_cellphone').mask('(00) 00000-0009');
			} else {
			  $('#billing_cellphone').mask('(00) 0000-00009');
			}
			$('#billing_cellphone').blur(function(event) {
				if($(this).val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
				  $('#billing_cellphone').mask('(00) 00000-0009');
				} else {
				  $('#billing_cellphone').mask('(00) 0000-00009');
				}
			});
		}
	}
	$( ".open-bundle-links" ).click(function(e) {
		e.preventDefault();
		var product_key = $(this).attr('data-key');
		$(this).closest('.cart_item').siblings("tr.yith-wcpb-child-of-bundle-table-item."+product_key).slideToggle();

	});
	/**
	 * Atualiza o cart (Pagina cart) automaticamente no mobile
	*/
	$( document ).on( 'change', 'body.woocommerce-cart .product-quantity select', function( e ) {
		if ( $( window ).width() <= 768 ) {
			$('input[name="'+ $(this).attr('name') +'"]').val($(this).val());
			$( 'button[name="update_cart"]' ).trigger( 'click' );
		}
	});

} );
