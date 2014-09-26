$(document).ready(function() {
    "use strict";

    $('.import').click(function(e) {
        console.log("Добавляем новое слово");
        alert($('#textImport').val());
        //var lines = $('#textImport').val().match(/^.*((\r\n|\n|\r)|$)/gm);
        var id_language = $('#selectLanguage').attr('data-value') + '';
        var id_category = $('#selectCategory').attr('data-value') + '';

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "importWords", data: $('#importWords').val(), idLanguage: id_language, idCategory: id_category},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    var words = object.words;
                    var id_language = object.id_language;

                    var table = '<table>';
                    for(var i in words) {
                        var word = words[i].word;
                        var structure = words[i].word;
                        var brief = words[i].brief;
                        var status = words[i].status;
                        var raw = '<tr><td>' + status + '</td><td>' + word + '</td><td>' + structure + '</td><td>' + brief + '</td></tr>'
                        table += raw;
                    }
                    table += '</table>';
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });


        return false;
    });
});

