$(document).ready(function() {
    "use strict";
    $('#buttonAddWord').attr('disabled', ($('#inputWord1').val().length == 0));

    $('.dropdown-menu a').click(function(e) {
        e.preventDefault();
        var v = $(this).attr('href');
        var t = $(this).html();
        var b = $(this).parents('.btn-group').children('button');
        b.html(t + ' <span class="caret"></span>').attr('data-value', v).click();
        $("#buttonNext").click();
//        console.log(b);
        return false;
    });

    $('#buttonNewWord').click(function(e) {
        e.preventDefault();
        location.href = "index.php?view=config";
        return false;
    });

    $("#inputWord").keyup(function(event) {
        $('#buttonAddWord').attr('disabled', (this.value.length == 0));
    });

    $('#buttonAddWord').click(function(e) {
        e.preventDefault();
//        console.log("click");

        var word = $('#inputWord').val() + '';
        var structure = $('#inputStructure').val() + '';
        var brief = $('#inputBrief').val() + '';
        var idLanguage = $('#selectMainLanguage').attr('data-value') + '';
//        var idPartOfSpeech = $('#selectPartOfSpeech').attr('data-value') + '';

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "addWord", word: word, structure: structure, brief: brief, idLanguage: idLanguage, idPartOfSpeech: "1"},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message + object.sql);

                $('#result').html($('#result').html() + message);
                if(parseInt(object.code) == 0) {
                    $('#inputWord').val('');
                    $('#inputStructure').val('');
                    $('#inputBrief').val('');
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
        return false;
    });

    $('#searchWord1').submit(function(e) {
        e.preventDefault();
        var search_input = $(this).find('input.search-input');
        if(search_input.attr('data').length > 0)
            document.location.href = search_input.attr('data');

//        console.log('check: ' + search_input.val());
        return false;
    });


    $('#searchWord2').submit(function(e) {
        e.preventDefault();
        var search_input = $(this).find('input.search-input');
        var id = search_input.attr('data');

        if((id == '') || ((parseInt(id) == 0)))
            return false;

        console.log('id: ' + id);

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "getWord", id: id, flag: false},
            success: function(data) {
                console.log('data: ' + data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message + object.sql);

                $('#result').html($('#result').html() + message);
                var word = object.word;
                if(parseInt(object.code) == 0) {
                    $('#inputWord2').val(word.word);
                    $('#inputStructure2').val(word.structure);
                    $('#inputBrief2').val(word.brief);

                    var title = $('#selectLanguage2').parent().find('li a[href="' + word.id_language + '"]').html();
                    if(title.length > 0) {
                        $('#selectLanguage2').html(title);
                        $('#selectLanguage2').attr('data-value', word.id_language);
                    }
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });


        return false;
    });
});

