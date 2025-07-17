jQuery(document).ready(function(jQ) {
	var input_upload_name = '';
	var orig_send_to_editor = window.send_to_editor;
	jQ('.aurel-panel-upload-button').click(function() {
		input_upload = jQ(this).prev('input');
		tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true');
		window.send_to_editor = function(html) {
			var regex = /src="(.+?)"/;
            var rslt = html.match(regex);
            var imgurl = rslt[1];
			input_upload.val(imgurl);
			tb_remove();
			window.send_to_editor = orig_send_to_editor;
		}
		return false;
	});
});
