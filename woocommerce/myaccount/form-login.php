<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="u-columns col2-set" id="customer_login">

	<div class="col-xs-12 col-sm-12 col-md-5 pull-left login-form">

<?php endif; ?>

		<form method="post" class="login">
			<h2><?php _e( 'Já sou cliente do sítio', 'odin' ); ?></h2>

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="col-md-8">
				<label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
			</p><!-- .col-md-6 -->
			<div class="col-md-12"></div><!-- .col-md-12 -->
			<p class="col-md-8">
				<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
			</p><!-- .col-md-6 -->

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="col-md-4">
				<?php wp_nonce_field( 'woocommerce-login' ); ?>
				<input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Ok', 'odin' ); ?>" />
				<label for="rememberme" class="inline">
					<input class="woocommerce-Input woocommerce-Input--checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
				</label>
			</p><!-- .col-md-6 -->
			<p class="col-md-10">
				<a class="btn btn-primary btn-cart-link col-md-2" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
			</p><!-- .col-md-6 -->

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="col-xs-12 col-sm-12 col-md-6 pull-right register-form">

		<form method="post" class="register register-check-delivery">
			<h2><?php _e( 'Quero me cadastrar', 'odin' ); ?></h2>

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
				<p class="col-md-12"></p><!-- .col-md-12 -->
				<p class="col-md-6">
					<label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
					<input required type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</p><!-- .col-md-6 -->

			<?php endif; ?>
			<p class="col-md-12"></p><!-- .col-md-12 -->
			<p class="col-md-6">
				<label for="reg_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input required type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
			</p><!-- .col-md-6 -->

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>
			<?php $label = __( 'CEP*', 'odin' );?>
			<?php $loading_txt = __( 'Carregando..', 'odin' );?>
			<?php $redirect_error = '';?>
			<?php if ( $value = get_theme_mod( 'delivery_error_redirect', false ) ) : ?>
				<?php $redirect_error = $value;?>
			<?php endif;?>
			<?php echo do_shortcode( sprintf( '[brasa_check_delivery label="%s" button_load_text="%s" form_tag="div" redirect_error="%s"]', $label, $loading_txt, $redirect_error ) );?>

			<?php wp_nonce_field( 'woocommerce-register' ); ?>

			<?php do_action( 'woocommerce_register_form_end' ); ?>
		</form>
	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
