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
    switch($_locale) {
        case 'ru':
            include_once("i18n/string_ru.php");
            break;
        case 'en':
            include_once("i18n/string_en.php");
            break;
        case 'jp':
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


function getLanguage($_accept_languages)
{
    $available_languages = array('ru', 'en', 'jp');

    $accept_languages = strtolower($_accept_languages);
    $languages = explode(',', $accept_languages);
    foreach($languages as $language) {
        foreach($available_languages as $a_language ) {
            if(strcmp(substr($language, 0, 2), $a_language) == 0)
                return $a_language;
        }
    }
    return 'en';
}
?>