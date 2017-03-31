$( document ).ready(function() {

	// Save area
	$('#saveArea button').click(function() {
		$('#saveArea p').css('display', 'inline');
		setTimeout(function() {
		    $('#saveArea p').css('display', 'none');
		}, 3000);
	});

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

	// Content elements
	$(document).on("click", "#content > div > .actions .up",function() {
		if ($(this).parent().parent().prev().hasClass('contentElem'))
			$(this).parent().parent().swapWith( $(this).parent().parent().prev() );
	});
	$(document).on("click", "#content > div > .actions .down",function() {
		if ($(this).parent().parent().next().hasClass('contentElem'))
			$(this).parent().parent().swapWith( $(this).parent().parent().next() );
	});
	$(document).on("click", "#content > div > .actions .delete",function() {
		$(this).parent().parent().remove();
	});

		// Text area
		while(document.getElementById("editor1")) { // Initializes generated textareas
	        initTextArea();
	    }
		$('#addButtons #addTextArea').click(function() {
			$.get('asset/textArea.html', function(data) {
			    $('#content').append(data);
			    initTextArea();
			});
		});
		function initTextArea() {
			$('#content #editor1').parent().parent().parent().find('.textarea_rankMarker').attr('name', 'textarea_rankMarker' + parseInt(Math.random() * 1e9));
			var randId1 = "editor_" + Math.floor(Math.random() * 1e9);
			document.getElementById("editor1").id = randId1;
			initSample(randId1);
			var randId2 = "editor_" + Math.floor(Math.random() * 1e9);
			document.getElementById("editor2").id = randId2;
			initSample(randId2);
		}
		$(document).on("change", "#content .textArea #isTwoCol input",function() {
			if($(this).is(':checked')) {
				$(this).parent().parent().find('#rightColumn').show();
				$(this).parent().parent().find('#leftColumn p').html("Colonne gauche");
				$(this).parent().parent().find('#leftColumn').css('width', '45%');
			} else {
				$(this).parent().parent().find('#rightColumn').hide();
				$(this).parent().parent().find('#leftColumn p').html("");
				$(this).parent().parent().find('#leftColumn').css('width', '90%');
			}
		});

		// Galery
		$('#addButtons #addGalery').click(function() {
			$.get('asset/galery.html', function(data) {
			     $('#content').append(data);
			     $.get('asset/galery_image.html', function(data) {
			     	$('#content .galery:last-child').append(data);
			     	$('#content .galery:last .galeryImage .galeryImage_rankMarker').attr('name', 'galleryIm_rankMarker' + parseInt(Math.random() * 1e9));
			     });
			     $('#content .galery:last-child > .galery_rankMarker').attr('name', 'gallery_rankMarker' + parseInt(Math.random() * 1e9));
			});
		});
		$(document).on("click", "#content .galery .galery_addPhoto",function() {
			var curGalery = $(this).parent().parent();
			$.get('asset/galery_image.html', function(data) {
			    curGalery.append(data);
			    curGalery.find('.galeryImage_rankMarker:last').attr('name', 'galleryIm_rankMarker' + parseInt(Math.random() * 1e9));
			});

		});
		$(document).on("click", "#content .galery .galeryImage .up",function() {
			if ($(this).parent().parent().prev().hasClass('galeryImage'))
				$(this).parent().parent().swapWith( $(this).parent().parent().prev() );
		});
		$(document).on("click", "#content .galery .galeryImage .down",function() {
			if ($(this).parent().parent().next().hasClass('galeryImage'))
				$(this).parent().parent().swapWith( $(this).parent().parent().next() );
		});
		$(document).on("click", "#content .galery .galeryImage .image_delete img",function() {
			$(this).parent().parent().remove();
		});

		// Link
		$('#addButtons #addLink').click(function() {
			$.get('asset/link.html', function(data) {
			     $('#content').append(data);
			     var newName = 'link_isUpload_' + parseInt(Math.random() * 1e9);
			     $('#content .link:last .link_uploadDiv .link_isUpload').attr('name', newName);
			     $('#content .link:last .link_urlDiv .link_isUpload').attr('name', newName);
			});
		});
		$(document).on("change", "#content .link .link_isUpload",function() {
			if ($(this).val() == 'true') {
				$(this).parent().parent().find('.link_uploadedFile').show();
				$(this).parent().parent().find('.link_urlInput').hide();
			} else {
				$(this).parent().parent().find('.link_uploadedFile').hide();
				$(this).parent().parent().find('.link_urlInput').show();
			}
		});
});