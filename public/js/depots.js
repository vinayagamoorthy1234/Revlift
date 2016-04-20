$(document).ready(function() {

	$.fn.dataTable.moment( 'MM/YYYY' );
	$.fn.dataTable.moment( 'MM/D/YYYY' );

	$('#submit-header').click(function(e) {
		e.preventDefault();
		
		var params = {
			depot_id: $('#depot_id').val(),
			name: $('#name').val(),
			owner: $('#owner').val()
		};
		console.log(params);

		$.ajaxSetup({
  		headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
		});

		$.post('/admin/headers', {params}, function(data, textStatus, xhr) {
			console.log(data);
			if(data.responseText == 'Success!') {
				$('#myModal').modal('hide');
				window.location.reload();
			}
		}).fail(function(jqXhr) {
			if( jqXhr.status === 401 ) //redirect if not authenticated user.
        $( location ).prop( 'pathname', 'login' );
      if( jqXhr.status === 422 ) {
        //process validation errors here.

        var errors = jqXhr.responseJSON; //this will get the errors response data.

        errorsHtml = '<div class="alert alert-danger"><strong>Whoops! Something went wrong!</strong><ul>';

        $.each(errors, function(key, value) {
          errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
        });
        errorsHtml += '</ul></div>';
            
        $('#form-errors').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
      } else {
        $('#form-errors').html('<div class="alert alert-danger"><strong>Something went wrong witht the server. Try again later.</strong></div>');
      }
		});
	});

	$('#submit-allocation').click(function(e) {
		e.preventDefault();
		
		var params = {
			depot_id: $('#depot_id').val(),
			bbls: $('#allocationModal .bbls').val(),
			bbls_revised: $('#allocationModal .bbls_revised').val(),
			month_year: $('#allocationModal .month_year').val(),
			comments: $('#allocationModal .comments').val(),
		};
		console.log(params);

		$.ajaxSetup({
  		headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
		});

		$.post('/admin/allocations', {params}, function(data, textStatus, xhr) {
			console.log(data);
			if(data.responseText == 'Success!') {
				$('#myModal').modal('hide');
				window.location.reload();
			}
		}).fail(function(jqXhr) {
			if( jqXhr.status === 401 ) //redirect if not authenticated user.
        $( location ).prop( 'pathname', 'login' );
      if( jqXhr.status === 422 ) {
        //process validation errors here.

        var errors = jqXhr.responseJSON; //this will get the errors response data.

        errorsHtml = '<div class="alert alert-danger"><strong>Whoops! Something went wrong!</strong><ul>';

        $.each(errors, function(key, value) {
          errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
        });
        errorsHtml += '</ul></div>';
            
        $('#form-errors').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
      } else {
        $('#form-errors').html('<div class="alert alert-danger"><strong>Something went wrong witht the server. Try again later.</strong></div>');
      }
		});
	});

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
			[1, 'asc']
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
			text: "You will not be able to recover this depot!",
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
						text: "Depot has been deleted.",
						type: "success"
					}, function() {
						window.location.href = '/admin/depots';
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

	var globals = {}; // used for multiple SA-WARNING rows

	$('.sa-warning.header').click(function(e){
		globals['id'] = $(this).data('header-id');
		e.stopPropagation();

		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this depot header!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false 
		}, function(){
			console.log('Clicked Yes');
			var token = $('#_token').val();
			console.log(token);
			$.post('/admin/headers/'+globals.id, {_method: 'DELETE', _token: token}, function(data, textStatus, xhr) {
				console.log(data);
				if(data=="success"){
					swal({
						title:"Deleted!",
						text: "Depot Header has been deleted.",
						type: "success"
					}, function() {
						window.location.reload();
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

	$('.sa-warning.allocation').click(function(e){
		globals['id'] = $(this).data('allocation-id');
		e.stopPropagation();

		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this depot allocation!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false 
		}, function(){
			console.log('Clicked Yes');
			var token = $('#_token').val();
			console.log(token);
			$.post('/admin/allocations/'+globals.id, {_method: 'DELETE', _token: token}, function(data, textStatus, xhr) {
				console.log(data);
				if(data=="success"){
					swal({
						title:"Deleted!",
						text: "Depot Allocation has been deleted.",
						type: "success"
					}, function() {
						window.location.reload();
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