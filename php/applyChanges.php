<?php

require_once ("readxl.php");
require_once ("readPlan.php");

function parseKey($str) {
  $typeToCol = ["exam" =>3,
  "zachet" =>4,
  "kp" =>5,
  "kr" =>6,];
  $tmp=array();
  preg_match_all("~\d+$~", $str, $tmp, PREG_OFFSET_CAPTURE);
  if (isset($tmp[0][0][0]) ==FALSE) {
    return $str;
  }
  $tmp = ['row' => intval($tmp[0][0][0]),'col'=> $typeToCol[substr($str,0, $tmp[0][0][1])] ];
  //var_dump($tmp);
  return $tmp;
}

function formatValues(iterable $strs)
{
  if (count($strs) == 1)
  {
    return $strs[0];
  }
  asort($strs);
  return implode("," , $strs);
}



function applyChanges( string $path="\\..\\excel\\tempFiles\\")
{
  $fname = $_COOKIE["filename"];
  $excel = new Excel($fname, $path);


  $template = new Excel("template.xlsx", "\\..\\resources\\");
  $template->setSheet(0);
  $templateTable = clone $template->worksheet;
  $templateTable->setTitle("График Учебного процесса");

  $excel->spreadsheet->removeSheetByIndex($excel->spreadsheet->getIndex($excel->spreadsheet->getSheetByName("График Учебного процесса")));

  $excel->spreadsheet->addExternalSheet($templateTable);
  $excel->setSheet(0);
  $maxColLen = $excel->worksheet->getHighestRow();
  $startRow = 10;
  $typeToCol = ["exam" =>3,
  "zachet" =>4,
  "kp" =>5,
  "kr" =>6,];

  $semestrToCol = [ "1" => 14,
    "2" =>15,
    "3" =>16,
    "4" =>17,
    "5" =>18,
    "6" =>19,
    "7" =>20,
    "8" =>21,
    "9" =>22,
    "10"=>23,];
  $checkSemestr = array_keys($semestrToCol);
  $indexAndValue = [];
  $startRow=10;
  //  var_dump($_POST);

    foreach ($_POST as $key => $value) {
      switch ($key) {
          case 'fio':
            $excel->setSheet(2);
            $excel->worksheet->setCellValue('F19', "$value");
            $excel->setSheet(0);
            break;
          case 'direction':
            $excel->setSheet(2);
            $excel->worksheet->setCellValue('K22', "$value");
            $excel->setSheet(0);
            break;
          case 'educationForm':
            $excel->setSheet(2);
            $excel->worksheet->setCellValue('J24', "$value");
            $excel->setSheet(0);
            break;
          default:
          $tmpColAndRow=parseKey($key);
          $indexAndValue[] = ["indexes"=>array("row" => $tmpColAndRow["row"],"col" => $tmpColAndRow["col"]),"value" => $value];
        //  echo "<br>";
          break;
    }
  }
    // foreach ($indexAndValue as $key => $value) {
    //   echo "$key<br>";
    //   var_dump($value);
    //   echo "<br>";
    //}
    //var_dump($indexAndValue);
    $cell;
    $hoursCell;
    for ($i=$startRow; $i <= $excel->worksheet->getHighestRow(); $i++) {
      $rowValues=[];
      foreach ($typeToCol as $colInd) {
        $inArr = FALSE;
        for ($j=0; $j < count($indexAndValue); $j++) {
          $cell=$excel->worksheet->getCellByColumnAndRow($colInd, $i);
          if ($indexAndValue[$j]["indexes"]["row"]==$i && $indexAndValue[$j]["indexes"]["col"] == $colInd)
          {
            $inArr = TRUE;
            $excel->worksheet->setCellValueByColumnAndRow($colInd, $i, formatValues($indexAndValue[$j]['value']));
            $rowValues = $indexAndValue[$j]['value'];
            break;
            }
            if (($inArr == FALSE) && ($cell->getStyle()->getFont()->getItalic() == FALSE) && ($cell->getCalculatedValue() != 'х'))
            {
              $excel->worksheet->setCellValueByColumnAndRow($colInd, $i, NULL);
            }
          }
        }
        $array_iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($rowValues));
        $cleanHours = [];
        $tmpArrayVals=[];
        foreach ($array_iterator as $inArray) {
          $tmpArrayVals[]=$inArray;
        }
        foreach ($checkSemestr as $semstr) {
            if (!(in_array($semstr, $tmpArrayVals) || in_array($semstr."д", $tmpArrayVals)))
            {
              $cleanHours[]=$semestrToCol["$semstr"];
            }
        }
        foreach ( $cleanHours as $cleanHour) {
          $excel->worksheet->setCellValueByColumnAndRow($cleanHour, $i, NULL);
        }


      }
        $excel->writer->save(__DIR__ . $path . $fname);
    }

applyChanges();
require_once (__DIR__ . "\\..\\views\\saveFile.php");
$content = savefiles([$_COOKIE["filename"]]);
require_once (__DIR__ . "\\..\\views\\template.php");
 ?>
