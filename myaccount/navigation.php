<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
$user = wp_get_current_user();
?>
<nav class="woocommerce-MyAccount-navigation">
	<ul>
		<?php $current_endpoint = WC()->query->get_current_endpoint();?>
		<?php $items = wc_get_account_menu_items();?>
		<?php unset( $items['downloads'] );?>
		<?php $items[ 'orders' ] = __( 'Meus Pedidos', 'odin' );?>
		<?php $items[ 'dashboard' ] = $user->display_name;?>
		<?php $items[ 'edit-account' ] = __( 'Minha conta', 'odin' );?>
		<?php foreach ( $items as $endpoint => $label ) : ?>
			<?php $classes = wc_get_account_menu_item_classes( $endpoint );?>
			<li class="<?php echo $classes;?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
