$(document).ready(function() {
    "use strict";
    checkAssignButton();
    checkButtons();

    $('#selectCategory').on('click', '.dropdown-menu a', function(e) {
        e.preventDefault();
        var category_id = $(this).attr('href');
        var text = $(this).html();
        var i = $(this).parents('.input-group').children('input');
        i.val(text).attr('data', category_id);
        checkButtons();
        setModalTitle(text);

        ajaxGetCategoryAssignments(category_id);

        checkAssignButton();
        return true;
    });


    $('#buttonAssignWord').click(function(e) {
        e.preventDefault();

        var word_id = getWordId();
        var category_id = getCategoryId();

        if((word_id > 0) && (category_id > 0)) {
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {command: "assignWordToCategory", word_id: word_id, category_id: category_id},
                success: function(data) {
                    console.log(data);

                    var object = jQuery.parseJSON(data);
                    var message = alertResult(object.code, object.message, object.sql);

                    $('#result').html(message);
                    if(parseInt(object.code) == 0) {
                        var word = getWord();
                        var action = $('p.action-delete-from-category').html();
                        action = action.replace('[+word_id+]', word_id);
                        var row = '<tr><td>' + word + '</td><td>' + action + '</td></tr>';
                        $('#tableList tr:last').after(row);
                     }
                },
                error: function(request, status, error) {
                    alert(request.responseText);
                }
            });
        } else {
            alert("Invalid id!");
        }

        return false;
    });

    $('#tableList').delegate('.delete-from-category', 'click', function(e) {
        e.preventDefault();

        var word_id = $(this).attr('data');
        var category_id = getCategoryId();
        var tr = $(this).parents('tr');

        if((word_id > 0) && (category_id > 0)) {
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {command: "deleteWordFromCategory", word_id: word_id, category_id: category_id},
                success: function(data) {
                    console.log(data);

                    var object = jQuery.parseJSON(data);
                    var message = alertResult(object.code, object.message, object.sql);

                    $('#result').html(message);
                    if(parseInt(object.code) == 0) {
                        var row = $(this).parents('tr');
                        tr.fadeOut('fast');
//                        tr.remove();
                    }
                },
                error: function(request, status, error) {
                    alert(request.responseText);
                }
            });
        } else {
            alert("Invalid id!");
        }

        return false;
    });


    $('#searchWord').submit(function(e) {
        checkAssignButton();
    });

    $("#searchWord").keyup(function(event) {
        if( (event.keyCode != 13) &&
            (event.keyCode != 40) &&
            (event.keyCode != 38)) {
            setWordId(0);
            checkAssignButton();
        }
    });

    $('#modalRenameCategory input.category-name').on("change cut paste keyup", function() {
        $('#buttonModalSave').prop('disabled', ($(this).val().length == 0));
    }).change();

    $('#modalAddCategory input.category-name').on("change cut paste keyup", function() {
        $('#buttonModalAdd').prop('disabled', ($(this).val().length == 0));
    }).change();

    $('#buttonModalSave').click(function(e) {
        var category_id = getCategoryId();
        var category_name = $('#modalRenameCategory input.category-name').val();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "saveCategory", category_id: category_id, category_name: category_name},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    $('#modalRenameCategory').modal('hide');
                    updateCategory(category_id, category_name);
                    setModalTitle(category_name);
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    });

    $('#buttonModalAdd').click(function(e) {
        var category_name = $('#modalAddCategory input.category-name').val();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "addCategory", category_name: category_name},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    $('#modalAddCategory').modal('hide');
                    var category_id = object.category_id;
                    addCategory(category_id, category_name);
                    setModalTitle(category_name);
                    clearTable();
                    $('#modalDeleteCategory').find('div.modal-body').find('p').html('');
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    });

    $('#buttonModalDelete').click(function(e) {
        var category_id = getCategoryId();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {command: "deleteCategory", category_id: category_id},
            success: function(data) {
                console.log(data);

                var object = jQuery.parseJSON(data);
                var message = alertResult(object.code, object.message, object.sql);

                $('#result').html(message);
                if(parseInt(object.code) == 0) {
                    $('#modalDeleteCategory').modal('hide');
                    deleteCategory(category_id);
                    clearTable();
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    });


    $('#tableList').on('click', '.clickable', function() {
        var id = $(this).parents('tr').find('button').attr('data');
        var word = $(this).html();
        bake_cookie('memorizer_ids', {id: id, word: word});
        window.location.replace("index.php?view=config");
    });
});

