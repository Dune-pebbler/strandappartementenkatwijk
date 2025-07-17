<div class="wrap">

<div id="ah-page-title">
	<h2>Booking System Settings</h2>
	<p id="ah-save-changes">
		<input id="ah-save-changes-submit" type="button" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
	<?php
	if ( isset($_GET['settings-updated']) ) {
	?>
	<div id="ah-message-top" class="ah-updated"><p>Settings have been saved.</p></div>
	<?php
	}
	?>
	<div class="clear"></div>
</div>

<hr/>

<form id="ah-main-settings-form" class="ah-form" method="post" action="options.php">

<?php
settings_fields( 'ah-main-settings-group' );
?>

<h3>Form id</h3>
<p>
	Enter the id of the form which is used for sending a request of a reservation (if you have several forms separate ids with commas).
</p>
<p>
	<input type="text" name="ah_form_id" size="40" value="<?php echo get_option('ah_form_id'); ?>" />
</p>

<h3>Booking system access</h3>
<p>
	Enter the username of people who can access the booking system (separate username with commas).
</p>
<p>
	<input type="text" name="ah_users_can_access" size="40" value="<?php echo get_option('ah_users_can_access'); ?>" />
</p>

<h3>Message templates</h3>
<?php
$ah_template_message_list_str = get_option( 'ah_template_message_list' );
$ah_template_message_list_arr = array_filter( explode( ',', $ah_template_message_list_str ) );
?>
<input type="hidden" name="ah_template_message_list" id="ah_template_message_list" value="<?php echo( $ah_template_message_list_str ); ?>" />
<p>
	<input type="button" id="ah-add-template-message" class="button" value="Add a template message" />
	<span id="ah-add-template-message-options">
		Enter template name:
		<input type="text" id="ah-template-message-name" />
		<input type="button" id="ah-add-template-message-ok" class="button" value="OK" />
		<input type="button" id="ah-add-template-message-cancel" class="button" value="Cancel" />
	</span>
</p>
<p>
	Select message template
	<select name="ah_template_message_select" id="ah_template_message_select">
		<option value="default">Default</option>
		<?php
		$ah_template_message_select = get_option( 'ah_template_message_select' );
		foreach ( $ah_template_message_list_arr as $template_message_name ) {
			$template_selected = '';
			if ( $template_message_name == $ah_template_message_select ) {
				$template_selected = 'selected';
			}
		?>
		<option value="<?php echo( $template_message_name ); ?>" <?php echo( $template_selected ); ?>><?php echo( $template_message_name ); ?></option>
		<?php
		}
		?>
	</select>
	<input type="button" id="ah-delete-template-message" class="button" value="Delete template message" />
</p>

<div>
	<?php
	$template_messages_json = get_option( 'ah_template_messages_content' );
	$template_messages_array = json_decode( $template_messages_json, true );
	$template_messages_subjects_json = get_option( 'ah_template_messages_subjects' );
	$template_messages_subjects_array = json_decode( $template_messages_subjects_json, true );
	?>
	<input type="hidden" name="ah_template_messages_content" id="ah_template_messages_content" />
	<input type="hidden" name="ah_template_messages_subjects" id="ah_template_messages_subjects" />
	<p><label>Template message subject:</label></p>
	<p id="ah-template-message-subjects">
		<input type="text" name="ah_mail_subject" id="ah_mail_subject" value="<?php echo( get_option('ah_mail_subject') ); ?>" size="40" />
		<?php
		foreach ( $ah_template_message_list_arr as $template_message_name ) {
		?>
		<input type="text" size="40" name="ah-template-message-subject-<?php echo( $template_message_name ); ?>" id="ah-template-message-subject-<?php echo( $template_message_name ); ?>" value="<?php echo( $template_messages_subjects_array['ah-template-message-subject-' . $template_message_name] ); ?>" />
		<?php
		}
		?>
	</p>
	<p><label>Template message body:</label></p>
	<p id="ah-template-message-textareas">
		<textarea class="widefat" name="ah_mail_confirmation_content" id="ah_mail_confirmation_content" rows="10" cols="30"><?php echo( get_option('ah_mail_confirmation_content') ); ?></textarea>
		<?php
		foreach ( $ah_template_message_list_arr as $template_message_name ) {
		?>
		<textarea class="widefat" name="ah-template-message-textarea-<?php echo( $template_message_name ); ?>" id="ah-template-message-textarea-<?php echo( $template_message_name ); ?>" rows="10" cols="30"><?php echo( $template_messages_array['ah-template-message-textarea-' . $template_message_name] ); ?></textarea>
		<?php
		}
		?>
	</p>
</div>

<h3>Message settings</h3>
<div>
	<p><label for="ah_mail_from">"From" e-mail address. This is the address the recipient will see in the <b>from</b> field (insert a complete e-mail address eg. Name &lt;contact@the-palace.com&gt;).</label></p>
	<p><input type="text" name="ah_mail_from" id="ah_mail_from" value="<?php echo( get_option('ah_mail_from') ); ?>" size="40" /></p>
</div>
<div>
	<p><label for="ah_copy_mail_to">"Booking requests" email settings. Add the email addresses (comma separated) of people who will receive a copy of emails sent via the "Booking requests" manager (eg. admin@domain.com, sales@website.com)</label></p>
	<p><input type="text" name="ah_copy_mail_to" id="ah_copy_mail_to" value="<?php echo( get_option('ah_copy_mail_to') ); ?>" size="40" /></p>
</div>

