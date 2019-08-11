<?php
/**
 * acacia Theme Customizer
 *
 * @package acacia
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function acacia_customize_register( $wp_customize ) {

	$blog_navigation_array = array(
		'navigation' => __( 'Navigation', 'acacia' ),
		'pagination' => __( 'Pagination', 'acacia' ),
	);

	$google_fonts_headings = array(
		'Dancing Script'    => 'Dancing Script',
		'Cinzel Decorative' => 'Cinzel Decorative',
		'Elsie Swash Caps'  => 'Elsie Swash Caps',
	);

	$google_fonts_text = array(
		'Lato'             => 'Lato',
		'Open Sans'        => 'Open Sans',
		'Source Sans Pro'  => 'Source Sans Pro',
		'Source Serif Pro' => 'Source Serif Pro',
	);

	$footer_widgets = array(
		'1' => 1,
		'2' => 2,
		'3' => 3,
		'4' => 4,
	);

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'acacia_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'acacia_customize_partial_blogdescription',
		) );
	}

	// ==============================
	// ==   Acacia Custom Settings    ==
	// ==============================
	$wp_customize->add_section(
		'theme_settings',
		array(
			'title'       => __( 'Theme Settings', 'acacia' ),
			'description' => __( 'In this section you can choose the options to customize your site.', 'acacia' ),
			'priority'    => 115,
		)
	);
	// ===============================
	$wp_customize->add_setting(
		'blog_navigation',
		array(
			'sanitize_callback' => 'acacia_sanitize_blog_nav',
			'capability'        => 'edit_theme_options',
			'default'           => 'navigation',
		)
	);

	$wp_customize->add_control(
		'blog_navigation',
		array(
			'settings' => 'blog_navigation',
			'label'    => __( 'Choose your preferred mode of navigating between old and new articles in multiple view pages', 'acacia' ),
			'section'  => 'theme_settings',
			'type'     => 'radio',
			'choices'  => $blog_navigation_array,
		)
	);
	// ===============================
	$wp_customize->add_setting(
		'headings_font',
		array(
			'sanitize_callback' => 'acacia_sanitize_font_style',
			'capability'        => 'edit_theme_options',
			'default'           => 'Elsie Swash Caps',
		)
	);

	$wp_customize->add_control(
		'headings_font',
		array(
			'settings' => 'headings_font',
			'label'    => __( 'Choose the headings font', 'acacia' ),
			'section'  => 'theme_settings',
			'type'     => 'select',
			'choices'  => $google_fonts_headings,
		)
	);
	// ===============================
	$wp_customize->add_setting(
		'text_font',
		array(
			'sanitize_callback' => 'acacia_sanitize_font_style',
			'capability'        => 'edit_theme_options',
			'default'           => 'Lato',
		)
	);

	$wp_customize->add_control(
		'text_font',
		array(
			'settings' => 'text_font',
			'label'    => __( 'Choose the text font', 'acacia' ),
			'section'  => 'theme_settings',
			'type'     => 'select',
			'choices'  => $google_fonts_text,
		)
	);

	// ===============================
	$wp_customize->add_setting(
		'footer_widgets',
		array(
			'sanitize_callback' => 'absint',
			'capability'        => 'edit_theme_options',
			'default'           => 2,
		)
	);

	$wp_customize->add_control(
		'footer_widgets',
		array(
			'settings' => 'footer_widgets',
			'label'    => __( 'Choose the number of footer widgets', 'acacia' ),
			'section'  => 'theme_settings',
			'type'     => 'select',
			'choices'  => $footer_widgets,
		)
	);
}
add_action( 'customize_register', 'acacia_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function acacia_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function acacia_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function acacia_customize_preview_js() {
	wp_enqueue_script( 'acacia-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'acacia_customize_preview_js' );
