$(document).ready(function() {

	var first_row = $('#base_rates');
	var inner_html = first_row.html();

	$('#addRow').click(function(e) {
		e.preventDefault();

		if($('.baseRateRow').length !== 0) {
			var last_row = $('.baseRateRow').last();
		} else {
			var last_row = first_row;
		}

		$('<div class="form-group baseRateRow"></div>').insertAfter(last_row).html(inner_html);
		$('.baseRateRow:last label').remove();
		if($('.baseRateRow:last div:first').not('.col-sm-offset-3')) {
			$('.baseRateRow:last div:first').addClass('col-sm-offset-3');
		}
	});

	$('#removeRow').click(function(e) {
		e.preventDefault();

		if($('.baseRateRow').length !== 0) {
			var last_row = $('.baseRateRow').last();
		} else {
			var last_row = first_row;
		}

		last_row.remove();
	});

	$('#submit-rate').click(function(e) {
		e.preventDefault();

		var mileage_array = $('input[name="base_rate_mileage[]"]').map(function(){return $(this).val();}).get();
		var value_array = $('input[name="base_rate_value[]"]').map(function(){return $(this).val();}).get();
		
		var params = {
			billing_office_id: $('#office_id').val(),
			name: $('#name').val(),
			chain_up_fee: $('#chain_up_fee').val(),
			chain_up_pay: $('#chain_up_pay').val(),
			demm_fee: $('#demm_fee').val(),
			nc_demm_hrs: $('#nc_demm_hrs').val(),
			divert_fee: $('#divert_fee').val(),
			reject_fee: $('#reject_fee').val(),
			split_fee: $('#split_fee').val(),
			masking_fee: $('#masking_fee').val(),
			fsc_formula: $('#fsc_formula').val(),
			min_bbls: $('#min_bbls').val(),
			discount: $('#discount').val(),
			is_default: $('#is_default').val(),
			base_rate_mileage: mileage_array,
			base_rate_value: value_array,
		};
		console.log(params);

		$.ajaxSetup({
  		headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
		});

		$.post('/admin/rates', {params}, function(data, textStatus, xhr) {
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
			null,
			null,
		]
	});

	$('#sa-warning').click(function(){
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this office!",
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
						text: "Billing Office has been deleted.",
						type: "success"
					}, function() {
						window.location.href = '/admin/billing';
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