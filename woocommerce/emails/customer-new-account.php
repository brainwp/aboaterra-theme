<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.5.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s Customer username */ ?>

<?php /* translators: %1$s: Site title, %2$s: Username, %3$s: My account link */ ?>

<p><?php printf( __( 'Seja bem-vindo ao Sítio A Boa Terra! <br>
Seu nome de usuário é %2$s. <br>
Aqui você alimenta a sua saúde e a saúde do campo!<br>
Além de uma história de 37 anos nos orgânicos. <a href=https://aboaterra.com.br/nossa-historia> Conheça nossa história.</a> <br>
A credibilidade nos alimentos orgânicos que oferecemos é nosso valor número um!<br>
Assim queremos compartilhar com você que além de sermos certificados pelo IBD ( Instituto Biodinâmico)  tanto em nossa produção orgânica, quanto em nossa comercialização de cestas orgânicas, também investimos em análises laboratoriais de resíduos de agrotóxicos em nossas frutas, legumes e verduras comercializadas.<br>
Parabéns por escolher saúde , praticidade e credibilidade! <br>
Você pode acessar sua conta para ver pedidos, alterar sua senha e muito mais em: %3$s <br>
Equipe A Boa Terra', 'woocommerce' ), esc_html( $blogname ), '<strong>' . esc_html( $user_login ) . '</strong>', make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ); ?></p><?php // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>

<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated ) : ?>
	<?php /* translators: %s Auto generated password */ ?>
	<p><?php printf( esc_html__( 'Your password has been automatically generated: %s', 'woocommerce' ), '<strong>' . esc_html( $user_pass ) . '</strong>' ); ?></p>
<?php endif; ?>


<?php
do_action( 'woocommerce_email_footer', $email );