<h3>Miscellaneous</h3>
<div>
	<p>Select a default date format for the date pickers and the Booking System.</p>
	<p>
		<?php $current_date_format = get_option('ah_date_format'); ?>
		<select id="ah_date_format" name="ah_date_format">
			<option value="dd-mm-yyyy" <?php if ( $current_date_format == 'dd-mm-yyyy' ) { echo( 'selected' ); }; ?>>dd-mm-yyyy</option>
			<option value="mm-dd-yyyy" <?php if ( $current_date_format == 'mm-dd-yyyy' ) { echo( 'selected' ); }; ?>>mm-dd-yyyy</option>
			<option value="yyyy-mm-dd" <?php if ( $current_date_format == 'yyyy-mm-dd' ) { echo( 'selected' ); }; ?>>yyyy-mm-dd</option>
		</select>
	<p>
</div>
<?php
$datepick_langs = array(
	'' => '',
	'Afrikaans' => 'af',
	'Albanian' => 'sq',
	'Amharic' => 'am',
	'Arabic' => 'ar',
	'Arabic/Algeria' => 'ar-DZ',
	'Arabic/Egypt' => 'ar-EG',
	'Armenian' => 'hy',
	'Azerbaijani' => 'az',
	'Basque' => 'eu',
	'Bosnian' => 'bs',
	'Bulgarian' => 'bg',
	'Catalan' => 'ca',
	'Chinese Hong Kong' => 'zh-HK',
	'Chinese Simplified' => 'zh-CN',
	'Chinese Traditional' => 'zh-TW',
	'Croatian' => 'hr',
	'Czech' => 'cs',
	'Danish' => 'da',
	'Dutch' => 'nl',
	'Dutch/Belgian' => 'nl-BE',
	'English/Australia' => 'en-AU',
	'English/New Zealand' => 'en-NZ',
	'English/US' => 'en-US',
	'English/UK' => 'en-GB',
	'Esperanto' => 'eo',
	'Estonian' => 'et',
	'Faroese' => 'fo',
	'Farsi/Persian' => 'fa',
	'Finnish' => 'fi',
	'French' => 'fr',
	'French/Swiss' => 'fr-CH',
	'Galician' => 'gl',
	'Georgian' => 'ka',
	'German' => 'de',
	'German/Swiss' => 'de-CH',
	'Greek' => 'el',
	'Gujarati' => 'gu',
	'Hebrew' => 'he',
	'Hungarian' => 'hu',
	'Icelandic' => 'is',
	'Indonesian' => 'id',
	'Italian' => 'it',
	'Japanese' => 'ja',
	'Khmer' => 'km',
	'Korean' => 'ko',
	'Latvian' => 'lv',
	'Lithuanian' => 'lt',
	'Macedonian' => 'mk',
	'Malayalam' => 'ml',
	'Malaysian' => 'ms',
	'Maltese' => 'mt',
	'Montenegrin' => 'me',
	'Montenegrin' => 'me-ME',
	'Norwegian' => 'no',
	'Polish' => 'pl',
	'Portuguese/Brazil' => 'pt-BR',
	'Romanian' => 'ro',
	'Romansh' => 'rm',
	'Russian' => 'ru',
	'Serbian' => 'sr',
	'Serbian' => 'sr-SR',
	'Slovak' => 'sk',
	'Slovenian' => 'sl',
	'Spanish' => 'es',
	'Spanish/Argentina' => 'es-AR',
	'Spanish/Peru' => 'es-PE',
	'Swedish' => 'sv',
	'Tamil' => 'ta',
	'Thai' => 'th',
	'Turkish' => 'tr',
	'Ukrainian' => 'uk',
	'Urdu' => 'ur',
	'Vietnamese' => 'vi'
);
?>
<div>
	<p>Select a default language for the date pickers (leave blank if you want to use American English or the current WordPress language).</p>
	<p>
		<select name="ah_date_picker_default_lang">
			<?php 
			$current_lang = get_option( 'ah_date_picker_default_lang' );
			foreach( $datepick_langs as $key => $value ) { 
				if ( $value == $current_lang ) {
					$selected = ' selected';
				} else {
					$selected ='';
				}
			?>
			<option value="<?php echo( $value ); ?>"<?php echo( $selected ); ?>><?php echo( $key ); ?></option>
			<?php
			}
			?>
		</select>
	</p>
</div>

<div>
	<p>Maximum number of days since the current day that can be shown in the date pickers.</p>
	<p>
		<input type="text" id="ah_date_picker_number_of_days" name="ah_date_picker_number_of_days" value="<?php echo( get_option( 'ah_date_picker_number_of_days', '365' ) ); ?>" />
	</p>
</div>

<div>
	<?php
	$ah_date_picker_strike_unavailable_dates = get_option( 'ah_date_picker_strike_unavailable_dates', 'No' );
	?>
	<p>Add a strikethrough to unavailable dates</p>
	<p>
		<input type="radio" id="ah_date_picker_strike_unavailable_dates_yes" name="ah_date_picker_strike_unavailable_dates" value="Yes" <?php if ( $ah_date_picker_strike_unavailable_dates == 'Yes' ) { echo( 'checked ' ); }; ?>/> <label for="ah_date_picker_strike_unavailable_dates_yes">Yes</label>&nbsp;&nbsp;&nbsp;
		<input type="radio" id="ah_date_picker_strike_unavailable_dates_no" name="ah_date_picker_strike_unavailable_dates" value="No" <?php if ( $ah_date_picker_strike_unavailable_dates == 'No' ) { echo( 'checked ' ); }; ?>/> <label for="ah_date_picker_strike_unavailable_dates_no">No</label>
	</p>
</div>

<div>
	<p>Date picker options (advanced settings).</p>
	<p>
	<input type="text" name="ah_date_picker_options" size="100" value="<?php echo get_option('ah_date_picker_options'); ?>" />
	</p>
</div>

<br/>
<hr/>

<p>
	<input id="ah-save-changes-submit-bis" type="button" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>

</div>