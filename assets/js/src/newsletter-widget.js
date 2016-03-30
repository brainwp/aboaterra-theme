/* Set email checkbox and hidden it */
jQuery(document).ready(function($) {
	if ( $( '#mdirector_widget_form' ).length > 0 ) {
		$( '#mdirector_widget_form input[name="mdirector_widget-accept"]').prop( "checked", true );
	}
});
