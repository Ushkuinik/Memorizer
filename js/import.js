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
        var id_language = getLanguageId();
        var id_category = getCategoryId();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "importWords", data: data, idLanguage: id_language, idCategory: id_category},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    var status = object.status;
                    var id_language = object.id_language;

                    var table;
                    for(var i in status) {
                        var word = status[i].word;
                        var code = status[i].code;
                        var id = status[i].id;
                        switch(code) {
                            case 0: // successfully added
                                code = $('p.status-success').html();
                                var action = '';
                                break;
                            case 1: // word already present
                                code = $('p.status-present').html();
                                var action = $('p.action-add-synonym').html();
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
                        var row = '<tr><td>' + code + '</td><td>' + word + '</td><td>' + id + '</td><td>' + action + '</td></tr>';
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
});

function getCategoryId() {
    return $('#selectCategory').find('input').attr('data');
}

function getLanguageId() {
    return $('#selectLanguage').find('button').attr('data');
}