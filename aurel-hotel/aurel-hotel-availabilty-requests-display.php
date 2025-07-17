<?php
require_once( get_template_directory() . '/aurel-hotel/aurel-hotel-functions.php' );
?>

<form id="ah-form-export-data" action="" method="post">
	<input type="hidden" id="ah-selected-resa-for-export" name="ah-selected-resa-for-export" value="none" />
</form>

<div class="wrap">
<h2>Rooms availability and booking requests</h2>

<hr/>

<form id="ah-main-form" method="post" action="#">
<?php
settings_fields( 'ah-requests-settings-group' );
wp_nonce_field( 'ah_nonce_resa_action', 'ah_nonce_resa_action' );
if ( isset($_GET['settings-updated']) ) {
?>
<div id="ah-message" class="ah-updated"><p>Options updated.</p></div>
<?php
}
?>

<?php
add_thickbox();
$select_room_type_options = '';
$divs_room_type_availability = '';
$room_types = get_ah_room_types();
$first = true;
if ( sizeof($room_types) < 1 ) {
?>

<p>At least one type of room should be defined to access the availability calendars.</p>
<input id="ah-calendars-data-new" name="ah_calendars_data_new" type="hidden" value="[]" />

<?php
} else {
	foreach($room_types as $rt) {
		if ( $first ) {
			$first_type_of_room = $rt['name'];
			$first = false;
		} 
		$select_room_type_options .= '<option value="' . $rt['id'] . '">' . $rt['name'] . '</option>';
		$divs_room_type_availability .= '<div id="calendar-' . $rt['id'] . '" class="ah-calendar"></div>';
	}
?>

<h3>Rooms availability</h3>
<p>Select room type
<select id="select-room-type">
	<?php echo( $select_room_type_options ); ?>
</select>
</p>
<!--
<p>
	<a href="#" class="button" id="ah-import-calendar">Import calendar</a>&nbsp;&nbsp;<a href="#" class="button" id="ah-export-calendar">Export calendar</a>
</p>

<p>
	From: 
	<input type="text" />
</p>

<p>
	To: 
	<input type="text" />
</p>

<p>
	<a href="#" class="button-primary" id="ah-import-calendar">Import</a>
</p>
-->
<p>
Select the unavailable nights for the type of room <b id="type-of-room-selected"><?php echo( $first_type_of_room ); ?></b>:
</p>

<div id="ah-calendars">

<div id="ah-calendars">
	<?php 
	echo( $divs_room_type_availability ); 
	$calendars_data = get_ah_calendars_data();
	?>
	<input id="ah-calendars-data-new" name="ah_calendars_data_new" type="hidden" value="<?php echo( htmlspecialchars($calendars_data) ); ?>" />
</div>

<div id="ah-p-save-availability">
	<p>
		<input id="ah-save-availability" type="button" class="button-primary" value="Save Changes" />
	</p>
	<p id="ah-saving-availability-message" class="ah-updated">Saving availability calendar...</p>
	<p id="ah-saved-availability-message" class="ah-updated"></p>
	<p class="clear"></p>
</div>

<?php
}

$date_format = get_option('ah_date_format');
?>

<hr/>

<div id="ah-resa">

<div id="ajax-resa-message" class="ah-updated"></div>
<input type="hidden" id="ah-send-email-for-resa" value="0" />
<input type="hidden" id="ah-date-format" value="<?php echo( $date_format ); ?>" />

<h3>Booking requests</h3>
<style>
	#ah-reservations-list .ah-resa-ok,
	#ah-reservations-list .ah-resa-ko,
	#ah-reservations-list .ah-resa-email,
	#ah-reservations-list .ah-resa-del,
	#ah-reservations-list .ah-resa-cancel{
		color: transparent;
	}
	
