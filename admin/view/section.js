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

	// Text area
	$('#addButtons #addTextArea').click(function() {
		$.get('asset/textArea.html', function(data) {
		     $('#content').append(data);
		});
	});

	// Galery
	$('#addButtons #addGalery').click(function() {
		$.get('asset/galery.html', function(data) {
		     $('#content').append(data);
		     $.get('asset/galery_image.html', function(data) {
		     	$('#content .galery:last-child').append(data);
		     });
		});
	});
	$(document).on("click", "#content .galery .galery_addPhoto",function() {
		var curGalery = $(this).parent().parent();
		$.get('asset/galery_image.html', function(data) {
		    curGalery.append(data);
		});

	});
	$(document).on("click", "#content .galery .galeryImage .up",function() {
		$(this).parent().parent().swapWith( $(this).parent().parent().prev() );
	});
	$(document).on("click", "#content .galery .galeryImage .down",function() {
		$(this).parent().parent().swapWith( $(this).parent().parent().next() );
	});
	$(document).on("click", "#content .galery .galeryImage .image_delete img",function() {
		$(this).parent().parent().remove();
	});

	// Link
	$('#addButtons #addLink').click(function() {
		$.get('asset/link.html', function(data) {
		     $('#content').append(data);
		});
	});
	$(document).on("change", "#content .link .link_isUpload",function() {
		if ($(this).val() == 'true') {
			$(this).parent().find('.link_uploadedFile').show();
			$(this).parent().find('.link_url').hide();
		} else {
			$(this).parent().find('.link_uploadedFile').hide();
			$(this).parent().find('.link_url').show();
		}
	});

});