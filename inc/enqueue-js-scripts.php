<?php
function ap_enqueue_js_scripts() {
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'palace_sliders', get_template_directory_uri() . '/js/sliders.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'palace_rotate', get_template_directory_uri() . '/js/jQueryRotateCompressed.2.1.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/js/jquery.prettyphoto.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'palace_calendar', get_template_directory_uri() . '/js/jquery.datepick.min.js', array('jquery'), '1.0', true );
	$dpl = get_option( 'ah_date_picker_lang' );
	if ($dpl != '') {
		$dpls = explode(',', $dpl);
		foreach( $dpls as $d ) {
			wp_enqueue_script( 'palace_calendar_lang_' . $d, get_template_directory_uri() . '/js/datepicklang/jquery.datepick-' . $d . '.js', array('palace_calendar'), '1.0', true );
		}
	}
	wp_enqueue_script( 'palace_calendar_default_lang', get_template_directory_uri() . '/js/datepicklang/jquery.datepick-' . get_option( 'ah_date_picker_default_lang', 'en-US' ) . '.js', array('palace_calendar'), '1.0', true );
	if ( is_page() || is_single() ) {
		global $wp_query;
		$post_id = $wp_query->post->ID;
		if ( get_post_meta($post_id, 'pm-display-header-map', true) != '' ) {
			wp_enqueue_script( 'palace_map', 'http://maps.googleapis.com/maps/api/js?sensor=false', array(), '1.0', true );	
		}
	}
	wp_enqueue_script( 'palace_functions', get_template_directory_uri() . '/js/palace-functions.js', array('jquery'), '1.0', true );
	wp_localize_script( 'palace_functions', 'thepalacejstext', array( 
		'invaliddate' => __( 'Invalid date.', 'thepalace' ),
		'selectcheckin' => __( 'Select a check-in date.', 'thepalace' ),
		'selectcheckout' => __( 'Select a check-out date.', 'thepalace' ),
		'selectcheckincheckout' => __( 'Select a check-in date and a check-out date.', 'thepalace' ),
		'errorcheckoutbeforecheckin' => __( 'The check-out date must be after the check-in date.', 'thepalace' ),
		'noavailability' => __( 'There is no availability for that type of room at the chosen dates. Please change your selection.', 'thepalace' ),
		'minimalstay' => __( 'We have a minimal stay policy. Please select a later check-out date.', 'thepalace' ),
		'check_in_day_compulsory' => __( 'Please select another check-in date. Check-in day are on a set day of the week ', 'thepalace' ),
		'check_out_day_compulsory' => __( 'Please select another check-out date. Check-out day are on a set day of the week ', 'thepalace' )
	));
}
?>