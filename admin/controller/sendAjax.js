$( document ).ready(function() {

    $("#saveArea button").click(function() {
        var formData = new FormData(document.getElementById('mainForm'));

        var count  = 0;
        $('.textArea .editorArea > div.editorContainer').each(function () {
            var value = CKEDITOR.instances[$(this).attr('id')].getData();
            formData.append('editor' + (count ++), value);
        });

        /*for(var pair of formData.entries()) {
          alert(pair[0]+ ', '+ pair[1]); 
        }*/

        $.ajax({
            url: 'http://127.0.1.1/compagnielepassage.fr/admin/controller/formToModel.php',
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