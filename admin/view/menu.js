$( document ).ready(function() {

	// Sections
	$('#sections #addSection').click(function() {
		$.get('asset/section.html', function(data) {
			data = data.replace("<TITLE>", "Nouvelle section");
			data = data.replace("<ID>", parseInt(Math.random() * 1e9));
		    $('#sections').append(data);
		});
	});

	// Actions
	$(document).on("click", ".content > .contentElem .actions .up",function() {
		if ($(this).parent().parent().prev().hasClass('contentElem'))
			$(this).parent().parent().swapWith( $(this).parent().parent().prev() );
	});
	$(document).on("click", ".content > .contentElem .down",function() {
		if ($(this).parent().parent().next().hasClass('contentElem'))
			$(this).parent().parent().swapWith( $(this).parent().parent().next() );
	});
	$(document).on("click", ".content > .contentElem .delete",function() {
		if (confirm("Supprimer cette section ?"))
			$('.' + $(this).parent().parent().find(".rankMarker").val()).parent().parent().remove();
			$(this).parent().parent().remove();
	});

});