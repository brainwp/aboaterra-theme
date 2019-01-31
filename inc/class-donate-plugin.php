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
				'all_items'             => __( 'All Items', 'odin' ),
				'add_new_item'          => __( 'Add New Item', 'odin' ),
				'add_new'               => __( 'Add New', 'odin' ),
				'new_item'              => __( 'New Item', 'odin' ),
				'edit_item'             => __( 'Edit Item', 'odin' ),
				'update_item'           => __( 'Update Item', 'odin' ),
				'view_item'             => __( 'View Item', 'odin' ),
				'view_items'            => __( 'View Items', 'odin' ),
				'search_items'          => __( 'Search Item', 'odin' ),
				'not_found'             => __( 'Not found', 'odin' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'odin' ),
				'featured_image'        => __( 'Featured Image', 'odin' ),
				'set_featured_image'    => __( 'Set featured image', 'odin' ),
				'remove_featured_image' => __( 'Remove featured image', 'odin' ),
				'use_featured_image'    => __( 'Use as featured image', 'odin' ),
				'insert_into_item'      => __( 'Insert into item', 'odin' ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', 'odin' ),
				'items_list'            => __( 'Items list', 'odin' ),
				'items_list_navigation' => __( 'Items list navigation', 'odin' ),
				'filter_items_list'     => __( 'Filter items list', 'odin' ),
			);
			$args = array(
				'label'                 => __( 'Instituição', 'odin' ),
				'description'           => __( 'instituições para doação', 'odin' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor' ),
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