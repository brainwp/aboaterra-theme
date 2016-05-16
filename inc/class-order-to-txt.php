<?php
/**
 * Export to TXT class.
 *
 */
class Brasa_Order_To_TXT {
	/**
	 * @var string
	 */
	private $nonce_action = 'download_txt';

	/**
	 * init class
	 * @return boolean
	 */
	public function __construct() {
		// register metabox
		add_action( 'admin_init', array( $this, 'register_metabox' ) );

		add_action( 'wp_ajax_brasa_order_to_txt', array( $this, 'download_txt' ) );
	}
	/**
	 * Register metabox
	 * @return boolean
	 */
	public function register_metabox() {
		if ( ! isset( $_GET[ 'post'] ) ) {
			return;
		}
		add_meta_box( 'order-to-txt', __( 'Exportar ordem para TXT', 'odin' ), array( $this, 'metabox_display' ), 'shop_order', 'side', 'default' );

	}
	/**
	 * Display download button
	 * @return boolean
	 */
	public function metabox_display() {
		if ( ! isset( $_GET[ 'post'] ) ) {
			return;
		}

		$url = admin_url( 'admin-ajax.php' );
		$url .= '?action=brasa_order_to_txt';
		$url .= '&id=' . $_GET[ 'post' ];
		$url = wp_nonce_url( $url, $this->nonce_action, '_wpnonce' );
		printf( '<a class="button button-primary" href="%s">%s</a>', $url, __( 'Fazer download', 'odin' ) );
	}

	/**
	 * create & download TXT file
	 * @return boolean
	 */
	public function download_txt() {
		if ( ! isset ( $_GET[ '_wpnonce' ] ) || ! wp_verify_nonce( $_GET[ '_wpnonce' ], $this->nonce_action ) ) {
			return;
		}
		header( 'Content-Type: text/plain' );
		header( 'Content-Transfer-Encoding: Binary' );
		$file = sprintf( 'Content-disposition: attachment; filename="%s.txt"', $_GET[ 'id' ] );
		header( $file );

		$order = wc_get_order( $_GET[ 'id' ] );
		$items = '';
		foreach( $order->get_items() as $item ) {
			if ( $sku = get_post_meta( $item['item_meta']['_product_id'][0], '_sku', true ) ) {
				$items .= sprintf( '%s,%s;', $sku, $item[ 'item_meta' ][ '_qty'][0] );
			}
		}
		echo $items;
		wp_die();
	}
}
new Brasa_Order_To_TXT();
