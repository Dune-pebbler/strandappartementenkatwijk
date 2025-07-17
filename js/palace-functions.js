/* Copyright AurelienD http://themeforest.net/user/AurelienD?ref=AurelienD */
jQuery(document).ready(function (jQ) {

	function debouncer(func, timeout) {
		var timeoutID, timeout = timeout || 50;
		return function () {
			var scope = this, args = arguments;
			clearTimeout(timeoutID);
			timeoutID = setTimeout(function () {
				func.apply(scope, Array.prototype.slice.call(args));
			}, timeout);
		}
	}

	function nav_init() {
		if (!(jQ.browser.msie && parseInt(jQ.browser.version, 10) === 8)) {

			if (jQ('#nav-select select').length > 0) {
				jQ('<option />', {
					'value': '#',
					'text': ' '
				}).appendTo('#nav-select select');
				jQ('nav a').each(function () {
					var el = jQ(this);
					var dashes = '';
					for (var i = 1; i < el.parents('ul').length; i++) {
						dashes += '-';
					}
					if (dashes != '') {
						dashes += ' ';
					}
					jQ('<option />', {
						'value': el.attr('href'),
						'text': dashes + el.text()
					}).appendTo('#nav-select select');
				});
				jQ('#nav-select select').change(function () {
					window.location.href = jQ(this).find('option:selected').val();
				});
			} else {
				var nav = jQ('nav').html();
				nav = nav.replace('class="nav-standard"', 'class="nav-mobile"');
				nav = nav.replace('id="', 'id="mobile-');
				jQ('nav').append(nav);
				jQ('nav>ul.nav-mobile li').each(function () {
					if (jQ(this).children('ul').length > 0) {
						jQ(this).append('<a class="nav-button-sub" href="#"><span class="nav-plus-small">+</span></a>');
					}
				});

				jQ('ul.nav-mobile').css('top', '-1000px');
				jQ('#nav-button-main').click(function () {
					var main_ul = jQ('ul.nav-mobile');
					if (main_ul.hasClass('nav-main-expanded')) {
						main_ul.removeClass('nav-main-expanded');
						main_ul.animate({ top: '-1000px' });
						jQ('#nav-button-main .nav-arrow').rotate({ animateTo: 0 });
					} else {
						main_ul.addClass('nav-main-expanded');
						main_ul.animate({ top: 0 });
						jQ('#nav-button-main .nav-arrow').rotate({ animateTo: 180 });
					}
				});
				jQ('.nav-button-sub').click(function () {
					var son_ul = jQ(this).parent().find('>ul');
					if (son_ul.hasClass('nav-sub-expanded')) {
						son_ul.removeClass('nav-sub-expanded');
						son_ul.slideUp();
						jQ(this).find('.nav-plus-small').rotate({
							animateTo: 0, callback: function () {
								jQ(this).html('+').removeClass('nav-minus-small');
							}
						});
					} else {
						son_ul.addClass('nav-sub-expanded');
						son_ul.slideDown();
						jQ(this).find('.nav-plus-small').rotate({
							animateTo: 180, callback: function () {
								jQ(this).html('&#8722;').addClass('nav-minus-small');
							}
						});
					}
					return false;
				});
			}
			jQ('nav>ul.nav-standard>li').each(function () {
				if (jQ(this).children('ul').length > 0) {
					jQ(this).find('>a').append('&nbsp;&nbsp;<span class="nav-arrow-down">&#9660;</span>');
				}
			});
			jQ('nav ul.nav-standard li ul li ul').parent().find('>a').append('<span class="nav-arrow-right">&#9658;</span>');
		}
		jQ('nav ul.nav-standard').superfish({
			delay: 600,
			animation: { height: 'show' },
			animationClose: { height: 'hide' },
			autoArrows: false
		});
	}
	nav_init();

	if (jQ('#ap_fwh_options').length > 0) {
		var fwho = JSON.parse(jQ('#ap_fwh_options').val());
		if (fwho['autoplay'] == 'yes') {
			ma = true;
		} else {
			ma = false;
		}
		if (jQ('#full-width-slider').length > 0) {
			full_width_slider(ma, fwho['pause_time'], fwho['animation_speed']);
		} else {
			full_width_header(fwho['animation_speed']);
		}
	}

	if (jQ('#full-screen-slider').length > 0) {
		full_screen_slider('#full-screen-slider');
	}

	jQ('.sc-fws-container').each(function () {
		full_width_slider_inside(jQ(this));
	});

	jQ('.slider-type-a').each(function () {
		slider_type_a(jQ(this));
	});

	jQ('.slider-type-b').each(function () {
		slider_type_b(jQ(this));
	});

	if (jQ('.gallery-ap').length > 0) {
		gallery_ap();
	}

	var day_names = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

	jQ('.ap-calendars-wrapper').each(function () {
		var cid = jQ(this).attr('id');
		var co = JSON.parse(jQ('#' + cid).find('input.ah-calendar-options').val());
		var adminDateFormat = co['dateFormat'];
		var ahcd = new Array();
		var sa = false;
		var lang = '';
		if (jQ(this).find('.ah-calendars-data').length > 0) {
			ahcd = JSON.parse(jQ('#' + cid).find('.ah-calendars-data').val());
			sa = true;
		}
		if (jQ(this).find('.ah-calendar-lang').length > 0) {
			lang = jQ('#' + cid).find('.ah-calendar-lang').val();
		}
		if (lang != '') {
			co['dateFormat'] = jQ.datepick.regional[lang].dateFormat;
			day_names = jQ.datepick.regional[lang].dayNames;
		}
		var iid = cid.substring('calendar-'.length);
		jQ('#' + iid).data('date-format', co['dateFormat']);
		jQ('#' + iid).data('admin-date-format', adminDateFormat);
		if (jQ(this).hasClass('calendar-inline-no-input')) {
			jQ('#' + iid).css('display', 'none');
		} else {
			jQ('#' + iid).prop('readonly', true);
		}
		if (jQ(this).hasClass('calendar-pop-up')) {
			//jQ('#' + iid).after('<a class="calendar-button" href="#"></a>');
			jQ('#' + iid).addClass('input-calendar');
			jQ(this).css('display', 'none');
		}
		co['onSelect'] = function (dates) {
			if (co['multiSelect'] == 0) {
				if (dates.length) {
					jQ('#' + iid).val(jQ.datepick.formatDate(co['dateFormat'], dates[0]));
					if (jQ(this).parent().hasClass('calendar-pop-up')) {
						jQ(this).parent().slideToggle();
					}
				}
			} else {
				if (dates.length) {
					var d = '';
					for (var i = 0; i < dates.length; i++) {
						if (i != 0) {
							d = d + ', ';
						}
						d = d + jQ.datepick.formatDate(co['dateFormat'], dates[i]);
					}
					jQ('#' + iid).val(d);
				} else {
					jQ('#' + iid).val(d);
				}
			}
		};
		jQ('#' + cid + ' .ap-calendar').each(function () {
			if (sa) {
				co['onDate'] = function (date) {
					var id = jQ(this).attr('id');
					var n = id.indexOf('-name-');
					id = id.substring(0, n);
					if (jQ.inArray(jQ.datepick.formatDate('yyyy-mm-dd', date), ahcd[id]) > -1) {
						return { selectable: false };
					} else {
						return {};
					}
				};
			}
			if (co['multiSelect'] == 0) {
				jQ(this).parent().find('.calendar-button-ok').css('display', 'none');
			}
			jQ(this).datepick();
			if (lang != '') {
				jQ(this).datepick('option', jQ.datepick.regional[lang]);
			}
			function remove_selection(id, c) {
				jQ('#' + id + ' .datepick table a').css({ 'cursor': 'default', 'color': c }).attr('title', '');
			}
			function change_calendar_width(id, w) {
				jQ('#' + id + ' .datepick-month').css('width', w + '%');
			}
			if (co['multiSelect'] == -1) {
				co['onSelect'] = function () {
					var id = jQ(this).attr('id');
					var c = jQ(this).find('.datepick table a').css('color');
					setTimeout(function () { remove_selection(id, c); }, 10);
				}
				co['onChangeMonthYear'] = function (year, month) {
					var id = jQ(this).attr('id');
					var c = jQ(this).find('.datepick table a').css('color');
					setTimeout(function () { remove_selection(id, c); }, 10);
					jQ('#' + cid + ' .ap-calendar').datepick('showMonth', year, month);
				};
			} else {
				co['onChangeMonthYear'] = function (year, month) {
					if (cid == 'calendar-check-in') {
						var check_out_month_shown = jQ('#calendar-check-out .ap-calendar').data('month-shown');
						var check_out_year_shown = jQ('#calendar-check-out .ap-calendar').data('year-shown');
						if (check_out_year_shown * 12 + check_out_month_shown < year * 12 + month) {
							jQ('#calendar-check-out .ap-calendar').datepick('showMonth', year, month);
							jQ('#calendar-check-out .ap-calendar').data('month-shown', month);
							jQ('#calendar-check-out .ap-calendar').data('year-shown', year);
						}
					}
					if (cid == 'calendar-check-out') {
						jQ('#calendar-check-out .ap-calendar').data('month-shown', month);
						jQ('#calendar-check-out .ap-calendar').data('year-shown', year);
					}
				};
			}
			jQ(this).datepick('option', co);
			if (co['multiSelect'] == -1) {
				var c = jQ(this).find('.datepick table a').css('color');
				jQ(this).find('.datepick table a').css({ 'cursor': 'default', 'color': c }).attr('title', '');
			}
			if (cid == 'calendar-check-out') {
				var current_date = new Date();
				var current_month = current_date.getMonth() + 1;
				var current_year = current_date.getFullYear();
				jQ(this).data('month-shown', current_month);
				jQ(this).data('year-shown', current_year);
			}
		});
		if ((jQ('#' + cid + ' .ah-calendar-type-to-show').length > 0) && (jQ('#' + cid + ' .ap-calendar').length > 1)) {
			jQ('#' + cid + ' .calendar-for-' + jQ('#' + cid + ' .ah-calendar-type-to-show').val()).css('display', 'block');
		} else {
			jQ('#' + cid + ' .ap-calendar').eq(0).css('display', 'block');
		}
	});

	if ((jQ('#check-in').length > 0) && (jQ('#check-out').length > 0)) {
		jQ('.wpcf7-submit').click(function () {
			var date_format = jQ('#check-in').data('date-format');
			var check_in_date, check_out_date;
			try {
				check_in_date = jQ.datepick.parseDate(date_format, jQ('#check-in').val());
				check_out_date = jQ.datepick.parseDate(date_format, jQ('#check-out').val());
			} catch (e) {
				alert(thepalacejstext.invaliddate);
				return false;
			}
			if ((check_in_date == null) && (check_out_date == null)) {
				alert(thepalacejstext.selectcheckincheckout);
				return false;
			} else if (check_in_date == null) {
				alert(thepalacejstext.selectcheckin);
				return false;
			} else if (check_out_date == null) {
				alert(thepalacejstext.selectcheckout);
				return false;
			}
			if (check_in_date >= check_out_date) {
				alert(thepalacejstext.errorcheckoutbeforecheckin);
				return false;
			}
			var _MS_PER_DAY = 1000 * 60 * 60 * 24;
			var utc1 = Date.UTC(check_in_date.getFullYear(), check_in_date.getMonth(), check_in_date.getDate());
			var utc2 = Date.UTC(check_out_date.getFullYear(), check_out_date.getMonth(), check_out_date.getDate());
			var number_of_nights = Math.floor((utc2 - utc1) / _MS_PER_DAY);
			var room_type = '';
			if (jQ('#calendar-check-in .ah-calendar-type-to-show').length > 0) {
				room_type = jQ('#calendar-check-in .ah-calendar-type-to-show').val();
			} else {
				room_type = jQ('.room-type').val();
			}
			if (room_type == '') {
				room_type = jQ('input[name="room"]').val();
			}
			var minimal_stay = JSON.parse(jQ('#minimal-stay').val());
			for (var i = 0; i < minimal_stay.length; i++) {
				if ((room_type == minimal_stay[i]['room-id']) && (number_of_nights < minimal_stay[i]['nights'])) {
					alert(thepalacejstext.minimalstay);
					return false;
				}
			}
			var check_in_day_c = JSON.parse(jQ('#check-in-day-compulsory').val());
			for (var i = 0; i < check_in_day_c.length; i++) {
				if ((room_type == check_in_day_c[i]['room-id']) && (check_in_date.getDay() != (check_in_day_c[i]['check-in-day'] - 1))) {
					alert(thepalacejstext.check_in_day_compulsory + '(' + day_names[check_in_day_c[i]['check-in-day'] - 1] + ').');
					return false;
				}
			}
			var check_out_day_c = JSON.parse(jQ('#check-out-day-compulsory').val());
			for (var i = 0; i < check_out_day_c.length; i++) {
				if ((room_type == check_out_day_c[i]['room-id']) && (check_out_date.getDay() != (check_out_day_c[i]['check-out-day'] - 1))) {
					alert(thepalacejstext.check_out_day_compulsory + '(' + day_names[check_out_day_c[i]['check-out-day'] - 1] + ').');
					return false;
				}
			}
			if (jQ('.ah-control-avai-calendars-data').length > 0) {
				var unavai_dates = JSON.parse(jQ('.ah-control-avai-calendars-data').val())['calendar-' + room_type];
				var check_in_date_for_control = new Date(check_in_date.getTime());
				do {
					str_date = jQ.datepick.formatDate('yyyy-mm-dd', check_in_date_for_control);
					if (jQ.inArray(jQ.datepick.formatDate('yyyy-mm-dd', check_in_date_for_control), unavai_dates) > -1) {
						alert(thepalacejstext.noavailability);
						return false;
					}
					check_in_date_for_control.setDate(check_in_date_for_control.getDate() + 1);
				} while (check_in_date_for_control < check_out_date);
			}
			jQ('#check-in-formatted').val(jQ.datepick.formatDate('yyyy-mm-dd', check_in_date));
			jQ('#check-out-formatted').val(jQ.datepick.formatDate('yyyy-mm-dd', check_out_date));
		});
	}

	jQ('.input-calendar').click(function () {
		var cid = jQ(this).attr('id');
		jQ('#calendar-' + cid).slideToggle();
		return false;
	});

	jQ('.calendar-button-ok').click(function () {
		jQ(this).parent().parent().slideToggle();
		return false;
	});

	if (jQ('.ah-room-types-data').length > 0) {
		var rt = JSON.parse(jQ('.ah-room-types-data').val());
		var select_rt_content = '';
		for (var i = 0; i < rt.length; i++) {
			select_rt_content += '<option value="' + rt[i]['id'] + '">' + rt[i]['name'] + '</option>';
		}
		jQ('.room-type').html(select_rt_content);
	}
	jQ('.room-type').change(function () {
		var rt = jQ(this).val();
		jQ('.ap-calendars-wrapper').each(function () {
			if (jQ(this).find('.ap-calendar').length > 1) {
				jQ(this).find('.ap-calendar').css('display', 'none');
				jQ(this).find('.calendar-for-' + rt).fadeIn(1000);
			}
		});
	});

	function init_google_map(map_coords, map_type) {
		var lat_lng = map_coords.split(',');
		var point = new google.maps.LatLng(lat_lng[0], lat_lng[1]);
		var google_map_type = google.maps.MapTypeId.ROADMAP;
		if (map_type == 'satellite') {
			google_map_type = google.maps.MapTypeId.SATELLITE;
		}
		var mapOptions = {
			zoom: 15,
			center: point,
			mapTypeId: google_map_type
		}
		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		var noPoi = [{
			featureType: "poi.business",
			stylers: [{ visibility: "off" }]
		}];
		map.setOptions({ styles: noPoi });
		var marker = new google.maps.Marker({
			position: point,
			map: map
		});
		jQ(window).unload(function () {
			GUnload();
		});
	}

	if (jQ('#map-lat-lng').length > 0) {
		init_google_map(jQ('#map-lat-lng').val(), jQ('#map-type').val());
	}

	var logo_height = 0,
		logo_width = 0;

	function init_logo_resize() {
		jQ('<img />').load(function () {
			logo_height = jQ('#logo img.logo').height();
			logo_width = jQ('#logo img.logo').width();
			logo_resize();
		}).attr('src', jQ('#logo img.logo').attr('src'));
	}

	function viewport_width() {
		var e = window, a = 'inner';
		if (!('innerWidth' in window)) {
			a = 'client';
			e = document.documentElement || document.body;
		}
		return e[a + 'Width'];
	}

	function logo_resize() {
		if (viewport_width() <= 959) {
			var reducing_scale_factor = jQ('#logo .logo').data('reducing-scale-factor');
			jQ('#logo img.logo').css({ 'height': Math.floor(logo_height / reducing_scale_factor) + 'px', 'width': Math.floor(logo_width / reducing_scale_factor) + 'px' });
		} else {
			jQ('#logo img.logo').css({ 'height': logo_height + 'px', 'width': logo_width + 'px' });
		}
	}

	function logo_change() {
		if (viewport_width() <= 959) {
			jQ('#logo img.logo').attr('src', jQ('#logo .logo').data('mobile-logo-url'));
		} else {
			jQ('#logo img.logo').attr('src', jQ('#logo .logo').data('default-logo-url'));
		}
	}

	if (jQ('#logo .logo').data('mobile-logo-type') == 'reduce') {
		init_logo_resize();
		jQ(window).resize(debouncer(function (e) {
			logo_resize();
		}));
	} else if (jQ('#logo .logo').data('mobile-logo-type') == 'change-img') {
		jQ(window).resize(debouncer(function (e) {
			logo_change();
		}));
		logo_change();
	}

	function copy_widget_area_mobile() {
		if (jQ('#widget-area-top-container').length > 0) {
			jQ('#widget-area-top-container-mobile').html(jQ('#widget-area-top-container').html() + '<div class="clear"></div>');
		}
	}
	copy_widget_area_mobile();

	if (jQ('#background').length > 0) {
		function do_resize() {
			var img = jQ('#background img');
			ratio_img = img.width() / img.height(),
				ratio_win = jQ(window).width() / jQ(window).height();
			if (ratio_win < ratio_img) {
				img.css({ 'height': '100%', 'width': 'auto' });
				img.css({ 'left': '50%', 'margin-left': -Math.floor(img.width() / 2) + 'px', 'margin-top': 0, 'top': 0 });
			} else {
				img.css({ 'height': 'auto', 'width': '100%' });
				img.css({ 'left': 0, 'margin-left': 0, 'margin-top': -Math.floor(img.height() / 2) + 'px', 'top': '50%' });
			}
		}
		jQ(window).resize(debouncer(function (e) {
			do_resize();
		}));
		jQ('<img />').attr('src', jQuery('#background img').attr('src')).load(function () {
			do_resize();
		});
	}

	if (jQ('#footer-image').length == 0) {
		jQ('footer.below-main-container, #footer-image-container').css('background', 'none');
	}

	jQ('p:not([class]):empty').remove();

});

/* Copyright AurelienD http://themeforest.net/user/AurelienD?ref=AurelienD */