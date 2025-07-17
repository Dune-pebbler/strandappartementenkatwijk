<?php
$ap_sections = array (
	array (
		'id' => 'appearance',
		'name' => 'Appearance'
	),
	array (
		'id' => 'sliders',
		'name' => 'Sliders'
	),
	array (
		'id' => 'widget_areas',
		'name' => 'Widget areas'
	),
	array (
		'id' => 'lists_of_posts',
		'name' => 'Lists of posts'
	),
	array (
		'id' => 'categories',
		'name' => 'Categories'
	),
	array (
		'id' => 'single_posts',
		'name' => 'Single posts'
	),
	array (
		'id' => 'pages',
		'name' => 'Pages'
	),
	array (
		'id' => 'translation',
		'name' => 'Translation'
	),
	array (
		'id' => 'misc',
		'name' => 'Miscellaneous'
	)
);

$ap_options = array (  
	
	/* begin appearance */
	'ap_logo_sub_section' => array (
		'section' => 'appearance',
		'desc' => 'Logo',
		'type' => 'sub-section',
		'val' => ''
	),
	
	'ap_logo' => array ( 
		'section' => 'appearance',
		'name' => 'Logo image',  
		'desc' => 'Enter an URL or select an image.',  
		'type' => 'image-upload',  
		'val' => ''
	),
	
	'ap_logo_mobile_settings_enabled' => array ( 
		'section' => 'appearance',
		'name' => 'Activate mobile logo settings',  
		'desc' => '',  
		'type' => 'radio',
		'radio_options' => array('yes', 'no'),
		'val' => 'no'
	),
	
	'ap_logo_mobile_settings' => array ( 
		'section' => 'appearance',
		'name' => '',  
		'desc' => '',  
		'type' => 'logo-mobile-settings',
		'val' => array(
			'logo-url' => '',
			'reducing-scale-factor' => '1.5'
		)
	),
	
	'ap_logo_background_color' => array (
		'section' => 'appearance',
		'name' => 'Logo background color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#000000'
	),
	
	'ap_logo_background_opacity' => array (
		'section' => 'appearance',
		'name' => 'Logo background opacity',
		'desc' => 'A number between 0 and 100',
		'type' => 'input-text',
		'val' => '75'
	),

	'ap_header_sub_section' => array (
		'section' => 'appearance',
		'desc' => 'Default header',
		'type' => 'sub-section',
		'val' => ''
	),
	
	'ap_header_image' => array (
		'section' => 'appearance',
		'name' => '- an image:',
		'desc' => '',
		'type' => 'image-upload',
		'val' => ''
	),

	'ap_header_slider' => array (
		'section' => 'appearance',
		'name' => '- or a slider:',
		'desc' => '',
		'type' => 'slider-selector',
		'val' => 'no-slider'
	),

	'ap_header_min_height' => array (
		'section' => 'appearance',
		'name' => 'Header minimum height',
		'desc' => '(in px)',
		'type' => 'input-text',
		'val' => '280'
	),
	
	'ap_menu_sub_section' => array (
		'section' => 'appearance',
		'desc' => 'Menu',
		'type' => 'sub-section',
		'val' => ''
	),

	'ap_navigation_y_position' => array (
		'section' => 'appearance',
		'name' => 'Main navigation y-position',
		'desc' => 'How far is the navigation from the top (in px)',
		'type' => 'input-text',
		'val' => '60'
	),
	
	'ap_menu_background_color' => array (
		'section' => 'appearance',
		'name' => 'Menu background color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#000000'
	),
		
	'ap_menu_background_opacity' => array (
		'section' => 'appearance',
		'name' => 'Menu background opacity',
		'desc' => 'A number between 0 and 100',
		'type' => 'input-text',
		'val' => '75'
	),
		
	'ap_menu_text_color' => array (
		'section' => 'appearance',
		'name' => 'Color of text in the menu',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#ffffff'
	),

	'ap_menu_text_hover_color' => array (
		'section' => 'appearance',
		'name' => 'Color of text on hover in the menu',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#999999'
	),	
		
	'ap_mobile_menu_sub_section' => array (
		'section' => 'appearance',
		'desc' => 'Mobile menu',
		'type' => 'sub-section',
		'val' => ''
	),

	'ap_mobile_menu_type' => array (
		'section' => 'appearance',
		'name' => 'Mobile menu type',
		'desc' => '',
		'type' => 'radio',
		'radio_options' => array('drop-down menu', 'select box menu'),
		'val' => 'drop-down menu'
	),
	
	'ap_mobile_menu_icon' => array (
		'section' => 'appearance',
		'name' => 'Mobile menu icon',
		'desc' => '',
		'type' => 'radio',
		'radio_options' => array('arrow', '3-bars'),
		'val' => 'arrow'
	),
		
	'ap_mobile_menu_icon_color' => array (
		'section' => 'appearance',
		'name' => 'Mobile menu icon color',
		'desc' => '',
		'type' => 'radio',
		'radio_options' => array('black', 'white'),
		'val' => 'white'
	),
	
	'ap_mobile_button_background_color' => array (
		'section' => 'appearance',
		'name' => 'Mobile button (or select-box) background color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#000000'
	),	
		
	'ap_mobile_button_background_opacity' => array (
		'section' => 'appearance',
		'name' => 'Mobile button (or select-box) background opacity',
		'desc' => '',
		'type' => 'input-text',
		'val' => '85'
	),	
	
	'ap_top_strip_top_widget_sub_section' => array (
		'section' => 'appearance',
		'desc' => 'Top strip and top widget area',
		'type' => 'sub-section',
		'val' => ''
	),
	
	'ap_top_strip_background_color' => array (
		'section' => 'appearance',
		'name' => 'Top strip background color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#000000'
	),
	
	'ap_top_strip_background_opacity' => array (
		'section' => 'appearance',
		'name' => 'Top strip background opacity',
		'desc' => 'A number between 0 and 100',
		'type' => 'input-text',
		'val' => '75'
	),
		
	'ap_top_widget_area_background_color' => array (
		'section' => 'appearance',
		'name' => 'Top widget area background color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#000000'
	),
	
	'ap_top_widget_area_background_opacity' => array (
		'section' => 'appearance',
		'name' => 'Top widget area background opacity',
		'desc' => 'A number between 0 and 100',
		'type' => 'input-text',
		'val' => '75'
	),

	'ap_slider_controls_sub_section' => array (
		'section' => 'appearance',
		'desc' => 'Slider controls',
		'type' => 'sub-section',
		'val' => ''
	),
	
	'ap_slider_controls_color' => array (
		'section' => 'appearance',
		'name' => 'Slider controls color',
		'desc' => '',
		'type' => 'radio',
		'radio_options' => array('black', 'white'),
		'val' => 'white'
	),
	
	'ap_slider_controls_background_color' => array (
		'section' => 'appearance',
		'name' => 'Slider controls background color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#000000'
	),
	
	'ap_slider_controls_background_opacity' => array (
		'section' => 'appearance',
		'name' => 'Slider controls background opacity',
		'desc' => 'A number between 0 and 100',
		'type' => 'input-text',
		'val' => '75'
	),
	
	'ap_page_title_sub_section' => array (
		'section' => 'appearance',
		'desc' => 'Page title',
		'type' => 'sub-section',
		'val' => ''
	),

	'ap_title_text_color' => array (
		'section' => 'appearance',
		'name' => 'Title text color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#ffffff'
	),	
	
	'ap_title_background_color' => array (
		'section' => 'appearance',
		'name' => 'Title background color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#000000'
	),
	
	'ap_title_background_opacity' => array (
		'section' => 'appearance',
		'name' => 'Title background opacity',
		'desc' => 'A number between 0 and 100',
		'type' => 'input-text',
		'val' => '75'
	),
	
	'ap_title_location' => array (
		'section' => 'appearance',
		'name' => 'Title location',
		'desc' => 'Where is displayed the title of pages',
		'type' => 'radio',
		'radio_options' => array('header', 'content'),
		'val' => 'header'
	),
	
	'ap_title_animation_speed' => array (
		'section' => 'appearance',
		'name' => 'Title animation speed',
		'desc' => 'How fast the title slide in the page (in ms)',
		'type' => 'input-text',
		'val' => '1000'
	),
	
	'ap_texture_sub_section' => array (
		'section' => 'appearance',
		'desc' => 'Texture',
		'type' => 'sub-section',
		'val' => ''
	),

	'ap_texture' => array (
		'section' => 'appearance',
		'name' => 'Texture',
		'desc' => '',
		'type' => 'select',
		'select_options' => array('diamond-1', 'diamond-2', 'floral-1', 'floral-2', 'fabric', 'leather', 'luxury', 'lyonnette', 'pineapple-cut', 'vichy'),
		'val' => 'diamond-1'
	),
	
	'ap_texture_custom' => array (
		'section' => 'appearance',
		'name' => 'Custom texture',
		'desc' => '',
		'type' => 'image-upload',
		'val' => ''
	),
	
	'ap_sidebars_texture' => array (
		'section' => 'appearance',
		'name' => 'Display a texture for sidebars',
		'desc' => '',
		'type' => 'radio',
		'radio_options' => array('yes', 'no'),
		'val' => 'yes'
	),
	
	'ap_bg_sub_section' => array (
		'section' => 'appearance',
		'desc' => 'Background',
		'type' => 'sub-section',
		'val' => ''
	),
	
	'ap_bg_color' => array (
		'section' => 'appearance',
		'name' => 'Body and footer background color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#f0f3ff'
	),
	
	'ap_bg_image' => array (
		'section' => 'appearance',
		'name' => 'Default background image',
		'desc' => '',
		'type' => 'image-upload',
		'val' => ''
	),

	'ap_bg_texture' => array (
		'section' => 'appearance',
		'name' => '- or select a default background texture',
		'desc' => '(this will set the right background url for you)',
		'type' => 'select',
		'select_options' => array('none', 'diamond-1', 'diamond-2', 'floral-1', 'floral-2', 'fabric', 'leather', 'luxury', 'lyonnette', 'pineapple-cut', 'vichy'),
		'val' => 'none'
	),
	
	'ap_bg_stretch_or_tile' => array (
		'section' => 'appearance',
		'name' => 'If you have selected a background image you can choose between a stretched or a tiled background',
		'desc' => '',
		'type' => 'radio',
		'radio_options' => array('stretch', 'tile'),
		'val' => 'stretch'
	),

	'ap_bg_fixed_or_scrollable' => array (
		'section' => 'appearance',
		'name' => 'If you have selected a tiled background image or a texture you can choose between a fixed or scrollable background',
		'desc' => '',
		'type' => 'radio',
		'radio_options' => array('fixed', 'scrollable'),
		'val' => 'fixed'
	),
	
	'ap_footer_sub_section' => array (
		'section' => 'appearance',
		'desc' => 'Footer',
		'type' => 'sub-section',
		'val' => ''
	),
	
	'ap_footer_location' => array(
		'section' => 'appearance',
		'name' => 'Footer location',
		'desc' => 'Display the footer below the main content box or inside the main content box',
		'type' => 'radio',
		'radio_options' => array('below', 'inside'),
		'val' => 'inside'
	),
	
	'ap_footer_image' => array(
		'section' => 'appearance',
		'name' => 'Default footer image',
		'desc' => '',
		'type' => 'image-upload',
		'val' => ''
	),
	
	'ap_footer_min_height' => array(
		'section' => 'appearance',
		'name' => 'Footer minimum height',
		'desc' => '(in px)',
		'type' => 'input-text',
		'val' => '200'
	),
	
	'ap_footer_copyright' => array(
		'section' => 'appearance',
		'name' => 'Copyright informations',
		'desc' => 'The bit of text at the bottom of the footer. This is the perfect place to put copyright information but you can put what you want.',
		'type' => 'textarea',
		'val' => '&copy; Copyright 2013 The Place  -  Designed by <a href="http://themeforest.net/user/AurelienD/?ref=AurelienD">AurelienD</a>'
	),
	
	'ap_misc_sub_section' => array (
		'section' => 'appearance',
		'desc' => 'Misc',
		'type' => 'sub-section',
		'val' => ''
	),

	'ap_boxed_layout' => array (
		'section' => 'appearance',
		'name' => 'Boxed layout on wide screen',
		'desc' => '',
		'type' => 'radio',
		'radio_options' => array('yes', 'no'),
		'val' => 'yes'
	),
	
	'ap_favicon' => array( 
		'section' => 'appearance',
		'name' => 'Favicon',  
		'desc' => 'Enter an URL or select an icon.<br/>A favicon or Favorites Icon is a small graphic that is displayed in the browser tab bar (and also in the bookmarks when the website is saved).',  
		'type' => 'image-upload',  
		'val' => ''
	),
	
	'ap_headings_font' => array (
		'section' => 'appearance',
		'name' => 'Google headings font',
		'desc' => '',
		'type' => 'input-text',
		'val' => ''
	),
	
	'ap_headings_color' => array (
		'section' => 'appearance',
		'name' => 'Headings color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#3699b5'
	),
	
	'ap_headings_color_sidebar' => array (
		'section' => 'appearance',
		'name' => 'Headings color for sidebar',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#3699b5'
	),
	
	'ap_headings_color_footer' => array (
		'section' => 'appearance',
		'name' => 'Headings color for footer',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#3699b5'
	),
	
	'ap_buttons_color' => array (
		'section' => 'appearance',
		'name' => 'Default buttons color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#4c8c23'
	),
	
	'ap_links_color' => array (
		'section' => 'appearance',
		'name' => 'Links color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#3699b5'
	),
	
	'ap_links_color_sidebar' => array (
		'section' => 'appearance',
		'name' => 'Links color for sidebar',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#444444'
	),
	
	'ap_text_color_footer' => array (
		'section' => 'appearance',
		'name' => 'Text color for footer',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#444444'
	),	
	
	'ap_links_color_footer' => array (
		'section' => 'appearance',
		'name' => 'Links color for footer',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#444444'
	),
	
	'ap_links_hover_color' => array (
		'section' => 'appearance',
		'name' => 'Links hover color',
		'desc' => '',
		'type' => 'color-picker',
		'val' => '#d76144'
	),
	/* end appearance */
	
	/* begin sliders */
	'ap_global_slider_manager' => array (
		'section' => 'sliders',
		'name' => '',
		'desc' => '',
		'type' => 'global-slider-manager',
		'val' => array()
	),
	
	'ap_slider_manager' => array (
		'section' => 'sliders',
		'name' => '',
		'desc' => '',
		'type' => 'slider-manager',
		'val' => array()
	),
	/* end sliders */
	
	/* begin widget areas */
	'ap_widget_areas_manager' => array (
		'section' => 'widget_areas',
		'name' => '',
		'desc' => '',
		'type' => 'widget-areas-manager',
		'val' => array()
	),
	/* end widget areas */
	
	/* begin lists of posts */
	'ap_lists_of_posts_manager' => array (
		'section' => 'lists_of_posts',
		'name' => '',
		'desc' => '',
		'type' => 'lists-of-posts-manager',
		'val' => array( array( 'layout' => 'one-col-right-sidebar', 'sidebar' => 'default_sidebar', 'display-title' => 'yes', 'meta' => array('date', 'categories', 'tags', 'comments'), 'show-thumbnail' => 'yes', 'thumbnail-links' => 'post', 'content' => 'excerpt', 'learn-more' => 'button', 'header-image' => '', 'fws' => 'no', 'footer-image' => '' ) )
	),
	/* end lists of posts */
	
	/* begin categories */
	'ap_categories_manager' => array (
		'section' => 'categories',
		'name' => '',
		'desc' => '',
		'type' => 'categories-manager',
		'val' => array()
	),
	/* end categories */
	
	/* begin single posts */
	'ap_single_posts_manager' => array (
		'section' => 'single_posts',
		'name' => '',
		'desc' => '',
		'type' => 'single-posts-manager',
		'val' => array( array( 'layout' => 'one-col-right-sidebar', 'sidebar' => 'default_sidebar', 'meta' => array('date', 'categories', 'tags', 'comments'), 'disable-comments' => 'no' ) )
	),
	/* end single posts */
	
	/* begin pages */
	'ap_default_layout_for_pages' => array (
		'section' => 'pages',
		'name' => 'Choose a default layout for pages',
		'desc' => 'You can change this default setting on a per-page basis.',
		'type' => 'select-advanced',
		'select_options' => array(array('full-width','Full width'),array('one-col-left-sidebar', 'One column and left sidebar'),array('one-col-right-sidebar','One column and right sidebar')),
		'val' => 'full-width'
	),
	
	'ap_sidebar_name_for_pages' => array (
		'section' => 'pages',
		'name' => 'Sidebar name for pages',
		'desc' => 'You can change this default setting on a per-page basis.',
		'type' => 'sidebar-selector',
		'val' => 'default_sidebar'
	),
	
	'ap_disable_comments_for_pages' => array (
		'section' => 'pages',
		'name' => 'Disable comments for ALL pages',
		'desc' => '',
		'type' => 'radio',
		'radio_options' => array('yes', 'no'),
		'val' => 'yes'
	),
	/* end pages */
	
	/* begin translation */
	'ap_translation_manager' => array (
		'section' => 'translation',
		'name' => '',
		'desc' => '',
		'type' => 'translation-manager',
		'val' => array(
			'langs' => array(
				array( 'code' => 'Default' ),
				array( 'code' => 'en_US' )
			),
			'strings' => array(
				array(
					'value' => array( 
						'Default' => 'Learn more',
						'en_US' => 'Learn more'
					)
				),
				array(
					'value' => array( 
						'Default' => 'Post Comment',
						'en_US' => 'Post Comment'
					)
				)
			)
		)
	),	
	/* end translation */
	
	/* begin miscellaneous */
	'ap_main_reset' => array (
		'section' => 'misc',
		'name' => 'Main reset',
		'desc' => 'Click on the button below if you want to reset ALL options.',
		'type' => 'custom',
		'custom_code' => '<p><input type="button" id="reset-ap-options" class="button" value="Reset ALL options" /></p>',
		'val' => ''
	),
	
	'ap_load_demo_options' => array (
		'section' => 'misc',
		'name' => 'Load Demo Options',
		'desc' => 'Click on the button below if you want to load the Demo options.',
		'type' => 'custom',
		'custom_code' => '<p><input type="button" id="load-demo-ap-options" class="button" value="Load Demo Options" /></p>',
		'val' => ''
	),

	'ap_load_demo_widgets' => array (
		'section' => 'misc',
		'name' => 'Load Demo Widgets',
		'desc' => 'Click on the button below if you want to load all the Widgets as they are in demo.',
		'type' => 'custom',
		'custom_code' => '<p><input type="button" id="load-demo-widgets-ap-options" class="button" value="Load Demo Widgets" /></p>',
		'val' => ''
	),
	
	'ap_activate_hotel' => array (
		'section' => 'misc',
		'name' => 'Activate the Booking System',
		'desc' => '',
		'type' => 'radio',
		'radio_options' => array('yes', 'no'),
		'val' => 'yes'
	),
	
	'ap_404_title' => array (
		'section' => 'misc',
		'name' => 'Title of "404 Page"',
		'desc' => '',
		'type' => 'input-text-w50p',
		'val' => 'Error 404'
	),
	
	'ap_404_message' => array(
		'section' => 'misc',
		'name' => 'Message of "404 Page"',
		'desc' => '',
		'type' => 'textarea',
		'val' => 'Sorry, it seems we can\'t find what you\'re looking for.'
	),
	
	'ap_display_edit_link' => array(
		'section' => 'misc',
		'name' => 'Display edit link',
		'desc' => 'Display an edit link when logged in.',
		'type' => 'radio',
		'radio_options' => array('yes', 'no'),
		'val' => 'no'
	),
	
	'ap_header_img_width' => array(
		'section' => 'misc',
		'name' => 'Natural width of full width slider images and header images',
		'desc' => '',
		'type' => 'input-text',
		'val' => '1500'
	),
		
	'ap_disable_wp_gallery' => array(
		'section' => 'misc',
		'name' => 'Replace WordPress gallery with the theme gallery',
		'desc' => '',
		'type' => 'radio',
		'radio_options' => array('yes', 'no'),
		'val' => 'yes'
	),
	
	'ap_custom_header_code' => array( 
		'section' => 'misc',
		'name' => 'Custom header code',  
		'desc' => 'This custom code will be added at the end of the &lt;head&gt;&lt;/head&gt; section.',  
		'type' => 'textarea',  
		'val' => ''
	),
		
	'ap_custom_footer_code' => array( 
		'section' => 'misc',
		'name' => 'Custom footer code',  
		'desc' => 'This custom code will be added at the end of the &lt;/body&gt; section.',  
		'type' => 'textarea',  
		'val' => ''
	)
	/* end miscellaneous */
);
  
$ap_options_defaults = $ap_options;

global $ap_theme_name;

$ap_options_saved = get_option($ap_theme_name . '_theme_options');
foreach ( $ap_options as $key => $ap_option ) {
	if ( isset($ap_options_saved[$key]) ) {
		$ap_options[$key]['val'] = $ap_options_saved[$key]['val'];
	}
}
?>