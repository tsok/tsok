<?php

require_once('db.inc.php');
require_once('styles.php');
require_once('PHPExcel.php');

db_connect();

$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
$cacheSettings = array(' memoryCacheSize ' => '1MB');
PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

function generate_excel($limit, $filename, $cond)
{
    $cond = !empty($cond) ? $cond : '';

    $BorderOutline = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000')
            )
        )
    );

    /*
       $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
       $cacheSettings = array(' memoryCacheSize ' => '8MB');
       PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
    */

    $objPHPExcel = new PHPExcel();


    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Лист1');


    $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setWrapText(true);


    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);


    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("A1", "№ п/п")
        ->setCellValue("B1", "Номер квартиры")
        ->setCellValue("C1", "Номер ПУ")
        ->setCellValue("D1", "Номер ЛС")
        ->setCellValue("E1", "Дата съема показаний")
        ->setCellValue("F1", "Показание")
        ->setCellValue("G1", "Показание день")
        ->setCellValue("H1", "Показание ночь")
        ->setCellValue("I1", "Показание пик")
        ->setCellValue("J1", "Показание полупик")
        ->setCellValue("K1", "Адрес")
        ->setCellValue("L1", "Подпись абонента");

    $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("B1")->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("C1")->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("D1")->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("E1")->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("F1")->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("G1")->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("H1")->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("I1")->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("J1")->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("K1")->applyFromArray($BorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("L1")->applyFromArray($BorderOutline);


    $items = db_fetchall_array("SELECT *, DATE_FORMAT(dt,'%d.%m.%y') dat FROM tsok_info where pok>0 $cond ORDER BY id ASC LIMIT $limit");

    $len = count($items);

    $i = 1;
    foreach ($items as $item) {

        $item['kv'] = iconv("windows-1251", "UTF-8", $item['kv']);
        $item['address'] = iconv("windows-1251", "UTF-8", $item['address']);

        $item['dat'] = $item['dat'] != '00.00.00' ? $item['dat'] : '';
        $i++;
        $cur_num = $i - 1;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit("A$i", "$cur_num", PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("B$i", "$item[kv]", PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("C$i", "$item[pu]", PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("D$i", "$item[ls]", PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("E$i", "$item[dat]", PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("F$i", "$item[pok]", PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("K$i", "$item[address]", PHPExcel_Cell_DataType::TYPE_STRING);

        $objPHPExcel->getActiveSheet()->getStyle("C$i")
            ->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

        $objPHPExcel->getActiveSheet()->getStyle("A$i")->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle("B$i")->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle("C$i")->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle("D$i")->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle("E$i")->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle("F$i")->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle("G$i")->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle("H$i")->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle("I$i")->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle("J$i")->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle("K$i")->applyFromArray($BorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle("L$i")->applyFromArray($BorderOutline);

    }


    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

    $objWriter->save(EXCEL_FINAL_FOLDER . $filename . '.xls');


}

?>