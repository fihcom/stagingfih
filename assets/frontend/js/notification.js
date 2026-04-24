$(function () {
	
	$('#notificationtab').click(function(){
		notificationfunc();
	});
});

function notificationfunc(){
	//alert('notificationfunc');
	setInterval(function(){ 
		$.ajax({
			url: $('#sitepath').val()+'user/countnotification',
			data: {
			},
			dataType: 'json', 
			type: 'post',
			success: function(data) {
				var noti = data.totalnotifications;
				$('.notificationspan').html(noti);
			}             
		});
	}, 30000);
}