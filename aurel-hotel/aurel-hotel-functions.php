<?php
function get_ah_room_types() {
	$room_types = get_option('ah_room_types');
	if ( $room_types ) {
		return json_decode( $room_types, true );
	} else {
		$room_types = array();
		$rtslugs = get_option('ah_room_type_slugs');
		$rtnames = get_option('ah_room_type_names');
		if ( $rtslugs ) {
			$rtslugs = explode(',', $rtslugs);
			$rtnames = explode(',', $rtnames);
			foreach ( $rtslugs as $i => $rtslug ) {
				$room_types[$i] = array (
					'id' => $rtslug,
					'name' => $rtnames[$i],
					'update' => 'no'
				);
			}
		}
		return $room_types;
	}
}

function get_ah_room( $id ) {
	$room_types = get_ah_room_types();
	$room = array();
	$find = false;
	$i = 0;
	while ( !$find ) {
		if ( $room_types[$i]['id'] == $id ) {
			$find = true;
			$room = $room_types[$i];
		} else {
			$i++;
		}
		if ( $i >= sizeof($room_types) ) {
			return false;
		}
	}
	return $room;
}

function get_ah_room_name( $id ) {
	$room = get_ah_room( $id );
	if ( ! $room ) {
		return $id;
	} else {
		return $room['name'];
	}
}

function get_ah_room_update( $id ) {
	$room = get_ah_room( $id );
	return $room['update'];
}

function get_ah_calendars_data() {
	$calendars_data = get_option('ah_calendars_data_new');
	if ( $calendars_data ) {
		return $calendars_data;
	} else {
		$calendars_data = get_option( 'ah_calendars_data' );
		$date_format = get_option('ah_date_format');
		if ( $calendars_data == '' ) {
			return '[]';
		}
		if ( $date_format == 'yyyy-mm-dd' ) {
			return $calendars_data;
		}
		$calendars_data = json_decode( $calendars_data, true );
		$calendars_data_new = array();
		foreach( $calendars_data as $id => $calendar_data ) {
			$dates = array();
			foreach ( $calendar_data as $date ) {
				if ( $date_format == 'dd-mm-yyyy' ) {
					$dates[] = substr($date,6,4) . '-' . substr($date,3,2) . '-' . substr($date,0,2);
				}elseif ( $date_format == 'mm-dd-yyyy' ) {
					$dates[] = substr($date,6,4) . '-' . substr($date,0,2) . '-' . substr($date,3,2);
				}
			}
			$calendars_data_new[$id] = $dates;
		}		
	}
	return json_encode( $calendars_data_new );
}