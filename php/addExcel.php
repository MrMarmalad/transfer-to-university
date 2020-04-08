<?php

require_once (__DIR__."\\..\\vendor\\autoload.php");
require_once (__DIR__."\\readxl.php");
use PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;

function saveFile(string $uploaddir=NULL)
{
  $maxDifference = ["years" => 0,
  "months" => 0,
  "days" => 0,
  "hours" => 12];
  $dir='\\..\\excel\\tempFiles\\';
  if ($uploaddir == NULL)
  {
  $uploaddir = __DIR__ . $dir;
  }
  //$tmpFname = "tmpXLFile.xlsx";
  $tmpFname = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36) . '.xlsx';
  // $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
  $uploadfile = $uploaddir . $tmpFname;
  //echo $uploadfile . is_uploaded_file($_FILES['tmpFile']['tmp_name']). '<pre>';
  // if () {
  //     echo "Файл корректен и был успешно загружен.\n";
  // } else {
  //     echo "Возможная атака с помощью файловой загрузки!\n";
  // }
  //echo 'Некоторая отладочная информация:';
  //print_r($_FILES);
  // print "</pre>";
  // echo "fname $tmpFname<br>";
  // echo "fpath $uploaddir<br>";
  // $tempEx=new Excel($tmpFname, '\\..\\excel\\tempFiles\\');
  // //$uploaddir . $tmpFname  $uploadfile
  move_uploaded_file($_FILES['tmpFile']['tmp_name'], $uploadfile);
  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
  if ($reader->canRead($uploadfile) == TRUE)
  {
    ///ЛОГИКА ПРОДОЛЖАЕТСЯ
    //echo "FILE IS READABLE<br>";
    setcookie("filename", $tmpFname, time() + $maxDifference["hours"]*3600 );
    //$fd = fopen (__DIR__. "\\..\\resources\\fileuptime.txt", "a+");
    //$strs=
    $db = __DIR__. "\\..\\resources\\fileuptime.txt";
    $file = file($db, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

    // while(!feof($fd))
    // {
    foreach ($file as $key => $str) {
    //$str = fgets($fd);
    if (!empty($str))
    {
    //echo "$str<br>";
    $date=[];
    $time = [];
    $fname = [];
    preg_match_all("~\d{4}(-|\/)\d{2}(-|\/)\d{2}~", $str, $date);
    preg_match_all("~\d{2}:\d{2}~", $str, $time);
    preg_match_all("~[0-9,a-z,A-Z]+.xlsx~", $str, $fname);
    //var_dump($date);
    //echo date("Y-m-d", strtotime($date[0][0])) . "<br>";
    //echo date("Y-m-d") . " - today<br>";
    $fileDate = DateTime::createFromFormat('Y-m-d H:i', $date[0][0] . " " . $time[0][0]);
    $now = DateTime::createFromFormat('Y-m-d H:i', date("Y-m-d H:i"));
    $interval = date_diff($fileDate, $now);
    //echo $interval->format("%I") . "<br>";
    //echo $interval->format("%H") . "<br>";

    if ((integer)$interval->format("%Y") > $maxDifference["years"] ||
    (integer)$interval->format("%M") >  $maxDifference["months"] ||
    (integer)$interval->format("%D") > $maxDifference["days"] ||
    (integer)$interval->format("%H") > $maxDifference["hours"])
    {
      if (unlink(__DIR__ . $dir . $fname[0][0]) == TRUE)
      {
        // require_once(__DIR__."\\..\\views\\backButton.php");
        // $typeOfError = "<br> Внутренняя ошибка сервера <br>";
        // require_once(__DIR__."\\..\\views\\template.php");
        //echo "$file[$key] is deleted";
      unset($file[$key]);
      }
    }
    }
    }
    require_once(__DIR__."\\..\\views\\showFile.php");
    $content=showFile($tmpFname, $dir);
    require_once(__DIR__."\\..\\views\\template.php");
    //fwrite ($fd, "$tmpFname " . date("Y-m-d H:i") . PHP_EOL);
    $file[] =  "$tmpFname " . date("Y-m-d H:i");
    file_put_contents ($db, implode("\n", $file));

  }
  else {
    ///НЕЧИТАЕМЫЙ ФАЙЛ, УДАЛЯЕМ ЕГО, ПЕРЕКИДЫВАЕМ НА ПРЕДЫДУЩУЮ СТРАНИЦУ
    //unlink($uploadfile);
    require_once(__DIR__."\\..\\views\\backButton.php");
    require_once(__DIR__."\\..\\views\\template.php");
    unlink ($uploadfile);
    return false;
  }

}
saveFile();


?>
