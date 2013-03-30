<?php

require_once('../config.php');
require_once('db.inc.php');
require_once('geo.php');
db_connect();


$cond = '';

if (intval($_REQUEST['city'])) {
    $cond .= " AND city = " . intval($_REQUEST['city']);
}

if (intval($_REQUEST['area'])) {
    $cond .= " AND area = " . intval($_REQUEST['area']);
}

if (isset($_REQUEST['dtB']) && $_REQUEST['dtB'] != '') {
    $cond .= " AND dt >= '" . implode('-', array_reverse(explode('.', $_REQUEST['dtB']))) . " 00:00:00'";
}

if (isset($_REQUEST['dtE']) && $_REQUEST['dtE'] != '') {
    $cond .= " AND dt <= '" . implode('-', array_reverse(explode('.', $_REQUEST['dtE']))) . " 00:00:00'";
}


$items = db_fetchall_array("SELECT DISTINCT address FROM tsok_info WHERE id>0 $cond");

$html = '<table>
<tr><th>№</th><th>Адрес</th><th>Заполнено</th><th>Незаполнено</th></tr>';
$cnt = 0;
$cnt_fill = 0;
$cnt_empty = 0;
foreach ($items as $item) {
    $cnt++;
    $items_fill = db_fetchone_array("SELECT COUNT(*) cnt FROM tsok_info WHERE address='$item[address]' AND pok>0 $cond");
    $items_empty = db_fetchone_array("SELECT COUNT(*) cnt FROM tsok_info WHERE address='$item[address]' AND pok=0 $cond");
   echo "SELECT COUNT(*) cnt FROM tsok_info WHERE address='$item[address]' AND pok>0 $cond<br>SELECT COUNT(*) cnt FROM tsok_info WHERE address='$item[address]' AND pok=0 $cond";
    $html .= "<tr><td>$cnt</td><td>$item[address]</td><td>$items_fill[cnt]</td><td>$items_empty[cnt]</td></tr>";
    $cnt_fill += $items_fill['cnt'];
    $cnt_empty += $items_empty['cnt'];
}

$html .= "<tr><td></td><td>Всего:</td><td><b>$cnt_fill</b></td><td><b>$cnt_empty</b></td></tr>";


$html .= "</table>";

//echo $html;

$fp = fopen(EMPTY_ADDRESS_FOLDER . '/reestr.html', 'w+');
fwrite($fp, $html);
fclose($fp);

echo $cnt;

?>