</style>
<table id="ah-reservations-list" class="wp-list-table widefat" cellspacing="0">
	
	<thead>
		<tr>
			<th><input type="checkbox" class="ah-checkbox-resa-all"/></th>
			<th>Status</th>
			<th>Check-in / Check-out</th>
			<th>Other data</th>
			<th>Received on</th>
			<th>Replied on</th>
			<th>Actions</th>
		</tr>
	</thead>
	
	<tfoot>
		<tr>
			<th width="5%"><input type="checkbox" class="ah-checkbox-resa-all"/></th>
			<th width="7%">Status</th>
			<th width="15%">Check-in / Check-out</th>
			<th width="32%">Other data</th>
			<th width="9%">Received on</th>
			<th width="9%">Replied on</th>
			<th width="12%">Actions</th>
		</tr>
	</tfoot>
	
	<tbody>
		<?php 
		$resas = get_option( 'ah_reservations' );
		
		if ( !$resas ) {
			$resas = array();
		}
		foreach( $resas as $i => $resa ) {
			if ( isset( $resa['room_type'] ) && isset( $resa['check_in'] ) && isset( $resa['check_in'] ) ) {
		?>
		<tr data-email="<?php echo( $resa['mail'] ); ?>" data-room-type="<?php echo( $resa['room_type'] ); ?>" data-check-in="<?php echo( $resa['check_in'] ); ?>" data-check-out="<?php echo( $resa['check_out'] ); ?>" data-update-calendar="<?php echo( get_ah_room_update( $resa['room_type'] ) ); ?>" >
			<?php
			} else {
			?>
		<tr data-email="<?php echo( $resa['mail'] ); ?> data-update-calendar="no" >
			<?php
			}
			?>			
			<td>&nbsp;&nbsp;<input type="checkbox" class="ah-checkbox-resa" value="<?php echo( $i ); ?>"/></td>
			<td>
				<div class="ah-status">
				<?php if ( $resa['status'] == 'confirmed' ) { ?>
					<span class="ah-confirmed">confirmed</span>
				<?php } elseif ( $resa['status'] == 'rejected' ) { ?>
					<span class="ah-rejected">rejected</span>
				<?php } else { ?>
					<span style="display: none" class="ah-confirmed">confirmed</span>
					<span style="display: none" class="ah-rejected">rejected</span>
					<span class="ah-pending">pending</span>
				<?php } ?>
				</div>
			</td>
			<td>
				<?php
				if ( !isset( $resa['check_in_check_out'] ) ) {
				?>
					This reservation was made before the introduction of the check-in/check-out option.
				<?php
				} elseif ( $resa['check_in_check_out'] == 'yes' ) {
					if ( $date_format == 'dd-mm-yyyy' ) {
						$check_in = date('d-m-Y', strtotime($resa['check_in']));
						$check_out = date('d-m-Y', strtotime($resa['check_out']));
					} elseif ( $date_format == 'mm-dd-yyyy' ) {
						$check_in = date('m-d-Y', strtotime($resa['check_in']));
						$check_out = date('m-d-Y', strtotime($resa['check_out']));
					} else {
						$check_in = $resa['check_in'];
						$check_out = $resa['check_out'];
					}
				?>
				<b>Check in</b> <br/>
				<?php echo( $check_in ); ?>
				<br/>
				<b>Check out</b> <br/>
				<?php echo( $check_out ); ?>
				<?php
				} else { 
				?>
					No check-in/check-out dates saved for this reservation.
				<?php } ?>
			</td>

			<td>
				<?php
				if ( is_array( $resa['data'] ) ) {
					$sep = '&nbsp;&nbsp;-&nbsp;&nbsp;';
					$data = '';
					foreach ( $resa['data'] as $data_key => $data_value ) {
						if ( ( $data_key[0] != '_' ) && ( $data_key != 'room' ) && ( $data_key != 'check-in' ) && ( $data_key != 'check-out' ) && ( $data_key != 'check-in-formatted' ) && ( $data_key != 'check-out-formatted' ) ) {
							if ( is_array( $data_value ) ) {
								$data .= $sep . ucfirst($data_key) . ': ';
								foreach( $data_value as $v ) {
									$data .= '<b>' . $v . '</b> ';
								}
							} else {
								$data .= $sep . ucfirst($data_key) . ': <b>' . $data_value . '</b>';
							}
						}
					}
					echo( substr( $data, strlen($sep) ) );
				} else {
					echo( str_replace('<br/>', '&nbsp;&nbsp;-&nbsp;&nbsp;', $resa['data']) ); 
				}
				?>
			</td>
			<td>
				<b>
				<?php 
				if ( isset( $resa['received_on'] ) ) {	
					if ( $date_format == 'dd-mm-yyyy' ) {
						echo( date('d-m-Y', strtotime($resa['received_on'])) );
					} elseif ( $date_format == 'mm-dd-yyyy' ) {
						echo( date('m-d-Y', strtotime($resa['received_on'])) );
					} else {
						echo( $resa['received_on'] ); 
					}
				} 
				?>
				</b>
			</td>
			<td> 
				<?php
				$replied_on_formatted = array();
				if ( isset( $resa['replied_on'] ) ) {	
					foreach ( $resa['replied_on'] as $replied_on ) {
						if ( $date_format == 'dd-mm-yyyy' ) {
							$replied_on_formatted[] = date( 'd-m-Y', strtotime( $replied_on ) );
						} elseif ( $date_format == 'mm-dd-yyyy' ) {
							$replied_on_formatted[] = date( 'm-d-Y', strtotime( $replied_on ) );
						} else {
							$replied_on_formatted[] = $replied_on;
						}
					}
				}
				?>
				<b class="ah-replied-on"><?php echo( implode( ', ', $replied_on_formatted ) ); ?></b>
			</td>
			<td>
				<?php if ( ( $resa['status'] == 'confirmed' ) || ( $resa['status'] == 'rejected' ) ) { ?>
					<a href="#" class="ah-resa-del" title="Delete"><?php echo( $i ); ?></a>
				<?php } else { ?>
					<a href="#" class="ah-resa-ok" title="Confirm"><?php echo( $i ); ?></a>
					<a href="#" class="ah-resa-ko" title="Reject"><?php echo( $i ); ?></a>
					<a href="#" class="ah-resa-del" title="Delete"><?php echo( $i ); ?></a>
				<?php } ?>
				<a href="#TB_inline?width=600&height=480&inlineId=ah-send-email-content" class="thickbox ah-resa-email" title="Send email"><?php echo( $i ); ?></a>
			</td>
		</tr>
		<?php
		}
		?>
		
	</tbody>
	
