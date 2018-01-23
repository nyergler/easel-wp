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

?>