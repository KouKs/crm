<?php
/**
 * @package BasicCRM
 */

class BasicCRM {

	/**
	 * @var $fields Meta boxes to be added
	 */
	public $fields = [
		[ 'name' => '_crm_first_name' 	, 'label' => 'First Name' ],
		[ 'name' => '_crm_last_name' 	, 'label' => 'Last Name' ],
		[ 'name' => '_crm_telephone' 	, 'label' => 'Telephone' ],
		[ 'name' => '_crm_email' 		, 'label' => 'Email' ],	
	];

	public function __construct() {

		add_action('init', [ $this, 'registerPostType' ]);
		add_action('init', [ $this, 'registerTaxonomies' ]);

		add_action('add_meta_boxes', [ $this, 'addMetaBoxes'] );
		add_action('save_post', [ $this, 'savePostMeta']);

		add_filter('manage_edit-client_columns', [ $this, 'columnsNames' ]);
		add_action('manage_posts_custom_column', [ $this, 'columnsData' ]);

	}

	/**
	 * Registering the Client post type
	 */
	public function registerPostType() {

		register_post_type('client', [
			'labels' 	=> [
				'name' 					=> 'Clients',
				'singular_name' 		=> 'Client',
				'add_new_item' 			=> 'Add new client',
				'edit_item' 			=> 'Edit client',
				'new_item' 				=> 'New client',
				'view_item' 			=> 'View client',
				'search_items' 			=> 'Search clients',
				'parent' 				=> 'Parent client',
				'not_found' 			=> 'No client found',
				'not_found_in_trash' 	=> 'No client found in trash',
			],
			'public' 	=> true,
			'menu_icon' => 'dashicons-businessman',
			'supports' 	=> [ '' ],
		]);
	}

	/**
	 * Registering the both Company and Position taxonomies
	 */
	public function registerTaxonomies() {

		register_taxonomy('company', 'client', [
			'labels' 	=> [
				'name' 						=> 'Companies',
				'singular_name' 			=> 'Company',
				'add_new_item' 				=> 'Add new company',
				'edit_item' 				=> 'Edit company',
				'new_item' 					=> 'New company',
				'view_item' 				=> 'View company',
				'search_items'				=> 'Search companies',
				'not_found' 				=> 'No company found',
				'not_found_in_trash' 		=> 'No company found in trash',
				'separate_items_with_commas'=> 'Separate companies with commas',
				'choose_from_most_used'		=> 'Choose from the most used companies',
			], 
		]);


		register_taxonomy('position', 'client', [
			'labels' 	=> [
				'name' 						=> 'Positions',
				'singular_name' 			=> 'Position',
				'add_new_item' 				=> 'Add new position',
				'edit_item' 				=> 'Edit position',
				'new_item' 					=> 'New position',
				'view_item' 				=> 'View position',
				'search_items' 				=> 'Search positions',
				'not_found' 				=> 'No position found',
				'not_found_in_trash' 		=> 'No position Found in trash',
				'separate_items_with_commas'=> 'Separate positions with commas',
				'choose_from_most_used'		=> 'Choose from the most used positions',
			], 
		]);
	}

	/**
	 * Adding meta boxes specified the the $fields variable
	 */
	public function addMetaBoxes() {

		wp_nonce_field(CRM_PLUGIN_DIR, 'clients_nonce');

		foreach($this->fields as $field)
		{
			$name = $field['name'];

			add_meta_box($field['name'], $field['label'], function($post) use($name) {

				$post_meta = get_post_meta($post->ID);
				include('partials/input.php');

			}, 'client');
		}

	}

	/**
	 * Saving meta data od the DB
	 *
	 * @param $id The post ID
	 */
	public function savePostMeta($id) {

		if(wp_is_post_autosave($id) || wp_is_post_revision($id) || wp_verify_nonce(@$_POST['clients_nonce'])) {
			return;
		}

		foreach($this->fields as $field) {
			
			if(isset($_POST[$field['name']])) {
				update_post_meta($id, $field['name'], sanitize_text_field($_POST[$field['name']]));
			}
		}
	}

	/**
	 * Defining own columns on the 'Clients' page
	 */
	public function columnsNames() {

		return [
			'cb'					=> '<input type="checkbox" />',
			'crm_name'				=> 'Name',
			'crm_position'			=> 'Position',
			'crm_contact'			=> 'Contact',
		];
	}


	/**
	 * Filtering the data that shows up on the 'Clients' page
	 *
	 * @param $column Name of a column
	 */
	function columnsData($column) {
		
		global $post, $wp_taxonomies;

		$companies = get_the_terms($post, 'company');
		$positions = get_the_terms($post, 'position');

		switch($column) {
			case 'crm_name':
				printf('<strong>%s %s</strong>',
					esc_html(get_post_meta($post->ID, '_crm_first_name', true)),
					esc_html(get_post_meta($post->ID, '_crm_last_name', true))); 
				include('partials/row-actions.php');
				break;
			case 'crm_position':
				printf('%s at <strong>%s</strong>',
					esc_html(@$positions[0]->name),
					esc_html(@$companies[0]->name));
				break;
			case 'crm_contact':
				printf('<strong>Phone:</strong> %s <br /> <strong>Email:</strong> %s',
					esc_html(get_post_meta($post->ID, '_crm_telephone', true)),
					esc_html(get_post_meta($post->ID, '_crm_email', true)));
				break;
		}

	}
}
?>
