<?php

include_once("db.php");
include_once("pageTester.php");
include_once("pageConfig.php");
include_once("pageImport.php");
include_once("pageCategory.php");
include_once("pageStatistics.php");

include_once("i18n.php");

session_start();

try {
    // подключаемся к серверу баз данных
    $mysqli = connectDB();

    $view = isset($_GET['view']) ? $_GET['view'] : "";
    $id1   = isset($_POST['id1']) ? $_POST['id1'] : "";
    $id2   = isset($_POST['id2']) ? $_POST['id2'] : "";
//    $id1   = isset($_GET['id1']) ? $_GET['id1'] : "";
//    $id2   = isset($_GET['id2']) ? $_GET['id2'] : "";

    $page = null;
    switch($view) {
        case 'tester':
            $page = new pageTester($mysqli);
            break;

        case 'config':
            $page = new pageConfig($mysqli, $id1, $id2);
            break;

        case 'import':
            $page = new pageImport($mysqli);
            break;

        case 'category':
            $page = new pageCategory($mysqli);
            break;

        case 'statistics':
            $page = new pageStatistics($mysqli);
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

    $language = getLanguage($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $tpl = processContent($tpl, $language);

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