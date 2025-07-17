jQuery(document).ready(function(jQ){
	
	function prepare_room_types_data() {
		var rts = [];
		jQ('.ah-room-type').each(function() {
			var rt = {};
			rt['id'] = jQ(this).find('.ah-room-type-slug').html();
			rt['name'] = jQ(this).find('.ah-room-type-name').val();
			rt['update'] = jQ(this).find('.ah-room-type-update:checked').val();
			rt['minimal-stay'] = jQ(this).find('.ah-room-type-minimal-stay').val();
			rt['check-in-day'] = jQ(this).find('.ah-room-type-check-in-day').val();
			rt['check-out-day'] = jQ(this).find('.ah-room-type-check-out-day').val();
			rts.push(rt);
		});
		jQ('#ah-room-types').val(JSON.stringify(rts));
	}
	
	jQ('#ah-save-changes-submit').click(function() {
		prepare_room_types_data();
		jQ('#ah-action').val('save');
		jQ('.ah-form').submit();
	});
	
	jQ('#ah-add-room-type').click(function() {
		if ( /^\w+$/.test( jQ('#ah-room-type-slug').val() ) ) {
			jQ('#ah-action').val('add-room-type');
			jQ('#ah-room-types-form').submit();
		} else {
			alert('Please enter a correct id (the id can only contain letters, numbers, and underscores).');
		}
	});

	function init_room_type_remove() {
		jQ('body').on('click', '.ah-room-type-remove', function() {
			if (confirm('Delete this room type? (this will also delete all the data linked to this type of room)') ) {
				jQ(this).parent().slideUp(400,function() { jQ(this).remove(); });
			}
			return false;
		});
	}
	init_room_type_remove();
	
	jQ('#ah-room-type-wrapper').sortable({
		axis: 'y',
		items: '.ah-room-type'
	});
	
});


/* Copyright AurelienD http://themeforest.net/user/AurelienD?ref=AurelienD */