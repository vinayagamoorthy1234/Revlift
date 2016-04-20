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

});