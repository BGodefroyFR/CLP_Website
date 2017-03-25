$( document ).ready(function() {

	// Top links
	for (var i = 0; i < 3; i++) {
		$.get('asset/toplink.html', function(data) {
		     $('#toplinks').append(data);
		});
	}

	// Miniatures
	for (var i = 0; i < 3; i++) {
		$.get('asset/miniature.html', function(data) {
		     $('#miniatures').append(data);
		});
	}

	// Sections
	$('#sections #addSection').click(function() {
		$.get('asset/section.html', function(data) {
		     $('#sections').append(data);
		});
	});
	


});