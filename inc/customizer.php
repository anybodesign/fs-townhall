<?php defined('ABSPATH') or die();
/**
 * FS Townhall Customizer functionality
 *
 * @package WordPress
 * @subpackage FS_Townhall
 * @since 1.0
 * @version 1.0
 */

// Customizer JS

add_action( 'customize_preview_init', 'fs_customizer_scripts' );
function fs_customizer_scripts() {
	wp_enqueue_script(
		'fs-customizer',
	    	FS_THEME_URL . '/js/customizer.js',
	    	array( 'customize-preview' ), 
	    	false, 
	    	true
	);
}

// Customizer Settings
 
function fs_customize_register($fs_customize) {

	// Title and Description
	// -
	// + + + + + + + + + + 
	
	$fs_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$fs_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	if ( isset( $fs_customize->selective_refresh ) ) {
		$fs_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => array('.site-title', '.site-title a'),
			'render_callback' => 'fs_customize_partial_blogname',
		) );
		$fs_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-desc',
			'render_callback' => 'fs_customize_partial_blogdescription',
		) );
	}	 

	// Create Some Sections
	// -
	// + + + + + + + + + + 
	
	$fs_customize->add_section(
		'fs_header_section',
		array(
			'title'			=> __('Header Options', 'fs-townhall'),
			'priority'		=> 40,
		)
	);
	$fs_customize->add_section(
		'fs_footer_section',
		array(
			'title'			=> __('Footer Options', 'fs-townhall'),
			'priority'		=> 40,
		)
	);
	$fs_customize->add_section(
		'fs_options_section',
		array(
			'title'			=> __('Theme Options', 'fs-townhall'),
			'priority'		=> 50,
		)
	);
	$fs_customize->add_section(
		'fs_blog_section',
		array(
			'title'			=> __('Blog Options', 'fs-townhall'),
			'priority'		=> 50,
		)
	);
	$fs_customize->add_section(
		'fs_layout_section', 
		array(
			'title' 		=> __('Layout Options', 'fs-townhall'),
			'description' 	=> __('Choose the layout of the site header and main navigation.', 'fs-townhall'),
			'priority'		=> 50,
		)
	);
	$fs_customize->add_section(
		'fs_pictures_section', 
		array(
			'title' 		=> __('Theme Pictures', 'fs-townhall'),
			'description' 	=> __('Select default banner pictures.', 'fs-townhall'),
			'priority'		=> 60,
		)
	);
	$fs_customize->add_section(
		'fs_fonts_section', 
		array(
			'title' 		=> __('Theme Fonts', 'fs-townhall'),
			'description' 	=> __('Choose a font combination for the site.', 'fs-townhall'),
			'priority'		=> 60,
		)
	);
	
	if ( class_exists('FS_CPT_AGENDA') ) {
		$fs_customize->add_section(
			'fs_agenda_section', 
			array(
				'title' 		=> __('Events options', 'fs-townhall'),
				'priority'		=> 50,
			)
		);
	}


	// Colors
	// -
	// + + + + + + + + + + 
		
		// Primary color
		
		$fs_customize->add_setting(
			'primary_color', 
			array(
				'default'			=> '#23252b',
				'sanitize_callback'	=> 'sanitize_hex_color',
				'capability'		=> 'edit_theme_options',
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage', 
			)
		);
		$fs_customize->add_control(
			new WP_Customize_Color_control(
				$fs_customize, 
				'primary_color', 
				array(
					'label'			=> __('Primary color', 'fs-townhall'),
					'description'	=> __('Main color and titles color', 'fs-townhall'),
					'section'		=> 'colors',
					'settings'		=> 'primary_color',
				)
			)
		);
				
		// Secondary color
		
		$fs_customize->add_setting(
			'secondary_color', 
			array(
				'default'			=> '#606060',
				'sanitize_callback'	=> 'sanitize_hex_color',
				'capability'		=> 'edit_theme_options',
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage', 
			)
		);
		$fs_customize->add_control( 
			new WP_Customize_Color_control(
				$fs_customize, 
				'secondary_color', 
				array(
					'label'		=> __('Secondary color', 'fs-townhall'),
					'section'	=> 'colors',
					'settings'	=> 'secondary_color',
				)
			)
		);
				
		// Accent color
		
		$fs_customize->add_setting(
			'accent_color', 
			array(
				'default'			=> '#ceff00',
				'sanitize_callback'	=> 'sanitize_hex_color',
				'capability'		=> 'edit_theme_options',
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage', 
			)
		);
		$fs_customize->add_control( new WP_Customize_Color_control($fs_customize, 'accent_color', array(
					'label'			=> __('Contrast color', 'fs-townhall'),
					'description'	=> __('Links and contrast color', 'fs-townhall'),
					'section'		=> 'colors',
					'settings'		=> 'accent_color',
				)
			)
		);
		
		// Buttons
		
		$fs_customize->add_setting(
			'btn_text', 
			array(
				'default'			=> false,
				'transport'			=> 'refresh',
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'btn_text', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Buttons white text', 'fs-townhall'),
				'section'		=> 'colors',
				'settings'		=> 'btn_text',
			)
		);
		$fs_customize->add_setting(
			'btn_text_hover', 
			array(
				'default'			=> false,
				'transport'			=> 'refresh',
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'btn_text_hover', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Buttons white text on mouse over', 'fs-townhall'),
				'section'		=> 'colors',
				'settings'		=> 'btn_text_hover',
			)
		);
		
		// Text color
		
		$fs_customize->add_setting(
			'text_color', 
			array(
				'default'			=> '#23252b',
				'sanitize_callback'	=> 'sanitize_hex_color',
				'capability'		=> 'edit_theme_options',
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage', 
			)
		);
		$fs_customize->add_control( new WP_Customize_Color_control($fs_customize, 'text_color', array(
					'label'		=> __('Text color', 'fs-townhall'),
					'section'	=> 'colors',
					'settings'	=> 'text_color',
				)
			)
		);
		
		// Background color
		
		$fs_customize->add_setting(
			'bg_color', 
			array(
				'default'			=> '#f0f0f0',
				'sanitize_callback'	=> 'sanitize_hex_color',
				'capability'		=> 'edit_theme_options',
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage', 
			)
		);
		$fs_customize->add_control( new WP_Customize_Color_control($fs_customize, 'bg_color', array(
					'label'			=> __('Background color', 'fs-townhall'),
					'description'	=> __('Used for components backgrounds', 'fs-townhall'),
					'section'		=> 'colors',
					'settings'		=> 'bg_color',
				)
			)
		);
		
		$fs_customize->add_setting(
			'page_color', 
			array(
				'default'			=> '#ffffff',
				'sanitize_callback'	=> 'sanitize_hex_color',
				'capability'		=> 'edit_theme_options',
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage', 
			)
		);
		$fs_customize->add_control( new WP_Customize_Color_control($fs_customize, 'page_color', array(
					'label'		=> __('Page background color', 'fs-townhall'),
					'section'	=> 'colors',
					'settings'	=> 'page_color',
				)
			)
		);
		
		// Header color
		
		$fs_customize->add_setting(
			'header_color', 
			array(
				'default'			=> '',
				'sanitize_callback'	=> 'sanitize_hex_color',
				'capability'		=> 'edit_theme_options',
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage', 
			)
		);
		$fs_customize->add_control( new WP_Customize_Color_control($fs_customize, 'header_color', array(
					'label'		=> __('Header color', 'fs-townhall'),
					'section'	=> 'colors',
					'settings'	=> 'header_color',
				)
			)
		);
		$fs_customize->add_setting(
			'header_white_text', 
			array(
				'default'			=> false,
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'header_white_text', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('White text in header', 'fs-townhall'),
				'section'		=> 'colors',
				'settings'		=> 'header_white_text',
			)
		);
		
		// Footer color
		
		$fs_customize->add_setting(
			'footer_color', 
			array(
				'default'			=> '',
				'sanitize_callback'	=> 'sanitize_hex_color',
				'capability'		=> 'edit_theme_options',
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage', 
			)
		);
		$fs_customize->add_control( new WP_Customize_Color_control($fs_customize, 'footer_color', array(
					'label'		=> __('Footer color', 'fs-townhall'),
					'section'	=> 'colors',
					'settings'	=> 'footer_color',
				)
			)
		);
		$fs_customize->add_setting(
			'footer_white_text', 
			array(
				'default'			=> false,
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'footer_white_text', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('White text in footer', 'fs-townhall'),
				'section'		=> 'colors',
				'settings'		=> 'footer_white_text',
			)
		);



	// Header Options
	// -
	// + + + + + + + + + + 

		// Site logo
		
		$fs_customize->add_setting(
			'site_logo', 
			array(
				'sanitize_callback'	=> 'esc_url_raw'
			)
		);
		$fs_customize->add_control(
			new WP_Customize_Image_control(
				$fs_customize, 
				'site_logo', 
				array(
					'label'			=> __('Site Logo', 'fs-townhall'),
					'description'	=> __('Your logo, displayed instead of the website title.', 'fs-townhall'),
					'section'		=> 'fs_header_section',
					'settings'		=> 'site_logo',
				)
			)
		);
		
		$fs_customize->add_setting('site_logo_height', array(
			'transport'			=> 'postMessage',
			'sanitize_callback'	=> 'sanitize_text_field',		
		));
		$fs_customize->add_control('site_logo_height', array(
			'type'			=> 'number',
			'label'			=> __('Logo height', 'fs-townhall'),
			'description'	=> __('Set a maximum height in pixels.', 'fs-townhall'),
			'section'		=> 'fs_header_section',
			'settings'		=> 'site_logo_height',
		));
		
		// Site logo - Mobile
		
		$fs_customize->add_setting(
			'site_logo_mobile', array(
				'sanitize_callback'		=> 'esc_url_raw'
			)
		);
		$fs_customize->add_control( 
			new WP_Customize_Image_control(
				$fs_customize, 
				'site_logo_mobile', 
				array(
					'label'			=> __('Site Logo - Mobile', 'fs-townhall'),
					'description'	=> __('Specific version of the logo for mobile devices. If none, the default logo will be used.', 'fs-townhall'),
					'section'		=> 'fs_header_section',
					'settings'		=> 'site_logo_mobile',
				)
			)
		);
		
		$fs_customize->add_setting('site_logo_mobile_height', array(
			'transport'			=> 'postMessage',
			'sanitize_callback'	=> 'sanitize_text_field',		
		));
		$fs_customize->add_control('site_logo_mobile_height', array(
			'type'			=> 'number',
			'label'			=> __('Mobile logo height', 'fs-townhall'),
			'description'	=> __('Set a maximum height in pixels.', 'fs-townhall'),
			'section'		=> 'fs_header_section',
			'settings'		=> 'site_logo_mobile_height',
		));

		// Hide site name
		
		$fs_customize->add_setting(
			'hide_sitetitle', 
			array(
				'default'			=> false,
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'hide_sitetitle', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Hide the site title', 'fs-townhall'),
				'section'		=> 'fs_header_section',
				'settings'		=> 'hide_sitetitle',
			)
		);

		// Hide tagline
		
		$fs_customize->add_setting(
			'hide_tagline', 
			array(
				'default'			=> false,
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'hide_tagline', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Hide the website tagline', 'fs-townhall'),
				'section'		=> 'fs_header_section',
				'settings'		=> 'hide_tagline',
			)
		);
		
		// Searchbar
		
		$fs_customize->add_setting(
			'searchbar', 
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'searchbar', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Display search in toolbar', 'fs-townhall'),
				'section'		=> 'fs_header_section',
				'settings'		=> 'searchbar',
			)
		);
		
		// High contrast
		
		$fs_customize->add_setting(
			'contrast', 
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'contrast', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Display high Contrast button in toolbar', 'fs-townhall'),
				'section'		=> 'fs_header_section',
				'settings'		=> 'contrast',
			)
		);	

	// Footer Options
	// -
	// + + + + + + + + + + 
	
		
		// Footer text
		
		$fs_customize->add_setting(
			'footer_text', 
			array(
				'default'				=> '',
				'transport'				=> 'postMessage',				
				'sanitize_callback'		=> 'sanitize_text_field'
			)
		);
		$fs_customize->add_control(
			'footer_text', 
			array(
				'label'			=> __('Custom footer text', 'fs-townhall'),
				'description'	=> __('Add a custom text instead of the year and blog name.', 'fs-townhall'),
				'section'		=> 'fs_footer_section',
				'settings'		=> 'footer_text',
			)
		);
		
		
		// WP Credits
		
		$fs_customize->add_setting(
			'display_wp', 
			array(
				'default'			=> false,
				'transport'			=> 'postMessage',				
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'display_wp', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Display WordPress Link', 'fs-townhall'),
				'section'		=> 'fs_footer_section',
				'settings'		=> 'display_wp',
			)
		);


	// Theme Options
	// -
	// + + + + + + + + + +
	
		// Agenda
		
		$fs_customize->add_setting(
			'use_agenda', 
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'use_agenda', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Enable Events Custom post type', 'fs-townhall'),
				'section'		=> 'fs_options_section',
				'settings'		=> 'use_agenda',
			)
		); 
		
		// Back to top
	
		$fs_customize->add_setting(
			'back2top', 
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'back2top', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Display a Back to top button', 'fs-townhall'),
				'section'		=> 'fs_options_section',
				'settings'		=> 'back2top',
			)
		);
			
		// Sticky Nav
		
		$fs_customize->add_setting(
			'stickynav', 
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'stickynav', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Make the header sticky', 'fs-townhall'),
				'section'		=> 'fs_options_section',
				'settings'		=> 'stickynav',
			)
		);
		
		// IAS
		
		$fs_customize->add_setting(
			'use_ias', 
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'use_ias', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Load new posts on click', 'fs-townhall'),
				'section'		=> 'fs_options_section',
				'settings'		=> 'use_ias',
			)
		);
		
		// Scrollout
		
		$fs_customize->add_setting(
			'use_scrollout', 
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'use_scrollout', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Use Scrollout to animate blocks on scroll', 'fs-townhall'),
				'section'		=> 'fs_options_section',
				'settings'		=> 'use_scrollout',
			)
		);
		
		// Fancybox
		
		$fs_customize->add_setting(
			'use_fancybox', 
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'use_fancybox', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Use Fancybox to enlarge pictures', 'fs-townhall'),
				'section'		=> 'fs_options_section',
				'settings'		=> 'use_fancybox',
			)
		);
		
		
	// Blog options
	// -
	// + + + + + + + + + + 		
		
		// Banner text
		
		$fs_customize->add_setting('blog_excerpt', array(
			//'transport'			=> 'postMessage',
			'sanitize_callback'	=> 'sanitize_text_field',		
		));
		$fs_customize->add_control('blog_excerpt', array(
			'type'			=> 'textarea',
			'label'			=> __('Blog introduction text', 'fs-townhall'),
			'section'		=> 'fs_blog_section',
			'settings'		=> 'blog_excerpt',
		));
		
		// Sidebars
		
		$fs_customize->add_setting(
			'blog_sidebar', 
			array(
				'default'			=> true,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'blog_sidebar', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Show the sidebar on the blog page', 'fs-townhall'),
				'section'		=> 'fs_blog_section',
				'settings'		=> 'blog_sidebar',
			)
		);
		
		$fs_customize->add_setting(
			'post_sidebar', 
			array(
				'default'			=> true,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'post_sidebar', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Show the sidebar on single posts', 'fs-townhall'),
				'section'		=> 'fs_blog_section',
				'settings'		=> 'post_sidebar',
			)
		);
		
		// Category dropdown
		
		$fs_customize->add_setting(
			'cat_dropdown', 
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'cat_dropdown', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Show the category dropdown on the blog page', 'fs-townhall'),
				'section'		=> 'fs_blog_section',
				'settings'		=> 'cat_dropdown',
			)
		);
		
		// Excerpt
		
		$fs_customize->add_setting(
			'ex_lenght', 
			array(
				'default'				=> 24,
				'sanitize_callback'		=> 'sanitize_text_field'		
			)
		);
		$fs_customize->add_control(
			'ex_lenght', 
			array(
				'type'			=> 'number',
				'label'			=> __('Excerpt lenght (number of words)', 'fs-townhall'),
				'section'		=> 'fs_blog_section',
				'settings'		=> 'ex_lenght',
			)
		);
		
		// Post metas
		
		$fs_customize->add_setting(
			'meta_date', 
			array(
				'default'			=> true,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'meta_date', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Show the publication date in post meta', 'fs-townhall'),
				'section'		=> 'fs_blog_section',
				'settings'		=> 'meta_date',
			)
		);
		$fs_customize->add_setting(
			'meta_author', 
			array(
				'default'			=> true,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'meta_author', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Show the author in post meta', 'fs-townhall'),
				'section'		=> 'fs_blog_section',
				'settings'		=> 'meta_author',
			)
		);
		$fs_customize->add_setting(
			'meta_category', 
			array(
				'default'			=> true,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'meta_category', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Show the category in post meta', 'fs-townhall'),
				'section'		=> 'fs_blog_section',
				'settings'		=> 'meta_category',
			)
		);
		
		// Sharing 
		
		$fs_customize->add_setting(
			'share_box', 
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'share_box', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Add basic social networks sharing buttons on single posts (Facebook, Twitter, LinkedIn, e-mail)', 'fs-townhall'),
				'section'		=> 'fs_blog_section',
				'settings'		=> 'share_box',
			)
		);


	// Theme Layout
	// -
	// + + + + + + + + + + 

		// Header & Main nav

		$fs_customize->add_setting(
			'layout_option', 
			array(
				'default' => 'version1',
				'sanitize_callback' => 'fs_customizer_sanitize_radio_layout',
			)
		);
		$fs_customize->add_control(
			'layout_option', 
			array(
				'type' => 'radio',
				'label' => __( 'Layout version', 'fs-townhall' ),
				'section' => 'fs_layout_section',
				'choices' => array(
					'version1' => __( 'Version 1', 'fs-townhall' ),
					'version2' => __( 'Version 2', 'fs-townhall' ),
				),
			)
		);

	// Theme Fonts
	// -
	// + + + + + + + + + + 

		$fs_customize->add_setting(
			'webfont', 
			array(
				'default' => 'andes',
				'sanitize_callback' => 'fs_customizer_sanitize_font_layout',
			)
		);
		$fs_customize->add_control(
			'webfont', 
			array(
				'type' => 'radio',
				'label' => __( 'Choose your fonts', 'fs-townhall' ),
				'section' => 'fs_fonts_section',
				'choices' => array(
					'andes' => __( 'Andes Neue & Atkinson', 'fs-townhall' ),
					'cooper' => __( 'Cooper Hewit & Atkinson', 'fs-townhall' ),
					'barlow' => __( 'Barlow', 'fs-townhall' ),
					'bebas' => __( 'Bebas & Bitter', 'fs-townhall' ),
					'luciole' => __( 'Luciole', 'fs-townhall' ),
					
				),
			)
		);
	
	
	// Agenda
	// -
	// + + + + + + + + + + 
		
		// Banner text
		
		$fs_customize->add_setting('agenda_excerpt', array(
			//'transport'			=> 'postMessage',
			'sanitize_callback'	=> 'sanitize_text_field',		
		));
		$fs_customize->add_control('agenda_excerpt', array(
			'type'			=> 'textarea',
			'label'			=> __('Events introduction text', 'fs-townhall'),
			'section'		=> 'fs_agenda_section',
			'settings'		=> 'agenda_excerpt',
		));	
		
		// Tax filters
		
		$fs_customize->add_setting(
			'tax_filters', 
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'tax_filters', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Display the search filters.', 'fs-townhall'),
				'section'		=> 'fs_agenda_section',
				'settings'		=> 'tax_filters',
			)
		);


	// Theme Pictures
	// -
	// + + + + + + + + + + 
		
		$fs_customize->add_setting(
			'has_bg', 
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'fs_customizer_sanitize_checkbox',		
			)
		);
		$fs_customize->add_control(
			'has_bg', 
			array(
				'type'			=> 'checkbox',
				'label'			=> __('Show background images in the banner', 'fs-townhall'),
				'section'		=> 'fs_pictures_section',
				'settings'		=> 'has_bg',
			)
		);
		
		// Default Image
		
		$fs_customize->add_setting(
			'bg_default', 
			array(
				'sanitize_callback'	=> 'esc_url_raw'
			)
		);
		$fs_customize->add_control( 
			new WP_Customize_Image_control(
				$fs_customize, 
				'bg_default', 
				array(
					'label'			=> __('Default banner', 'fs-townhall'),
					'description'	=> __('Choose a default picture for the page banner. (2048 x 625 pixels max.)', 'fs-townhall'),
					'section'		=> 'fs_pictures_section',
					'settings'		=> 'bg_default',
				)
			)
		);
		
		// Blog Image
		
		$fs_customize->add_setting(
			'bg_blog', 
			array(
				'sanitize_callback'	=> 'esc_url_raw'
			)
		);
		$fs_customize->add_control( 
			new WP_Customize_Image_control(
				$fs_customize, 
				'bg_blog', 
				array(
					'label'			=> __('Blog', 'fs-townhall'),
					'description'	=> __('Choose a picture for the blog banner. (2048 x 625 pixels max.)', 'fs-townhall'),
					'section'		=> 'fs_pictures_section',
					'settings'		=> 'bg_blog',
				)
			)
		);
		
		// Agenda Image
		
		if ( class_exists('FS_CPT_AGENDA') ) {
			$fs_customize->add_setting(
				'bg_agenda', 
				array(
					'sanitize_callback'	=> 'esc_url_raw'
				)
			);
			$fs_customize->add_control( 
				new WP_Customize_Image_control(
					$fs_customize, 
					'bg_agenda', 
					array(
						'label'			=> __('Events', 'fs-townhall'),
						'description'	=> __('Choose a picture for the events banner. (2048 x 625 pixels max.)', 'fs-townhall'),
						'section'		=> 'fs_pictures_section',
						'settings'		=> 'bg_agenda',
					)
				)
			);
		}
		
		// 404 Image
		
		$fs_customize->add_setting(
			'bg_404', 
			array(
				'sanitize_callback'	=> 'esc_url_raw'
			)
		);
		$fs_customize->add_control( 
			new WP_Customize_Image_control(
				$fs_customize, 
				'bg_404', 
				array(
					'label'			=> __('404 error', 'fs-townhall'),
					'description'	=> __('Choose a picture for the 404 error page. (2048 x 625 pixels max.)', 'fs-townhall'),
					'section'		=> 'fs_pictures_section',
					'settings'		=> 'bg_404',
				)
			)
		);	

}
add_action('customize_register', 'fs_customize_register');


