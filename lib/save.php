<?php
if (!session_id())
    session_start();

require_once('db.inc.php');
require_once('../config.php');
require_once('geo.php');
db_connect();

$item_id = intval($_REQUEST['id']);

$dat = array_reverse(explode('.', $_REQUEST['dat']));

if (count($dat) === 3)
    $date = (strlen($dat[0]) !== 2 ? $dat[0] : '20' . $dat[0]) . '-' . $dat[1] . '-' . $dat[2] . ' 00:00:00';
else
    $date = '0000-00-00 00:00:00';

$sql = "
UPDATE tsok_info SET
address = '" . addslashes($_REQUEST['address']) . "',
kv = '" . addslashes($_REQUEST['kv']) . "',
pu = '" . addslashes($_REQUEST['pu']) . "',
ls = '" . addslashes($_REQUEST['ls']) . "',
pok = '" . addslashes($_REQUEST['pok']) . "',
dt = '" . addslashes($date) . "',
city = " . intval($_REQUEST['city']) . ",
area = " . intval($_REQUEST['area']) . "
WHERE
    id = $item_id
";

db_query($sql);

$_SESSION['message'] = 'Изменения приняты';

header("Location: " . $_SERVER['HTTP_REFERER']);
//echo


?>