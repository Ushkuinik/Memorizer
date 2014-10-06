function alertResult(_code, _message, _message_opt) {
    var alert_class = "warning";
    var alert_title = "";
    var alert_message = "";

    switch(parseInt(_code)) {
        case 0:
            alert_class = "success";
            if(_message.length == 0)
                alert_message = "Operation succeeded";
            else
                alert_message = _message + ((_message_opt != undefined) ? '<br />' + _message_opt : '');
            break;
        case 1:
            alert_class = "danger";
            alert_title = "Ошибка!";
            alert_message = _message + ((_message_opt != undefined) ? '<br />' + _message_opt : '');
            break;
        default:
            alert_class = "warning";
            alert_title = "Предупреждение!";
            alert_message = _message + ((_message_opt != undefined) ? '<br />' + _message_opt : '');
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

function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}