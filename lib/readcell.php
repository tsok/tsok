<?php
require_once('../config.php');
require_once 'PHPExcel.php';
require_once('db.inc.php');
//require_once('gen.php');

db_connect();

$months = array(
    1 => 'jan',
    2 => 'feb',
    3 => 'mar',
    4 => 'apr',
    5 => 'may',
    6 => 'jun',
    7 => 'jul',
    8 => 'aug',
    9 => 'sep',
    10 => 'oct',
    11 => 'nov',
    12 => 'dec'
);

$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objReader->setReadDataOnly(true);


//Очищаем файл
$fp = fopen('../logs/load.html', 'w');
fwrite($fp, '');
fclose($fp);


$files = GetFilesArr(FILLED_EXCEL_FOLDER);

$cnt_updates = 0;
$curdate = strtotime("now");

foreach ($files as $file) {

    $objPHPExcel = $objReader->load($file);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
    $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
    for ($row = 1; $row <= $highestRow - 8; ++$row) {
        if ($row > 3) {
            $val1 = intval($objWorksheet->getCellByColumnAndRow(5, $row)->getValue());
            $val2 = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
            $date_pok = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
            if ($val1) {

                $dat_pieces = explode('.', $date_pok);

                if (count($dat_pieces) == 3) {
                    if (strlen($dat_pieces[2]) <= 2)
                        $dat_pieces[2] = '20' . $dat_pieces[2];
                    $dt = implode(array_reverse($dat_pieces), '-');
                    if (strtotime($dt) > $curdate){
                       //Если неправильная дата, то сбрасываем ее
                       html_log($file.iconv("UTF-8", "windows-1251", " Неправильная дата: " . $date_pok . " в адресе с ЛС=" . $val2));
                       $dt = '00.00.0000 00:00:00';
                    }

                } else {
                    $dt = '00.00.0000 00:00:00';
                }

                $val1 = intval($val1);

                db_query("UPDATE tsok_info SET pok = $val1, dt = '$dt' WHERE ls='$val2'");
                $cnt_updates++;
            }
        }
    }

}


function html_log($message)
{
    $fp = fopen('../logs/load.html', 'a+');
    fwrite($fp, $message . '<br>');
    fclose($fp);
}

Function GetFilesArr($dir)
{
    $ListDir = Array();
    If ($handle = opendir($dir)) {
        While (False !== ($file = readdir($handle))) {
            If ($file == '.' || $file == '..') {
                Continue;
            }
            $parts = pathinfo($file);
            if (strtolower($parts['extension']) != 'xls') {
                html_log(iconv("UTF-8", "windows-1251", "Неправильный формат файла: ") . $file);
                continue;
            }
            $path = $dir . '/' . $file;
            If (Is_File($path)) {
                $ListDir[] = $path;
            } ElseIf (Is_Dir($path)) {
                $ListDir = array_merge($ListDir, GetFilesArr($path));
            }
        }
        CloseDir($handle);
        Return $ListDir;
    }
}

echo $cnt_updates ? $cnt_updates : iconv("UTF-8", "windows-1251", 'Изменений не найдено');

?>