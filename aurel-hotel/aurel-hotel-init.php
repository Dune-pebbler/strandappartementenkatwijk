<?php

add_action('admin_menu', 'add_aurel_hotel_admin_in_menu');

function current_user_can_manage_hotel() {
	global $current_user;
	$users_can_access = explode(',', get_option('ah_users_can_access'));
	for ($i=0; $i<sizeof($users_can_access); $i++) {
		$users_can_access[$i] = trim($users_can_access[$i]);
	}
	get_currentuserinfo();
	return in_array($current_user->user_login, $users_can_access);
}

function add_aurel_hotel_admin_in_menu() {
	global $ap_options;
	if ( $ap_options['ap_activate_hotel']['val'] == 'yes' ) {
		if ( current_user_can('edit_theme_options') || current_user_can_manage_hotel() ) {
			$page = add_menu_page('Booking System', 'Booking System', 'read', 'aurel_hotel_admin', 'aurel_hotel_admin_display');
			$page_availability_and_requests = add_submenu_page( 'aurel_hotel_admin', 'Availabilty and requests', 'Availabilty and requests', 'read', 'aurel_hotel_admin', 'aurel_hotel_admin_display' );
			$page_room_types = add_submenu_page( 'aurel_hotel_admin', 'Room types', 'Room types', 'read', 'aurel_hotel_room_types', 'aurel_hotel_room_types_display' );
			add_action('admin_print_styles-' . $page, 'aurel_hotel_admin_init');
			add_action('admin_print_styles-' . $page_room_types, 'aurel_hotel_room_types_init');
		}
		if ( current_user_can('edit_theme_options') ) {
			$page_settings = add_submenu_page( 'aurel_hotel_admin', 'Booking System Settings', 'Settings', 'read', 'aurel_hotel_configuration', 'aurel_hotel_settings_display' );
			add_action('admin_print_styles-' . $page_settings, 'aurel_hotel_settings_init');
		}
	}
}

function aurel_hotel_admin_init() {
	wp_enqueue_style('ah-common-style', get_template_directory_uri().'/aurel-hotel/aurel-hotel-common.css');
	wp_enqueue_style('ah-availabilty-requests-style', get_template_directory_uri().'/aurel-hotel/aurel-hotel-availabilty-requests.css');
	wp_enqueue_style('ah-date-style', get_template_directory_uri().'/aurel-hotel/jquery.datepick.css');
	//wp_enqueue_script('ah-date-script', get_template_directory_uri().'/js/jquery.datepick.min.js');
	wp_enqueue_script('ah-date-script', get_template_directory_uri().'/aurel-hotel/jquery.datepick.js');
	wp_enqueue_script('ah-availabilty-requests-script', get_template_directory_uri().'/aurel-hotel/aurel-hotel-availabilty-requests.js');
	wp_enqueue_script('ah-common-script', get_template_directory_uri().'/aurel-hotel/aurel-hotel-common.js');
}

function aurel_hotel_room_types_init() {
	wp_enqueue_style('ah-common-style', get_template_directory_uri().'/aurel-hotel/aurel-hotel-common.css');
	wp_enqueue_style('ah-room-types-style', get_template_directory_uri().'/aurel-hotel/aurel-hotel-room-types.css');
	wp_enqueue_script('ah-room-types-script', get_template_directory_uri().'/aurel-hotel/aurel-hotel-room-types.js');
	wp_enqueue_script('ah-common-script', get_template_directory_uri().'/aurel-hotel/aurel-hotel-common.js');
	wp_enqueue_script('jquery-ui-sortable');
}

function aurel_hotel_settings_init() {
	wp_enqueue_style('ah-common-style', get_template_directory_uri().'/aurel-hotel/aurel-hotel-common.css');
	wp_enqueue_style('ah-settings-style', get_template_directory_uri().'/aurel-hotel/aurel-hotel-settings.css');
	wp_enqueue_script('ah-common-script', get_template_directory_uri().'/aurel-hotel/aurel-hotel-common.js');
	wp_enqueue_script('ah-settings-script', get_template_directory_uri().'/aurel-hotel/aurel-hotel-settings.js');
}

