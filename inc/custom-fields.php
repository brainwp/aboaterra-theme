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

