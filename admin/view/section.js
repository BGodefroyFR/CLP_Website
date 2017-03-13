$( document ).ready(function() {

	// Top link
	$('#general #isTopLink input').click(function() {
		if($('#general #isTopLink input').is(':checked')) {
			$("#general #topLinkText").show();
		} else {
			$("#general #topLinkText").hide();
		}
	});

	// Miniature
	$('#general #isMiniature input').click(function() {
		if($('#general #isMiniature input').is(':checked')) {
			$("#general #miniatureImage").show();
		} else {
			$("#general #miniatureImage").hide();
		}
	});

});