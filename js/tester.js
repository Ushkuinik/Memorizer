$(document).ready(function() {
    "use strict";

    $('#selectCategory .dropdown-menu a').click(function(e) {
        e.preventDefault();
        var category_id = $(this).attr('href');
        var text = $(this).html();
        var i = $(this).parents('.input-group').children('input');
        i.val(text).attr('data', category_id);

        return true;
    });

    $('#selectMainLanguage .dropdown-menu a').click(function(e) {
        e.preventDefault();
        var v = $(this).attr('href');
        var t = $(this).html();
        var b = $(this).parents('.btn-group').children('button');
        b.html(t + ' <span class="caret"></span>').attr('data', v).click();
        $("#buttonNext").click();
        return false;
    });


    $("#buttonNext").click(function() {

        //$("#translation").slideUp("fast");
        $('#buttonPrevious').prop('disabled', false);

        var language_id = getLanguageId();
        var category_id = getCategoryId();

        var stack = getStack();

        var old_current_index = stack.current_index;
        stack.current_index++;
        if(stack.current_index >= stack.ids.length)
            stack.current_index = 0;

        if(old_current_index == stack.last_index) {
            stack.last_index = stack.current_index
            var data = {command: "getRandomWord", language_id: language_id, category_id: category_id};
        } else {
            var data = {command: "getWord", id: stack.ids[stack.current_index], flag: 1};
        }
        saveStack(stack);

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: data,
            success: function(data) {
                console.log('data: ' + data);

                var object = jQuery.parseJSON(data);
                bake_cookie("memorizer", object.word);

                if(object != null)
                    updateCard(object.word);

                $('#result').html(alertResult(object.code, object.message, object.sql));

                var stack = getStack();
                if(stack.current_index == stack.last_index) {
                    stack.last_index = stack.current_index;
                    stack.ids[stack.current_index] = object.word.id;
                }
                saveStack(stack);
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });

        return false;
    });

    $("#buttonHelp").click(function() {
        $("#translation").slideToggle("fast");
        return false;
    });

    $("#buttonPrevious").click(function() {
        var stack = getStack();

        stack.current_index--;
        if(stack.current_index < 0)
            stack.current_index = stack.ids.length - 1;

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "getWord", id: stack.ids[stack.current_index], flag: 1},
            success: function(data) {
                console.log('data: ' + data);

                var object = jQuery.parseJSON(data);
                bake_cookie("memorizer", object.word);

                if(object != null)
                    updateCard(object.word);

                $('#result').html(alertResult(object.code, object.message, object.sql));
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });

        var prev = stack.current_index - 1;
        if(prev < 0)
            prev = stack.ids.length - 1;
        if((stack.ids[prev] == 0) || (prev == stack.last_index)) {
            $('#buttonPrevious').prop('disabled', true);
            console.log("Disable Prev");
        }

        saveStack(stack);
        return false;
    });

    $('#radioWordStructure input').change(function(e) {
        e.preventDefault();
        updateCardFromCookie();
    })
});


function updateCardFromCookie() {
    var object = read_cookie("memorizer");
    if(object != null)
        updateCard(object);
}

function updateCard(object) {

    if($("#radioWordStructure .btn input:checked").val() == 1) {
        word = object.structure.replace(/!/g, '&#x301;');
        word = word.replace(/\[/g, '<span class="accent">');
        word = word.replace(/\]/g, '</span>');
        word = word.charAt(0).toUpperCase() + word.slice(1);
        $('#word').html(word);
    } else {
        $('#word').html(object.word);
    }

    var translations = object.translation;
    $('#translation').html("");
    for(var t in translations) {
        trans = '<p class="translation">' + translations[t].word;
        if(parseInt(translations[t].language_id) == 3) { // FIXME: hardcoded language
            trans += ' <span>(' + translations[t].structure + ')</span></p>'
        }
        $('#translation').html($('#translation').html() + trans);
    }

}


function getStack() {
    var stack = read_cookie("memorizer_stack");
    if(stack == null) {
        stack = createStack();
    }
    return stack;
}


function createStack() {
    var ids = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    var stack = {ids: ids, last_index: 0, current_index: 0};
    return stack;
}


function saveStack(_stack) {
    if(_stack != null)
        bake_cookie("memorizer_stack", _stack);
}

function getCategoryId() {
    return $('#selectCategory').find('input').attr('data');
}

function getLanguageId() {
    return $('#selectMainLanguage').find('button').attr('data');
}