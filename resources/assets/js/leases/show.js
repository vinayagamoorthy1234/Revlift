$(document).ready(function() {

	$('#submit-tank').click(function(e) {
		e.preventDefault();
		
		var params = {
			lease_id: $('#lease_id').val(),
			number: $('#number').val(),
			size: $('#size').val(),
			bbls_per_inch: $('#bbls_per_inch').val(),
		};
		console.log(params);

		$.ajaxSetup({
  		headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
		});

		$.post('/admin/tanks', {params}, function(data, textStatus, xhr) {
			console.log(data);
			if(data.responseText == 'Success!') {
				$('#tanksModal').modal('hide');
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

	$('#submit-mileage').click(function(e) {
		e.preventDefault();
		
		var params = {
			lease_id: $('#lease_id').val(),
			depot_id: $('#depot_id').val(),
			mileage: $('#mileage').val(),
		};
		console.log(params);

		$.ajaxSetup({
  		headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
		});

		$.post('/admin/mileages', {params}, function(data, textStatus, xhr) {
			console.log(data);
			if(data.responseText == 'Success!') {
				$('#mileageModal').modal('hide');
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
		]
	});

	$('#sa-warning').click(function(){
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this lease!",
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