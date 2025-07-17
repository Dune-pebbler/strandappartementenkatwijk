jQuery(document).ready(function (jQ) {

	var ahcdl = JSON.parse(jQ('#ah-calendars-data-new').val());
	let calendars = [];
	// jQ('.ah-calendar').datepick({
	// 	monthsToShow: [2, 6],
	// 	monthsToStep: 6, 
	// 	defaultDate: '2014-01-01',
	// 	minDate: new Date(2014, 1 - 1, 1), 
	// 	prevText: 'Prev months', 
	// 	nextText: 'Next months',
	// 	changeMonth: false,
	// 	firstDay: 1,
	// 	useMouseWheel: false,
	// 	multiSelect: 99999,
	// 	dateFormat: 'yyyy-mm-dd',
	// 	renderer: jQ.extend({}, jQ.datepick.defaultRenderer, 
	//     {picker: jQ.datepick.defaultRenderer.picker.replace(/\{link:today\}/, '')})
	// });
	// we loop through all the calendars.
	jQ('.ah-calendar').each(function (i, e) {
		let inputQuery = '<input type="hidden" name="ah-calendar-fake-input-' + i + '"/>';
		// create input.
		jQuery(this).append(inputQuery);

		let flatpickr = calendars[i] = jQuery("[name=ah-calendar-fake-input-" + i + "]").flatpickr({
			changeMonth: false,
			firstDay: 1,
			useMouseWheel: false,
			mode: 'multiple',
			dateFormat: 'Y-m-d',
			renderer: jQ.extend({}, jQ.datepick.defaultRenderer,
				{ picker: jQ.datepick.defaultRenderer.picker.replace(/\{link:today\}/, '') }),
			inline: true,
		});

		flatpickr.setDate(ahcdl[jQ(this).attr('id')]);

		jQuery("[name=ah-calendar-fake-input-" + i + "]").hide();
	})

	jQ('.ah-calendar').each(function () {
		// jQ(this).datepick('setDate', ahcdl[jQ(this).attr('id')]);
	});

	jQ('#select-room-type').change(function () {
		jQ('.ah-calendar').css('display', 'none');
		jQ('#calendar-' + jQ(this).val()).fadeIn(1000);
		jQ('#type-of-room-selected').html(jQ(this).find('option:selected').text());
	});

	function prepare_calendars_data() {
		var ahcd = {};
		var dateFormat = 'YYYY-MM-DD';
		jQ('.ah-calendar').each(function (i, e) {
			var ds = calendars[i].selectedDates;
			var dsa = ds.map(function (item) {
				return moment(item).format(dateFormat)
				// return calendars[i].formatDate(ds[i], dateFormat);
			});
			ahcd[jQ(this).attr('id')] = dsa;
		});
		jQ('#ah-calendars-data-new').val(JSON.stringify(ahcd));
	}

	jQ('#ah-main-form').submit(function (event) {
		prepare_calendars_data();
	});

	var timer_fadeout_ajax_message = 'no_timer';

	function fadeout_ajax_message() {
		jQ('#ajax-resa-message').fadeOut();
	}

	jQ('.ah-resa-ok').click(function () {
		if (timer_fadeout_ajax_message != 'no_timer') {
			window.clearTimeout(timer_fadeout_ajax_message);
		}
		var id = jQ(this).html();
		var send_mail = 1;
		if (jQ('input:radio[name=ah_confirmation_mail]:checked').val() == 'yes') {
			jQ('#ajax-resa-message').html('<span class="ah-ajaxer">Sending email and updating database...</span>');
		} else {
			jQ('#ajax-resa-message').html('<span class="ah-ajaxer">Updating database...</span>');
			send_mail = 0;
		}
		jQ('#ajax-resa-message').fadeIn();
		var data = {
			action: 'ah_confirm_resa',
			nonce: jQ('#ah_nonce_resa_action').val(),
			id: id,
			send_mail: send_mail,
			message: jQ('#ah_mail_confirmation_content').val()
		};
		jQ.post(ajaxurl, data, function (response) {
			if (response.indexOf('Error') == -1) {
				id = parseInt(id) + 2;
				var current_tr = jQ('#ah-reservations-list').find('tr').eq(id);
				if (current_tr.data('update-calendar') == 'yes') {
					var room_type = current_tr.data('room-type');
					var check_in = current_tr.data('check-in');
					var check_out = current_tr.data('check-out');
					chosen_dates = [];
					check_in = jQ.datepick.parseDate('yyyy-mm-dd', check_in);
					check_out = jQ.datepick.parseDate('yyyy-mm-dd', check_out);
					do {
						chosen_dates.push(new Date(check_in.getTime()));
						check_in.setDate(check_in.getDate() + 1);
					} while (check_in < check_out);
					taken_dates = jQ('#calendar-' + room_type).datepick('getDate');
					taken_dates = taken_dates.concat(chosen_dates);
					jQ('#calendar-' + room_type).datepick('setDate', taken_dates);
				}
				current_tr.find('.ah-confirmed').fadeIn();
				current_tr.find('.ah-pending').fadeOut();
				current_tr.find('.ah-resa-ok').fadeOut();
				current_tr.find('.ah-resa-ko').fadeOut();
			}
			jQ('#ajax-resa-message').html(response);
			timer_fadeout_ajax_message = setTimeout(fadeout_ajax_message, 3000);
		});
		return false;
	});

	jQ('.ah-resa-ko').click(function () {
		if (timer_fadeout_ajax_message != 'no_timer') {
			window.clearTimeout(timer_fadeout_ajax_message);
		}
		var id = jQ(this).html();
		var send_mail = 1;
		if (jQ('input:radio[name=ah_rejection_mail]:checked').val() == 'yes') {
			jQ('#ajax-resa-message').html('<span class="ah-ajaxer">Sending email and updating database...</span>');
		} else {
			jQ('#ajax-resa-message').html('<span class="ah-ajaxer">Updating database...</span>');
			send_mail = 0;
		}
		jQ('#ajax-resa-message').fadeIn();
		var data = {
			action: 'ah_reject_resa',
			nonce: jQ('#ah_nonce_resa_action').val(),
			id: id,
			send_mail: send_mail,
			message: jQ('#ah_mail_refusal_content').val()
		};
		jQ.post(ajaxurl, data, function (response) {
			if (response.indexOf('Error') == -1) {
				id = parseInt(id) + 2;
				var current_tr = jQ('#ah-reservations-list').find('tr').eq(id);
				current_tr.find('.ah-rejected').fadeIn();
				current_tr.find('.ah-pending').fadeOut();
				current_tr.find('.ah-resa-ok').fadeOut();
				current_tr.find('.ah-resa-ko').fadeOut();
			}
			jQ('#ajax-resa-message').html(response);
			timer_fadeout_ajax_message = setTimeout(fadeout_ajax_message, 3000);
		});
		return false;
	});

	function renum_resa_after_delete() {
		var i = 0;
		jQ('#ah-reservations-list tbody tr').each(function () {
			jQ(this).find('a').html(i);
			jQ(this).find('.ah-checkbox-resa').val(i);
			i++;
		});
	}

	jQ('.ah-resa-del').click(function () {
		if (confirm('Delete the booking request?')) {
			var id = jQ(this).html();
			if (timer_fadeout_ajax_message != 'no_timer') {
				window.clearTimeout(timer_fadeout_ajax_message);
			}
			jQ('#ajax-resa-message').html('<span class="ah-ajaxer">Deleting...</span>').fadeIn();
			var data = {
				action: 'ah_delete_resa',
				nonce: jQ('#ah_nonce_resa_action').val(),
				ids: id
			};
			jQ.post(ajaxurl, data, function (response) {
				jQ('#ajax-resa-message').html(response).fadeOut(0);
				jQ('#ah-reservations-list tbody tr').eq(id).fadeOut(function () {
					jQ(this).remove();
					renum_resa_after_delete();
				});
			});
		}
		return false;
	});

	jQ('#ah-delete-selected-resa').click(function () {
		if (jQ('.ah-checkbox-resa:checked').length > 0) {
			if (confirm('Delete the booking requests ?')) {
				if (timer_fadeout_ajax_message != 'no_timer') {
					window.clearTimeout(timer_fadeout_ajax_message);
				}
				jQ('#ajax-resa-message').html('<span class="ah-ajaxer">Deleting...</span>').fadeIn();
				var ids = '';
				jQ('.ah-checkbox-resa:checked').each(function () {
					ids = ids + ',' + jQ(this).val();
				});
				ids = ids.substring(1);
				var data = {
					action: 'ah_delete_resa',
					nonce: jQ('#ah_nonce_resa_action').val(),
					ids: ids
				};
				jQ.post(ajaxurl, data, function (response) {
					jQ('#ajax-resa-message').html(response).fadeOut(0);
					ids = ids.split(',');
					var deleted_trs = jQ('#ah-reservations-list tbody tr').filter(function (i) {
						return jQ.inArray(i.toString(), ids) > -1;
					});
					deleted_trs.fadeOut(function () {
						jQ(this).remove();
						renum_resa_after_delete();
					});
				});
			}
		} else {
			alert('No booking requests were selected.');
		}
		return false;
	});

	jQ('.ah-checkbox-resa-all').click(function () {
		if (jQ(this).is(':checked')) {
			jQ('.ah-checkbox-resa').prop('checked', true);
			jQ('.ah-checkbox-resa-all').prop('checked', true);
		} else {
			jQ('.ah-checkbox-resa').prop('checked', false);
			jQ('.ah-checkbox-resa-all').prop('checked', false);
		}
	});

	jQ('.ah-ajax-save').click(function () {
		jQ('.ah-ajax-updated').html('<p>Saving data...</p>');
		jQ('.ah-ajax-updated').css('display', 'block');
		prepare_calendars_data();
		var data = {
			action: 'ah_save_data',
			nonce: jQ('#ah_nonce_resa_action').val(),
			ah_calendars_data_new: jQ('#ah-calendars-data-new').val(),
			ah_confirmation_mail: jQ('input[name=ah_confirmation_mail]:checked').val(),
			ah_rejection_mail: jQ('input[name=ah_rejection_mail]:checked').val(),
			ah_mail_confirmation_content: jQ('#ah_mail_confirmation_content').val(),
			ah_mail_refusal_content: jQ('#ah_mail_refusal_content').val(),
			ah_mail_from: jQ('#ah_mail_from').val(),
			ah_mail_subject: jQ('#ah_mail_subject').val()
		};
		jQ.post(ajaxurl, data, function (response) {
			jQ('.ah-ajax-updated').html(response);
			setTimeout(suahm, 4000);
		});
	});

	jQ('#ah-cancel-send-email').click(function () {
		tb_remove();
		return false;
	});

	jQ('#ah-ok-send-email').click(function () {
		jQ('#ah-send-email-action').css('display', 'none');
		jQ('#ah-sending-email-ajaxer').css('display', 'block');
		var id = jQ('#ah-send-email-for-resa').val();
		var message = '';
		var subject = '';
		var selected_message = jQ('#ah_template_message_select').val();
		if (selected_message == 'default') {
			message = jQ('#ah_mail_confirmation_content').val();
		} else {
			message = jQ('#ah-template-message-textarea-' + selected_message).val();
		}
		if (selected_message == 'default') {
			subject = jQ('#ah_mail_subject').val();
		} else {
			subject = jQ('#ah-template-message-subject-' + selected_message).val();
		}
		var data = {
			action: 'ah_send_email',
			nonce: jQ('#ah_nonce_resa_action').val(),
			id: id,
			subject: subject,
			message: message
		};
		jQ.post(ajaxurl, data, function (response) {
			jQ('#ah-sending-email-ajaxer').html(response).removeClass('ah-ajaxer-for-email');
			if (response.indexOf('Error') == -1) {
				var replied_on = jQ('#ah-reservations-list').find('tr').eq(parseInt(id) + 2).find('.ah-replied-on').html();
				var today = new Date();
				var today_reply = jQ.datepick.formatDate(jQ('#ah-date-format').val(), today);
				if (replied_on == '') {
					replied_on = today_reply;
				} else {
					replied_on = replied_on + ', ' + today_reply;
				}
				jQ('#ah-reservations-list').find('tr').eq(parseInt(id) + 2).find('.ah-replied-on').html(replied_on);
				var timer_tb_remove = setTimeout(tb_remove, 1000);
			}
		});
		return false;
	});

	jQ('.ah-resa-email').click(function () {
		jQ('#ah_mail_subject').val(jQ('#ah_mail_subject').data('value'));
		jQ('.ah-template-message-subject').each(function () {
			jQ(this).val(jQ(this).data('value'));
		});
		jQ('#ah_mail_confirmation_content').val(jQ('#ah_mail_confirmation_content').data('value'));
		jQ('.ah-template-message-textarea').each(function () {
			jQ(this).val(jQ(this).data('value'));
		});
		jQ('#ah-sending-email-ajaxer').html('Sending email...').addClass('ah-ajaxer-for-email').css('display', 'none');
		jQ('#ah-send-email-action').css('display', 'block');
		var id = parseInt(jQ(this).html());
		jQ('#ah-send-email-for-resa').val(id);
		var email = jQ('#ah-reservations-list').find('tr').eq(id + 2).data('email');
		jQ('#ah-send-email-to').html(email);
	});

	var save_availability_timer = 0;

	function fade_out_saved_availability_message() {
		jQ('#ah-saved-availability-message').fadeOut();
	}

	jQ('#ah-save-availability').click(function () {
		prepare_calendars_data();
		jQ('#ah-saved-availability-message').html('');
		clearTimeout(save_availability_timer);
		jQ('#ah-save-availability').prop('disabled', true);
		jQ('#ah-saved-availability-message').css('display', 'none');
		jQ('#ah-saving-availability-message').css('display', 'block');
		var data = {
			action: 'ah_save_availability_calendar',
			nonce: jQ('#ah_nonce_resa_action').val(),
			ah_calendars_data_new: jQ('#ah-calendars-data-new').val()
		}
		jQ.post(ajaxurl, data, function (response) {
			jQ('#ah-saving-availability-message').css('display', 'none');
			jQ('#ah-saved-availability-message').css('display', 'block');
			jQ('#ah-saved-availability-message').html(response);
			jQ('#ah-save-availability').prop('disabled', false);
			save_availability_timer = setTimeout(fade_out_saved_availability_message, 3000);
		});
	});

	jQ('#ah-export-selected-resa').click(function () {
		if (jQ('.ah-checkbox-resa:checked').length > 0) {
			var ids = '';
			jQ('.ah-checkbox-resa:checked').each(function () {
				ids = ids + ',' + jQ(this).val();
			});
			ids = ids.substring(1);
			jQ('#ah-selected-resa-for-export').val(ids);
			jQ('#ah-form-export-data').submit();
		} else {
			alert('No booking requests were selected.');
		}
		return false;
	});


});

/* Copyright AurelienD http://themeforest.net/user/AurelienD?ref=AurelienD */