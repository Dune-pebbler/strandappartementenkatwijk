jQuery(document).ready(function(jQ){
	
	function suahm() {
		jQ('#ah-message, .ah-ajax-updated').slideUp(1000);
		jQ('#ah-message-top').fadeOut();
	}
	
	setTimeout(suahm, 3000);
	
	jQ('#ah_template_message_select').change(function() {
		jQ('#ah-template-message-textareas textarea').css('display','none');
		jQ('#ah-template-message-subjects input').css('display','none');
		if ( jQ(this).val() == 'default' ) {
			jQ('#ah_mail_confirmation_content').css('display','block');
			jQ('#ah_mail_subject').css('display','block');
			jQ('#ah-delete-template-message').css('display','none');
		} else {
			jQ('#ah-template-message-textarea-' + jQ(this).val()).css('display','block');
			jQ('#ah-template-message-subject-' + jQ(this).val()).css('display','block');
			jQ('#ah-delete-template-message').css('display','inline');
		}
	}).change();
	
});