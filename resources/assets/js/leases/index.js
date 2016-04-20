$(document).ready(function() {
	$('#datatable').DataTable({
		order: [
			[1, 'desc']
		],
		columns: [
			{ orderable: false },
			null,
			null,
			null,
			null,
			null,
			null,
		]
	});

	var globals = {};

	$('.sa-warning').click(function(e){
		globals['id'] = $(this).data('lease-id');
		e.stopPropagation();
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this lease!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false 
		}, function(){
			console.log(globals.id);
			console.log('Clicked Yes');
			var token = $('#token').data('token');
			console.log(token);
			$.post('/admin/leases/'+globals.id, {_method: 'DELETE', _token: token}, function(data, textStatus, xhr) {
				console.log(data);
				if(data=="success"){
					swal({
						title:"Deleted!",
						text: "Depot has been deleted.",
						type: "success"
					}, function() {
						window.location.href = '/admin/leases';
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