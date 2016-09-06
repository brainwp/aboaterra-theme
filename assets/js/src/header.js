jQuery(document).ready(function($) {
	$('.menu-item-has-children').hover(function() {
		$('.menu-item-has-children ul').css({
			display: 'block',
		});
	}, function() {
		$('.menu-item-has-children ul').css({
			display: 'none',
		});
	});
});
