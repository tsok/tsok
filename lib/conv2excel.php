<?php

require_once('../config.php');
require_once 'PHPExcel.php';
require_once('db.inc.php');
require_once('geo.php');
require_once('styles.php');

db_connect();

$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Титульный лист');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(150);

$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($titleCenterFont);
$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($titleCenter);
$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($titleUnderline);
$objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($titleCenter);
$objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($titleUnderline);
$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($titleCenter);
$objPHPExcel->getActiveSheet()->getStyle('A11')->applyFromArray($titleRightFont);
$objPHPExcel->getActiveSheet()->getStyle('A12')->applyFromArray($titleRightFont);
$objPHPExcel->getActiveSheet()->getStyle('A13')->applyFromArray($titleRightFont);
$objPHPExcel->getActiveSheet()->getStyle('A14')->applyFromArray($titleRight);
$objPHPExcel->getActiveSheet()->getStyle('A15')->applyFromArray($titleRight);
$objPHPExcel->getActiveSheet()->getStyle('A16')->applyFromArray($titleRightFont);
$objPHPExcel->getActiveSheet()->getStyle('A17')->applyFromArray($titleRight);
$objPHPExcel->getActiveSheet()->getStyle('A18')->applyFromArray($titleRight);

//echo 'Start: ' . date("Y-m-d H:i:s") . '<br>';

$city_title = intval($_REQUEST['city']) ? iconv("windows-1251", "UTF-8", $city_ar[intval($_REQUEST['city'])]) : '';

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A1", "Контрольные обходы")
    ->setCellValue("A2", "дата съема показаний – день, месяц, год)")
    ->setCellValue("A3", "                                {$city_title}                               ")
    ->setCellValue("A4", "(наименование населенного пункта)")
    ->setCellValue("A5", "                                                                                  ")
    ->setCellValue("A6", "(наименование улицы (микрорайона, проспекта, переулка и т.д.)- писать полностью)")
    ->setCellValue("A11", "Количество списаний ________")
    ->setCellValue("A12", "Количество нормативов ______")
    ->setCellValue("A13", "Сдал представитель ООО «ЦОК-ЭНЕРГО»")
    ->setCellValue("A14", "/__________________/____________________")
    ->setCellValue("A15", "           (Ф.И.О.)                                     ПОДПИСЬ")
    ->setCellValue("A16", "Принял представитель ОАО «ЯСК»")
    ->setCellValue("A17", "/_________________ /_________________")
    ->setCellValue("A18", "(Ф.И.О.)                ПОДПИСЬ      ");


//$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleThinBlackBorderOutline);

$cond = '';

if (intval($_REQUEST['city'])) {
    $cond .= " AND city = " . intval($_REQUEST['city']);
}

if (intval($_REQUEST['area'])) {
    $cond .= " AND area = " . intval($_REQUEST['area']);
}

$items1 = db_fetchall_array("SELECT DISTINCT address FROM tsok_info WHERE id>0 $cond LIMIT " . MAX_ADDRESS_LIMIT);

$cnt_files = 0;

