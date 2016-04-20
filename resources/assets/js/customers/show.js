$(document).ready(function() {
	$.fn.dataTable.moment( 'MM/YYYY' );
	$.fn.dataTable.moment( 'MM/D/YYYY' );
	
	$('#datatable').DataTable({
		order: [
			[1, 'desc']
		],
		columns: [
			{ orderable: false },
			null,
			null,
			null,
		]
	});

	$('#datatable2').DataTable({
		order: [
			[1, 'desc']
		],
		columns: [
			{ orderable: false },
			null,
			null,
			null,
		]
	});

	$('#sa-warning').click(function(){
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this customer!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false 
		}, function(){
			swal({
				title:"Deleted!",
				text: "Company has been deleted.",
				type: "success"
			}, function(){
				console.log('Clicked OK');
				// Run ajax here.
			});
		});
	});
});