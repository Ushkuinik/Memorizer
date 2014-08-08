<?php

class i18n
{
    function __construct($mysqli)
    {
    }

    public function setLocale()
    {
        return;
    }
}

function processContent($_content, $_locale)
{

    global $g_strings;

    switch($_locale) {
        case 'RU':
            include_once("i18n/string_ru.php");
            break;
        case 'EN':
            include_once("i18n/string_en.php");
            break;
        case 'JP':
            include_once("i18n/string_jp.php");
            break;
    }
    $_SESSION['strings'] = $strings;

    $result = preg_replace_callback('/@string:(\w+)/', 'string_replace_callback', $_content);

    return $result;
}

function string_replace_callback($matches)
{
    $strings = $_SESSION['strings'];
    // как обычно: $matches[0] -  полное вхождение шаблона
    // $matches[1] - вхождение первой подмаски,
    // заключенной в круглые скобки, и так далее...
    //$res = print_r($strings);
    if($strings[$matches[1]] != null)
        return $strings[$matches[1]];
    //return $matches[1];
    else
        return '<span class="undefined_resource">' . $matches[1] . '</span>';
}

?>