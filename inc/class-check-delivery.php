
<?php
/**
 * Check delivery
 *
 */
class Brasa_Check_Delivery {
	/**
	 * Error html
	 */
	private $error = '<span class="error animated bounceInUp">%s</span>';

	/**
	 * success html
	 */
	private $success = '<span class="success animated bounceInUp">%s</span>';

	/**
	 * init class
	 * @return boolean
	 */
	public function __construct( $success = '', $error = '' ) {
		// init vars
		if ( ! empty( $success ) ) {
			$this->success = $success;
		}
		if ( ! empty( $error ) ) {
			$this->error = $error;
		}
		// add fields to product price based on zipcode plugin
		add_action( 'wc_price_based_zipcode_admin_region_fields', array( &$this, 'add_fields' ) );
		add_filter( 'wc_price_based_zipcode_save_region_data', array( &$this, 'save_region_message' ) );

		// check delivery ajax
		add_action( 'wp_ajax_brasa_check_delivery', array( $this, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_brasa_check_delivery', array( $this, 'ajax' ) );

		// change zipcode
		add_filter( 'wcpbc_get_woocommerce_zipcode', array( &$this, 'get_woocommerce_zipcode' ) );

		// shortcode form
		add_shortcode( 'brasa_check_delivery', array( &$this, 'shortcode' ) );
	}
	public function shortcode( $atts, $content = '' ) {
		$atts = shortcode_atts( array(
			'label' => '',
			'button_text' => 'Ok',
			'button_load_text' => __( 'Loading..'),
			'placeholder' => ''
		), $atts, 'brasa_check_delivery' );
		$html = '<form class="brasa-check-delivery-container">';
		$html .= sprintf( '<label>%s</label>', $atts[ 'label'] );
		$html .= sprintf( '<input class="input-text" type="text" name="check-delivery" placeholder="%s">', $atts[ 'placeholder' ] );
		$html .= sprintf( '<button class="woocommerce-Button button" data-load="%s">%s</button>', $atts[ 'button_load_text'], $atts[ 'button_text' ] );
		$html .= '<div class="response"></div>';
		$html .= '</form>';
		return $html;
	}
	public function is_ajax() {
		if ( defined('DOING_AJAX') && DOING_AJAX && isset( $_REQUEST[ 'action'] ) && $_REQUEST[ 'action'] == 'brasa_check_delivery' ) {
			return true;
		}
		return false;
	}
	/**
	 * Add fields to region section
	 * @param array $region
	 * @return write
	 */
	public function add_fields( $region ) {
		echo '<table class="form-table">';
		echo '<tr valign="top">';
		echo '<th scope="row" class="titledesc">';
		printf( '<label for="message">%s</label>', __( 'Mensagem', 'odin' ) );
		echo '</th>';
		echo '<td class="forminp">';
		printf( '<textarea name="message">%s</textarea>', esc_textarea( $region['message'] ) );
		echo '</td>';
		echo '</tr>';
		echo '</table>';
	}
	/**
	 * Save field message
	 * @param array $region
	 * @return array
	 */
	public function save_region_message( $region ) {
		if ( isset( $_POST[ 'message' ] ) ) {
			$region[ 'message' ] = esc_textarea( $_POST[ 'message' ] );
		}
		return $region;
	}
	/**
	 * Execute ajax & check delivery area
	 * @return null
	 */
	public function ajax() {
		WC()->session->set( 'wcpbc_customer', array() );
		if ( ! class_exists( 'WCPBC_Customer' ) ) {
			header( sprintf( 'delivery-status: %s', 'false' ) );
			wp_die( sprintf( $this->error, __( 'Lamento, nós não entregamos nesse CEP.', 'odin' ) ) );
		}
		$customer = new WCPBC_Customer();
		$customer->save_data();
		$customer_data = WC()->session->get( 'wcpbc_customer' );
		if ( is_array( $customer_data ) && ! empty( $customer_data ) && isset( $customer_data[ 'message'] ) ) {
			header( sprintf( 'delivery-status: %s', 'true' ) );
			printf( $this->success, apply_filters( 'the_title', $customer_data[ 'message'] ) );
			wp_die();
		}
		header( sprintf( 'delivery-status: %s', 'false' ) );
		WC()->session->set( 'wcpbc_customer', array() );
		wp_die( sprintf( $this->error, __( 'Lamento, nós não entregamos nesse CEP.', 'odin' ) ) );
	}
	public function get_woocommerce_zipcode( $code ) {
		if ( ! $this->is_ajax() ) {
			return $code;
		}
		$code = wc_format_postcode( $_REQUEST[ 'postcode'], WC()->customer->get_shipping_country() );
		return $code;
	}
}
