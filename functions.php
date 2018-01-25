<?php

function eazel_enqueue_styles() {

    $parent_style = 'sketch-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'eazel-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    if ( is_post_type_archive( 'print' ) || is_tax( 'jetpack-portfolio-type' ) || is_tax( 'jetpack-portfolio-tag' ) ) {
        wp_enqueue_script( 'sketch-portfolio', get_template_directory_uri() . '/js/portfolio.js', array( 'jquery' ), '20150708', true );
    }
}
add_action( 'wp_enqueue_scripts', 'eazel_enqueue_styles' );

function eazel_post_formats(){
    add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'status', 'image', 'quote' ) );
}
add_action( 'after_setup_theme', 'eazel_post_formats', 11 );

function eazel_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'prints', array(
        'title' => __( 'Prints' ),
        'description' => __( 'Customize the Print archives here' ),
        'panel' => '', // Not typically needed.
        'priority' => 160,
        'capability' => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    $wp_customize->add_setting( 'prints_title', array(
        'default' => 'Prints',
    ) );
    $wp_customize->add_control( 'prints_title', array(
        'section' => 'prints',
        'label' => __( 'Archive Title' ),
        'description' => __( 'Page title for Print Archive page(s)' ),
      ) );

    $wp_customize->add_setting( 'prints_content', array(
        'default' => '',
    ) );
    $wp_customize->add_control( 'prints_content', array(
        'section' => 'prints',
        'label' => __( 'Archive Content' ),
        'description' => __( 'Page content for Print Archive page.' ),
        'type' => 'textarea',
    ) );
    }
add_action( 'customize_register', 'eazel_customize_register' );

function eazel_print_posts_per_page( $query ) {
    if ( !is_admin() && $query->is_main_query() && $query->is_post_type_archive('print') ) {
        $query->set( 'posts_per_page', 12 );
    }
}
add_action( 'pre_get_posts', 'eazel_print_posts_per_page' );

?>