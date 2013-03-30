<?php

if (!session_id())
    session_start();

require_once('db.inc.php');
require_once('../config.php');
require_once('geo.php');
db_connect();

if (isset($_REQUEST['id'])) {

    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }

    $item = db_fetchone_array("SELECT *,DATE_FORMAT(dt,'%d.%m.%y') dat  FROM tsok_info WHERE id=" . intval($_REQUEST['id']));

    if ($item) {

        foreach ($city_ar as $key => $val) {
            $sel = $key == $item['city'] ? 'SELECTED' : '';
            $city .= "<option $sel value='$key'>$val</option>";
        }

        $city_html = ' <select name="city">' . $city . '</select>';


        foreach ($area_ar as $key => $val) {
            $sel = $key == $item['area'] ? 'SELECTED' : '';
            $area .= "<option $sel value='$key'>$val</option>";
        }

        $area_html = ' <select name="area">' . $area . '</select>';


        $html = "
        <style>
        .tbl {
        border-collapse: collapse;
        }

        .tbl tr th {
        background-color: orange;
        color: white;
        }

        .tbl tr th, .tbl tr td {
        padding: 3px;
        }

        .tbl tr td {
        border: 1px solid gray;
        }

        h1 {
        font-family: Tahoma;
        font-size: 22px;
        color: navy;
        }

        </style>
        <h1>Редактирование записи (id=$item[id])</h1>
        <form method='post' action='/lib/save.php'>
        <input type='hidden' name='id' value='$_REQUEST[id]'>
        <table class='tbl'>
            <tr><th>№ п/п</th><th>Адрес</th><th>кв.</th><th>ПУ</th><th>ЛС</th><th>Дата съема пок.</th><th>Показание</th><th>Город</th><th>Район</th><th></th><th></th></tr>
            <tr><td>$item[id]</td><td><input name='address' type='text' value='$item[address]'></td><td><input name='kv' type='text' value='$item[kv]'></td><td><input type='text' name='pu' value='$item[pu]'></td><td><input type='text' name='ls' value='$item[ls]'></td><td><input type='text' name='dat' value='$item[dat]'></td><td><input type='text' name='pok' value='$item[pok]'></td><td>$city_html</td><td>$area_html</td><td></td><td><input type='submit' value='сохранить'></td></tr>
        </table>
        </form>";

    } else {
        $html = 'Запись не найдена';
    }

    $html .= "<p><a href='/'>вернуться назад</a></p>";

    echo $html;

} else {
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

    if (isset($_REQUEST['address'])) {
        $cond .= " AND address LIKE '%" . addslashes($_REQUEST['address']) . "%'";
    }

    if (isset($_REQUEST['dtE']) && $_REQUEST['dtE'] != '') {
        $cond .= " AND dt <= '" . implode('-', array_reverse(explode('.', $_REQUEST['dtE']))) . " 00:00:00'";
    }

    if (intval($_REQUEST['pu'])) {
        $cond .= " AND pu = '$_REQUEST[pu]'";
    }

    if (intval($_REQUEST['ls'])) {
        $cond .= " AND ls = '$_REQUEST[ls]'";
    }

    /*
    if (intval($_REQUEST['kv'])) {
        $cond .= " AND kv = '$_REQUEST[kv]'";
    }
    */

    if ($cond == '') {
        exit;
    }

    $sql = "SELECT *,DATE_FORMAT(dt,'%d.%m.%y') dat FROM tsok_info WHERE 1=1 $cond LIMIT 250";

    $items = db_fetchall_array($sql);

    $html = '
    <style>
    a:link, a:visited {
    color: navy;
    }

    .tbl {
    border-collapse: collapse;
    }

    .tbl tr th {
    background-color: orange;
    color: white;
    }

    .tbl tr th, .tbl tr td {
    padding: 3px;
    }

    .tbl tr td {
    border: 1px solid gray;
    }

    h1 {
    font-family: Tahoma;
    font-size: 22px;
    color: navy;
    }

    </style>
    <table class="tbl">';
    $html .= "<tr><th>№ п/п</th><th>Адрес</th><th>кв.</th><th>ПУ</th><th>ЛС</th><th>Дата съема пок.</th><th>Показание</th><th>Город</th><th>Район</th><th></th></tr>";

    $cnt = 0;
    foreach ($items as $item) {
        $cnt++;
        $html .= "<tr><td>$cnt</td><td>$item[address]</td><td>$item[kv]</td><td>$item[pu]</td><td>$item[ls]</td><td>$item[dat]</td><td>$item[pok]</td><td>" . $city_ar[$item['city']] . "</td><td>" . $area_ar[$item['area']] . "</td><td><a href='/lib/search.php?id=$item[id]'>редактировать</a></td></tr>";
    }
    $html .= '</table>';


    if ($items)
        echo '<h1>Результаты поиска</h1>' . $html;
    else
        echo "По параметрам ничего не найдено.";
}




?>