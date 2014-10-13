$(document).ready(function() {
    "use strict";

    $('#import2').hide();

    $('#selectCategory .dropdown-menu a').click(function(e) {
        e.preventDefault();
        var category_id = $(this).attr('href');
        var text = $(this).html();
        var i = $(this).parents('.input-group').children('input');
        i.val(text).attr('data', category_id);
        $(this).parents('.input-group').find('button').click();

        return true;
    });

    $('#selectLanguage .dropdown-menu a').click(function(e) {
        e.preventDefault();
        var v = $(this).attr('href');
        var t = $(this).html();
        var b = $(this).parents('.btn-group').children('button');
        b.html(t + ' <span class="caret"></span>').attr('data', v);
        return false;
    });

    $('.import').click(function(e) {
        console.log("Добавляем новое слово");

        var data = $('#textImport').val();
        var language_id = getLanguageId();
        var category_id = getCategoryId();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "importWords", data: data, language_id: language_id, category_id: category_id},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    var status = object.status;
                    var language_id = object.language_id;

                    var table;
                    for(var i in status) {
                        var id   = status[i].id;
                        var code = status[i].code;
                        var word = status[i].word;
                        switch(code) {
                            case 0: // successfully added
                                code = $('p.status-success').html();
                                var action = '';
                                break;
                            case 1: // word already present
                                code = $('p.status-present').html();
                                var action = $('p.action-add-synonym').html();
                                action = action.replace('[+id+]', id);
                                action = action.replace('[+word+]', word);
                                action = action.replace('[+structure+]', status[i].structure);
                                action = action.replace('[+brief+]', status[i].brief);
                                action = action.replace('[+language_id+]', status[i].language_id);
                                break;
                            case 2: // error during adding word
                                code = $('p.status-error').html();
                                break;
                            case 3: // error during assignment
                                code = $('p.status-error').html();
                                break;
                            default: break;
                        }
                        //var action = status[i].id;
                        word = createWord(id, word);
                        var row = '<tr><td class="status">' + code + '</td><td class="word">' + word + '</td><td class="id">' + id + '</td><td class="action">' + action + '</td></tr>';
                        table += row;
                    }
                    $('#import2').find('tbody').html(table);
                    $('#import1').fadeOut('fast', function() {
                        $('#import2').fadeIn('fast');
                    });
                    //$('.return').show('fast');
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });


        return false;
    });


    $('.return').click(function(e) {
        $('#import2').fadeOut('fast', function() {
            $('#import1').fadeIn('fast');
        });
    });

    $('#textImport').on('change keyup keydown paste cut', function() {
        $(this).height(0).height(this.scrollHeight);
    }).change();

    $('.dropdown-menu a').click(function(e) {
        e.preventDefault();
        var v = $(this).attr('href');
        var t = $(this).html();
        var b = $(this).parents('.btn-group').children('button');
        b.html(t + ' <span class="caret"></span>').attr('data-value', v).click();
        return false;
    });


    $('#tableList').on('click', 'button.add-synonym', function() {
        var word        = $(this).attr('word');
        var structure   = $(this).attr('structure');
        var brief       = $(this).attr('brief');
        var language_id = $(this).attr('language_id');
        var tr          = $(this).parents('tr');

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "addWord", word: word, structure: structure, brief: brief, idLanguage: language_id, idPartOfSpeech: "1"},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    var id = object.word_id;
                    tr.find('td.status').fadeOut('fast', function() {
                        $(this).html($('p.status-synonym-added').html()).fadeIn('fast');
                    });
                    tr.find('td.id').html(id);
                    tr.find('td.word').html(createWord(id, word));
                    tr.find('td.action').find('button').fadeOut('fast');
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    });


    $('#tableList').on('click', 'a', function() {
        var id = $(this).attr('data');
        var word = $(this).html();
        post('index.php?view=config', {id1: id, word1: word}, 'post');
        return false;
    });

});

function getCategoryId() {
    return $('#selectCategory').find('input').attr('data');
}

function getLanguageId() {
    return $('#selectLanguage').find('button').attr('data');
}

function createWord(_id, _word) {
    return '<a href="index.php?view=config" data="' + _id + '">' + _word + '</a>';
}