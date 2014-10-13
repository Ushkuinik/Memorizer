<?php
include_once "db.php";
include_once "sqlWord.php";
include_once "pageSearch.php";

$command = $_REQUEST['command'];

$mysqli = connectDB($db_host, $db_user, $db_pass, $db_base);

switch($command) {
    case 'getRandomWord':
        $content = sqlGetRandomWord($mysqli, $_REQUEST['language_id'], $_REQUEST['category_id']);
        break;

    case 'getWord':
        $content = sqlGetWord($mysqli, $_REQUEST['id'],  $_REQUEST['flag']);
        break;

    case 'searchSuggest':
        $search  = new pageSearch($mysqli);
        $content = $search->ajaxSuggest($_REQUEST['string']);
        break;

    case 'addWord':
        $content = sqlAddWord($_REQUEST['word'], $_REQUEST['structure'], $_REQUEST['brief'], $_REQUEST['idLanguage'], $_REQUEST['idPartOfSpeech']);
        break;
    case 'saveWord':
        $content = sqlEditWord($_REQUEST['id'], $_REQUEST['word'], $_REQUEST['structure'], $_REQUEST['brief'], $_REQUEST['idLanguage'], $_REQUEST['idPartOfSpeech']);
        break;
    case 'deleteWord':
        $content = sqlDeleteWord($_REQUEST['id']);
        break;

    case 'linkWords':
        $content = sqlLinkWords($_REQUEST['id1'], $_REQUEST['id2']);
        break;
    case 'unlinkWords':
        $content = sqlUnlinkWords($_REQUEST['id1'], $_REQUEST['id2']);
        break;

    case 'importWords':
        $content = sqlImportWords($_REQUEST['data'], $_REQUEST['language_id'], $_REQUEST['category_id']);
        break;

    case 'addCategory':
        $content = sqlAddCategory($_REQUEST['category_name']);
        break;
    case 'saveCategory':
        $content = sqlEditCategory($_REQUEST['category_id'], $_REQUEST['category_name']);
        break;
    case 'deleteCategory':
        $content = sqlDeleteCategory($_REQUEST['category_id']);
        break;

    case 'assignWordToCategory':
        $content = sqlAssignWordToCategory($_REQUEST['word_id'], $_REQUEST['category_id']);
        break;
    case 'deleteWordFromCategory':
        $content = sqlDeleteWordFromCategory($_REQUEST['word_id'], $_REQUEST['category_id']);
        break;
    case 'getCategoryAssignments':
        $content = sqlGetCategoryAssignments($_REQUEST['category_id']);
        break;

    case 'getStatistics':
        $content = sqlGetStatistics();
        break;
}

disconnectDB($mysqli);
echo json_encode($content);

?>