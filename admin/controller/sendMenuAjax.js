$( document ).ready(function() {

    $("#saveArea button").click(function() {
        var formData = new FormData(document.getElementById('mainForm'));

        $.ajax({
            url: 'http://127.0.1.1/compagnielepassage.fr/admin/controller/saveMenuForm.php',
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                alert('success');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});