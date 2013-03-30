<?php
// Определение пременных для доступа к БД								

$DB = array(
    'db_host' => 'localhost', // Сервер с БД
    'db_user' => 'root', // Пользователь
    'db_pass' => '', // Пароль
    'db_name' => 'tsok' // Название БД
);

//	Функции доступа к БД											   

function db_connect()
{
    global $DB;
    $DB['db_link'] = mysql_pconnect($DB['db_host'], $DB['db_user'], $DB['db_pass']) or die("Unable connect to database!");
    mysql_select_db($DB['db_name']) or die("Could not select database");
    $res = mysql_query("set names cp1251", $DB['db_link']);
    return ($DB['db_link']);
}

function db_disconnect()
{
    global $DB;
    return mysql_close($DB['db_link']);
}

function error_in($query)
{
    $err = '<p><strong>Error: wrong SQL query #' . $query . '#</strong><br>';
    echo $err;
    wlog($err);
    exit;
}

function db_query($query)
{
    global $DB;
    $res = mysql_query($query, $DB['db_link']) or error_in($query);
    return $res;
}

function db_fetchone_array($query)
{
    $res = db_query($query);
    $row = mysql_fetch_array($res, MYSQL_ASSOC);
    mysql_free_result($res);
    return ($row) ? $row : array();
}

function db_fetchall_array($query)
{
    $rows = array();
    $res = db_query($query);
    while ($row = mysql_fetch_array($res, MYSQL_ASSOC))
        $rows[] = $row;
    mysql_free_result($res);
    return ($rows) ? $rows : array();
}

function db_idlist_array($query)
{
    $rows = array();
    $res = db_query($query);
    while ($row = mysql_fetch_array($res, MYSQL_ASSOC))
        $rows[$row['id']] = $row;
    mysql_free_result($res);
    return ($rows) ? $rows : array();
}


function db_last_id()
{
    return mysql_insert_id();
}


function db_query_rows($query)
{
    return mysql_num_rows(db_query($query));
}


function wlog($message)
{
    $fp = fopen('../logs/log.txt', 'a+');
    fwrite($fp, 'Date: ' . date("Y-m-d H:i:s") . '
    ');
    fwrite($fp, $message);
    fwrite($fp, '###
    ');
    fclose($fp);
}


?>