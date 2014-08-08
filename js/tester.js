$(document).ready(function() {
    "use strict";
    updateCardFromCookie();

    $("#buttonNext").click(function() {

        $("#translation").slideUp("fast");

        var idLanguage = $('#selectMainLanguage').attr('data-value') + '';


        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "getRandomWord", idLanguage: idLanguage},
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
        return false;
    });

    $("#buttonHelp").click(function() {
        $("#translation").slideToggle("fast");
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

    //$('#brief').html(object.brief + "&nbsp;");

    var translations = [];
    translations = object.translation;
    $('#translation').html("");
    for(var t in translations) {
        trans = '<p class="translation">' + translations[t].word;
        if(parseInt(translations[t].id_language) == 3) { // FIXME: hardcoded language
            trans += ' <span>(' + translations[t].structure + ')</span></p>'
        }
        $('#translation').html($('#translation').html() + trans);
    }

}


