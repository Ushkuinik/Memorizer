$(document).ready(function() {
    "use strict";
    $('#buttonAddWord1').hide();
    $('#buttonDeleteWord1').hide();
    $('#buttonSaveWord1').hide();

    $('#buttonAddWord2').hide();
    $('#buttonDeleteWord2').hide();
    $('#buttonSaveWord2').hide();

    $('#buttonLinkWords').hide();
    $('#buttonUnlinkWords').hide();

    $('#buttonAddWord1').click(function(e) {
        console.log("Добавляем новое слово");

        var word = $('#inputWord1').val() + '';
        var structure = $('#inputStructure1').val() + '';
        var brief = $('#inputBrief1').val() + '';
        var idLanguage = getLanguageId('1');// $('#selectLanguage1').attr('data-value') + '';
//        var idPartOfSpeech = $('#selectPartOfSpeech1').attr('data-value') + '';

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "addWord", word: word, structure: structure, brief: brief, idLanguage: idLanguage, idPartOfSpeech: "1"},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    setWordId('1', object.word_id);
                    switchToEditMode('1', object.word_id)
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });

        return false;
    });

    $('#buttonSaveWord1').click(function(e) {
        console.log("Сохраняем");

        var id = $(this).attr('data-id');
        console.log("id: " + id);
        var word = $('#inputWord1').val() + '';
        var structure = $('#inputStructure1').val() + '';
        var brief = $('#inputBrief1').val() + '';
        var idLanguage = getLanguageId('1'); //$('#selectLanguage1').attr('data-value') + '';
//        var idPartOfSpeech = $('#selectPartOfSpeech1').attr('data-value') + '';

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "saveWord", id: id, word: word, structure: structure, brief: brief, idLanguage: idLanguage, idPartOfSpeech: "1"},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);
                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    setWordId('1', id);
                    switchToEditMode('1', id)
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });

        return false;
    });

    $('#buttonDeleteWord1').click(function(e) {
        console.log("Удаляем");

        var id = $(this).attr('data-id');
        console.log("id: " + id);

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "deleteWord", id: id},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    $('#inputWord1').val('');
                    $('#inputStructure1').val('');
                    $('#inputBrief1').val('');

                    $('#buttonAddWord1').hide();
                    $('#buttonDeleteWord1').hide();
                    $('#buttonDeleteWord1').attr('data-id', '');
                    $('#buttonSaveWord1').hide();
                    $('#buttonSaveWord1').attr('data-id', '');

                    $('#buttonLinkWords').fadeOut('fast');
                    $('#buttonUnlinkWords').fadeOut('fast');
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });

        return false;
    });

    $('#buttonAddWord2').click(function(e) {
        console.log("Добавляем новое слово");

        var word = $('#inputWord2').val() + '';
        var structure = $('#inputStructure2').val() + '';
        var brief = $('#inputBrief2').val() + '';
        var idLanguage = getLanguageId('2'); //$('#selectLanguage2').attr('data-value') + '';
//        var idPartOfSpeech = $('#selectPartOfSpeech1').attr('data-value') + '';

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "addWord", word: word, structure: structure, brief: brief, idLanguage: idLanguage, idPartOfSpeech: "1"},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    setWordId('2', object.word_id);
                    switchToEditMode('2', object.word_id)
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });

        return false;
    });

    $('#buttonSaveWord2').click(function(e) {
        console.log("Сохраняем");

        var id = $(this).attr('data-id');
        console.log("id: " + id);
        var word = $('#inputWord2').val() + '';
        var structure = $('#inputStructure2').val() + '';
        var brief = $('#inputBrief2').val() + '';
        var idLanguage = getLanguageId('2'); //$('#selectLanguage2').attr('data-value') + '';
//        var idPartOfSpeech = $('#selectPartOfSpeech1').attr('data-value') + '';

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "saveWord", id: id, word: word, structure: structure, brief: brief, idLanguage: idLanguage, idPartOfSpeech: "1"},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    setWordId('2', id);
                    switchToEditMode('2', id)
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });

        return false;
    });

    $('#buttonDeleteWord2').click(function(e) {
        console.log("Удаляем");

        var id = $(this).attr('data-id');
        console.log("id: " + id);

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "deleteWord", id: id},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    $('#inputWord2').val('');
                    $('#inputStructure2').val('');
                    $('#inputBrief2').val('');

                    $('#buttonAddWord2').hide();
                    $('#buttonDeleteWord2').hide();
                    $('#buttonDeleteWord2').attr('data-id', '');
                    $('#buttonSaveWord2').hide();
                    $('#buttonSaveWord2').attr('data-id', '');

                    $('#buttonLinkWords').fadeOut('fast');
                    $('#buttonUnlinkWords').fadeOut('fast');
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });

        return false;
    });


    $('.dropdown-menu a').click(function(e) {
        e.preventDefault();
        var v = $(this).attr('href');
        var t = $(this).html();
        var b = $(this).parents('.btn-group').children('button');
        b.html(t + ' <span class="caret"></span>').attr('data', v).click();
        return false;
    });

