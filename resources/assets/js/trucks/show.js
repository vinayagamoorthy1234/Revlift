$(document).ready(function() {

	$('#sa-warning').click(function(){
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this truck!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false 
		}, function(){
			swal({
				title:"Deleted!",
				text: "Truck has been deleted.",
				type: "success"
			}, function(){
				console.log('Clicked OK');
				// Run ajax here.
			});
		});
	});

});