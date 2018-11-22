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

	$('#dataTables-example .start-stop .btn').click(function() {
		var val = $(this).html();
		var id = $(this).attr('camp_id');
		var status;
		if(val == 'Start') {
			status = 2;
		}else {
			status = 1;
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
			console.log(data);
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