<?php


error_reporting(E_ALL);
 ini_set('display_errors', 'On');
 require_once('vendor\\autoload.php');
 // require_once (__DIR__."\\php\\readxl.php");
 // require_once (__DIR__."\\php\\settings.php");
require_once (__DIR__."\\readxl.php");
require_once (__DIR__."\\settings.php");

 function printPlan($filename)
{
  $plan = new Excel($filename, "\\..\\excel\\");
  $plan->reader->setReadEmptyCells(FALSE);
  $plan->setSheet(1);
  // $one=$plan->readRow(10,[2,3,4,5,6]);
  // var_dump($one);
 $itog = array();
 $startRow=10;
 $i=10;
 $readColsArray=[2,3,4,5,6];
 $colsNotNull=[3,4,5,6];
 $numRows=$plan->worksheet->getHighestDataRow() ;//+ 100;
 echo $numRows . "<br>";
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
     echo $plan->last_data[2]->getStyle()->getFont()->getItalic() . "GET ITALIC<br>";
     $skip=TRUE;

   }
   if ($skip == FALSE)
   {
     $itog[$i]=$row;
   }


   }
 foreach ($itog as $key => $value) {
   var_dump($value);
   echo "<br>";
 }
 return $itog;
 }


 ?>
