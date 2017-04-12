$( document ).ready(function() {

    var isRecentSave = true;
    var timeout = setTimeout(function(){ isRecentSave = false; }, 30000);

    function preprocessFormData(formData) {
        // Textareas
        var count = 0;
        $('.textArea .editorArea > div.editorContainer').each(function () {
            var value = CKEDITOR.instances[$(this).attr('id')].getData();
            formData.append('editor' + (count ++), value);
        });
        count = 0;
        $('.textArea #isTwoCol input').each(function () {
            var value = $(this).is(':checked');
            formData.append('isTwoCol' + (count ++), value);
        });

        // Galleries
        count = 0;
        $('.galery').each(function () {
            var nbImages = $(this).find('.galeryImage').length;
            formData.append('gallery' + (count ++), nbImages);
        });

        return formData;
    }

    function saveForm() {
        var formData = new FormData(document.getElementById('mainForm'));
        formData = preprocessFormData(formData);

        isRecentSave = true;
        clearTimeout(timeout);
        timeout = setTimeout(function(){ isRecentSave = false; }, 30000);

        $.ajax({
            url: '../controller/saveSectionForm.php',
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

    $("#nav button").click(function() {
        if (!isRecentSave && confirm("Enregistrer les modifications ?")) {
            saveForm();
        }
        window.location = "menu.php";
    });
});