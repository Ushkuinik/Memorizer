$(document).ready(function() {
    "use strict";
    updateCardFromCookie();

    $("#buttonNext").click(function() {

        $("#translation").slideUp("fast");

        var idLanguage = $('#selectMainLanguage').attr('data-value') + '';


        $.ajax({
            type: 'POST',
            url: 'ajaxTester.php',
            data: {command: "getRandomWord", idLanguage: idLanguage},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                bake_cookie("memorizer", object);

                if(object != null)
                    updateCard(object);

//                message = alertResult(object.result_code, object.result_message + object.result_sql);

//                $('#result').html($('#result').html() + message);
//                $('#tableCompany tbody').append(object.aux);

            },
            error: function (request, status, error) {
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
        word = object.wordStructure.replace(/!/g, '&#x301;');
        word = word.replace(/\[/g, '<span class="accent">');
        word = word.replace(/\]/g, '</span>');
        word = word.charAt(0).toUpperCase() + word.slice(1);
        $('#word').html(word);
    } else {
        $('#word').html(object.wordWord);
    }

    //$('#brief').html(object.wordBrief + "&nbsp;");

    var translations = [];
    translations = object.wordTranslation;
    $('#translation').html("");
    for(var t in translations) {
        trans = '<p class="translation">' + translations[t].transWord;
        if(parseInt(translations[t].transLanguageId) == 3) { // FIXME: hardcoded language
            trans += ' <span>(' + translations[t].transStructure + ')</span></p>'
        }
        $('#translation').html($('#translation').html() + trans);
//                    alert("" + t + translations[t]);
    }
}

function alertResult(result_code, result_message)
{
  var alert_class = "warning";
  var alert_title = "";

  switch(parseInt(result_code))
  {
    case 0:
      alert_class = "success";
      break;
    case 1:
      alert_class = "danger";
      alert_title = "Ошибка!";
      break;
    default:
      alert_class = "warning";
      alert_title = "Предупреждение!";
      break;
  }

  content = '<div class="alert alert-' + alert_class + ' fade in\">\n \
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n \
    <strong>'+ alert_title +'</strong> ' + result_message + '\n \
    </div>\n';

  return content;
}


