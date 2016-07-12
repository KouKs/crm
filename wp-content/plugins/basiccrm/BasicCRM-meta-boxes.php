<?php
/**
 * @package CRM
 */

$fields = [
	[ 'name' => 'first_name' , 'label' => 'First Name' ],
	[ 'name' => 'last_name' , 'label' => 'Last Name' ],
	[ 'name' => 'company' , 'label' => 'Company' ],
	[ 'name' => 'position' , 'label' => 'Position' ],
	[ 'name' => 'telephone' , 'label' => 'Telephone' ],
	[ 'name' => 'email' , 'label' => 'Email'],	
];

add_action('add_meta_boxes', function($post) use($fields) {

	wp_nonce_field(CRM_PLUGIN_DIR, 'clients_nonce');

	foreach($fields as $field)
	{
		crm_add_meta_box($field['name'], $field['label']);
	}

});

add_action('save_post', function($id) use($fields) {

	if(wp_is_post_autosave($id) || wp_is_post_revision($id) || wp_verify_nonce(@$_POST['clients_nonce']))
	{
		return;
	}

	foreach($fields as $field)
	{
		if(isset($_POST[$field['name']]))
		{
			update_post_meta($id, $field['name'], sanitize_text_field($_POST[$field['name']]));
		}
	}
});

function crm_add_meta_box($name, $label) {

	add_meta_box($name, $label, function($post) use($name) {

		$post_meta = get_post_meta($post->ID);
		include('partials/input.php');

	}, 'client');
}
