<?php

error_reporting(E_ALL);
 ini_set('display_errors', 'On');
 require_once('vendor\\autoload.php');
 require_once (__DIR__."\\php\\readxl.php");
 require_once (__DIR__."\\php\\settings.php");

 $plan = new Excel("ex.xlsx", "\\..\\excel\\");
 $plan->setSheet(1);

 // $one=$plan->readRow(10,[2,3,4,5,6]);
 // var_dump($one);
$itog = array();
$startRow=10;
$i=10;
$readColsArray=[2,3,4,5,6];
$colsNotNull=[2,3,4,5,6];
$numRows=$plan->worksheet->getHighestRow() ;//+ 100;
// for ($i=$startRow; $i<$numRows; $i++)
// {
do {
    $row=$plan->readRow($i,$readColsArray);
    $allColsNull=false;
    foreach ($colsNotNull as $value) {
      if ($row["$value"] != null)
      {
        break;
      }
      $allColsNull=true;
    }

    if ($plan->last_data[2]->getStyle()->getFont()->getItalic()== true)
    {
      $allColsNull=true;
    }
    if($allColsNull == false)
    {
      $itog["$i"]=$row;
    }
    $allColsNull=false;
    $i++;
    //print_r($plan->last_data[2]->getStyle()->getBorders()->getRight()->getBorderStyle());
    //print_r($plan->last_data[2]->getStyle()->getBorders()->getRight()->getBorderStyle());
} while ($i<=$numRows);//$plan->last_data[2]->getStyle()->getBorders()->getRight()->getBorderStyle() == "medium");
//var_dump($itog);
//print_r($plan->last_data[2]->getStyle()->getBorders()->getRight());
//$plan->last_data[2]->getStyle()->getBorders()->getRight() !=null
///////////////////////////////////////////
foreach ($itog as $key => $value) {
  var_dump($value);
  echo "<br>";
}

///////////////////////////////
 // $name=$plan->readCol(2,10);
 // $exams=$plan->readCol(3,10);
 // $zach=$plan->readCol(4,10);
 // $kp=$plan->readCol(5,10);
 // $kr=$plan->readCol(6,10);
 //
 //
 // foreach ($name as $value) {
 //
 //   echo $value . "<br>";
 //   // $itog["$i"]['name']=$value->getCalculatedValue();
 //   // $itog["$i"]['exams']=$exams["$i"]->getCalculatedValue();
 //   // $itog["$i"]['zach']=$zach["$i"]->getCalculatedValue();
 //   // $itog["$i"]['kp']=$kp["$i"]->getCalculatedValue();
 //   // $itog["$i"]['kr']=$kr["$i"]->getCalculatedValue();
 //   // $i++;
 // }
 // var_dump($name);
 // var_dump($exams);
 // var_dump($zach);
 // var_dump($kp);
 // var_dump($kr);
 // $i=0;
 // foreach ($name as $value) {
 //
 //   $itog["$i"]['name']=$value->getCalculatedValue();
 //   $itog["$i"]['exams']=$exams["$i"]->getCalculatedValue();
 //   $itog["$i"]['zach']=$zach["$i"]->getCalculatedValue();
 //   $itog["$i"]['kp']=$kp["$i"]->getCalculatedValue();
 //   $itog["$i"]['kr']=$kr["$i"]->getCalculatedValue();
 //   $i++;
 // }
//  for ($i=0; $i<count($name);$i++)
//  {
//    $itog["$i"]['name']=$value->getCalculatedValue();
//     $itog["$i"]['exams']=$exams["$i"]->getCalculatedValue();
//     $itog["$i"]['zach']=$zach["$i"]->getCalculatedValue();
//     $itog["$i"]['kp']=$kp["$i"]->getCalculatedValue();
//     $itog["$i"]['kr']=$kr["$i"]->getCalculatedValue();
//  }
// var_dump($itog);

 //var_dump($plan->worksheet->toArray(null, true, true, true));
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
