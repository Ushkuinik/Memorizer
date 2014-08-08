<?php

include_once("db.php");
include_once("pageTester.php");
include_once("pageConfig.php");

include_once("i18n.php");

session_start();

try {
    // подключаемся к серверу баз данных
    $mysqli = connectDB();

    $view = isset($_GET['view']) ? $_GET['view'] : "";
    $id   = isset($_GET['id']) ? $_GET['id'] : "";

    $page = null;
    switch($view) {
        case 'tester':
            $page = new pageTester($mysqli);
            break;

        case 'config':
            $page = new pageConfig($mysqli, $id);
            break;

        default:
            $page = new pageTester($mysqli);
            break;
    }

    // читаем шаблон страницы из файла
    // TODO: проверку на ошибки
    $tpl = file_get_contents('templates/index.tpl');

    if($page == null)
        $page = new Page($mysqli);

    //$pageMenu = getMenu();

    try {
        $pageMenu = $page->getMenu();
    } catch(Exception $e) {
        $pageContent = getAlert($e);
    }

    try {
        $pageContent = $page->getContent();
    } catch(Exception $e) {
        $pageContent = getAlert($e);
    }

    try {
        $pageScript = $page->getScript();
    } catch(Exception $e) {
        $pageContent = getAlert($e);
    }

    try {
        $pageFooter = $page->getFooter();
    } catch(Exception $e) {
        $pageContent .= getAlert($e);
    }

    // вставляем контент в страницу
    $tpl = str_replace('[+menu+]', $pageMenu, $tpl);
    $tpl = str_replace('[+content+]', $pageContent, $tpl);
    $tpl = str_replace('[+footer+]', $pageFooter, $tpl);
    $tpl = str_replace('[+script+]', $pageScript, $tpl);

    $tpl = processContent($tpl, "RU");

    // выводим страницу
    echo $tpl;

    // закрываем соединение
    disconnectDB($mysqli);
} catch(Exception $e) {
    echo getAlert($e);
}


function getAlert($e)
{
    $content =
        '<div class="panel panel-danger">
          <div class="panel-heading"><strong>Exception! </strong></div>
          <div class="panel-body">' . $e->getMessage() . ' <em>(' . $e->getFile() . " [" . $e->getLine() . '])</em></div>
</div>';

    return $content;
}

?>