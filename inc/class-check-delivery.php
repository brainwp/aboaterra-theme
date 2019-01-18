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
 	 * Instance of this class.
 	 *
	 * @var object
	*/
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	*/
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

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

		// prevent send checkout form with invalid postcode.
		add_action( 'woocommerce_checkout_process', array( &$this, 'validate_checkout_postcode' ) );
	}
	public function shortcode( $atts, $content = '' ) {
		$atts = shortcode_atts( array(
			'label'				=> '',
			'button_text'		=> 'Ok',
			'button_load_text'	=> __( 'Loading..'),
			'placeholder' 		=> '',
			'container_width' 	=> '',
			'form_tag' 			=> 'form',
			'redirect_error'	=> '',
			'redirect_success'	=> '',
			'show_btn' => true
		), $atts, 'brasa_check_delivery' );
		$container_style = '';
		if ( ! empty( $atts[ 'container_width' ] ) ) {
			$container_style = sprintf( 'style="width:%s;"', $atts[ 'container_width' ] );
		}
		$html = sprintf( '<%s class="brasa-check-delivery-container" data-redirect-error="%s" data-redirect-success="%s">', $atts[ 'form_tag' ], $atts[ 'redirect_error' ], $atts[ 'redirect_success' ] );
		$html .= sprintf( '<div class="elements" %s>', $container_style );
		$html .= sprintf( '<label>%s</label>', $atts[ 'label'] );
		$html .= sprintf( '<input class="input-text" type="text" name="check-delivery" placeholder="%s">', $atts[ 'placeholder' ] );
		if ( $atts[ 'show_btn' ] === true ) {
			$html .= sprintf( '<button class="woocommerce-Button button" data-load="%s">%s</button>', $atts[ 'button_load_text'], $atts[ 'button_text' ] );
		}
		$html .= '<div class="response"></div>';
		$html .= '</div>';
		$html .= sprintf( '</%s>', $atts[ 'form_tag'] );
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
		$email = $_REQUEST['email'];
		if (email_exists($email)) {
			header( sprintf( 'delivery-status: %s', '' ) );
			WC()->session->set( 'wcpbc_customer', array() );
			WC()->cart->empty_cart();
			printf( $this->success, apply_filters( 'the_title', 'Este e-mail já esta cadastrado. Por favor faça login ao lado.' ) );
			wp_die();

		}
		WC()->session->set( 'wcpbc_customer', array() );
		if ( ! class_exists( 'WCPBC_Customer' ) ) {
			header( sprintf( 'delivery-status: %s', 'false' ) );
			wp_die( sprintf( $this->error, __( 'Lamento, nós não entregamos nesse CEP.', 'odin' ) ) );
		}
		print_r($_REQUEST);
		die;
		$customer = new WCPBC_Customer();
		$customer->save_data();
		$customer_data = WC()->session->get( 'wcpbc_customer' );
		if ( is_array( $customer_data ) && ! empty( $customer_data ) && isset( $customer_data[ 'message'] ) ) {
			header( sprintf( 'delivery-status: %s', 'true' ) );
			if ( ! is_user_logged_in() ) {
				$code = wc_format_postcode( $_REQUEST[ 'postcode'], WC()->customer->get_shipping_country() );
				WC()->customer->set_postcode( $code );
				WC()->customer->set_shipping_postcode( $code );
			}
			// $email = $_REQUEST['email'];
			// $password = wp_generate_password();
			// $user = wc_create_new_customer( $email, $email, $password );
			// // Caso de erro criando o usuário
			// if ( is_wp_error( $user )) {
			// 	header( sprintf( 'delivery-status: %s', 'false' ) );
			// 	WC()->session->set( 'wcpbc_customer', array() );
			// 	WC()->cart->empty_cart();
			// 	wp_die( sprintf( $this->error, __( $user->get_error_message(), 'odin' ) ) );
			// }
			if ( isset( $_REQUEST[ 'show_accept_message'] ) && $_REQUEST[ 'show_accept_message'] == 'true' ) {
				if ( $value = get_theme_mod( 'delivery_success', false ) ) {
					printf( $this->success, apply_filters( 'the_title', $value ) );
					_e( '<a href="#" class="close-modal woocommerce-Button button">Ok</a>', 'odin' );
					printf( __( '<a href="%s" class="back-home woocommerce-Button button">Ok</a>', 'odin' ), get_home_url() );
				} else {
					printf( $this->success, apply_filters( 'the_title', $customer_data[ 'message'] ) );
				}
			} else {
				printf( $this->success, apply_filters( 'the_title', $customer_data[ 'message'] ) );
			}
			wp_die();
		}
		header( sprintf( 'delivery-status: %s', 'false' ) );
		WC()->session->set( 'wcpbc_customer', array() );
		WC()->cart->empty_cart();
		wp_die( sprintf( $this->error, __( 'Lamento, nós não entregamos nesse CEP.', 'odin' ) ) );
	}
	public function get_woocommerce_zipcode( $code ) {
		if ( ! $this->is_ajax() ) {
			return $code;
		}
		$code = wc_format_postcode( $_REQUEST[ 'postcode'], WC()->customer->get_shipping_country() );
		return $code;
	}
	public function check_postcode() {
		$customer = new WCPBC_Customer();
		$customer->save_data();
		$customer_data = WC()->session->get( 'wcpbc_customer' );
		if ( is_array( $customer_data ) && ! empty( $customer_data ) && isset( $customer_data[ 'message'] ) ) {
			return $customer_data[ 'message'];
		} else {
			return false;
		}
	}
	public function validate_checkout_postcode() {
		if ( ! $this->check_postcode() ) {
			$message = get_theme_mod( 'delivery_error', __( 'CEP não atendido', 'odin' ) );
			wc_add_notice( $message, 'error' );
		}
	}

}
