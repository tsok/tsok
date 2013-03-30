<?php
require_once('../config.php');
require_once 'PHPExcel.php';
require_once('db.inc.php');
//require_once('gen.php');

db_connect();

$items_all = db_fetchone_array("SELECT count(*) cnt FROM tsok_info");
$items_fill = db_fetchone_array("SELECT count(*) cnt FROM tsok_info WHERE pok>0 ");
$items_empty = db_fetchone_array("SELECT count(*) cnt FROM tsok_info WHERE pok=0 OR pok=''");

$items_type = db_fetchall_array("SELECT face_type, COUNT(*) cnt FROM tsok_info GROUP BY face_type ORDER BY face_type ASC");





?>