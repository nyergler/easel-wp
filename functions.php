<?php

function eazel_enqueue_styles() {

    $parent_style = 'sketch-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'eazel-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'eazel_enqueue_styles' );

function eazel_post_formats(){
     add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'status', 'image', 'quote' ) );
}
add_action( 'after_setup_theme', 'eazel_post_formats', 11 );

?>