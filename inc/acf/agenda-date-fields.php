<?php defined('ABSPATH') or die(); 

function fs_agenda_fields() {

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_60ded805a94fe',
	'title' => __('Event date', 'fs-townhall'),
	'fields' => array(
		array(
			'key' => 'field_60ded81a13787',
			'label' => __('Event starting date', 'fs-townhall'),
			'name' => 'event_starting_date',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'd/m/Y',
			'return_format' => 'Y-m-d',
			'first_day' => 1,
		),
		array(
			'key' => 'field_60ded87013789',
			'label' => __('Event ending date (optional)', 'fs-townhall'),
			'name' => 'event_ending_date',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'd/m/Y',
			'return_format' => 'Y-m-d',
			'first_day' => 1,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'event',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;

}
add_action('acf/init', 'fs_agenda_fields');