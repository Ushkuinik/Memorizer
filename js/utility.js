function alertResult(_code, _message, _message_opt) {
    var alert_class = "warning";
    var alert_title = "";
    var alert_message = "";

    switch(parseInt(_code)) {
        case 0:
            alert_class = "success";
            alert_message = "Operation succeeded";
            break;
        case 1:
            alert_class = "danger";
            alert_title = "Ошибка!";
            alert_message = _message + _message_opt;
            break;
        default:
            alert_class = "warning";
            alert_title = "Предупреждение!";
            alert_message = _message + _message_opt;
            break;
    }

    content = '<div class="alert alert-' + alert_class + ' fade in\">\n \
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n \
    <strong>' + alert_title + '</strong> ' + alert_message + '\n \
    </div>\n';

    return content;
}

function removeDecorations(_string) {
    var result = _string.replace(/\u0301/g, '');
    result = result.replace(/\[/g, '');
    result = result.replace(/\]/g, '');
    return result;
}