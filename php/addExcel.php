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
  $tmpFname = "tmpXLFile.xlsx";
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
    require_once(__DIR__."\\..\\views\\showFile.php");
    $content=showFile($tmpFname, $dir);
    require_once(__DIR__."\\..\\views\\template.php");
  }
  else {
    ///НЕЧИТАЕМЫЙ ФАЙЛ, УДАЛЯЕМ ЕГО, ПЕРЕКИДЫВАЕМ НА ПРЕДЫДУЩУЮ СТРАНИЦУ
    require_once(__DIR__."\\..\\views\\backButton.php");
    require_once(__DIR__."\\..\\views\\template.php");
    unlink ($uploadfile);
    return false;
  }

}


saveFile();


?>
