<?php

/**
 * Registers the `easel_work` post type.
 */
function easel_work_init() {
	register_post_type( 'easel_work', array(
		'labels'                => array(
			'name'                  => __( 'Works', 'easel' ),
			'singular_name'         => __( 'Work', 'easel' ),
			'all_items'             => __( 'All Works', 'easel' ),
			'archives'              => __( 'Work Archives', 'easel' ),
			'attributes'            => __( 'Work Attributes', 'easel' ),
			'insert_into_item'      => __( 'Insert into Work', 'easel' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Work', 'easel' ),
			'featured_image'        => _x( 'Featured Image', 'easel_work', 'easel' ),
			'set_featured_image'    => _x( 'Set featured image', 'easel_work', 'easel' ),
			'remove_featured_image' => _x( 'Remove featured image', 'easel_work', 'easel' ),
			'use_featured_image'    => _x( 'Use as featured image', 'easel_work', 'easel' ),
			'filter_items_list'     => __( 'Filter Works list', 'easel' ),
			'items_list_navigation' => __( 'Works list navigation', 'easel' ),
			'items_list'            => __( 'Works list', 'easel' ),
			'new_item'              => __( 'New Work', 'easel' ),
			'add_new'               => __( 'Add New', 'easel' ),
			'add_new_item'          => __( 'Add New Work', 'easel' ),
			'edit_item'             => __( 'Edit Work', 'easel' ),
			'view_item'             => __( 'View Work', 'easel' ),
			'view_items'            => __( 'View Works', 'easel' ),
			'search_items'          => __( 'Search Works', 'easel' ),
			'not_found'             => __( 'No Works found', 'easel' ),
			'not_found_in_trash'    => __( 'No Works found in trash', 'easel' ),
			'parent_item_colon'     => __( 'Parent Work:', 'easel' ),
			'menu_name'             => __( 'Works', 'easel' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor', 'revisions', 'author', 'thumbnail' ),
		'has_archive'           => true,
		'rewrite'               => array(
			'slug'				=> 'print',
		),
		'query_var'             => true,
		'menu_icon' => plugins_url( 'assets/icon-32.png', __FILE__ ),
		'show_in_rest'          => true,
		'rest_base'             => 'easel_work',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'register_meta_box_cb' 	=> 'easel_setup_meta_box',
	) );

}
add_action( 'init', 'easel_work_init' );

/**
 * Sets the post updated messages for the `easel_work` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `easel_work` post type.
 */
function easel_work_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['easel_work'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Work updated. <a target="_blank" href="%s">View Work</a>', 'easel' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'easel' ),
		3  => __( 'Custom field deleted.', 'easel' ),
		4  => __( 'Work updated.', 'easel' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Work restored to revision from %s', 'easel' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Work published. <a href="%s">View Work</a>', 'easel' ), esc_url( $permalink ) ),
		7  => __( 'Work saved.', 'easel' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Work submitted. <a target="_blank" href="%s">Preview Work</a>', 'easel' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Work scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Work</a>', 'easel' ),
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Work draft updated. <a target="_blank" href="%s">Preview Work</a>', 'easel' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'easel_work_updated_messages' );

function load_easel_work_template($template) {
	// If 'single-easel_work.php' file in the user's theme doesn't exist, load it from the plugin directory.
	global $post;

	$found = locate_template('single-easel_work.php');
	if($post->post_type == 'easel_work' && $found == ''){
        $template = plugin_dir_path( __FILE__ ) . '../templates/single-easel_work.php';
	}

    return $template;
}
add_filter('single_template', 'load_easel_work_template');

function load_easel_work_archive_template($template) {
	// If 'archive-easel_work.php' file in the user's theme doesn't exist, load it from the plugin directory.
	if (is_post_type_archive('easel_work')) {
		$theme_files = array('archive-easel_work.php');
		$exists_in_theme = locate_template($theme_files, false);
		if ($exists_in_theme == '') {
			$template = plugin_dir_path( __FILE__ ) . '../templates/archive-easel_work.php';
		}
	}

    return $template;
}
add_filter('archive_template', 'load_easel_work_archive_template');

/**
 * Configure the metaboxes for Easel Works
 *
 */
function easel_setup_meta_box() {
    $screens = ['easel-work'];
    foreach ($screens as $screen) {
        add_meta_box(
            'easel-prpos',           // Unique ID
            'Work Properties',  // Box title
            'easel_work_props_box',  // Content callback, must be of type callable
            $screen,
            'normal',
            'high'
        );
    }
}

function easel_work_props_box() {
    echo 'Hello, metabox';
}

?>