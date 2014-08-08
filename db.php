<?php
$db_host = "localhost";
$db_port = 3307;
$db_base = "memorizer";
$db_user = "root";
$db_pass = "1234";


function connectDB()
{
    global $db_host;
    global $db_port;
    global $db_base;
    global $db_user;
    global $db_pass;

    return connectDB_Local($db_host, $db_port, $db_user, $db_pass, $db_base);
}

function connectDB_Local($db_host, $db_port, $db_user, $db_pass, $db_base)
{
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_base, $db_port);
    if($mysqli->connect_errno)
        throw new Exception("Не получается подключиться к серверу баз данных: " . $mysqli->connect_error);

    if(!$mysqli->set_charset("utf8"))
        throw new Exception("Ошибка при загрузке набора символов utf8: " . $mysqli->connect_error);

    return $mysqli;
}

function disconnectDB($mysqli)
{
    if(!$mysqli->close())
        throw new Exception("Не получается закрыть соединение с базой данных." . $mysqli->connect_error);
}

?>