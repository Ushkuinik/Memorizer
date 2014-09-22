//operation1: Add new word1
//operation1: Edit word1
//operation2: Add new word2
//operation2: Edit word1
//operation3: Link word1 and word2

$(document).ready(function() {
    "use strict";
    $('#buttonAddWord1').hide();
    $('#buttonDeleteWord1').hide();
    $('#buttonSaveWord1').hide();

    $('#buttonAddWord2').hide();
    $('#buttonDeleteWord2').hide();
    $('#buttonSaveWord2').hide();

    $('#buttonAddWord1').click(function(e) {
        console.log("Добавляем новое слово");

        var word = $('#inputWord1').val() + '';
        var structure = $('#inputStructure1').val() + '';
        var brief = $('#inputBrief1').val() + '';
        var idLanguage = $('#selectLanguage1').attr('data-value') + '';
//        var idPartOfSpeech = $('#selectPartOfSpeech1').attr('data-value') + '';

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
                    $('#inputWord1').val('');
                    $('#inputStructure1').val('');
                    $('#inputBrief1').val('');

                    $('#buttonAddWord1').hide();
                    $('#buttonDeleteWord1').hide();
                    $('#buttonDeleteWord1').attr('data-id', '');
                    $('#buttonSaveWord1').hide();
                    $('#buttonSaveWord1').attr('data-id', '');
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
        var idLanguage = $('#selectLanguage1').attr('data-value') + '';
//        var idPartOfSpeech = $('#selectPartOfSpeech1').attr('data-value') + '';

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "saveWord", id: id, word: word, structure: structure, brief: brief, idLanguage: idLanguage, idPartOfSpeech: "1"},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message + object.sql);

                $('#result').html($('#result').html() + message);
                if(parseInt(object.code) == 0) {
                    $('#inputWord1').val('');
                    $('#inputStructure1').val('');
                    $('#inputBrief1').val('');

                    $('#buttonAddWord1').hide();
                    $('#buttonDeleteWord1').hide();
                    $('#buttonDeleteWord1').attr('data-id', '');
                    $('#buttonSaveWord1').hide();
                    $('#buttonSaveWord1').attr('data-id', '');
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
                var message = alertResult(object.code, object.message + object.sql);

                $('#result').html($('#result').html() + message);
                if(parseInt(object.code) == 0) {
                    $('#inputWord1').val('');
                    $('#inputStructure1').val('');
                    $('#inputBrief1').val('');

                    $('#buttonAddWord1').hide();
                    $('#buttonDeleteWord1').hide();
                    $('#buttonDeleteWord1').attr('data-id', '');
                    $('#buttonSaveWord1').hide();
                    $('#buttonSaveWord1').attr('data-id', '');
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
        var idLanguage = $('#selectLanguage2').attr('data-value') + '';
//        var idPartOfSpeech = $('#selectPartOfSpeech1').attr('data-value') + '';

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
                    $('#inputWord2').val('');
                    $('#inputStructure2').val('');
                    $('#inputBrief2').val('');

                    $('#buttonAddWord2').hide();
                    $('#buttonDeleteWord2').hide();
                    $('#buttonDeleteWord2').attr('data-id', '');
                    $('#buttonSaveWord2').hide();
                    $('#buttonSaveWord2').attr('data-id', '');
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
        var idLanguage = $('#selectLanguage2').attr('data-value') + '';
//        var idPartOfSpeech = $('#selectPartOfSpeech1').attr('data-value') + '';

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "saveWord", id: id, word: word, structure: structure, brief: brief, idLanguage: idLanguage, idPartOfSpeech: "1"},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message + object.sql);

                $('#result').html($('#result').html() + message);
                if(parseInt(object.code) == 0) {
                    $('#inputWord2').val('');
                    $('#inputStructure2').val('');
                    $('#inputBrief2').val('');

                    $('#buttonAddWord2').hide();
                    $('#buttonDeleteWord2').hide();
                    $('#buttonDeleteWord2').attr('data-id', '');
                    $('#buttonSaveWord2').hide();
                    $('#buttonSaveWord2').attr('data-id', '');
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
                var message = alertResult(object.code, object.message + object.sql);

                $('#result').html($('#result').html() + message);
                if(parseInt(object.code) == 0) {
                    $('#inputWord2').val('');
                    $('#inputStructure2').val('');
                    $('#inputBrief2').val('');

                    $('#buttonAddWord2').hide();
                    $('#buttonDeleteWord2').hide();
                    $('#buttonDeleteWord2').attr('data-id', '');
                    $('#buttonSaveWord2').hide();
                    $('#buttonSaveWord2').attr('data-id', '');
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
        b.html(t + ' <span class="caret"></span>').attr('data-value', v).click();
        $("#buttonNext").click();
//        console.log(b);
        return false;
    });

    $('#buttonNewWord').click(function(e) {
        e.preventDefault();
        console.log("Добавляем новое слово2");
        //location.href = "index.php?view=config";
        return false;
    });

    $("#inputWord").keyup(function(event) {
        $('#buttonAddWord').attr('disabled', (this.value.length == 0));
    });

    $("#inputWord1").keyup(function(event) {
        $('#buttonAddWord1').attr('disabled', (this.value.length == 0));
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
                    var message = alertResult(object.code, object.message + object.sql);

                    $('#result').html($('#result').html() + message);
                    var word = object.word;
                    if(parseInt(object.code) == 0) {
                        console.log('Заполняем поля данными о слове id: ' + id);
                        $('#inputWord1').val(word.word);
                        $('#inputStructure1').val(word.structure);
                        $('#inputBrief1').val(word.brief);

                        var title = $('#selectLanguage1').parent().find('li a[href="' + word.id_language + '"]').html();
                        if(title.length > 0) {
                            $('#selectLanguage1').html(title);
                            $('#selectLanguage1').attr('data-value', word.id_language);
                        }

                        $('#buttonAddWord1').fadeOut('fast', function(){
                            $('#buttonDeleteWord1').fadeIn('fast');
                            $('#buttonDeleteWord1').attr('data-id', id);
                            $('#buttonSaveWord1').fadeIn('fast');
                            $('#buttonSaveWord1').attr('data-id', id);
                        });
                    }
    /*
                    else {
                    }
    */
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
                    var message = alertResult(object.code, object.message + object.sql);

                    $('#result').html($('#result').html() + message);
                    var word = object.word;
                    if(parseInt(object.code) == 0) {
                        console.log('Заполняем поля данными о слове id: ' + id);
                        $('#inputWord2').val(word.word);
                        $('#inputStructure2').val(word.structure);
                        $('#inputBrief2').val(word.brief);

                        var title = $('#selectLanguage2').parent().find('li a[href="' + word.id_language + '"]').html();
                        if(title.length > 0) {
                            $('#selectLanguage2').html(title);
                            $('#selectLanguage2').attr('data-value', word.id_language);
                        }

                        $('#buttonAddWord2').fadeOut('fast', function(){
                            $('#buttonDeleteWord2').fadeIn('fast');
                            $('#buttonDeleteWord2').attr('data-id', id);
                            $('#buttonSaveWord2').fadeIn('fast');
                            $('#buttonSaveWord2').attr('data-id', id);
                        });
                    }
                    /*
                     else {
                     }
                     */
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
});