// Callbacks + Sanitize

function fs_customize_partial_blogname() {
	bloginfo( 'name' );
}
function fs_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function fs_customizer_sanitize_checkbox( $input ) {
	if ( $input === true || $input === '1' ) {
		return '1';
	}
	return '';
}
function fs_customizer_sanitize_radio_layout( $input ) {
    if( !in_array( $input, array( 'version1', 'version2' ) ) ) {
        $input = 'version1';
    }
    return $input;
}
function fs_customizer_sanitize_font_layout( $input ) {
    if( !in_array( $input, array( 'andes' , 'cooper', 'barlow', 'bebas', 'luciole' ) ) ) {
        $input = 'barlow';
    }
    return $input;
}


// Customizer Colors Output

function fs_inline_styles() { ?>

	<style>
		:root {
			--primary_color: <?php echo esc_attr(get_theme_mod('primary_color', '#23252b')); ?>; 
			--secondary_color: <?php echo esc_attr(get_theme_mod('secondary_color', '#606060')); ?>;
			--accent_color: <?php echo esc_attr(get_theme_mod('accent_color', '#ceff00')); ?>;	
			--bg_color: <?php echo esc_attr(get_theme_mod('bg_color', '#f0f0f0')); ?>;			
			--page_color: <?php echo esc_attr(get_theme_mod('page_color', '#ffffff')); ?>;			
			--text_color: <?php echo esc_attr(get_theme_mod('text_color', '#23252b')); ?>;				
			
			<?php if ( get_theme_mod('header_color') ) { ?>
			--header_color: <?php echo esc_attr(get_theme_mod('header_color', '')); ?>;
			<?php }
				if ( get_theme_mod('footer_color') ) { ?>
			--footer_color: <?php echo esc_attr(get_theme_mod('footer_color', '')); ?>;
			<?php } ?>
			
			<?php if ( get_theme_mod('btn_text') ) { ?>
			--btn_text: #ffffff;
			<?php }
				if ( get_theme_mod('btn_text_hover') ) { ?>
			--btn_text_hover: #ffffff;
			<?php } ?>
			
			<?php if ( get_theme_mod('webfont') == 'bebas' ) { ?>
			--font_title: 'Title-Bebas', var(--font_stack);
			--font_regular: 'Regular-Bebas', var(--font_stack);
			--font_italic: 'Italic-Bebas', var(--font_stack);
			--font_bold: 'Bold-Bebas', var(--font_stack);
			--font_bolditalic: 'BoldItalic-Bebas', var(--font_stack);
			<?php }
				if ( get_theme_mod('webfont') == 'cooper' ) { ?>
			--font_title: 'Title-Cooper', var(--font_stack);
			--font_regular: 'Regular-Cooper', var(--font_stack);
			--font_italic: 'Italic-Cooper', var(--font_stack);
			--font_bold: 'Bold-Cooper', var(--font_stack);
			--font_bolditalic: 'BoldItalic-Cooper', var(--font_stack);
			<?php }
				if ( get_theme_mod('webfont') == 'luciole' ) { ?>
			--font_title: 'Title-Luciole', var(--font_stack);
			--font_regular: 'Regular-Luciole', var(--font_stack);
			--font_italic: 'Italic-Luciole', var(--font_stack);
			--font_bold: 'Bold-Luciole', var(--font_stack);
			--font_bolditalic: 'BoldItalic-Luciole', var(--font_stack);
			<?php }
				if ( get_theme_mod('webfont') == 'barlow' ) { ?>
			--font_title: 'Title-Barlow', var(--font_stack);
			--font_regular: 'Regular-Barlow', var(--font_stack);
			--font_italic: 'Italic-Barlow', var(--font_stack);
			--font_bold: 'Bold-Barlow', var(--font_stack);
			--font_bolditalic: 'BoldItalic-Barlow', var(--font_stack);
			<?php } ?>
		}
	</style>

<?php }
add_action('wp_head','fs_inline_styles');

