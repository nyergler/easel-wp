<?php

function load_easel_taxonomy_template($template) {
	global $taxonomy;

	// see if we're dealing with one of the easel taxonomies here
    if ( ! $template ) {
		if ( $taxonomy == 'easel_medium' ) {
			$template = plugin_dir_path( __FILE__ ) . '../templates/taxonomy-easel_medium.php';
		} elseif ( $taxonomy == 'easel_series' ) {
			$template = plugin_dir_path( __FILE__ ) . '../templates/taxonomy-easel_series.php';
		}
    }

    return $template;
}
add_filter('taxonomy_template', 'load_easel_taxonomy_template');

?>