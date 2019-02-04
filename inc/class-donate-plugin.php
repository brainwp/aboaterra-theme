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
			// add custom fields
			add_action('init', array( $this,'my_acf_add_local_field_groups'));
			// add donation field to cart
			add_action( 'woocommerce_after_cart_table', array( $this,'donation_checkout_field_cart' ));

			// add donation field to checkout
			add_action( 'woocommerce_after_checkout_billing_form', array( $this, 'donation_checkout_field_checkout' ), 10, 1 );

			// save data to wc->session
			add_action( 'wp_ajax_donation_checkout_field_ajax', array( $this, 'donation_checkout_field_ajax' ) );
			add_action( 'wp_ajax_nopriv_donation_checkout_field_ajax', array( $this, 'donation_checkout_field_ajax' ) );
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

		public function donation_checkout_field_checkout(){
			// WC()->session->set( 'doacao', 'instituicao' );
			$instituicao = WC()->session->get( 'doacao' );
			?>
			<div class="donate_button_div col-sm-6">
				<h2>Faça uma doação</h2>
				<p>A cada compra você pode doar 1 real para colaborar com uma das instituições abaixo</p>
				<?php
				$loop = new WP_Query( array(
					'post_type' => 'instituicoes',
					'posts_per_page' => -1
				  )
				);
				?>
				<?php while ( $loop->have_posts() ) : $loop->the_post();
				$id = get_the_id();
					?>
					<div class="col-md-4">
						<input type="radio" name="imagem" id="<?php echo $id ?>" <?php echo ( $id == $instituicao ?  'checked="checked"' : ''); ?>/>
						<label for="<?php echo $id; ?>"><img src="<?php echo get_the_post_thumbnail_url( )  ;?>" alt=""></label>
						<h4><?php echo get_the_title( ); ?></h4>
					</div>
				<?php endwhile; wp_reset_query(); ?>
			</div>
			<?php
		}
		// Add data to session via ajax
		public function donation_checkout_field_ajax(){
			$instituicao = $_REQUEST['instituicao'];
			global $woocommerce;
    		WC()->session->set( 'doacao', $instituicao );
			echo 'ok';
			wp_die();
		}
		// Add donation field to checkout
		public function donation_checkout_field_cart( $checkout ) {
			?>
			<div class="donate_button_div col-sm-6">
				<h2>Faça uma doação</h2>
				<p>A cada compra você pode doar 1 real para colaborar com uma das instituições abaixo</p>
				<?php
				$loop = new WP_Query( array(
				    'post_type' => 'instituicoes',
				    'posts_per_page' => -1
				  )
				);
				?>

				<?php while ( $loop->have_posts() ) : $loop->the_post();
					?>
					<div class="col-md-4">

						<input type="radio" name="imagem" id="<?php echo get_the_id() ?>" />
						<label for="<?php echo get_the_id(); ?>"><img src="<?php echo get_the_post_thumbnail_url( )  ;?>" alt=""></label>
						<h4><?php echo get_the_title( ); ?></h4>
					</div>



				<?php endwhile; wp_reset_query(); ?>
			</div>
			<?php
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
		// add custom fields
		public function my_acf_add_local_field_groups() {
			if(function_exists("register_field_group")){
				register_field_group(array (
					'id' => 'acf_valor',
					'title' => 'Valor',
					'fields' => array (
						array (
							'key' => 'field_5c5268b977d15',
							'label' => 'Valor da doação',
							'name' => 'valor_da_doação',
							'type' => 'number',
							'required' => 1,
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'min' => '',
							'max' => '',
							'step' => '',
						),
					),
					'location' => array (
						array (
							array (
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'instituicoes',
								'order_no' => 0,
								'group_no' => 0,
							),
						),
					),
					'options' => array (
						'position' => 'normal',
						'layout' => 'no_box',
						'hide_on_screen' => array (
						),
					),
					'menu_order' => 0,
				));
			}
		}
	}
	new Brasa_Donate_Plugin();