//    $('#buttonNewWord').click(function(e) {
//        e.preventDefault();
//        console.log("Добавляем новое слово2");
//        //location.href = "index.php?view=config";
//        return false;
//    });
//
//    $("#inputWord").keyup(function(event) {
//        $('#buttonAddWord').attr('disabled', (this.value.length == 0));
//    });

//    $("#inputWord1").keyup(function(event) {
//        $('#buttonAddWord1').attr('disabled', (this.value.length == 0));
//    });

//    $('#buttonAddWord').click(function(e) {
//        e.preventDefault();
////        console.log("click");
//
//        var word = $('#inputWord').val() + '';
//        var structure = $('#inputStructure').val() + '';
//        var brief = $('#inputBrief').val() + '';
//        var idLanguage = $('#selectMainLanguage').attr('data-value') + '';
////        var idPartOfSpeech = $('#selectPartOfSpeech').attr('data-value') + '';
//
//        $.ajax({
//            type: 'POST',
//            url: 'ajax.php',
//            data: {command: "addWord", word: word, structure: structure, brief: brief, idLanguage: idLanguage, idPartOfSpeech: "1"},
//            success: function(data) {
//                console.log(data);
//
//                var object = jQuery.parseJSON(data);
//                var message = alertResult(object.code, object.message, object.sql);
//
//                $('#result').html(message);
//                if(parseInt(object.code) == 0) {
//                    $('#inputWord').val('');
//                    $('#inputStructure').val('');
//                    $('#inputBrief').val('');
//                }
//            },
//            error: function(request, status, error) {
//                alert(request.responseText);
//            }
//        });
//        return false;
//    });

    $('#searchWord1').submit(function(e) {
        e.preventDefault();
        console.log("form#searchWord1.submit");

        var search_input = $(this).find('input.search-input');
        var search_text = search_input.val();
        console.log("search_text: " + search_text);

        var id = search_input.attr('data');
        if((id == '') || ((parseInt(id) == 0)))
        {
            console.log('Новое слово');

            $('#inputWord1').val(search_text);
            $('#inputStructure1').val(search_text);
            $('#inputBrief1').val('');

            $('#buttonDeleteWord1').fadeOut('fast');
            $('#buttonSaveWord1').fadeOut('fast', function(){
                $('#buttonAddWord1').fadeIn('fast');
            });

            setLanguageId('1', detectLanguage(search_text));

            return false;
        }
        else {
            console.log('Существующее слово, id: ' + id);

            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {command: "getWord", id: id, flag: false},
                success: function(data) {
                    console.log('Получили ответ с данными о слове id: ' + id);
                    console.log('data: ' + data);

                    var object = jQuery.parseJSON(data);
                    bake_cookie("memorizer_word", object.word);

                    var message = alertResult(object.code, object.message, object.sql);

                    $('#result').html(message);
                    var word = object.word;
                    if(parseInt(object.code) == 0) {
                        console.log('Заполняем поля данными о слове id: ' + id);
                        $('#inputWord1').val(word.word);
                        $('#inputStructure1').val(word.structure);
                        $('#inputBrief1').val(word.brief);

                        setLanguageId('1', word.language_id); //$('#selectLanguage1').attr('data-value', word.language_id);

                        switchToEditMode('1', id);
                        $("#wordCard1").html(createWordCard(word));

                        var min_code = 0xffffffff;
                        var max_code = 0;
                        for(var c in word.word) {
                            if(word.word.charCodeAt(c) > max_code)
                                max_code = word.word.charCodeAt(c);
                            if(word.word.charCodeAt(c) < min_code)
                                min_code = word.word.charCodeAt(c);
                        }
                        console.log(min_code.toString(16) + ' - ' + max_code.toString(16));
                    }
                },
                error: function(request, status, error) {
                    alert(request.responseText);
                }
            });
        }
        return false;
    });


    $('#searchWord2').submit(function(e) {
        e.preventDefault();
        console.log("form#searchWord2.submit");

        var search_input = $(this).find('input.search-input');
        var search_text = search_input.val();
        console.log("search_text: " + search_text);

        var id = search_input.attr('data');
        if((id == '') || ((parseInt(id) == 0)))
        {
            console.log('Новое слово');

            $('#inputWord2').val(search_text);
            $('#inputStructure2').val(search_text);
            $('#inputBrief2').val('');

            $('#buttonDeleteWord2').fadeOut('fast');
            $('#buttonSaveWord2').fadeOut('fast', function(){
                $('#buttonAddWord2').fadeIn('fast');
            });

            setLanguageId('2', detectLanguage(search_text));

            return false;
        }
        else {
            console.log('Существующее слово, id: ' + id);

            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {command: "getWord", id: id, flag: false},
                success: function(data) {
                    console.log('Получили ответ с данными о слове id: ' + id);
                    console.log('data: ' + data);

                    var object = jQuery.parseJSON(data);
                    var message = alertResult(object.code, object.message, object.sql);

                    $('#result').html(message);
                    var word = object.word;
                    if(parseInt(object.code) == 0) {
                        console.log('Заполняем поля данными о слове id: ' + id);
                        $('#inputWord2').val(word.word);
                        $('#inputStructure2').val(word.structure);
                        $('#inputBrief2').val(word.brief);

                        setLanguageId('2', word.language_id);
                    }
                    switchToEditMode('2', id);
                    $("#wordCard2").html(createWordCard(word));
                },
                error: function(request, status, error) {
                    alert(request.responseText);
                }
            });
        }
        return false;
