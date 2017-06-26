<?php
function wp_swift_get_location() {
	$location = array();
	$post = array( array (
		'param' => 'post_type',
		'operator' => '==',
		'value' => 'post',
	));
	$page = array( array (
		'param' => 'post_type',
		'operator' => '==',
		'value' => 'page',
	));
	$location[] = $post;
	$location[] = $page;
	return $location;
}
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_557c76602bb85',
	'title' => 'Additional Fields',
	'fields' => array (
		array (
			'key' => 'field_557d39eb7cd4f',
			'label' => 'Modules',
			'name' => 'modules',
			'type' => 'flexible_content',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'button_label' => 'Add Module',
			'min' => '',
			'max' => 1,
			'layouts' => array (
				array (
					'key' => '557d39fc8d32e',
					'name' => 'video',
					'label' => 'Video',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_557d3a0a7cd50',
							'label' => 'Video',
							'name' => 'video',
							'type' => 'oembed',
							'instructions' => 'Add Video',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'width' => '',
							'height' => '',
						),
					),
					'min' => '',
					'max' => '',
				),
				array (
					'key' => '5582a84e85d75',
					'name' => 'gallery',
					'label' => 'Gallery',
					'display' => 'row',
					'sub_fields' => array (
						array (
							'key' => 'field_5582a85c85d76',
							'label' => 'Images',
							'name' => 'images',
							'type' => 'gallery',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'min' => '',
							'max' => '',
							'preview_size' => 'thumbnail',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
							'insert' => 'append',
						),
					),
					'min' => '',
					'max' => '',
				),
			),
		),
	),
	'location' => wp_swift_get_location(),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;