/* slider links home */
jQuery(document).ready(function($) {
	if ( $( '#slider-destaques-row' ).length == 0 ) {
		console.log( 'are you go now?' );
		return;
	}
	$element = $( '#slider-destaques-row' );
	var slider_desktop = function( response ) {
		$element.html( response.template );
		var $slider = $element.find( '.is_slider' );
		$slider.slick( $slider.data( 'json' ) );
	}
	var slider_mobile = function( response ) {
		var html = '';
		for( var i = 0; i < response.items.length; i++ ) {
			var item = '<a href="{{link}}" class="col-md-12 slider-link"><img src="{{src}}"/></a>';
			var item = item.replace( '{{link}}', response.items[i][ 'url' ] );
			var item = item.replace( '{{src}}', response.items[i][ 'image'][0] );
			var html = html + item;
		}
		console.log( html );
		$element.html( html );
	}
	var slider_by_size = function() {
		// get rest api URL
		var url = $( 'link[rel="https://api.w.org/"]' ).attr( 'href' ) + 'brasa-slider/name/';
		// make rest api request
		var data = {
			'slider': $element.attr( 'data-slider' ),
			'print_template': 'true',
			'image_size': 'medium'
		};
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.get(url, data).done( function( response ) {
			if ( $( window ).width() < 1024 ) {
				slider_mobile( response );
			} else {
				slider_desktop( response );
			}
		});
	}
	slider_by_size();
	$( window ).resize( slider_by_size );
} );
