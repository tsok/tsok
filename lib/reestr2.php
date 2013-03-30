<?

/*error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', TRUE);*/

require_once('../config.php');
require_once('db.inc.php');
require_once('geo.php');
db_connect();

$header = <<<HTML
<table border="0" cellpadding="0" cellspacing="0" style="width:683px;" width="683" align="center">
	<tbody>
		<tr>
			<td style="width:683px;height:20px;">
			<p align="center"><strong>Реестр обходных листов&nbsp; __________________ 2013г.</strong></p>
			</td>
		</tr>
		<tr>
			<td style="width:683px;height:20px;">
			<p align="center"><strong>_______________________________________________________</strong></p>
			</td>
		</tr>
		<tr>
			<td style="width:683px;height:20px;">
			<p align="center">(наименование участка)</p>
			</td>
		</tr>
	</tbody>
</table>

<p></p>
<table border="1" cellpadding="4" cellspacing="0" align="center">
    <tr>
        <td>№ п/п</td>
        <td>Населенный пункт</td>
        <td>Адрес</td>
        <td>Количество РТУ в МКД</td>
        <td>Количество выполненных съемов РТУ</td>
        <td>Примечание</td>
    </tr>

HTML;


$footer = <<<HTML
</table>
<p></p>
<table border="0" cellpadding="0" cellspacing="0" style="width:683px;" width="683" align="center">
	<tbody>
		<tr>
			<td colspan="7" style="width:683px;height:20px;">
			<p>Приложение: обходные листы на (<em>указывается количество листов</em>) листах.</p>
			</td>
		</tr>
		<tr>
			<td style="width:63px;height:20px;">&nbsp;</td>
			<td style="width:115px;height:20px;">&nbsp;</td>
			<td style="width:103px;height:20px;">&nbsp;</td>
			<td style="width:83px;height:20px;">&nbsp;</td>
			<td style="width:88px;height:20px;">&nbsp;</td>
			<td style="width:111px;height:20px;">&nbsp;</td>
			<td style="width:121px;height:20px;">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="7">Заказчик&nbsp;&nbsp;&nbsp; /_______________ /  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Исполнитель&nbsp;&nbsp;&nbsp; /_______________ /</td>
		</tr>
	</tbody>
</table>

<p align="right">Количество согласованных допусков ________<br>
    Сдал представитель ООО «ЦОК-ЭНЕРГО»<br>
    /Синицын С.Л./____________________<br>
    (Ф.И.О.) ПОДПИСЬ<br>
    Принял представитель ОАО «ЯСК»<br>
    /_________________ /_________________<br>
    (Ф.И.О.) ПОДПИСЬ</p>
HTML;


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


$sql = "SELECT DISTINCT address FROM tsok_info WHERE address<>'' $cond ORDER BY city ASC, address ASC";

//echo $sql;

$address = db_fetchall_array($sql);
$cnt = 0;
$html = '';

foreach ($address as $add) {
    $cnt_fill = 0;
    $cnt_empty = 0;
    $items_fill = db_fetchone_array("SELECT COUNT(id) cnt FROM tsok_info WHERE address = '$add[address]' $cond");
    $items_empty = db_fetchone_array("SELECT COUNT(id) cnt FROM tsok_info WHERE address = '$add[address]' AND pok > 0 $cond");
    //$address_one = db_fetchone_array("SELECT area, city FROM tsok_info WHERE address = '$add[address]' LIMIT 1");
    $nas = '';
    //$nas = intval($address_one['city']) ? $city_ar[intval($address_one['city'])] : '';
    //$nas .= intval($address_one['area']) ? ','.$area_ar[intval($address_one['area'])] : '';
    $cnt_fill = $items_fill['cnt'];
    $cnt_empty = $items_empty['cnt'];
    if ($cnt_empty) {
        $cnt++;
        $html .= "<tr>
            <td>$cnt</td>
            <td>$nas</td>
            <td>$add[address]</td>
            <td>$cnt_fill</td>
            <td>$cnt_empty</td>
            <td></td>
            </tr>";

    }
}

$fp = fopen(REESTR_OBH_FOLDER . '/reestr.html', 'w+');
fwrite($fp, $header . $html . str_replace('[address]', $add['address'], $footer));
fclose($fp);


echo count($address);

?>