function aurel_hotel_admin_display() {
	if (current_user_can('edit_theme_options') || current_user_can_manage_hotel() ) {
		require_once( get_template_directory() . '/aurel-hotel/aurel-hotel-availabilty-requests-display.php' );
	}
}

function aurel_hotel_room_types_display() {
	if (current_user_can('edit_theme_options') || current_user_can_manage_hotel() ) {
		require_once( get_template_directory() . '/aurel-hotel/aurel-hotel-room-types-display.php' );
	}
}

function aurel_hotel_settings_display() {
	if ( current_user_can('edit_theme_options') ) {
		require_once( get_template_directory() . '/aurel-hotel/aurel-hotel-settings-display.php' );
	}
}

function register_aurel_hotel_main_settings() {
	register_setting( 'ah-main-settings-group', 'ah_form_id' );
	register_setting( 'ah-main-settings-group', 'ah_date_picker_options' );
	register_setting( 'ah-main-settings-group', 'ah_date_picker_strike_unavailable_dates' );
	register_setting( 'ah-main-settings-group', 'ah_date_format' );
	register_setting( 'ah-main-settings-group', 'ah_date_picker_number_of_days' );
	register_setting( 'ah-main-settings-group', 'ah_date_picker_lang' );
	register_setting( 'ah-main-settings-group', 'ah_users_can_access' );
	register_setting( 'ah-main-settings-group', 'ah_date_picker_default_lang' );
	register_setting( 'ah-main-settings-group', 'ah_mail_from' );
	register_setting( 'ah-main-settings-group', 'ah_copy_mail_to' );
	register_setting( 'ah-main-settings-group', 'ah_mail_subject' );
	register_setting( 'ah-main-settings-group', 'ah_mail_confirmation_content' );
	register_setting( 'ah-main-settings-group', 'ah_template_message_select' );
	register_setting( 'ah-main-settings-group', 'ah_template_message_list' );
	register_setting( 'ah-main-settings-group', 'ah_template_messages_content' );
	register_setting( 'ah-main-settings-group', 'ah_template_messages_subjects' );
}

function register_aurel_hotel_requests_settings() {
	register_setting( 'ah-requests-settings-group', 'ah_calendars_data_new' );
}

add_action( 'admin_init', 'register_aurel_hotel_main_settings' );

add_action( 'admin_init', 'register_aurel_hotel_requests_settings' );

function remove_non_utf8_char( $str ) {
	$str = preg_replace('/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
	'|[\x00-\x7F][\x80-\xBF]+'.
	'|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
	'|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
	'|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
	'?', $str );
 
	$str = preg_replace('/\xE0[\x80-\x9F][\x80-\xBF]'.
	'|\xED[\xA0-\xBF][\x80-\xBF]/S','?', $str );
	
	return $str;
}

function save_reservation( $form ) {
	$form_id = $form->id();
	//$form_id = $form->id;
	if ( in_array( $form_id, explode(',', get_option('ah_form_id'))) ) {
		$data = array();
		$submission = WPCF7_Submission::get_instance();
		if ( $submission ) {
			$data = $submission->get_posted_data();
		}
		//$data = $form->posted_data;
		$check_in_check_out = '';
		$exists_date_check_in = false;
		$exists_date_check_out = false;
		$mail = '';
		$date_format = '';
		$check_in = '';
		$check_out = '';
		$room_type = '';
		foreach ( $data as $data_key => $data_value ) {	
			$data_value = remove_non_utf8_char( $data_value );
			$data[$data_key] = $data_value;
			if ( $data_key == 'check-in-formatted' ) {
				$exists_date_check_in = true;
				$check_in = $data_value;
			}
			if ( $data_key == 'check-out-formatted' ) {
				$exists_date_check_out = true;
				$check_out = $data_value;
			}
			if ( $data_key == 'room' ) {
				$room_type = $data_value;
			}
			if ( is_string($data_value) && is_email($data_value) && ($mail == '') ) {
				$mail = $data_value;
			}
		}
		if ( $exists_date_check_in && $exists_date_check_out ) {
			$check_in_check_out = 'yes';
		}
		$reservations = get_option('ah_reservations');
		if ( ! $reservations ) {
			$reservations = array();
		}
		array_unshift( $reservations, array( 
			'status' => 'pending', 
			'check_in_check_out' => $check_in_check_out, 
			'check_in' => $check_in, 
			'check_out' => $check_out, 
			'received_on' => substr(current_time('mysql'),0,10), 
			'replied_on' => array(),
			'mail' => $mail, 
			'room_type' => $room_type, 
			'data' => $data 
		) );
		update_option( 'ah_reservations', $reservations );
	}
	
}

