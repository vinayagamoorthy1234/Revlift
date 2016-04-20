$(document).ready(function() {
	$('#datatable').DataTable({
		order: [
			[1, 'asc']
		],
		columns: [
			{ orderable: false },
			null,
			null,
			null,
			null,
			null,
		]
	});
});