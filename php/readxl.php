<?php
//require_once "settings.php";

// $settings = array(
//   "path_to_libs"=>__DIR__ . "\\..\\libs\\vendor\\",
//   "path_to_autoloader"=> __DIR__ . "\\..\\libs\\vendor\\autoload.php",
//   "path_to_excel"=>__DIR__ . "\\..\\excel\\",
// );

//require_once $settings["path_to_autoloader"];
 require_once(__DIR__. '\\..\\vendor\\autoload.php');
 use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 *
 */
class Excel //extends AnotherClass
{
  public $path_to_excel;
  public $excel;
  public $spreadsheet;
  public $reader;
  public $filename;
  public $sheetData;
  public $worksheet;

  public $num;
  public function __construct($filename, $path)
  {
    $this->filename = $filename;
    $this->path_to_excel = $path;
    $inputFileName = __DIR__ . $path . $filename;
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $this->spreadsheet = $reader->load($inputFileName);

  }


  public function setSheet($num)
  {
    if (empty($this->spreadsheet))
    {
      var_dump("Spreadsheet is empty");
      return 1;
    }
    $this->spreadsheet->setActiveSheetIndex($num);
    $this->worksheet = $this->spreadsheet->getActiveSheet();//->toArray(null, true, true, true);
    var_dump("setSheet() complete");
    //var_dump($this->worksheet->toArray(null, true, true, true));
    // if (empty($this->excel))
    // {
    //   return 1;
    // }
    //$this->spreadsheet->setActiveSheetIndex(1);
    //$this->last_data =
  //  var_dump($this->spreadsheet->getActiveSheet()->toArray(null, true, true, true));
  //  var_dump($this->last_data);
    //var_dump($this->worksheet->toArray(null, true, true, true));
    //$this->worksheet = $this->spreadsheet->getActiveSheet();
    // var_dump($this->spreadsheet->getActiveSheet()->toArray(null, true, true, true));
    // var_dump($this->worksheet->toArray(null, true, true, true));
    //$this->spreadsheet = getSheet($num);
  }


  public function readCol($col, $stop=-1, $start=1, $callbackFilter=-1)
  {
    if (empty($this->worksheet))
    {
      echo "Worksheet is empty <br>";
      return;
    }
    if ($stop==-1)
    {
      $stop=$this->worksheet->getHighestRow();
    }
    $retVal = array();
    //////////////////////////

    //$callbackFilter=function($style){return true;};
    //////////////////////////////
    for ($i=$start; $i<=$stop; $i++)
    {
      if (is_callable($callbackFilter))
      {
        $style=$this->worksheet->getStyle($col, $i);
        if ($callbackFilter($style))
        {
            //echo "callback is callable <br>";
          $retVal[$i] = $this->worksheet->getCellByColumnAndRow($col, $i)->getCalculatedValue();
        }
      }
      else {
      //echo "callback is not callable <br>";
      $retVal[$i] = $this->worksheet->getCellByColumnAndRow($col, $i)->getCalculatedValue();
      }

    }
    $this->last_data = $retVal;
    var_dump($this->last_data);
    return $retVal;
  }


//   public function getCellValue($cellOrCol, $row = null, $format = 'd.m.Y')
//     {
//         //column set by index
//         // if(is_numeric($cellOrCol)) {
//         //     $cell = $this->worksheet->getCellByColumnAndRow($cellOrCol, $row);
//         // } else {
//         //     $lastChar = substr($cellOrCol, -1, 1);
//         //     if(!is_numeric($lastChar)) { //column contains only letter, e.g. "A"
//         //        $cellOrCol .= $row;
//         //     }
//         //
//         //     $cell = $this->worksheet->getCell($cellOrCol);
//         // }
//
//         //try to find current coordinate in all merged cells ranges
//         //if find -> get value from head cell
//         // foreach($this->mergedCellsRange as $currMergedRange){
//         //     if($cell->isInRange($currMergedRange)) {
//         //         $currMergedCellsArray = PHPExcel_Cell::splitRange($currMergedRange);
//         //         $cell = $this->worksheet->getCell($currMergedCellsArray[0][0]);
//         //         break;
//         //     }
//         // }
//
//         //simple value
//         // $val = $cell->getValue();
//         //
//         // //date
//         // if(PHPExcel_Shared_Date::isDateTime($cell)) {
//         //      $val = date($format, PHPExcel_Shared_Date::ExcelToPHP($val));
//         // }
//         //
//         // //for incorrect formulas take old value
//         // if((substr($val,0,1) === '=' ) && (strlen($val) > 1)){
//         //     $val = $cell->getOldCalculatedValue();
//         // }
//         //
//         // return $val;
//     }
 }
// echo PHP_EOL . $settings["path_to_excel"] . '<br>';
// echo PHP_EOL . $settings["path_to_libs"] . '<br>';
// echo PHP_EOL . $settings["path_to_autoloader"] . '<br>';
// echo PHP_EOL . $settings["path_to_excel"] . $filename;   $settings["path_to_excel"], $filename




 ?>
