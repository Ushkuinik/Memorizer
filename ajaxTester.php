<?php
include_once "db.php";
include_once "pageTester.php";

$command = $_REQUEST['command'];

$mysqli = connectDB($db_host, $db_user, $db_pass, $db_base);
$tester = new pageTester($mysqli);

switch($command)
{
  case 'getRandomWord':
    $content = $tester->ajaxGetRandom($_REQUEST['idLanguage']);
    break;
}
echo $content;

?>