<?php


error_reporting(E_ALL);
 ini_set('display_errors', 'On');
 require_once(__DIR__ . '\\..\\vendor\\autoload.php');
 // require_once (__DIR__."\\php\\readxl.php");
 // require_once (__DIR__."\\php\\settings.php");
require_once (__DIR__."\\readxl.php");
require_once (__DIR__."\\settings.php");

 function readPlan($filename, $path = "\\..\\excel\\")
{
  $plan = new Excel($filename, $path);
  $plan->reader->setReadEmptyCells(FALSE);
  // echo "$plan->path_to_excel<br>$plan->filename<br>";

  $plan->setSheet(1);
  //echo "$plan->worksheet<br>";
  // $one=$plan->readRow(10,[2,3,4,5,6]);
  // var_dump($one);
 $itog = array();
 $startRow=10;
 $i=10;
 $readColsArray=[2,3,4,5,6];
 $colsNotNull=[3,4,5,6];
 $numRows=$plan->worksheet->getHighestDataRow() ;//+ 100;
 //echo $numRows . "<br>";
 $skip=TRUE;
 for ($i=$startRow; $i<=$numRows; $i++)
 {
   $row=[];
   $skip=TRUE;
   $row=$plan->readRow($i,$readColsArray);
   foreach ($colsNotNull as $value) {
     if (!(is_null($row[$value])))
     {
       $skip=FALSE;
       break 1;
     }
   }
   //echo $plan->last_data[2]->getValue() . '   ' . is_null($plan->last_data[2]->getStyle()->getFont()->getItalic()) . "<br>";
   if ($plan->last_data[2]->getStyle()->getFont()->getItalic() == TRUE)
   {
     //echo $plan->last_data[2]->getStyle()->getFont()->getItalic() . "GET ITALIC<br>";
     $skip=TRUE;

   }
   if ($skip == FALSE)
   {
     $itog[$i]=$row;
   }


   }

 return $itog;
 }

//readPlan('4.xlsx');

// $itog = readPlan('tmpXLFile.xlsx','\\..\\excel\\tempFiles\\');
// foreach ($itog as $key => $value) {
//   echo "$key     ";
//   var_dump($value);
//   echo "<br>";
// }



// include_once (__DIR__ . '\\..\\views\\showFile.php');
// include_once (__DIR__ . '\\..\\views\\template.php');

 ?>
