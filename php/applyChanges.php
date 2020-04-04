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



function applyChanges(string $fname="tmpXLFile.xlsx", string $path="\\..\\excel\\tempFiles\\")
{
  $excel = new Excel($fname, $path);
  $excel->setSheet(1);
  $maxColLen = $excel->worksheet->getHighestRow();
  $startRow = 10;
  $typeToCol = ["exam" =>3,
  "zachet" =>4,
  "kp" =>5,
  "kr" =>6,];
  // $semestrToCol = [ "1" => 14,
  //   "1д" => 14,
  //   "2" =>15,
  //   "2д" =>15,
  //   "3" =>16,
  //   "3д" =>16,
  //   "4" =>17,
  //   "4д" =>17,
  //   "5" =>18,
  //   "5д" =>18,
  //   "6" =>19,
  //   "6д" =>19,
  //   "7" =>20,
  //   "7д" =>20,
  //   "8" =>21,
  //   "8д" =>21,
  //   "9" =>22,
  //   "9д" =>22,
  //   "10"=>23,
  //   "10д"=>23,];
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
            echo "$key<br>";
            break;
          case 'direction':
              echo "$key<br>";
            break;
          case 'educationForm':
              echo "$key<br>";
            break;
          default:
          $tmpColAndRow=parseKey($key);
          $indexAndValue[] = ["indexes"=>array("row" => $tmpColAndRow["row"],"col" => $tmpColAndRow["col"]),"value" => $value];
        //  echo "<br>";
          break;
    }
  }
    foreach ($indexAndValue as $key => $value) {
      echo "$key<br>";
      var_dump($value);
      echo "<br>";
    }
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
            //echo $cell->getCalculatedValue() . "<br>";
            $inArr = TRUE;
            //var_dump($indexAndValue[$j]['value']);
            //echo "<br>" . $indexAndValue[$j]['indexes']['row']. " : ". $indexAndValue[$j]['indexes']['col']." TRUE <br>";
            //echo formatValues($indexAndValue[$j]['value']) . "<br>";
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
        // var_dump($cleanHours);
        // echo "cleanHours<br>";
        // foreach ($semestrToCol as $sem => $semCol) {
        //
        //     if (!in_array($inArray,$checkSemestr))
        //     {
        //       $cleanHours[]=$semCol
        //     }
        //
        // }
        //   foreach ($array_iterator as $inArray) {
        //     if (!in_array($inArray,$checkSemestr))
        //     {
        //       $cleanHours[]=$semCol
        //     }
        //   }
        // foreach ($array_iterator as $semestr) {
        //    echo "$semestr<br>";
        //    $hoursCell=$excel->worksheet->getCellByColumnAndRow($colInd, $i);
        // }

      }
        $excel->writer->save(__DIR__ . $path . "test1.xlsx");
    }

        //var_dump(["row" => $i, "col" => $value]);
        // echo "<br>";
        // echo in_array([$i, $value], $indexAndValue);

        // if (array_search(["row" => $i, "col" => $value], $indexAndValue) != NULL)
        // {
        //   echo "find<br>";
        // }
        // else {
        //   echo "not find <br>";
        // }

    //       var_dump($indexAndValue);
      //$indexAndValue[] = [$tmpColAndRow["row"], $tmpColAndRow["col"], $value];
      //var_dump();
      // var_dump(parseKey($key));
      // echo "<br>";
    // for ($i=$startRow; $i < $maxColLen; $i++) {
    //   foreach ($typeToCol as $key => $value) {
    //     if(array_search())
    //   }
    // }

      //echo "$key<br>";

  // foreach ($_POST as $key => $value) {
  //   //echo "$key<br>";
  //   //var_dump($value);
  //   switch ($key) {
  //     case 'fio':
  //       echo "$key<br>";
  //       break;
  //     case 'direction':
  //         echo "$key<br>";
  //       break;
  //     case 'educationForm':
  //         echo "$key<br>";
  //       break;
  //     default:
  //     $colAndRow = parseKey($key);
  //     //$cleanRows=[];
  //     //readPlan($fname,$path);
  //     // for ($i=0; $i < $excel->maxColLen ; $i++) {
  //     //     $excel->cleanCols($i, $typeToCol);
  //     //   }
  //     $startRow=10;
  //     $readColsArray=[3,4,5,6];
  //     //$numRows=$excel->worksheet->getHighestDataRow() ;//+ 100;
  //        foreach ($readColsArray as $cleanCol) {
  //          $cell=$excel->worksheet->getCellByColumnAndRow($cleanCol,$i);
  //          if (($cell->getStyle()->getFont()->getItalic() == FALSE) && ($cell->getCalculatedValue() != 'х'))
  //          {
  //             $excel->worksheet->setCellValueByColumnAndRow($cleanCol, $colAndRow['row'],NULL);
  //          }
  //
  //        }
  //     }
  //     // foreach ($excel->readRows as $cleanRow) {
  //     //   $excel->cleanCols($cleanRow, $typeToCol);
  //     // }
  //     //НАДО ЧИСТИТЬ И ЗАПИСЫВАТЬ ПО ЯЧЕЙКЕ
  //     $writeStr = formatValues($value);
  //     echo "$writeStr in ${colAndRow["row"]} : ${colAndRow["col"]}<br>";
  //     var_dump($colAndRow);
  //     $excel->worksheet->setCellValueByColumnAndRow($colAndRow["col"], $colAndRow["row"],$writeStr);
  //     var_dump($colAndRow);
  //     //$writeStr = formatValues($value);
  //     //echo "$writeStr<br>";
  //   //
  //      //echo "1<br>";
  //   }
  //   }
  //   $excel->writer->save(__DIR__ . $path . "test1.xlsx");


    //   foreach ($semestrToCol as $key => $col) {
    //
    //     if (!in_array($key, $value))
    //     {
    //       echo "1<br>";
    //       //echo "col: ${col}<br> row:${colAndRow["row"]}";
    //       $excel->worksheet->setCellValueByColumnAndRow(intv$col), $colAndRow["row"], NULL);
    //     }
    //   }
    //   $values = array();
    //   foreach ($value as $attestation) {
    //     $values[] = $attestation;
    //   }
    //   echo "3<br>";
    //   $colAndRow["col"] = $typeToCol[$colAndRow["type"]];
    //   $excel->worksheet->setCellValueByColumnAndRow($colAndRow["col"], $colAndRow["row"], formatValues($values));
    //     break;
    // }
    // var_dump($key);
    // echo "    <br>  ";
    // //var_dump($value);
    // var_dump(parseKey($key));
    //   var_dump($value);


  //$excel->writer->save(__DIR__ . $path . "test1.xlsx");
  //echo "Изменения прошли успешно<br>";


applyChanges();
 ?>