add_action('wpcf7_before_send_mail', 'save_reservation');

function ah_confirm_resa() {
	if ( wp_verify_nonce( $_POST['nonce'], 'ah_nonce_resa_action' ) && (current_user_can('edit_theme_options') || current_user_can_manage_hotel()) ) {
		$resas = get_option( 'ah_reservations' );
		$resa = $resas[$_POST['id']];
		require_once( get_template_directory() . '/aurel-hotel/aurel-hotel-functions.php' );
		$room_types = get_ah_room_types();
		if ( get_ah_room_update( $resa['room_type'] ) == 'yes' ) {
			$calendars_data = json_decode( get_ah_calendars_data(), true );
			$current_dates = $calendars_data['calendar-' . $resa['room_type']];
			$resa_dates = array();
			$check_in = date('Y-m-d', strtotime($resa['check_in']));
			$check_out = date('Y-m-d', strtotime($resa['check_out']));
			$ci = $check_in;
			while ( $ci != $check_out ) {
				$resa_dates[] = $ci;
				$ci = date('Y-m-d', strtotime($ci . ' + 1 day'));
			}
			if ( $current_dates === NULL ) {
				$current_dates = array();
			}
			$calendars_data['calendar-' . $resa['room_type']] = array_merge( $current_dates, $resa_dates);
			update_option( 'ah_calendars_data_new', json_encode( $calendars_data ) );
		}
		$resa['status'] = 'confirmed';
		$resas[$_POST['id']] = $resa;
		update_option( 'ah_reservations', $resas );
		echo( 'Database updated.' );
	}
	die();
}

function ah_reject_resa() {
	if ( wp_verify_nonce( $_POST['nonce'], 'ah_nonce_resa_action' ) && (current_user_can('edit_theme_options') || current_user_can_manage_hotel()) ) {
		$resas = get_option( 'ah_reservations' );
		$resa = $resas[$_POST['id']];
		$resa['status'] = 'rejected';
		$resas[$_POST['id']] = $resa;
		update_option( 'ah_reservations', $resas );
		echo( 'Database updated.' );
	}
	die();
}

function ah_delete_resa() {
	if ( wp_verify_nonce( $_POST['nonce'], 'ah_nonce_resa_action' ) && (current_user_can('edit_theme_options') || current_user_can_manage_hotel()) ) {
		$ids = explode(',', $_POST['ids']);
		$resas = get_option( 'ah_reservations' );
		foreach ( $ids as $id ) {
			unset($resas[$id]);
		}
		$resas = array_values($resas);
		update_option( 'ah_reservations', $resas );
		echo( 'Deleted.' );
	}
	die();
}