//            document.location.href = search_input.attr('data');

//        console.log('check: ' + search_input.val());
    });

    $("#searchWord1").keyup(function(event) {
        if( (event.keyCode != 13) &&
            (event.keyCode != 40) &&
            (event.keyCode != 38)) {
            $('#inputWord1').val('');
            $('#inputStructure1').val('');
            $('#inputBrief1').val('');
            $('#buttonAddWord1').fadeOut('fast');
            $('#buttonSaveWord1').fadeOut('fast');
            $('#buttonDeleteWord1').fadeOut('fast');
            $('#buttonLinkWords').fadeOut('fast');
            $('#buttonUnlinkWords').fadeOut('fast');
        }
    });

    $("#searchWord2").keyup(function(event) {
        if( (event.keyCode != 13) &&
            (event.keyCode != 40) &&
            (event.keyCode != 38)) {
            $('#inputWord2').val('');
            $('#inputStructure2').val('');
            $('#inputBrief2').val('');
            $('#buttonAddWord2').fadeOut('fast');
            $('#buttonSaveWord2').fadeOut('fast');
            $('#buttonDeleteWord2').fadeOut('fast');
            $('#buttonLinkWords').fadeOut('fast');
            $('#buttonUnlinkWords').fadeOut('fast');
        }
    });


    $('#buttonLinkWords').click(function(e) {
        var id1 =  $('#searchWord1').find('input.search-input').attr('data');
        var id2 =  $('#searchWord2').find('input.search-input').attr('data');
        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "linkWords", id1: id1, id2: id2},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    $('#searchWord1').submit()
                    $('#searchWord2').submit()
                    $('#buttonLinkWords').fadeOut('fast', function() {
                        $('#buttonUnlinkWords').fadeIn('fast');
                    });
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });

        return false;
    });


    $('#buttonUnlinkWords').click(function(e) {
        var id1 =  $('#searchWord1').find('input.search-input').attr('data');
        var id2 =  $('#searchWord2').find('input.search-input').attr('data');
        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "unlinkWords", id1: id1, id2: id2},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    $('#searchWord1').submit()
                    $('#searchWord2').submit()
                    $('#buttonUnlinkWords').fadeOut('fast', function() {
                        $('#buttonLinkWords').fadeIn('fast');
                    });
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });

        return false;
    });

    $('#wordCard1').on('click', '.translation', function() {
        setWordId('2', $(this).attr('data')).val($(this).text());
        $('#searchWord2').submit();
    });

    $('#wordCard2').on('click', '.translation', function() {
        setWordId('1', $(this).attr('data')).val($(this).text());
        $('#searchWord1').submit();
    });

    if((getWordId('1') > 0) && ($('#searchWord1').find('input.search-input').val().length > 0))
        $('#searchWord1').submit();
    if((getWordId('2') > 0) && ($('#searchWord2').find('input.search-input').val().length > 0))
        $('#searchWord2').submit();
});

