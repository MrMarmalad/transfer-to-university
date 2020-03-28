<?php

error_reporting(E_ALL);
 ini_set('display_errors', 'On');
 require_once('vendor\\autoload.php');
 require_once (__DIR__."\\php\\readxl.php");
 require_once (__DIR__."\\php\\settings.php");

 $ras = new Excel("ex.xlsx", "\\..\\excel\\");
 $ras->setSheet(1);
 $ras->readCol(2,28,10);
 //var_dump($ras->worksheet->toArray(null, true, true, true));
 // use PhpOffice\PhpSpreadsheet\IOFactory;
 //
 // require 'C:\Users\UserPC12\Desktop\Al\WEB\OSPanel\domains\IT-kursach2\vendor\phpoffice\phpspreadsheet\samples\Header.php';
 //
 // $inputFileName = __DIR__ . '\\excel\\ex.xlsx';
 // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
 // $spreadsheet = $reader->load($inputFileName);
 // $spreadsheet->setActiveSheetIndex(0);
 // $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
 // var_dump($sheetData);
 ?>
