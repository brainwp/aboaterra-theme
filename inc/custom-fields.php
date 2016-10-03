<?php
/**
 *
 * ACF Fields
 *
*/
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_configuracoes-da-pagina',
		'title' => 'Configurações da Página',
		'fields' => array (
			array (
				'key' => 'field_57a1256b0c854',
				'label' => 'Mensagem de região não atendida',
				'name' => 'regioes_error',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-regioes.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_conteudo-no-lado-direito',
		'title' => 'Conteúdo no lado direito',
		'fields' => array (
			array (
				'key' => 'field_57ed7e205e297',
				'label' => 'Conteúdo no lado direito',
				'name' => 'right_content',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-contato.php',
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
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_exibir-produto-destacado-no-rodape-livro',
		'title' => 'Exibir produto destacado no rodapé (livro)',
		'fields' => array (
			array (
				'key' => 'field_57edc316eb760',
				'label' => 'Deseja exibir o produto destacado (livro) no rodapé?',
				'name' => 'show_featured_product',
				'type' => 'true_false',
				'message' => '',
				'default_value' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
if(function_exists("register_field_group"))
{
	function _add_field_product_cat_cesta() {
		$term = get_term_by( 'slug', 'cesta', 'product_cat', OBJECT, 'raw' );
		register_field_group(array (
			'id' => 'acf_opcoes-da-cesta',
			'title' => 'Opções da Cesta',
			'fields' => array (
				array (
					'key' => 'field_57f05f2242849',
					'label' => 'Título da cesta na página de cestas',
					'name' => 'cesta_title',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_57f05f704284a',
					'label' => 'Descrição da cesta na página de cestas',
					'name' => 'cesta_content',
					'type' => 'textarea',
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'formatting' => 'br',
				),
			),
			'location' => array (
				array (
						array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'product',
						'order_no' => 0,
						'group_no' => 0,
						),
						array (
						'param' => 'taxonomy',
						'operator' => '==',
						'value' => $term->term_id,
						'order_no' => 1,
						'group_no' => 0,
						),
				),
			),
			'options' => array (
				'position' => 'side',
				'layout' => 'default',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 0,
		));
	}
	add_action( 'admin_init', '_add_field_product_cat_cesta' );
	register_field_group(array (
		'id' => 'acf_pagina-de-cestas',
		'title' => 'Página de Cestas',
		'fields' => array (
			array (
				'key' => 'field_57f073050ec37',
				'label' => 'Link 1 abaixo das cestas',
				'name' => 'link_1',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_57f0734d0ec38',
				'label' => 'Texto do Link 1',
				'name' => 'link_1_txt',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_57f0735e0ec39',
				'label' => 'Link 2 abaixo das cestas',
				'name' => 'link_2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_57f0738d0ec3a',
				'label' => 'Texto do Link 2',
				'name' => 'link_2_txt',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-cestas.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
