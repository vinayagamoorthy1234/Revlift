$(document).ready(function() {

	$('#sa-warning').click(function(){
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this device!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false 
		}, function(){
			console.log('Clicked Yes');
			var token = $('#_token').val();
			console.log(token);
			$.post(window.location.href, {_method: 'DELETE', _token: token}, function(data, textStatus, xhr) {
				console.log(data);
				if(data=="success"){
					swal({
						title:"Deleted!",
						text: "Device has been deleted.",
						type: "success"
					}, function() {
						window.location.href = '/admin/devices';
					});
				} else {
					swal({
						title:"Error!",
						text: "Unfortunately, an error occured. Please try again, or contact the web administrator.",
						type: "error"
					});	
				}
			});
		});
	});
	
});