foreach ($items1 as $item1) {


    $objPHPExcel->createSheet();

    $objPHPExcel->setActiveSheetIndex(1);

    $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleLeft);

    $objPHPExcel->getActiveSheet()->setTitle('Обходной лист');

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(9);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);

    $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle('I3')->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle('J3')->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle('K3')->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle('L3')->applyFromArray($BorderOutline);

    $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");

    $objPHPExcel->setActiveSheetIndex(1)
        ->setCellValue("A3", "№ п/п")
        ->setCellValue("B3", "Номер квартиры")
        ->setCellValue("C3", "Номер ПУ")
        ->setCellValue("D3", "Номер ЛС")
        ->setCellValue("E3", "Дата съема показаний")
        ->setCellValue("F3", "Показание")
        ->setCellValue("G3", "Показание день")
        ->setCellValue("H3", "Показание ночь")
        ->setCellValue("I3", "Показание пик")
        ->setCellValue("J3", "Показание полупик")
        ->setCellValue("K3", "Адрес")
        ->setCellValue("L3", "Подпись абонента");


    $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(30);

    $objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setWrapText(true);


    $objPHPExcel->getActiveSheet()->setCellValue("A1", $city_title . ', ' . iconv("windows-1251", "UTF-8", $item1['address']));

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("A5", "                     " . iconv("windows-1251", "UTF-8", $item1['address']) . "                        ");
    $objPHPExcel->setActiveSheetIndex(1);

    $cond = '';

    if (intval($_REQUEST['city'])) {
        $cond .= " AND city = " . intval($_REQUEST['city']);
    }

    if (intval($_REQUEST['area'])) {
        $cond .= " AND area = " . intval($_REQUEST['area']);
    }

    if (intval($_REQUEST['fempty'])) {
        $cond .= " AND pok=0";
    }

    $items = db_fetchall_array("SELECT * FROM tsok_info WHERE address='$item1[address]' $cond");

    if (count($items))
        $cnt_files++;
    else
        continue;

    $i = 4;
    $cnt = 1;
    foreach ($items as $item) {

        $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $i)->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('H' . $i)->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $i)->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('J' . $i)->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('K' . $i)->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('L' . $i)->applyFromArray($BorderOutline);

        $kv = iconv("windows-1251", "UTF-8", $item['kv']);
        $pu = iconv("windows-1251", "UTF-8", $item['pu']);
        $ls = iconv("windows-1251", "UTF-8", $item['ls']);
        $address = iconv("windows-1251", "UTF-8", $item['address']);

        $objPHPExcel->getActiveSheet()
            ->setCellValueExplicit("A$i", $cnt, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("B$i", $kv, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("C$i", $pu, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("D$i", $ls, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("K$i", $address, PHPExcel_Cell_DataType::TYPE_STRING);
        $i++;
        $cnt++;
    }

    $i = $i + 3;

    $objPHPExcel->getActiveSheet()->getStyle("A$i")->applyFromArray($boldRight);
    $objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 1))->applyFromArray($boldRight);
    $objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 2))->applyFromArray($boldRight);
    $objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 3))->applyFromArray($boldRight);
    $objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 4))->applyFromArray($boldRight);
    $objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 5))->applyFromArray($boldRight);


    $objPHPExcel->setActiveSheetIndex(1)
        ->setCellValue("A$i", 'Отсутствие показаний ввиду невозможности (отсутствия) доступа к приборам учета')
        ->setCellValue("A" . ($i + 1), 'по квартирам №№_____________________подтверждаю_____________/__________________/')
        ->setCellValue("A" . ($i + 2), 'подпись    статус, расшифровка подписи')
        ->setCellValue("A" . ($i + 3), '_____________/__________________/')
        ->setCellValue("A" . ($i + 4), 'дата(число, месяц, год)  подпись    (Ф.И.О. исполнителя)');


    $objPHPExcel->getActiveSheet()->mergeCells("A$i:L$i");
    $objPHPExcel->getActiveSheet()->mergeCells("A" . ($i + 1) . ":L" . ($i + 1));
    $objPHPExcel->getActiveSheet()->mergeCells("A" . ($i + 2) . ":L" . ($i + 2));
    $objPHPExcel->getActiveSheet()->mergeCells("A" . ($i + 3) . ":L" . ($i + 3));
    $objPHPExcel->getActiveSheet()->mergeCells("A" . ($i + 4) . ":L" . ($i + 4));

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $filename = preg_replace('/[\*|\\\\:"<>\?\/]/i', '', (intval($_REQUEST['city']) ? $city_ar[intval($_REQUEST['city'])] : '') . ', ' . $item['address']);

    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setVisible(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setVisible(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setVisible(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setVisible(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setVisible(false);

    $objWriter->save(EMPTY_EXCEL_FOLDER . $filename . '.xls');

    $sheetIndex = $objPHPExcel->getIndex($objPHPExcel->getSheetByName('Обходной лист'));
    $objPHPExcel->removeSheetByIndex($sheetIndex);


    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setVisible(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setVisible(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setVisible(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setVisible(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setVisible(true);

}

//echo 'End: ' . date("Y-m-d H:i:s") . '<br><br>';


//echo 'Created: ' . count($items1) . ' excel files<br><br>';

echo $cnt_files ? $cnt_files : iconv("UTF-8", "windows-1251", 'файлы не созданы');


?>