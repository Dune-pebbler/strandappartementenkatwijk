<?php
require_once( get_template_directory() . '/aurel-hotel/aurel-hotel-functions.php' );
if ( isset( $_POST['ah-action'] ) && ( $_POST['ah-action'] == 'add-room-type' ) ) {
	$new_room = array(
		'id' => stripslashes( $_POST['ah-room-type-slug'] ),
		'name' => stripslashes( $_POST['ah-room-type-name'] ),
		'update' => 'no',
		'check-in-day' => 'none',
		'check-out-day' => 'none'
	);
	$room_types = get_ah_room_types();
	array_unshift($room_types, $new_room);
	update_option( 'ah_room_types', json_encode( $room_types ) );
}
?>

<div class="wrap">

<div id="ah-page-title">
	<h2>Room types</h2>
	<p id="ah-save-changes">
		<input id="ah-save-changes-submit" type="button" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
	<?php
	if ( isset( $_POST['ah-action'] ) && ( $_POST['ah-action'] == 'save' ) && isset( $_POST['ah-room-types'] ) ) {
		update_option( 'ah_room_types', stripslashes( $_POST['ah-room-types'] ) );
	?>
	<div id="ah-message-top" class="ah-updated"><p>Settings have been saved.</p></div>
	<?php
	}
	?>
	<div class="clear"></div>
</div>

<hr/>

<form id="ah-room-types-form" class="ah-form" method="post" action="">

<div id="ah-add-room-types-wrapper">
	<p>
		Id: <input id="ah-room-type-slug" name="ah-room-type-slug" type="text" size="20" value="" />&nbsp;&nbsp;&nbsp;
		Name: <input id="ah-room-type-name" name="ah-room-type-name" type="text" size="20" value="" />&nbsp;&nbsp;&nbsp;
		<input type="button" id="ah-add-room-type" class="button" value="Add room type" />
	</p>
</div>

<div id="ah-room-type-wrapper">

<?php 
$check_in_check_out_day_options = array(
	'none' => 'No specific day',
	'2' => 'Monday',
	'3' => 'Tuesday',
	'4' => 'Wednesday',
	'5' => 'Thursday',
	'6' => 'Friday',
	'7' => 'Saturday',
	'1' => 'Sunday',
);
$room_types = get_ah_room_types();
foreach ( $room_types as $i => $room_type ) {
	?>
	<div class="ah-room-type">
		<a href="#" title="Delete room type" class="ah-room-type-remove"></a>
		<p>
			Room type id: 
			<b class="ah-room-type-slug"><?php echo( $room_type['id'] ); ?></b>
		</p>
		<p class="ah-label-wrapper">
			Room type name:
		</p>
		<p class="ah-input-wrapper">
			<input type="text" class="ah-room-type-name" size="20" value="<?php echo( esc_attr( $room_type['name'] ) ); ?>" />
		</p>
		<p class="ah-label-wrapper">
			Only one room of this type (automatically update the calendars on confirmation):
		</p>
		<p class="ah-input-wrapper">
			<input class="ah-room-type-update" type="radio" name="ah-room-type-update-<?php echo( $i ); ?>" id="ah-room-type-update-yes-<?php echo( $i ); ?>" value="yes" <?php if ( $room_type['update'] == 'yes' ) { echo( 'checked' ); } ?> /> 
			<label for="ah-room-type-update-yes-<?php echo( $i ); ?>">Yes</label> 
			<input class="ah-room-type-update" type="radio" name="ah-room-type-update-<?php echo( $i ); ?>" id="ah-room-type-update-no-<?php echo( $i ); ?>" value="no" <?php if ( $room_type['update'] == 'no' ) { echo( 'checked' ); } ?> /> 
			<label for="ah-room-type-update-no-<?php echo( $i ); ?>">No</label>
		</p>
		<p class="ah-label-wrapper">
			If you want to limit the check-in on a set day of the week, select that day below:
		</p>
		<p class="ah-input-wrapper">
			<select class="ah-room-type-check-in-day">
				<?php
				foreach ( $check_in_check_out_day_options as $op_val => $op_name ) {
					$selected = '';
					if ( $op_val == $room_type['check-in-day'] ) {
						$selected = 'selected';
					}
				?>
				<option value="<?php echo( $op_val ); ?>" <?php echo( $selected ); ?>><?php echo( $op_name ); ?></option>
				<?php
				}
				?>
			</select>
		</p>		
		<p class="ah-label-wrapper">
			If you want to limit the check-out on a set day of the week, select that day below:
		</p>
		<p class="ah-input-wrapper">
			<select class="ah-room-type-check-out-day">
				<?php
				foreach ( $check_in_check_out_day_options as $op_val => $op_name ) {
					$selected = '';
					if ( $op_val == $room_type['check-out-day'] ) {
						$selected = 'selected';
					}
				?>
				<option value="<?php echo( $op_val ); ?>" <?php echo( $selected ); ?>><?php echo( $op_name ); ?></option>
				<?php
				}
				?>
			</select>
		</p>
		<p class="ah-label-wrapper">
			Minimal stay:
		</p>
		<p class="ah-input-wrapper">
			<select class="ah-room-type-minimal-stay">
				<option value="none">No minimal stay</option>
				<?php
				for ( $j = 2; $j < 15; $j++ ) {
					$selected = '';
					if ( $j == $room_type['minimal-stay'] ) {
						$selected = 'selected';
					}
				?>
				<option value="<?php echo( $j ); ?>" <?php echo( $selected ); ?>><?php echo( $j ); ?> nights</option>
				<?php
				}
				?>
			</select>
		</p>
		
	</div>
	<?php
}
?>

</div>

<input type="hidden" id="ah-room-types" name="ah-room-types" value="" />
<input type="hidden" id="ah-action" name="ah-action" value="" />

</form>

</div><!-- end .wrap -->