<?php
	if ( ! defined( 'ABSPATH' ) )
		exit; // Exit if accessed directly.
	/**
	 * Brasa WooCommerce Extra fields
	 *
	 */
	class Brasa_WC_Extra_Fields {
		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $instance = null;

		/**
		 * Initialize the plugin
		 */
		public function __construct() {
			// add checkout custom fields
			/*add_action( 'woocommerce_after_checkout_billing_form', array( $this, 'add_checkout_billing_fields' ), 9999 );*/
			add_action( 'woocommerce_checkout_before_order_review', array( $this, 'add_checkout_order_fields' ), 9999 );

			// process custom fields
			add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'save_checkout_fields' ) );
			// save user fields
			add_action( 'init', array( $this, 'save_user_fields' ), 9999 );
			// show custom fields on order admin page
			add_action( 'woocommerce_admin_order_data_after_billing_address', array( $this, 'show_order_fields' ), 10, 1 );
			add_action( 'woocommerce_after_checkout_billing_form', array( $this, 'add_checkout_password' ), 10, 1 );
			// save password after first checkout
			add_action( 'woocommerce_checkout_order_processed', array( $this, 'save_checkout_password' ), 1, 2 );
			// validate password
			add_action('woocommerce_checkout_process', array( $this,'validate_pass'));


		}

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
		public function show_order_fields( $order ) {
			if ( $value = get_post_meta( $order->get_id(), 'order_delivery_time', true ) ) {
				echo '<p><strong>'.__( 'Possui portaria 24horas?', 'odin' ).':</strong> ' . $value . '</p>';
			}
		}
		public function save_checkout_password($order_id, $posted_data){
			$meta = get_user_meta( get_current_user_id(), 'generated_pass', true);
			if ($meta[0]) {
				if ( ! isset( $_POST['checkout_pass_nonce'] )
				|| ! wp_verify_nonce( $_POST['checkout_pass_nonce'], 'checkout_pass' )
				) {
				   print 'Sorry, your nonce did not verify.';
				   exit;
				} else {
					$user_id = get_current_user_id();
					$user = get_user_by( 'ID', $user_id );
	    			wp_set_password( $_POST['brasa_checkout_password'], $user_id );
					$creds = array(
				        'user_login'    => $user->user_login,
				        'user_password' => $_POST['brasa_checkout_password'],
				        'remember'      => false
				    );
					update_user_meta( $user_id, 'generated_pass', 0 );
					$logged_user = wp_signon( $creds, false );
	    			// print_r($posted_data);
				}
			}
		}
		public function validate_pass() {
			// wc_add_notice( $_POST['brasa_checkout_password'], 'error' );
			$meta = get_user_meta( get_current_user_id(), 'generated_pass', true);
			if ($meta[0]) {
			    $pass = $_POST['brasa_checkout_password'];
				$pass_confirmation = $_POST['brasa_checkout_password_confirm'];
				if (!$pass || !$pass_confirmation) {
					wc_add_notice( __( 'Preencha corretamente a senha e a confirmação.' ), 'error' );
				}
				if ($pass != $pass_confirmation) {
					wc_add_notice( __( 'A confirmação não é igual a senha.' ), 'error' );
				}
			}
		    // your function's body above, and if error, call this wc_add_notice

		}
		public function add_checkout_password($checkout){
			$meta = get_user_meta( get_current_user_id(), 'generated_pass', true);
			if (isset($meta[0])) {
				?>
				<p class="form-row validate-required" id="brasa_password_field" data-priority="">
					<label for="brasa_checkout_password" class="">
						Criar uma senha para sua conta&nbsp;<abbr class="required" title="obrigatório">*</abbr>
					</label>
					<span class="woocommerce-input-wrapper">
						<input type="password" class="input-text " name="brasa_checkout_password" id="brasa_checkout_password" placeholder="Senha" value="" required>
					</span>
				</p>
				<p class="form-row validate-required" id="brasa_password_confirm_field" data-priority="">
					<label for="brasa_checkout_password_confirm" class="">
						Repita sua senha&nbsp;<abbr class="required" title="obrigatório">*</abbr>
					</label>
					<span class="woocommerce-input-wrapper">
						<input type="password" class="input-text " name="brasa_checkout_password_confirm" id="brasa_checkout_password_confirm" placeholder="Confirmação da Senha" value="" required>
					</span>
					<span id="pass_validation">

					</span>
				</p>
				<?php wp_nonce_field( 'checkout_pass', 'checkout_pass_nonce' ); ?>
				<?php

			}

		}
		public function add_checkout_order_fields( $checkout ) {
			$label = get_theme_mod( 'delivery_time', __( 'Possui entrega 24hrs?', 'odin' ) );
			woocommerce_form_field( 'order_delivery_time', array(
				'type'          => 'checkbox',
				'class'         => array( 'form-row-wide' ),
				'label'         => $label,
				'required'		=> false
			), 'Sim' );
		}
		/**
		 * Add fields to checkout billing section
		 * @param object $checkout
		 * @return null
		 *
		public function add_checkout_billing_fields( $checkout ) {

			$default_value = '';
			if ( $value = get_user_meta( get_current_user_id(), 'cpf', true ) ) {
				$default_value = $value;
			}
			woocommerce_form_field( 'cpf', array(
				'type'          => 'text',
				'class'         => array( 'form-row-wide' ),
				'label'         => __('CPF/CNPJ', 'odin' ),
				'required'		=> true
			), $default_value );

		}
		/**
		 * Save checkout fields
		 * @param int $order_id
		 * @return null
		 */
		public function save_checkout_fields( $order_id ) {
			if ( isset( $_POST[ 'order_delivery_time'] ) && ! empty( $_POST[ 'order_delivery_time' ] ) ) {
				update_post_meta( $order_id, 'order_delivery_time', 'Sim' );
			}
			if ( ! is_user_logged_in() ) {
				return;
			}
			/*if ( isset( $_POST[ 'cpf'] ) && ! empty( $_POST[ 'cpf'] ) ) {
				update_post_meta( get_current_user_id(), 'cpf', $_POST[ 'cpf' ] );
			}*/
		}

		public function get_billing_fields() {
			$fields = array();
			$fields[ 'billing_first_name' ] = __( 'Nome', 'odin' );
			$fields[ 'billing_last_name'] = __( 'Sobrenome', 'odin' );
			$fields[ 'email' ] = __( 'Email', 'odin' );
			$fields[ 'billing_cpf' ] = __( 'CPF', 'odin' );
			/*$fields[ 'billing_cnpj' ] = __( 'CNPJ', 'odin' );*/
			$fields[ 'billing_phone' ] = __( 'Telefone', 'odin' );
			return $fields;
		}
		public function get_billing_only_meta_fields() {
			$fields = array();
			$fields[ 'billing_cpf' ] = __( 'CPF', 'odin' );
			$fields[ 'billing_phone' ] = __( 'Telefone', 'odin' );
			return $fields;
		}
		public function save_user_fields() {
			if ( ! isset( $_REQUEST[ 'wc_edit_my_account_form'] ) ) {
				return;
			}
			if ( ! is_user_logged_in() ) {
				return;
			}
			$user = wp_get_current_user();
			$fields = $this->get_billing_only_meta_fields();
			foreach( $fields as $key => $value ) {
				if ( isset( $_REQUEST[ $key ] ) ) {
					update_user_meta( $user->ID, $key, sanitize_text_field( $_REQUEST[ $key ] ) );
				}
			}
		}
	}
	new Brasa_WC_Extra_Fields();
