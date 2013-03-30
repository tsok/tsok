<?

/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/

require_once('../config.php');
require_once('db.inc.php');
require_once('geo.php');
db_connect();

$header = <<<HTML
<p align="center">
    <b style="font-size: 16px; font-weight: bold">���� ������������ ������� ������� � ��������������� ������� �����
        ��������<br>
        ��� ������������ ����� ��������� �� ������:</b><br>
    _________________________________<br>
    (������������ ����������� ������)<br>
    _________________________________<br>
    (������������ ����� (�����������, ���������, �������� � �.�.)- ������ ���������)<br>
</p>
<p></p>
<table border="1" cellpadding="4" cellspacing="0" align="center">
    <tr>
        <td>� �/�</td>
        <td>�����</td>
        <td>����� ��</td>
        <td>����� ��</td>
        <td>���� �������������� �������</td>
        <td>������� ��������</td>
    </tr>

HTML;


$footer = <<<HTML
</table>
<p></p>
<p align="right">���������� ������������� �������� ________<br>
    ���� ������������� ��� ����-�����λ<br>
    /������� �.�./____________________<br>
    (�.�.�.) �������<br>
    ������ ������������� ��� ���ʻ<br>
    /_________________ /_________________<br>
    (�.�.�.) �������</p>
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

$sql = "SELECT DISTINCT address FROM tsok_info WHERE id>0 $cond ORDER BY address ASC";

$address = db_fetchall_array($sql);
$html = '';
$cnt = 1;

foreach ($address as $add) {

    $items = db_fetchall_array("SELECT *, DATE_FORMAT(dt, '%d.%m.%Y') dat FROM tsok_info WHERE address='$add[address]' AND dt!='0000-00-00 00:00:00' $cond");
    foreach ($items as $item) {

        $html .= "<tr>
            <td>$cnt</td>
            <td>$item[address]</td>
            <td>$item[pu]</td>
            <td>$item[ls]</td>
            <td>$item[dat]</td>
            <td></td>
            </tr>";
        $cnt++;
    }
}
$fp = fopen(REESTR_SOGL_FOLDER . '/reestr.html', 'w+');
fwrite($fp, $header . $html . $footer);
fclose($fp);

echo count($address);

?>




