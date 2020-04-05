<?php

require_once (__DIR__."\\..\\vendor\\autoload.php");
require_once (__DIR__."\\readxl.php");
use PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;

function saveFile(string $uploaddir=NULL)
{

  $dir='\\..\\excel\\tempFiles\\';
  if ($uploaddir == NULL)
  {
  $uploaddir = __DIR__ . $dir;
  }
  //$tmpFname = "tmpXLFile.xlsx";
  $tmpFname = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
  // $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
  $uploadfile = $uploaddir . $tmpFname . '.xlsx';
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
    setcookie("filename", $tmpFname);
    $fd = fopen (__DIR__. "\\..\\resources\\fileuptime.txt", "a+");
    while(!feof($fd))
    {
    $str = fgets($fd);
    echo "$str<br>";
    $date = preg_grep("~\d{4}(-|\/)\d{2}(-|\/)\d{2}~", $str);
    $time = preg_grep("~\d{2}:\d{2}~", $str);
    //$date = trim(preg_grep("", $str, PREG_GREP_INVERT));
    $fname = trim(preg_grep("~\d{2}:\d{2}~",preg_grep("~\d{4}(-|\/)\d{2}(-|\/)\d{2}~", $str, PREG_GREP_INVERT), PREG_GREP_INVERT));
    echo "$date<br>";
    echo "$time<br>";
    echo "$fname<br>";
    }
    require_once(__DIR__."\\..\\views\\showFile.php");
    $content=showFile($tmpFname, $dir);
    require_once(__DIR__."\\..\\views\\template.php");
    fwrite ($fd, "$tmpFname " . date("Y-m-d H:i"));
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
