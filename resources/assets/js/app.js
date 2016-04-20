window.$ = window.jQuery = require('jquery');

// Require NPM Bootstrap
require('bootstrap-sass');

$(document).ready(function() {
	$('.overlay').delay(1500).fadeOut(1500);

	$('.clickable-row').click(function(event) {
		window.document.location = $(this).data("href");
	});

});