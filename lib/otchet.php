<?
ini_set('display_errors', 0);

require_once('../config.php');
require_once 'PHPExcel.php';
require_once('db.inc.php');
require_once('gen.php');

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


$records = db_fetchone_array("SELECT COUNT(id) cnt FROM tsok_info WHERE pok>0 $cond");

$all = $records['cnt'];

$files_cnt = intval($all / MAX_LINES_PER_EXCEL);

for ($i = 0; $i <= $files_cnt; $i++) {
    $cur = $i * MAX_LINES_PER_EXCEL;
    $next = $i * MAX_LINES_PER_EXCEL + MAX_LINES_PER_EXCEL;
    generate_excel("$cur,$next", $i + 1, $cond);
}

echo 1;

?>