// Admin fonts

add_action('admin_print_styles', 'fs_admin_inline_styles' );
function fs_admin_inline_styles() { ?>
	
	<style>
		:root {
			<?php if ( get_theme_mod('webfont') == 'bebas' ) { ?>
			--font_title: 'Title-Bebas', var(--font_stack) !important;
			--font_regular: 'Regular-Bebas', var(--font_stack) !important;
			--font_italic: 'Italic-Bebas', var(--font_stack) !important;
			--font_bold: 'Bold-Bebas', var(--font_stack) !important;
			--font_bolditalic: 'BoldItalic-Bebas', var(--font_stack) !important;
			<?php }
				if ( get_theme_mod('webfont') == 'cooper' ) { ?>
			--font_title: 'Title-Cooper', var(--font_stack) !important;
			--font_regular: 'Regular-Cooper', var(--font_stack) !important;
			--font_italic: 'Italic-Cooper', var(--font_stack) !important;
			--font_bold: 'Bold-Cooper', var(--font_stack) !important;
			--font_bolditalic: 'BoldItalic-Cooper', var(--font_stack) !important;
			<?php }
				if ( get_theme_mod('webfont') == 'luciole' ) { ?>
			--font_title: 'Title-Luciole', var(--font_stack) !important;
			--font_regular: 'Regular-Luciole', var(--font_stack) !important;
			--font_italic: 'Italic-Luciole', var(--font_stack) !important;
			--font_bold: 'Bold-Luciole', var(--font_stack) !important;
			--font_bolditalic: 'BoldItalic-Luciole', var(--font_stack) !important;
			<?php }
				if ( get_theme_mod('webfont') == 'barlow' ) { ?>
			--font_title: 'Title-Barlow', var(--font_stack) !important;
			--font_regular: 'Regular-Barlow', var(--font_stack) !important;
			--font_italic: 'Italic-Barlow', var(--font_stack) !important;
			--font_bold: 'Bold-Barlow', var(--font_stack) !important;
			--font_bolditalic: 'BoldItalic-Barlow', var(--font_stack) !important;
			<?php } ?>
		}
	</style>
<?php }