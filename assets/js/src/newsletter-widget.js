/* Set email checkbox and hidden it */
jQuery(document).ready(function($) {
	if ( $( 'input[name="mdirector_sh-accept"]' ).length > 0 ) {
		$( 'input[name="mdirector_sh-accept"]').prop( "checked", true );
	}
});
