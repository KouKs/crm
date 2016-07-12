<?php
/**
 * @package CRM
 */

add_action('init', function() {

	$args = [
		'labels' => [
			'name' => 'Clients',
			'singular_name' => 'Client',
			'add_new_item' => 'Add New Client',
			'edit_item' => 'Edit Client',
			'new_item' => 'New Client',
			'view_item' => 'View Client',
			'search_term' => 'Search Clients',
			'parent' => 'Parent Client',
			'not_found' => 'No Client Found',
			'not_found_in_trash' => 'No Client Found in Trash',
		],
		'public' => true,
		'menu_icon' => 'dashicons-businessman',
		'supports' => [ '' ],
	];

	register_post_type('client', $args);
});