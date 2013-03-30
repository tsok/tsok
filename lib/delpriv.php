<?
require_once('../config.php');
require_once('db.inc.php');

db_connect();

$records = db_fetchall_array("SELECT address FROM tsok_info GROUP BY address HAVING COUNT(*)<" . MAX_PRIVATE_SECTOR);

$recs = array();

foreach ($records as $record)
    $recs[] = $record['address'];


if (count($recs))
    db_query("DELETE FROM tsok_info WHERE address IN ('" . implode("','", $recs) . "')");

echo count($records);


?>