</table>

<br/>
<a id="ah-delete-selected-resa" href="#" class="submitdelete">Delete selected</a>

<br/><br/>
<a id="ah-export-selected-resa" href="#">Export selected</a>

<div id="ah-send-email-content">
     <div>
		<p>
			Send email to: <b id="ah-send-email-to">s3e2@ymail.com</b>
		</p>
		<p>
			Select e-mail template: 
			<?php
			$ah_template_message_list_str = get_option( 'ah_template_message_list' );
			$ah_template_message_list_arr = array_filter( explode( ',', $ah_template_message_list_str ) );
			?>
			<select id="ah_template_message_select">
				<option value="default">Default</option>
				<?php
				foreach ( $ah_template_message_list_arr as $template_message_name ) {
				?>
				<option value="<?php echo( $template_message_name ); ?>"><?php echo( $template_message_name ); ?></option>
				<?php
				}
				?>
			</select>
		</p>
		<?php
		$template_messages_json = get_option( 'ah_template_messages_content' );
		$template_messages_array = json_decode( $template_messages_json, true );
		$template_messages_subjects_json = get_option( 'ah_template_messages_subjects' );
		$template_messages_subjects_array = json_decode( $template_messages_subjects_json, true );
		?>
		<p id="ah-template-message-subjects">
			Subject:<br/>
			<input type="text" name="ah_mail_subject" id="ah_mail_subject" data-value="<?php echo( get_option('ah_mail_subject') ); ?>" size="40" />
			<?php
			foreach ( $ah_template_message_list_arr as $template_message_name ) {
			?>
			<input type="text" size="40" class="ah-template-message-subject" name="ah-template-message-subject-<?php echo( $template_message_name ); ?>" id="ah-template-message-subject-<?php echo( $template_message_name ); ?>" data-value="<?php echo( $template_messages_subjects_array['ah-template-message-subject-' . $template_message_name] ); ?>" />
			<?php
			}
			?>
		</p>
		<p id="ah-template-message-textareas">
			Body:<br/>
			<textarea class="widefat" name="ah_mail_confirmation_content" id="ah_mail_confirmation_content" rows="10" cols="30" data-value="<?php echo( get_option('ah_mail_confirmation_content') ); ?>"></textarea>
			<?php
			foreach ( $ah_template_message_list_arr as $template_message_name ) {
			?>
			<textarea class="widefat ah-template-message-textarea" name="ah-template-message-textarea-<?php echo( $template_message_name ); ?>" id="ah-template-message-textarea-<?php echo( $template_message_name ); ?>" rows="10" cols="30" data-value="<?php echo( $template_messages_array['ah-template-message-textarea-' . $template_message_name] ); ?>"></textarea>
			<?php
			}
			?>
		</p>
		<p id="ah-send-email-action">
			<input type="button" id="ah-ok-send-email" class="button-primary" value="Send e-mail" />
			<input type="button" id="ah-cancel-send-email" class="button" value="Cancel" />
		</p>
		<p id="ah-sending-email-ajaxer" class="ah-ajaxer-for-email">
			Sending email...
		</p>
     </div>
</div>

</div>

</form>

</div><!-- end .wrap -->