function ah_send_email() {
	if ( wp_verify_nonce( $_POST['nonce'], 'ah_nonce_resa_action' ) && (current_user_can('edit_theme_options') || current_user_can_manage_hotel()) ) {
		$resas = get_option( 'ah_reservations' );
		$resa = $resas[$_POST['id']];
		require_once( get_template_directory() . '/aurel-hotel/aurel-hotel-functions.php' );
		$headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\n";
		$mail_from = get_option( 'ah_mail_from' );
		if ( $mail_from != '' ) {
			$headers .= 'From: ' . $mail_from . "\r\n";
		}
		$message = stripslashes( $_POST['message'] );
		$subject = stripslashes( $_POST['subject'] );
		foreach ( $resa['data'] as $data_key => $data_value ) {
			$data = '';
			if ( is_array( $data_value ) ) {
				$data = implode(',', $data_value);
			} else if ( $data_key == 'room' ) {
				$data = get_ah_room_name( $data_value );
			} else {
				$data = $data_value;
			}
			$message = str_replace('[' . $data_key . ']', $data, $message);
		}
		if ( wp_mail( $resa['mail'], $subject, $message, $headers ) ) {
			$send_copy_to = get_option( 'ah_copy_mail_to' );
			if ( $send_copy_to != '' ) {
				$send_copy_to = explode( ',', $send_copy_to );
				$message = 'Here is a copy of the email sent to ' . $resa['mail'] . ' from your website.<br/>----------<br/>' . $message;
				$subject = 'Reservation message copy';
				foreach ( $send_copy_to as $cc_email ) {
					wp_mail( trim( $cc_email ), $subject, $message, $headers );
				}
			}
			$today_reply = substr( current_time( 'mysql' ), 0, 10 );
			$resa['replied_on'][] = $today_reply;
			$resas[$_POST['id']] = $resa;
			update_option( 'ah_reservations', $resas );
			echo( 'E-mail sent.' );
		} else {
			echo( 'Error. E-mail not sent. ' );
			global $phpmailer;
			echo( $phpmailer->ErrorInfo );
		}
	}
	die();
}

function ah_save_data() {
	if ( wp_verify_nonce( $_POST['nonce'], 'ah_nonce_resa_action' ) && (current_user_can('edit_theme_options') || current_user_can_manage_hotel()) ) {
		update_option( 'ah_calendars_data_new', stripslashes($_POST['ah_calendars_data_new']) );
		$options_to_save = array('ah_confirmation_mail', 'ah_rejection_mail', 'ah_mail_confirmation_content', 'ah_mail_refusal_content', 'ah_mail_from', 'ah_mail_subject');
		foreach( $options_to_save as $op ) {
			update_option($op, $_POST[$op]);
		}		
		echo( '<p>Data saved.</p>' );
	}
	die();
}

function ah_save_availability_calendar() {
	if ( wp_verify_nonce( $_POST['nonce'], 'ah_nonce_resa_action' ) && ( current_user_can('edit_theme_options') || current_user_can_manage_hotel()) ) {
		update_option( 'ah_calendars_data_new', stripslashes($_POST['ah_calendars_data_new']) );
		echo( 'Availability calendar saved.' );
	}
	die();
}

add_action('wp_ajax_ah_confirm_resa', 'ah_confirm_resa');
add_action('wp_ajax_ah_reject_resa', 'ah_reject_resa');
add_action('wp_ajax_ah_delete_resa', 'ah_delete_resa');
add_action('wp_ajax_ah_send_email', 'ah_send_email');
add_action('wp_ajax_ah_save_data', 'ah_save_data');
add_action('wp_ajax_ah_save_availability_calendar', 'ah_save_availability_calendar');

function ah_export() {
	if ( isset( $_POST['ah-selected-resa-for-export'] ) && ( $_POST['ah-selected-resa-for-export'] != 'none' ) ) {
		$resas = get_option( 'ah_reservations' );
		$key_to_export = array( 'check_in', 'check_out', 'room_type', 'first-name', 'last-name', 'mail', 'received_on' );
		header( 'Content-Description: File Transfer' );
		header( 'Content-Disposition: attachment; filename=bookings.csv' );
		header( 'Content-Type: text/csv; charset=' . get_option( 'blog_charset' ), true );
		echo( "Check-in date,Check-out date,Room type,First name,Last name,Email,Received on\n" );
		$ids = explode( ',', $_POST['ah-selected-resa-for-export'] );
		foreach ( $ids as $id ) {
			$resa = $resas[$id];
			echo( $resa['check_in'] . ',' );
			echo( $resa['check_out'] . ',' );
			echo( $resa['room_type'] . ',' );
			echo( $resa['data']['first-name'] . ',' );
			echo( $resa['data']['last-name'] . ',' );
			echo( $resa['mail'] . ',' );
			echo( $resa['received_on'] );
			echo( "\n" );
		}
		die();
	}
}

add_action( 'init', 'ah_export' );
?>