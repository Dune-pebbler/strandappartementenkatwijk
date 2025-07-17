<?php
$ap_message = '';

add_action('admin_menu', 'add_aurel_panel_in_menu');

function add_aurel_panel_in_menu() {
	$page = add_menu_page('Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'aurel_panel_launch_display');
	add_action('admin_print_styles-' . $page, 'ap_init');
}

if ( isset($_REQUEST['aurel-panel-action']) && ($_REQUEST['aurel-panel-action'] == 'activate-hotel') && check_admin_referer('aurelien-panel') && current_user_can('edit_theme_options') ) {
	$ap_options['ap_activate_hotel']['val'] = 'yes';
 	update_option( $ap_theme_name . '_theme_options', $ap_options );
	$ap_message = 'Booking system activated.';
}
	
if ( isset($_REQUEST['aurel-panel-action']) && ($_REQUEST['aurel-panel-action'] == 'deactivate-hotel') && check_admin_referer('aurelien-panel') && current_user_can('edit_theme_options') ) {
	$ap_options['ap_activate_hotel']['val'] = 'no'; 	
	update_option( $ap_theme_name . '_theme_options', $ap_options );
	$ap_message = 'Booking system deactivated.';
}

function aurel_panel_launch_display() {
	require_once( get_template_directory() . '/aurel-panel/aurel-panel-display.php' );
	aurel_panel_display();
}

function ap_init() {
	
	global $ap_options, $ap_options_defaults, $ap_message, $ap_theme_name, $ap_dispatch;
	
	if ( isset($_REQUEST['aurel-panel-action']) && ($_REQUEST['aurel-panel-action'] == 'save') && check_admin_referer('aurelien-panel') && current_user_can('edit_theme_options') ) {
		$need_json_decode = array( 'widget-areas-manager', 'global-slider-manager', 'slider-manager', 'fsslider-manager' , 'lists-of-posts-manager', 'single-posts-manager', 'categories-manager', 'translation-manager', 'logo-mobile-settings' );
		foreach ( $ap_options as $key => $value ) {
			if ( isset($_REQUEST[$key]) ) {
				if ($ap_options[$key]['type'] == 'check-boxes') {
					$ap_options[$key]['val'] = $_REQUEST[$key];
				} else if ( in_array($ap_options[$key]['type'], $need_json_decode)) {
					$ap_options[$key]['val'] = json_decode(stripslashes($_REQUEST[$key]), true);
				} else {
					$ap_options[$key]['val'] = stripslashes(trim($_REQUEST[$key]));
				}
			}
		}
		foreach ( $ap_options as $key => $value ) {
			$ap_options_to_save[$key]['val'] = $value['val'];
		}
		update_option( $ap_theme_name . '_theme_options', $ap_options_to_save ); 
		die('Options saved.'); 
	}
	
	if ( isset($_REQUEST['aurel-panel-action']) && ($_REQUEST['aurel-panel-action'] == 'reset') && check_admin_referer('aurelien-panel') && current_user_can('edit_theme_options') ) {
		$ap_options = $ap_options_defaults;
		foreach ( $ap_options_defaults as $key => $value ) {
			$ap_options_to_save[$key]['val'] = $value['val'];
		}
		update_option( $ap_theme_name . '_theme_options', $ap_options_to_save );
		$ap_message = 'All options have been set to default.';
	}
	
	if ( isset($_REQUEST['aurel-panel-action']) && ($_REQUEST['aurel-panel-action'] == 'load_options') && check_admin_referer('aurelien-panel') && current_user_can('edit_theme_options') ) {
		
		if( !class_exists('WP_Http') ) {
			include_once( ABSPATH . WPINC. '/class-http.php' );
		}
		global $wpdb;
		$images_url = array(
			'image-1' => '', 
			'image-2' => '', 
			'image-3' => '', 
		);
		foreach ( $images_url as $image => $url ) {
			$attachement_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $image . "'" );
			if ( $attachement_id === NULL ) {
				$photo = new WP_Http();
				$photo = $photo->request( get_template_directory_uri() . '/img-demo/' . $image . '.jpg' );
				// to do: check for error
				$attachment = wp_upload_bits( $image . '.jpg', null, $photo['body'], '2012/01' );
				$filetype = wp_check_filetype( basename( $attachment['file'] ), null );
				$postinfo = array(
					'post_mime_type'	=> $filetype['type'],
					'post_title'		=> $image,
					'post_content'	=> '',
					'post_status'	=> 'inherit'
				);
				$images_url[$image] = $attachment['url'];
				$attach_id = wp_insert_attachment( $postinfo, $attachment['file'] );
				if( !function_exists('wp_generate_attachment_data') ) {
					require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				}
				$attach_data = wp_generate_attachment_metadata( $attach_id, $attachment['file'] );
				wp_update_attachment_metadata( $attach_id,  $attach_data );
			} else {
				$images_url[$image] = wp_get_attachment_url($attachement_id);
			}
		}
		
		$ap_options_demo = $ap_options_defaults;
		
		$ap_options_demo['ap_global_slider_manager']['val'][0]['name'] = 'slider_full_width';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['type'] = 'Full-width';		
		$ap_options_demo['ap_global_slider_manager']['val'][0]['options'] = array(1000,6000,'yes',400);
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][0]['caption'] = 'Image 1';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][0]['image_url'] = $images_url['image-1'];
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][1]['caption'] = 'Image 2';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][1]['image_url'] = $images_url['image-2'];
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][2]['caption'] = 'Image 3';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][2]['image_url'] = $images_url['image-3'];
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][0]['caption_background'] = '#000000';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][0]['caption_opacity'] = '75';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][0]['caption_color'] = '#ffffff';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][0]['css'] = '';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][1]['caption_background'] = '#000000';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][1]['caption_opacity'] = '75';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][1]['caption_color'] = '#ffffff';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][1]['css'] = '';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][2]['caption_background'] = '#000000';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][2]['caption_opacity'] = '75';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][2]['caption_color'] = '#ffffff';
		$ap_options_demo['ap_global_slider_manager']['val'][0]['slides'][2]['css'] = '';
		
		$ap_options_demo['ap_global_slider_manager']['val'][1]['name'] = 'slider_top_content';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['type'] = 'Top-content';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['options'] = array(1000,6000,'yes',400);
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][0]['caption'] = 'Image 1';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][0]['image_url'] = $images_url['image-1'];
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][1]['caption'] = 'Image 2';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][1]['image_url'] = $images_url['image-2'];
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][2]['caption'] = 'Image 3';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][2]['image_url'] = $images_url['image-3'];
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][0]['caption_background'] = '#000000';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][0]['caption_opacity'] = '75';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][0]['caption_color'] = '#ffffff';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][0]['css'] = '';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][1]['caption_background'] = '#000000';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][1]['caption_opacity'] = '75';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][1]['caption_color'] = '#ffffff';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][1]['css'] = '';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][2]['caption_background'] = '#000000';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][2]['caption_opacity'] = '75';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][2]['caption_color'] = '#ffffff';
		$ap_options_demo['ap_global_slider_manager']['val'][1]['slides'][2]['css'] = '';
			
		$ap_options_demo['ap_global_slider_manager']['val'][2]['name'] = 'slider_full_screen';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['type'] = 'Full-screen';		
		$ap_options_demo['ap_global_slider_manager']['val'][2]['options'] = array(1000,6000,'no');
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][0]['caption'] = 'Image 1';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][0]['image_url'] = $images_url['image-1'];
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][1]['caption'] = 'Image 2';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][1]['image_url'] = $images_url['image-2'];
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][2]['caption'] = 'Image 3';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][2]['image_url'] = $images_url['image-3'];
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][0]['caption_background'] = '#000000';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][0]['caption_opacity'] = '75';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][0]['caption_color'] = '#ffffff';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][0]['css'] = '';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][1]['caption_background'] = '#000000';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][1]['caption_opacity'] = '75';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][1]['caption_color'] = '#ffffff';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][1]['css'] = '';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][2]['caption_background'] = '#000000';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][2]['caption_opacity'] = '75';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][2]['caption_color'] = '#ffffff';
		$ap_options_demo['ap_global_slider_manager']['val'][2]['slides'][2]['css'] = '';

		$ap_options_demo['ap_widget_areas_manager']['val'] = array('rooms','news_and_deals','single_room');
		
		$generic_category = array(
			'category' => '',
			'visible' => 'no',
			'layout' => '',
			'sidebar' => '',
			'display-title' => 'yes',
			'meta' => array('date','categories','tags'),
			'show-thumbnail' => 'yes',
			'thumbnail-links' => 'post',
			'content' => 'excerpt',
			'learn-more' => 'button',
			'header-image' => '',
			'slider' => 'no-slider',
			'background-image' => '',
			'footer-image' => '',
			'disable-comments' => 'yes'
		);
		$rooms_category = $generic_category;
		$news_and_deals_category = $generic_category;
		
		$rooms_category['category'] = 'rooms';
		$rooms_category['layout'] = 'one-col-left-sidebar';
		$rooms_category['sidebar'] = 'rooms';
		$rooms_category['meta'] = array();
		
		$news_and_deals_category['category'] = 'news-and-deals';
		$news_and_deals_category['layout'] = 'one-col-right-sidebar';
		$news_and_deals_category['sidebar'] = 'news_and_deals';
		$news_and_deals_category['disable-comments'] = 'no';
		$news_and_deals_category['meta'] = array('date','categories','tags','comments');
				
		$ap_options_demo['ap_categories_manager']['val'] = array($rooms_category,$news_and_deals_category);
		
		$ap_options = $ap_options_demo;
		foreach ( $ap_options_demo as $key => $value ) {
			if ( isset($ap_options[$key]['val'])) {
				$ap_options[$key]['val'] = $value['val'];
			}
		}
		update_option( $ap_theme_name . '_theme_options', $ap_options );
		
		update_option('ah_mail_confirmation_content', 
		"Hello [first-name],<br/><br/>\r\n" .
		"This is to confirm your booking in our hotel.<br/>\r\n" .
		"Please find below all the details of your booking:<br/>\r\n" .
		"Room type: [room]<br/>\r\n" .
		"Check-in date: [check-in]<br/>\r\n" .
		"Check-out date: [check-out]<br/>\r\n" .
		"Regards,<br/><br/>\r\n" .
		"The hotel manager");
		
		update_option('ah_mail_subject', 'Your reservation' );
		
		update_option('ah_mail_from', 'The Place <info@the-place.com>' );
		
		$room_types = array(
			array(
				'id' => 'single',
				'name' => 'Single room',
				'update' => 'no'
			),
			array(
				'id' => 'double',
				'name' => 'Double room',
				'update' => 'no'
			),
			array(
				'id' => 'deluxe',
				'name' => 'Deluxe suite',
				'update' => 'no'
			)
		);
		update_option('ah_room_types', json_encode($room_types));
		
		$ap_message = 'Demo options loaded.';
	}

	if ( isset($_REQUEST['aurel-panel-action']) && ($_REQUEST['aurel-panel-action'] == 'load_widgets') && check_admin_referer('aurelien-panel') && current_user_can('edit_theme_options') ) {
		
		$sidebars_widgets = array (
			'wp_inactive_widgets' => array(),
			'default_sidebar' => array(),
			'top' => array(),
			'footer_1' => array( 1 => 'nav_menu-0' ),
			'footer_2' => array( 1 => 'ap_category_posts-0', 2 => 'ap_category_posts-1' ),
			'footer_3' => array( 1 => 'text-2', 2 => 'ap_social_widget-2' ),
			'footer_4' => array( 1 => 'ap_gallery_widget-2' ),
			'rooms' => array( 1 => 'nav_menu-1', 2 => 'text-3' ),
			'single_room' => array( 1 => 'text-4', 2 => 'nav_menu-2', 3 => 'text-5' ),
			//'layouts' => array( 1 => 'nav_menu-3'),
			//'features' => array( 1 => 'nav_menu-4'),
			'news_and_deals' => array ( 1 => 'ap_category_posts-0', 2 => 'text-6' ),
			'array_version' => 3
		);
		$widget_nav_menu = array (
			0 => array (
				'title' => 'Navigation',
				'nav_menu' => 14
			),
			1 => array (
				'title' => 'Our rooms',
				'nav_menu' => 12
			),
			2 => array (
				'title' => 'Our rooms',
				'nav_menu' => 12
			),
			/*3 => array (
				'title' => 'Layout menu',
				'nav_menu' => 13
			),
			4 => array (
				'title' => 'Features menu',
				'nav_menu' => 11
			)*/
			'_multiwidget' => 1
		);
		$widget_ap_category_posts = array (
			0 => array (
				'title' => 'News and Deals',
				'category' => 'news-and-deals',
				'max' => ''
			),
			1 => array (
				'title' => 'Rooms',
				'category' => 'rooms',
				'max' => ''
			),
			2 => array (
				'title' => 'News and Deals',
				'category' => 'news-and-deals',
				'max' => ''
			),
			'_multiwidget' => 1
		);
		$widget_ap_social_widget = unserialize( 'a:2:{i:2;a:76:{s:5:"title";s:9:"Follow us";s:3:"aim";s:0:"";s:5:"apple";s:0:"";s:4:"bebo";s:0:"";s:7:"blogger";s:0:"";s:10:"brightkite";s:0:"";s:5:"cargo";s:0:"";s:9:"delicious";s:0:"";s:11:"designfloat";s:0:"";s:9:"designmoo";s:0:"";s:10:"deviantart";s:0:"";s:4:"digg";s:0:"";s:8:"digg_alt";s:0:"";s:6:"dopplr";s:0:"";s:8:"dribbble";s:0:"";s:5:"email";s:0:"";s:5:"ember";s:0:"";s:8:"evernote";s:0:"";s:8:"facebook";s:19:"http://facebook.com";s:6:"flickr";s:0:"";s:6:"forrst";s:0:"";s:10:"friendfeed";s:0:"";s:8:"gamespot";s:0:"";s:6:"google";s:0:"";s:11:"google_plus";s:17:"http://google.com";s:12:"google_voice";s:0:"";s:11:"google_wave";s:0:"";s:10:"googletalk";s:0:"";s:7:"gowalla";s:0:"";s:11:"grooveshark";s:0:"";s:5:"ilike";s:0:"";s:17:"komodomedia_azure";s:0:"";s:16:"komodomedia_wood";s:0:"";s:6:"lastfm";s:0:"";s:8:"linkedin";s:0:"";s:4:"mixx";s:0:"";s:8:"mobileme";s:0:"";s:9:"mynameise";s:0:"";s:7:"myspace";s:0:"";s:8:"netvibes";s:0:"";s:8:"newsvine";s:0:"";s:6:"openid";s:0:"";s:5:"orkut";s:0:"";s:7:"pandora";s:0:"";s:6:"paypal";s:0:"";s:6:"picasa";s:0:"";s:8:"pinboard";s:0:"";s:11:"playstation";s:0:"";s:5:"plurk";s:0:"";s:9:"posterous";s:0:"";s:3:"qik";s:0:"";s:4:"rdio";s:0:"";s:10:"readernaut";s:0:"";s:6:"reddit";s:0:"";s:6:"roboto";s:0:"";s:3:"rss";s:0:"";s:9:"sharethis";s:0:"";s:5:"skype";s:0:"";s:8:"slashdot";s:0:"";s:5:"steam";s:0:"";s:11:"stumbleupon";s:0:"";s:10:"technorati";s:0:"";s:6:"tumblr";s:0:"";s:7:"twitter";s:18:"http://twitter.com";s:7:"viddler";s:0:"";s:5:"vimeo";s:0:"";s:4:"virb";s:0:"";s:7:"windows";s:0:"";s:9:"wordpress";s:0:"";s:5:"xanga";s:0:"";s:4:"xing";s:0:"";s:5:"yahoo";s:0:"";s:9:"yahoobuzz";s:0:"";s:4:"yelp";s:0:"";s:7:"youtube";s:18:"http://youtube.com";s:7:"zootool";s:0:"";}s:12:"_multiwidget";i:1;}' );
		$widget_text = array (
			2 => array (
				'title' => 'Contact details',
				'text' => 'The Place Hotel<br/>St Stephens Green<br/>Dublin, Ireland<br/>Phone: +353 (0)87 9326 988',
				'filter' => false
			),
			3 => array (
				'title' => 'Book a room',
				'text' => '[contact-form-7 id="789" title="Reservation form for sidebar"]',
				'filter' => false
			),
			4 => array (
				'title' => 'Custom sidebar',
				'text' => 'This is a custom sidebar for the Single room.',
				'filter' => false
			),
			5 => array (
				'title' => 'Book a Single room',
				'text' => '[contact-form-7 id="1243" title="Reservation form for Single Room"]',
				'filter' => false
			),
			6 => array (
				'title' => 'Book a room',
				'text' => '[contact-form-7 id="789" title="Reservation form for sidebar"]',
				'filter' => false
			),
			'_multiwidget' => 1
		);
		$widget_ap_gallery_widget = array (
			2 => array (
				'title' => 'Gallery',
				'images' => 'image-1,image-2,image-3,image-2,image-3,image-1',
				'link_text' => '',
				'link_url' => '',
				'link_parameters' => ''
			),
			'_multiwidget' => 1
		);
		update_option('widget_nav_menu', $widget_nav_menu);
		update_option('widget_ap_social_widget', $widget_ap_social_widget);
		update_option('widget_ap_category_posts', $widget_ap_category_posts);
		update_option('widget_text', $widget_text);
		update_option('widget_ap_gallery_widget', $widget_ap_gallery_widget);
		
		update_option('sidebars_widgets', $sidebars_widgets);
		
		$ap_message = 'Demo widgets loaded.';
	}
	
	wp_enqueue_style('ap-style', get_template_directory_uri().'/aurel-panel/css/aurel-panel.css');
	wp_enqueue_style('ap-colorpicker-style', get_template_directory_uri().'/aurel-panel/colorpicker/jquery.miniColors.css');
	wp_enqueue_style('ap-jq-ui-style', get_template_directory_uri().'/aurel-panel/css/jq-ui/jquery-ui.css');
	wp_enqueue_style('thickbox');
	
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-resizable');
	wp_enqueue_script('ap-colorpicker', get_template_directory_uri().'/aurel-panel/colorpicker/jquery.miniColors.min.js');
	wp_enqueue_script('ap-jqform', get_template_directory_uri().'/aurel-panel/js/jquery.form.js');
	wp_enqueue_script('ap-cookies', get_template_directory_uri().'/aurel-panel/js/jquery.gateau.js');
	wp_enqueue_script('ap-script', get_template_directory_uri().'/aurel-panel/js/aurel-panel.js');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('knockout', get_template_directory_uri() . '/aurel-panel/js/knockout-3.1.0.js' );
}
?>