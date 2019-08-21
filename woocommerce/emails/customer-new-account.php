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

<p style="text-align: justify;"><?php printf( __( '
Olá! <br>
Seu nome de usuário é %2$s. <br>
<br>
Aqui você alimenta a sua saúde e a saúde do campo!<br><br>
O Sítio A Boa Terra é um dos primeiros a acreditar e cultivar alimentos orgânicos no Brasil e a entregar cestas orgânicas na porta de casa. Tudo começou lá em 1981, com 3 casais, quando “falar sobre orgânicos e esse tal estilo de vida mais justo” ainda era pouco comum e desacreditado. Convidamos você a saber mais detalhes sobre essa <a href=https://aboaterra.com.br/nossa-historia> NOSSA HISTORIA.</a> <br>
<br>
A <strong>credibilidade</strong> nos alimentos orgânicos que oferecemos é nosso valor número um! Assim queremos compartilhar com você que além de sermos certificados pelo IBD (Instituto Biodinâmico), desde 1994, tanto em nossa produção orgânica quanto em nossa comercialização de cestas orgânicas, também investimos em uma rotina de análises laboratoriais de resíduos de agrotóxicos em nossas frutas, legumes e verduras comercializadas.
<br><br>
Para que sua cesta orgânica fique ainda mais completa, ela é composta por orgânicos do Sítio e também de outros produtores orgânicos certificados.
Nosso <strong>certificado orgânico</strong> de produtor e comercializador está disponível pra você em <a href=https://www.aboaterra.com.br/faq-2/> FAQ</a>, e claro você também pode solicitar por whatsapp ou email. <br><br>
Além de nossa produção orgânica e entrega de cestas em casa, para nós fica cada vez mais claro o quanto estar em meio à natureza viva nos faz bem e o quanto ela é parte de nós e nós somos parte dela.
Assim, em 2003, surge no Sítio A Boa Terra o nosso <strong>Centro de Ecologia</strong> - educação ambiental. Diversas escolas públicas e particulares, além de universidades, já vivenciaram aqui inúmeras atividades na natureza e em nossas hortas orgânicas.
Acreditamos que essa reconexão com a natureza e com a origem dos alimentos, é “o primeiro passo” para uma cultura de cuidado, cuidado com nossa saúde e a saúde do planeta. Saiba mais sobre nosso <a href=https://www.aboaterra.com.br/quer-nos-visitar/> CENTRO DE ECOLOGIA.</a> <br>
<br>
Parabéns por escolher saúde, praticidade e credibilidade! <br><br>
<strong>Garanta agora mesmo seus orgânicos! https://www.aboaterra.com.br/  <br><br></strong>

<strong>Você pode acessar sua conta para ver pedidos, alterar sua senha e muito mais em: %3$s <br></strong>
<br>
Grande Abraço de nossa Equipe A Boa Terra

', 'woocommerce' ), esc_html( $blogname ), '<strong>' . esc_html( $user_login ) . '</strong>', make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ); ?></p><?php // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>

<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated ) : ?>
	<?php /* translators: %s Auto generated password */ ?>
	<p><?php printf( esc_html__( 'Your password has been automatically generated: %s', 'woocommerce' ), '<strong>' . esc_html( $user_pass ) . '</strong>' ); ?></p>
<?php endif; ?>


<?php
do_action( 'woocommerce_email_footer', $email );
