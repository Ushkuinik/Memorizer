$(document).ready(function() {
    $("[data-toggle='popover']").popover({trigger: 'hover'});
    $(".alert").alert();


    $(document).on('click', function() { // закрываем список поисковых советов при клике вне списка
        $('.search-suggest').slideUp("fast");
        $('.popover').slideUp("fast");
    })


    $(".form-search").submit(function(e) {
        e.preventDefault();
        var search_input = $(this).find('input.search-input');
        search_text = search_input.val();
        var suggest_list = $(this).find('ul');

        if(suggest_list.is(':visible')) {
//            return;
        }
        if(search_text == '') {
            console.log("Пустой запрос!");

            $(this).popover({
                animation: true,
                trigger: 'manual',
                placement: 'bottom',
                content: 'Строка не должна быть пустой!',
                template: '<div class="popover popover-error"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p></p></div></div></div>'
            });

            $(this).popover('show');
            search_input.focus();
        }
        else {
            console.log("Автоподсказка ищет: " + search_text);
            if(search_input.attr('data').length > 0) {
                //console.log("прыг на : " + search_input.attr('data'));
//                document.location.href = search_input.attr('data');
            }
        }
        return false;
    });


    $(".form-search").keyup(function(event) {

        handled = false;
        var suggest_list = $(this).find('ul');
        var search_input = $(this).find('input.search-input');
        $(this).popover('destroy');

        switch(event.keyCode) {
            case 13: // enter
                event.preventDefault();
                console.log("Поймали Enter в форме поиска");
                if(suggest_list.is(':visible')) {
//                    event.preventDefault();
                    if(suggest_list.find('.btn-info').length) {
                        if(suggest_list.find('.btn-info a').attr('href') != null) {
                            search_input.val(removeDecorations(suggest_list.find('.btn-info a').text()));

                            search_input.attr('data', suggest_list.find('.btn-info a').attr('href'));
                            console.log("Выбранный элемент - ссылка: " + suggest_list.find('.btn-info a').attr('href'));
                            console.log("Подставляем его в строку поиска");
                            $(this).submit();
                        }
                        else {
                            console.log("Не ссылка");
                        }
                        suggest_list.slideUp("fast");
                        search_input.focus();
                        handled = true;
                    }
                    else {
                        $(this).submit(); // запускаем обработку слова, которое не выбрано из подсказки (подсказка видна)
                    }
                }
                else {
                    $(this).submit(); // запускаем обработку слова, для которого нет всплывающей подсказки
                }
                break;
            case 40: // down arrow
                event.preventDefault();
                if(suggest_list.is(':visible')) {
                    if(suggest_list.find('.btn-info').length) {
                        item_current = suggest_list.find('.btn-info');
                        item_next = item_current.next('li');

                        if(item_next.length) {
                            item_current.removeClass('btn-info');
                            item_next.addClass("btn-info");
                        }
                    }
                    else {
                        suggest_list.find('li').first().addClass("btn-info");
                    }
                    handled = true;
                }
                break;
            case 38: // up arrow
                event.preventDefault();
                if(suggest_list.is(':visible')) {
                    if(suggest_list.find('.btn-info').length) {
                        item_current = suggest_list.find('.btn-info');
                        item_prev = item_current.prev('li');

                        if(item_prev.length) {
                            item_current.removeClass('btn-info');
                            item_prev.addClass("btn-info");
                        }
                    }
                    else {
                        suggest_list.find('li').last().addClass("btn-info");
                    }
                    handled = true;
                }
                break;
            default:
                search_input.attr('data', '');
                console.log("Очистили data");
        }

        if(!handled) {

//            console.log("Подсказка: " + search_input.val());
            if(search_input.val().length > 0) {
                $.ajax({
                    type: 'POST',
                    url: 'ajax.php',
                    data: {command: "searchSuggest", string: search_input.val()},
                    success: function(data) {
//                    console.log("Reply: " + data);

                        var object = jQuery.parseJSON(data);

                        suggest_list.html(object.data);
                        if(object.data != null) {
                            suggest_list.show();
                            if(suggest_list.find('.suggestEmphasis') != null) {
                                var a = suggest_list.find('.suggestEmphasis').parent();
                                var suggest = removeDecorations(a.text());//.replace(/\u0301/g, '');
                                if((suggest.length) && (suggest == search_input.val())) {
//                                    search_input.attr('data', a.attr('href'));
//                                    console.log("Нашли подходящий элемент");
                                }
                            }
                        }
                        else
                            suggest_list.hide();
                    }
                });
            }
            else {
                suggest_list.html("");
                suggest_list.hide();
            }
        }
/*
        event.preventDefault();
        return false;
*/
    });

    $(".form-search").keypress(function(e) {
        var code = e.keyCode || e.which;
        if (code  == 13) {
            e.preventDefault();
            return false;
        }
    });

    $('.btn-info a').keyup(function(event) {

        switch(event.keyCode) {
            case 13: // enter
                event.preventDefault();
                if(suggest_list.is(':visible')) {
//                    event.preventDefault();
                    if(suggest_list.find('.btn-info').length) {
                        if(suggest_list.find('.btn-info a').attr('href') != null) {
                            search_input.val(suggest_list.find('.btn-info a').text());
                        }
                        else {
//                            console.log("Не ссылка");
                        }
                        suggest_list.slideUp("fast");
                        search_input.focus();
                        handled = true;
                    }
                }
                else {
//                    $(this).submit();
                }
                break;
        }
    });

    $('.form-search ul').delegate('.suggestItem', 'click', function(e) {
        e.preventDefault();
        var suggest_list = $(this);
        var search_input = $(this).parents('.form-search').find('input.search-input');

        suggest_list.slideUp("fast");
        search_input.val(removeDecorations($(this).text()));
        search_input.attr('data', $(this).attr('href'));
        search_input.focus();
        $(this).parents('.form-search').submit();
    });
});
