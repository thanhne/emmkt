/**
 * [Please don't remove and change any thing in this scripts]
 * @author {ThanhNe aka Victor}
 * @param  {[type]} ){} [description]
 * @return {[type]}       [description]
 */
$(document).ready(function(){
	$('#dataTables-limit select').change(function() {
		//var cur_url = window.location.href;
		var queryParameters = {}, queryString = location.search.substring(1), re = /([^&=]+)=([^&]*)/g, m;
		while (m = re.exec(queryString)) {
		    queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
		}
		queryParameters['limit'] = $(this).val();
		queryParameters['page'];

		location.search = $.param(queryParameters); 
	});

	if ($('.show_msg')) {
		setTimeout(function() {
		    $('.show_msg').slideUp('slow');
		}, 3000); // <-- time in milliseconds
	}

	$('.delete').click(function(e) {
		vik.confirm_delete(e);
	});

	$('.gen-secret-key').click(function(){
		$.ajax({
			url: '/admin/setting/get_secret_key/',
			type: 'POST',
			data: {get_secret_key: true},
		})
		.done(function(data) {
			$('#txtSecretKey').val(data);
		});
	});

	$('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

	$('#dataTables-example .start-stop .btn').click(function() {
		var a = $(this);
		var id = a.attr('camp_id');
		var status;
		if(a.html() == 'Start') {
			status = 2;
		}else {
			status = 1;
		}

		var camp_stt = $('.camp-status');
		if (camp_stt.html() == 'Stop') {
			camp_stt.removeClass('btn-danger');
			camp_stt.addClass('btn-primary');
			camp_stt.html('Sending..');	
		}else {
			camp_stt.removeClass('btn-primary');
			camp_stt.addClass('btn-danger');
			camp_stt.html('Stop');
		}

		$.ajax({
			url: '/admin/campaign/email/ajax/',
			type: 'POST',
			data: {
				run_campaign: true,
				campaign_id: id,
				status: status,
			},
		})
		.done(function(data) {
			if (data == 'updated') {
				if (a.html() == 'Start') {
					a.removeClass('btn-success');
					a.addClass('btn-danger');
					a.html('Stop');
					a.attr('data-original-title','Click to Stop this campaign');
				}else {
					a.removeClass('btn-danger');
					a.addClass('btn-success');
					a.html('Start');
					a.attr('data-original-title','Click to Start this campaign');
				}
			}
		});
	});
})

var vik = {
	'confirm_delete' : function(e) {
		var _confirm = confirm('You want to delete this item? Click ok to continue');
		if (!_confirm) {
			e.preventDefault();
		}
	},
	'alert_msg' : function(msg) {
		if (msg) {
			alert(msg);
		}
	}

}