function getTranslation(_id) {
    var object = read_cookie("memorizer_word");
    if(object != null) {
        var translation = object.translation;
        for(t in translation) {
            if(translation[t].id == _id)
                return true;
        }
    }
    return false;
};

function setWordId(_group, _id) {
    var selector = '#searchWord' + _group;
    var control = $(selector).find('input.search-input');
    control.attr('data', _id);
    return control;
}

function getWordId(_group) {
    var selector = '#searchWord' + _group;
    return $(selector).find('input.search-input').attr('data');
}

function setLanguageId(_group, _id) {
    var selector = '#selectLanguage' + _group;
    $(selector).find('button').html($(selector).parent().find('li a[href="' + _id + '"]').html());
    $(selector).find('button').attr('data', _id);
}

function getLanguageId(_group) {
    var selector = '#selectLanguage' + _group;
    return $(selector).find('button').attr('data');
}

function switchToEditMode(_group, _id) {
    var buttonAddWord = '#buttonAddWord' + _group;
    var buttonDeleteWord = '#buttonDeleteWord' + _group;
    var buttonSaveWord = '#buttonSaveWord' + _group;

    $(buttonAddWord).fadeOut('fast', function() {
        $(buttonDeleteWord).fadeIn('fast');
        $(buttonDeleteWord).attr('data-id', _id);
        $(buttonSaveWord).fadeIn('fast');
        $(buttonSaveWord).attr('data-id', _id);

        var id1 = getWordId('1');
        var id2 = getWordId('2');
        if((id1.length > 0) && (id2.length > 0) && (id1 != id2)) {
            //if($('#selectLanguage1').attr('data-value') == $('#selectLanguage2').attr('data-value')) {
            if(getLanguageId('1') == getLanguageId('2')) {
                //synonyms
                $('#buttonLinkWords').fadeOut('fast');
                $('#buttonUnlinkWords').fadeOut('fast');
            }
            else {
                if(getTranslation(id2)) {
                    $('#buttonLinkWords').fadeOut('fast', function() {
                        $('#buttonUnlinkWords').fadeIn('fast');
                    });
                } else {
                    $('#buttonUnlinkWords').fadeOut('fast', function() {
                        $('#buttonLinkWords').fadeIn('fast');
                    });
                }
            }
        }

//        $('#buttonLinkWords').fadeOut('fast');
//        $('#buttonUnlinkWords').fadeOut('fast');
    });
}

function detectLanguage(_word) {
    var intervals = {
        1: {min: 0x00000000, max: 0x0000007f},
        2: {min: 0x00000080, max: 0x000007ff},
        3: {min: 0x00000800, max: 0x0000ffff},
        4: {min: 0x00010000, max: 0x001fffff},
        5: {min: 0x00200000, max: 0x03ffffff},
        6: {min: 0x04000000, max: 0x7fffffff}
    }
    var min_code = 0xffffffff;
    var max_code = 0;
    for(var c in _word) {
        if(_word.charCodeAt(c) > max_code)
            max_code = _word.charCodeAt(c);
        if(_word.charCodeAt(c) < min_code)
            min_code = _word.charCodeAt(c);
    }
    console.log(min_code.toString(16) + ' - ' + max_code.toString(16));
    var interval = 0;
    for(i in intervals) {
        if(max_code < intervals[i]['max']) {
            interval = i;
            break;
        }
    }
    console.log('interval: ' + interval);
    switch(parseInt(interval)) {
        case 1: return 2;
        case 2: return 1;
        case 3: return 3;
        default: return 0;
    }
}


function createWordCard(_word) {
    var translation = _word.translation;
    var result = '';

    template_card = '<h3>[+word+]</h3>' +
        '<p>[+brief+]</p>' +
        '<ul>' +
        '[+translations+]' +
        '</ul>';
    template_translation = '<li class="translation clickable" data="[+id+]">[+translation+]</li>';

    var translations = '';
    for(t in translation) {
        item = template_translation.replace('[+translation+]', translation[t].word);
        item = item.replace('[+id+]', translation[t].id);
        translations += item;
    }
    result = template_card;
    result = result.replace('[+word+]', _word.word);
    if(_word.brief == null)
        _word.brief = "";
    result = result.replace('[+brief+]', _word.brief);
    result = result.replace('[+translations+]', translations);

/*
    result += '<h3>' + _word.word + '</h3>';
    result += '<p>' + _word.brief + '</p>';
    result += '<ul>';
    result += '</ul>';
*/
    return result;
}