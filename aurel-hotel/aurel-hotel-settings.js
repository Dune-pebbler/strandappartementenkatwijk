jQuery(document).ready(function(jQ){

	jQ('#ah-add-template-message').click(function() {
		jQ('#ah-add-template-message-options').css('display','inline');
		jQ(this).css('display','none');
	});
	
	jQ('#ah-add-template-message-cancel').click(function() {
		jQ('#ah-add-template-message-options').css('display','none');
		jQ('#ah-add-template-message').css('display','inline');
	});
	
	jQ('#ah-add-template-message-ok').click(function() {
		var m_name = jQ('#ah-template-message-name').val();
		if ( /^\w+$/.test( m_name ) ) {
			var list = jQ('#ah_template_message_list').val();
			if ( list == '' ) {
				jQ('#ah_template_message_list').val(m_name);
			} else {
				jQ('#ah_template_message_list').val( list + ',' + m_name );
			}
			jQ('#ah-add-template-message-options').css('display','none');
			jQ('#ah-add-template-message').css('display','inline');
			jQ('#ah-delete-template-message').css('display','inline');
			jQ('#ah_template_message_select').append('<option value=' + m_name + '>' + m_name + '</option>');
			jQ('#ah_template_message_select option:last').prop('selected', true);
			jQ('#ah-template-message-textareas').append('<textarea class="widefat" id="ah-template-message-textarea-' + m_name + '" rows="10" cols="30"></textarea>');
			jQ('#ah-template-message-subjects').append('<input type="text" size="40" id="ah-template-message-subject-' + m_name + '" value="" />');
			jQ('#ah_template_message_select').change();
		} else {
			alert('Please enter a correct id (the id can only contain letters, numbers, and underscores).');
		}
	});
	
	jQ('#ah-delete-template-message').click(function() {
		var ts = jQ('#ah_template_message_select').val();
		if ( confirm('Delete the message template ' + ts +'?') ) {
			jQ('#ah_template_message_select option:selected').remove();
			var list = jQ('#ah_template_message_list').val();
			list = list.replace(ts,'');
			jQ('#ah_template_message_list').val(list);
			jQ('#ah_template_message_select').change();
		}
	});
	
	if ( jQ('#ah_template_message_select').val() == 'default' ) {
		jQ('#ah-delete-template-message').css('display','none');
	}
	
	function prepare_message_templates() {
		var mts = {};
		jQ('#ah-template-message-textareas textarea').each(function() {
			mts[jQ(this).attr('id')] = jQ(this).val();
		});
		jQ('#ah_template_messages_content').val(JSON.stringify(mts));
		var mtsubjects = {};
		jQ('#ah-template-message-subjects input').each(function() {
			mtsubjects[jQ(this).attr('id')] = jQ(this).val();
		});
		jQ('#ah_template_messages_subjects').val(JSON.stringify(mtsubjects));
	}
	
	jQ('#ah-save-changes-submit, #ah-save-changes-submit-bis').click(function() {
		prepare_message_templates();
		jQ('.ah-form').submit();
	});
	
	if ( ( jQ('#ah_mail_confirmation_content').val() != '' ) && ( jQ('#ah_mail_confirmation_content').val().indexOf('[booking-data]') >= 0 ) ) {
		alert('Please note that the since the version 1.6 of the theme the [booking-data] shortcode is no longer valid. Please replace it with the Contact form 7 shortcodes (examples: [room], [check-in]...)');
	}
	
});