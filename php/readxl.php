<?php

 require_once(__DIR__. '\\..\\vendor\\autoload.php');
 use PhpOffice\PhpSpreadsheet\IOFactory;
 use \PhpOffice\PhpSpreadsheet\Style\Font;
class Excel
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
    $this->reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $this->spreadsheet = $this->reader->load($inputFileName);

  }


  public function setSheet($num)
  {
    if (empty($this->spreadsheet))
    {
      var_dump("Spreadsheet is empty");
      return 1;
    }
    $this->spreadsheet->setActiveSheetIndex($num);
    $this->worksheet = $this->spreadsheet->getActiveSheet();
  }


  public function readCol(int $col, int $start=1, int $stop=NULL, callable $callbackFilter=NULL)
  {
    $this->last_data=[];
    if (empty($this->worksheet))
    {
      echo "Worksheet is empty <br>";
      return;
    }
    if ($stop==NULL)
    {
      $stop=$this->worksheet->getHighestRow();
    }
    $retVal = array();
    //////////////////////////

    //$callbackFilter=function($style){return TRUE;};
    //////////////////////////////
    for ($i=$start; $i<=$stop; $i++)
    {
      if (is_callable($callbackFilter))
      {
        $cell=$this->worksheet->getCellByColumnAndRow($col, $i);
        if ($callbackFilter($cell))
        {
            //echo "callback is callable <br>";
          $retVal[$i] = $this->worksheet->getCellByColumnAndRow($col, $i)->getCalculatedValue();
          $this->last_data[$i]=$cell;
        }
      }
      else {
      //echo "callback is not callable <br>";
      $cell=$this->worksheet->getCellByColumnAndRow($col, $i);
      $retVal[$i] = $cell->getCalculatedValue();
      $this->last_data[$i]=$cell;
      }

    }
    // $this->last_data = $retVal;
    // var_dump($this->last_data);
    return $retVal;
  }
  public function readRow(int $row, iterable $cols=NULL, callable $callbackFilter=NULL)
  {
    $this->last_data=[];
    if (empty($this->worksheet))
    {
      echo "Worksheet is empty <br>";
      return;
    }
    if ($cols == NULL)
    {
      $colLen =\PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($this->worksheet->getHighestColumn());
      for ($i=0; $i<=$colLen; $i++)
      {
        if ($callbackFilter != NULL)
        {
          $cell= $this->worksheet->getCellByColumnAndRow($i,$row);
          if ($callbackFilter($cell))
          {
              //echo "callback is callable <br>";
            $retVal[$i] = $cell->getCalculatedValue();
            $this->last_data[$i]=$cell;
          }
        }
        else {
            $cell=$this->worksheet->getCellByColumnAndRow($i,$row);
            $retVal[$i] = $cell->getCalculatedValue();
            $this->last_data[$i]=$cell;
        }
      }
    }
    else {
      foreach ($cols as $key => $value)
      {
        if ($callbackFilter != NULL)
        {
          $cell= $this->worksheet->getCellByColumnAndRow($value, $row);
          if ($callbackFilter($cell))
          {
          $retVal[$value] =  $cell->getCalculatedValue();
          $this->last_data[$value]=$cell;
          }
        }
        else {
          $cell= $this->worksheet->getCellByColumnAndRow($value, $row);
          $retVal[$value] =  $cell->getCalculatedValue();
          $this->last_data[$value]=$cell;
        }
      }
    }
    return $retVal;
  }
}
 ?>
