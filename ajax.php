<?php
include_once "db.php";
include_once "sqlWord.php";
include_once "pageSearch.php";

$command = $_REQUEST['command'];

$mysqli = connectDB($db_host, $db_user, $db_pass, $db_base);

switch($command) {
    case 'getRandomWord':
        $content = getRandomWord($mysqli, $_REQUEST['idLanguage']);
        break;

    case 'getWord':
        $content = getWord($mysqli, $_REQUEST['id'],  $_REQUEST['flag']);
        break;

    case 'searchSuggest':
        $search  = new pageSearch($mysqli);
        $content = $search->ajaxSuggest($_REQUEST['string']);
        break;

    case 'addWord':
        $content = $config->addWord($_REQUEST['word'], $_REQUEST['structure'], $_REQUEST['brief'], $_REQUEST['idLanguage'], $_REQUEST['idPartOfSpeech']);
        break;
    case 'saveWord':
        $content = $config->saveWord($_REQUEST['id'], $_REQUEST['word'], $_REQUEST['structure'], $_REQUEST['brief'], $_REQUEST['idLanguage'], $_REQUEST['idPartOfSpeech']);
        break;
    case 'deleteWord':
        $content = $config->deleteWord($_REQUEST['id']);
        break;
}

disconnectDB($mysqli);
echo json_encode($content);

?>