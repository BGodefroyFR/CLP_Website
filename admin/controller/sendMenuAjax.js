$( document ).ready(function() {

    function saveForm() {
        formData = new FormData(document.getElementById('mainForm'));

        $.ajax({
            url: 'http://127.0.1.1/compagnielepassage.fr/admin/controller/saveMenuForm.php',
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                $('#saveArea #success').css('display', 'inline');
                setTimeout(function() {
                    $('#saveArea #success').css('display', 'none');
                }, 3000);
            },
            error: function (data) {
                $('#saveArea #fail').css('display', 'inline');
                setTimeout(function() {
                    $('#saveArea #fail').css('display', 'none');
                }, 3000);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    $("#saveArea button").click(function() {
        saveForm();
    });

    // Edit section
    $(document).on("click", ".section .actionsSection #edit", function() {
        saveForm();
        $.ajax({
            url: 'http://127.0.1.1/compagnielepassage.fr/admin/controller/generateSectionForm.php?id=' + $(this).parent().parent().find('.rankMarker').val(),
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                window.location = "modifySection.html";
            },
            error: function (data) {
                
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});