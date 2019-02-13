<?php
	if ( ! defined( 'ABSPATH' ) )
		exit; // Exit if accessed directly.
	/**
	 * Brasa WooCommerce Extra fields
	 *
	 */
	class Brasa_Donate_Plugin {
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
			// Register Custom Post Type instituições
			add_action( 'init', array( $this,'cpt_instituicoes'), 0 );
			// Register Custom Post Type doações
			add_action( 'init', array( $this,'cpt_doacoes'), 0 );

			// add donation field to cart
			add_action( 'woocommerce_after_cart_table', array( $this,'donation_checkout_field_cart' ));

			// add donation field to checkout
			add_action( 'brasa_donate', array( $this, 'donation_checkout_field_checkout' ), 10, 1 );

			// save data to wc->session
			add_action( 'wp_ajax_donation_checkout_field_ajax', array( $this, 'donation_checkout_field_ajax' ) );
			add_action( 'wp_ajax_nopriv_donation_checkout_field_ajax', array( $this, 'donation_checkout_field_ajax' ) );
			/**
			 * Update the order meta with donation
			 */
			add_action( 'woocommerce_checkout_update_order_meta', array( $this,'donation_checkout_field_save' ) );
			/**
			 * Display donation on the order edit page
			 */
			add_action( 'woocommerce_admin_order_data_after_billing_address', array( $this,'donation_checkout_field_order_show') , 10, 1 );

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
		function donation_checkout_field_order_show($order){
			if (get_post_meta( $order->id, 'instituicao', true ) ) {
				$titulo = get_the_title(get_post_meta( $order->id, 'instituicao', true ));
				echo '<p><strong>'.__('Instituição').':</strong> ' . $titulo . '</p>';
			}
		}
		public function donation_checkout_field_save( $order_id ) {
			if ( ! empty( $_POST['instituicao'] ) ) {
				update_post_meta( $order_id, 'instituicao', sanitize_text_field( $_POST['instituicao'] ) );
				WC()->session->set( 'doacao', '' );
				$order = wc_get_order($order_id);
				$number = $order->get_order_number();
				// Create post object
				$nome_instituicao = get_the_title( $_POST['instituicao'] );

				$my_post = array(
				  'post_title'    => $number.'-doacao-'.$nome_instituicao,
				  'post_type'     => 'doacoes',
				  'post_status'   => 'publish',
				  'post_author'   => 1,
				);
				$nome_instituicao = get_the_title( $_POST['instituicao'] );
				update_post_meta( $order_id, 'instituicao_id', sanitize_text_field( $_POST['instituicao'] ) );
				$doacao = wp_insert_post( $my_post );

				update_post_meta( $doacao, 'instituicao', sanitize_text_field( $nome_instituicao ) );

				// Insert the post into the database

			}
		}
		public function donation_checkout_field_checkout(){
			// WC()->session->set( 'doacao', 'instituicao' );
			$instituicao = WC()->session->get( 'doacao' );
			?>
			<div class="donate_button_div col-sm-12">
				<p>A cada compra, escolha uma causa para receber uma doação de R$1,00, e você não paga nada a mais por isso.</p>
				<?php
				$loop = new WP_Query( array(
					'post_type' => 'instituicoes',
					'posts_per_page' => -1
				  )
				);
				?>
				<div class="instituicoes">
					<?php while ( $loop->have_posts() ) : $loop->the_post();
					$id = get_the_id();
						?>
						<div class="instituicao">
							<input type="radio" name="instituicao" id="<?php echo $id ?>" value="<?php echo $id ?>" <?php echo ( $id == $instituicao ?  'checked="checked"' : ''); ?>/>
							<label for="<?php echo $id; ?>"><img src="<?php echo get_the_post_thumbnail_url( )  ;?>" alt=""></label>
							<h4><?php echo get_the_title( ); ?></h4>
						</div>
					<?php endwhile; wp_reset_query(); ?>
				</div>

			</div>
			<?php
		}
		// Add data to session via ajax
		public function donation_checkout_field_ajax(){
			$instituicao = $_REQUEST['instituicao'];
			global $woocommerce;
    		WC()->session->set( 'doacao', $instituicao );
			wp_die();
		}
		// Add donation field to checkout
		public function donation_checkout_field_cart( $checkout ) {
			?>
			<div class="donate_button_div col-sm-6">
				<h2>Faça uma doação</h2>
				<p>A cada compra, escolha uma causa para receber uma doação de R$1,00, e você não paga nada a mais por isso.</p>
				<?php
				$loop = new WP_Query( array(
				    'post_type' => 'instituicoes',
				    'posts_per_page' => -1
				  )
				);
				?>
				<div class="instituicoes">

				<?php while ( $loop->have_posts() ) : $loop->the_post();
					?>
					<div class="instituicao">

						<input type="radio" name="instituicao" id="<?php echo get_the_id() ?>" />
						<label for="<?php echo get_the_id(); ?>"><img src="<?php echo get_the_post_thumbnail_url( )  ;?>" alt=""></label>
						<h4><?php echo get_the_title( ); ?></h4>
					</div>
				<?php endwhile; wp_reset_query(); ?>
				</div>
			</div>
			<?php
		}
		// Register Custom Post Type instituições
		public function cpt_doacoes() {
			$labels = array(
				'name'                  => _x( 'Doações', 'Post Type General Name', 'odin' ),
				'singular_name'         => _x( 'Doação', 'Post Type Singular Name', 'odin' ),
				'menu_name'             => __( 'Doações', 'odin' ),
				'name_admin_bar'        => __( 'Doações', 'odin' ),
				'archives'              => __( 'Doações', 'odin' ),
				'attributes'            => __( 'Item Attributes', 'odin' ),
				'parent_item_colon'     => __( 'Parent Item:', 'odin' ),
				'all_items'             => __( 'Todas Doações', 'odin' ),
				'add_new_item'          => __( 'Adicionar', 'odin' ),
				'add_new'               => __( 'Adicionar', 'odin' ),
				'new_item'              => __( 'Nova', 'odin' ),
				'edit_item'             => __( 'Editar', 'odin' ),
				'update_item'           => __( 'Atualizar', 'odin' ),
				'view_item'             => __( 'Ver item', 'odin' ),
				'view_items'            => __( 'Ver itens', 'odin' ),
				'search_items'          => __( 'Search Item', 'odin' ),
				'not_found'             => __( 'Not found', 'odin' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'odin' ),
				'featured_image'        => __( 'Imagem destacada', 'odin' ),
				'set_featured_image'    => __( 'Definir imagem', 'odin' ),
				'remove_featured_image' => __( 'Remover imagem', 'odin' ),
				'use_featured_image'    => __( 'Usar como imagem', 'odin' ),
				'insert_into_item'      => __( 'Inserir no item', 'odin' ),
				'uploaded_to_this_item' => __( 'Upload', 'odin' ),
				'items_list'            => __( 'Items list', 'odin' ),
				'items_list_navigation' => __( 'Items list navigation', 'odin' ),
				'filter_items_list'     => __( 'Filter items list', 'odin' ),
			);
			$args = array(
				'label'                 => __( 'Doação', 'odin' ),
				'description'           => __( 'Doações', 'odin' ),
				'labels'                => $labels,
				'public'              => false,
				'show_ui'             => true,
				'capability_type'     => 'shop_order',
				'map_meta_cap'        => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_in_menu'        => current_user_can( 'manage_woocommerce' ) ? 'woocommerce' : true,
				'hierarchical'        => false,
				'show_in_nav_menus'   => false,
				'rewrite'             => false,
				'query_var'           => false,
				'supports'            => array( 'title' ),
				'has_archive'         => false,
			);
			register_post_type( 'doacoes', $args );
		}
		// Register Custom Post Type instituições
		public function cpt_instituicoes() {
			$labels = array(
				'name'                  => _x( 'Instituições', 'Post Type General Name', 'odin' ),
				'singular_name'         => _x( 'Instituição', 'Post Type Singular Name', 'odin' ),
				'menu_name'             => __( 'Instituições', 'odin' ),
				'name_admin_bar'        => __( 'Instituições', 'odin' ),
				'archives'              => __( 'Instituições', 'odin' ),
				'attributes'            => __( 'Item Attributes', 'odin' ),
				'parent_item_colon'     => __( 'Parent Item:', 'odin' ),
				'all_items'             => __( 'Todas instituições', 'odin' ),
				'add_new_item'          => __( 'Adicionar', 'odin' ),
				'add_new'               => __( 'Adicionar', 'odin' ),
				'new_item'              => __( 'Nova', 'odin' ),
				'edit_item'             => __( 'Editar', 'odin' ),
				'update_item'           => __( 'Atualizar', 'odin' ),
				'view_item'             => __( 'Ver item', 'odin' ),
				'view_items'            => __( 'Ver itens', 'odin' ),
				'search_items'          => __( 'Search Item', 'odin' ),
				'not_found'             => __( 'Not found', 'odin' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'odin' ),
				'featured_image'        => __( 'Imagem destacada', 'odin' ),
				'set_featured_image'    => __( 'Definir imagem', 'odin' ),
				'remove_featured_image' => __( 'Remover imagem', 'odin' ),
				'use_featured_image'    => __( 'Usar como imagem', 'odin' ),
				'insert_into_item'      => __( 'Inserir no item', 'odin' ),
				'uploaded_to_this_item' => __( 'Upload', 'odin' ),
				'items_list'            => __( 'Items list', 'odin' ),
				'items_list_navigation' => __( 'Items list navigation', 'odin' ),
				'filter_items_list'     => __( 'Filter items list', 'odin' ),
			);
			$args = array(
				'label'                 => __( 'Instituição', 'odin' ),
				'description'           => __( 'instituições para doação', 'odin' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor', 'thumbnail' ),
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => true,
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'page',
			);
			register_post_type( 'instituicoes', $args );
		}
	}
	new Brasa_Donate_Plugin();
