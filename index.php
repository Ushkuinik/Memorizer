<?php

include_once("db.php");
include_once("pageTester.php");

session_start();

try {
    // подключаемся к серверу баз данных
    $mysqli = connectDB();

    $view = isset($_GET['view']) ? $_GET['view'] : "";

    $page = NULL;
    switch ($view) {
        case 'config':
//            $page = new pageConfig($mysqli);
            break;

        default:
            $page = new pageTester($mysqli);
            break;
    }

    // читаем шаблон страницы из файла
    // TODO: проверку на ошибки
    $tpl = file_get_contents('templates/index.tpl');

    if ($page == NULL)
        $page = new Page($mysqli);

    //$pageMenu = getMenu();

    try {
        $pageContent = $page->getContent();
    } catch (Exception $e) {
        $pageContent = getAlert($e);
    }

    try {
        $pageSidebar = $page->getSidebar();
    } catch (Exception $e) {
        $pageContent .= getAlert($e);
    }

    try {
        $pageFooter = $page->getFooter();
    } catch (Exception $e) {
        $pageContent .= getAlert($e);
    }

    try {
        $pageScript = $page->getScript();
    } catch (Exception $e) {
        $pageContent .= getAlert($e);
    }

    // вставляем контент в страницу
//    $tpl = str_replace('[+menu+]', getMenu(), $tpl);
    $tpl = str_replace('[+content+]', $pageContent, $tpl);
//    $tpl = str_replace('[+sidebar+]', $pageSidebar, $tpl);
//    $tpl = str_replace('[+footer+]', $pageFooter, $tpl);
    $tpl = str_replace('[+script+]', $pageScript, $tpl);

    // выводим страницу
    echo $tpl;

    // закрываем соединение
    disconnectDB($mysqli);

} catch (Exception $e) {
    echo getAlert($e);
}

function getAlert($e)
{
    $content = '
<div class="panel panel-danger">
  <div class="panel-heading"><strong>Exception! </strong></div>
  <div class="panel-body">' . $e->getMessage() . ' <em>(' . $e->getFile() . " [" . $e->getLine() . '])</em></div>
</div>';
    return $content;
}

?>