function checkAssignButton() {
    var word_id = getWordId();
    var category_id = getCategoryId();

    if((word_id > 0) && (category_id > 0)) {
        $('#buttonAssignWord').prop('disabled', false);
    }
    else {
        $('#buttonAssignWord').prop('disabled', true);
    }
    return $('#buttonAssignWord');
}

function checkButtons() {
    if((getCategoryId() != 0) && (getCategoryId() != undefined)) {
        $('#buttonRenameCategory').prop('disabled', false);
        $('#buttonDeleteCategory').prop('disabled', false);
    } else {
        $('#buttonRenameCategory').prop('disabled', true);
        $('#buttonDeleteCategory').prop('disabled', true);
    }
}

function setModalTitle(_title) {
    $('#modalRenameCategory').find('h4.modal-title').find('span.accent').html(_title);
    $('#modalRenameCategory input.category-name').val(_title);
    $('#modalDeleteCategory').find('h4.modal-title').find('span.accent').html(_title);
}

function getWord() {
    return $('#searchWord').find('input.search-input').val();
}

function getWordId() {
    return $('#searchWord').find('input.search-input').attr('data');
}

function setWordId(_id) {
    return $('#searchWord').find('input.search-input').attr('data', _id);
}

function getCategoryId() {
    return $('#selectCategory').find('input').attr('data');
}

function setCategoryId(_id) {
    return $('#selectCategory').find('input').attr('data', _id);
}

function searchCategory(_category_name) {
    var i = $('#selectCategory').find('li').filter(function() {
        return ($(this).find('a').html() === _category_name);
    });

    if(i.length > 0) {
        return $(i).find('a').attr('href');
    }

    return 0;
}

function updateCategory(_id, _name) {
    $('#selectCategory').find('li').filter(function() {
        return $(this).find('a').attr('href') == _id;
    }).find('a').html(_name);

    $('#selectCategory').find('input.form-control').val(_name);
}

function addCategory(_category_id, _category_name) {
    $('#selectCategory').find('ul').append('<li><a href="' + _category_id + '">' + _category_name + '</a></li>')
    $('#selectCategory').find('input').val(_category_name).attr('data', _category_id);
}

function deleteCategory(_category_id) {
    $('#selectCategory').find('li').each(function() {
        if($(this).find('a').attr('href') == _category_id)
            $(this).remove();
    });
    $('#selectCategory').find('input').val('').attr('data', 0);
    checkButtons();
}

function clearTable() {
    $('#tableList tbody').html('');
}

function ajaxGetCategoryAssignments(_category_id) {
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: {command: "getCategoryAssignments", category_id: _category_id},
        success: function(data) {
            console.log(data);

            var object = jQuery.parseJSON(data);
            var message = alertResult(object.code, object.message, object.sql);

            $('#result').html(message);
            if(parseInt(object.code) == 0) {
                var words = object.words;
                clearTable()
                if(words != undefined) {
                    for(var i in words) {
                        var id = words[i].id;
                        var word = words[i].word;
                        var action = $('p.action-delete-from-category').html();
                        action = action.replace('[+word_id+]', id);
                        var row = '<tr><td><span class="clickable">' + word + '</span></td><td>' + action + '</td></tr>';
                        $('#tableList tbody').append(row);
                    }
                    var length = Object.keys(words).length;
                    if(length > 0) {
                        var message = "Количество слов в данной категории: " + length;
                    }
                }
                else {
                    var message = "Эта категория не содержит слов";
                }
                $('#modalDeleteCategory').find('div.modal-body').find('p').html(message);


            }
        },
        error: function(request, status, error) {
            alert(request.responseText);
        }
    });
}