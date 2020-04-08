<!-- <!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
    	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.js "></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<title></title>
</head>
<body> -->

<?php
function savefiles ($fnames) {
$content =<<<STARTCONTENT
<div class="container text-center text-md-left">
	<div class="row">
		<div class="col-md-3 mx-auto">
			<h5 class="font-weight-bold text-uppercase mt-3 mb-4">Скачать сгенерированные файлы</h5>
				<ul class="list-unstyled">
STARTCONTENT;
	$paths =[];
	foreach ($fnames as $key => $value) {
		$paths[$value]= "\\..\\excel\\tempFiles\\" . $value;
	}
	//$path="\\..\\excel\\tempFiles\\" . $fname;
	//$dir = __DIR__ . $path;
  //  $dir = '\\..\\excel\\tempFiles\\';
    // $files = scandir($dir);//Поменять путь, когда будем закидывать на хостинг, по-другому не работает
    // array_shift($files); // удаляем из массива '.'
    // array_shift($files); // удаляем из массива '..'
    // sort($files); //Сортировка по названию.

		foreach ($paths as $key => $value) {
			$format = explode(".",$value);//берём ласт элемент, отделяемый точкой
	    //if($format == 'xlsx') // устанавливаем нужный формат, который хотим скачивать
	    //{
				$content .=<<<FLIST
	    	<li>
	      <a href="${value}" title="открыть/скачать файл">${key}</a></br>
	      </li>
FLIST;
				}
				$content .= <<<ENDCONTENT
				</ul>
				</div>
				<hr class="clearfix w-100 d-md-none">
			</div>
			</div>
ENDCONTENT;
			return $content;
		}
    // for($i=0; $i<sizeof($files); $i++)
    // {
    //    $format = array_pop(explode(".",$files[$i]));//берём ласт элемент, отделяемый точкой
    //     if($format == 'xlsx') // устанавливаем нужный формат, который хотим скачивать
    //   		{
    //   		 echo '<li>
    //         <a href="'.$path.$files[$i].'"title="открыть/скачать файл">'.$files[$i].'</a></br>
    //       	</li>';
    //         // echo 'Нажмите, чтобы скачать: <a href="'.$path.$files[$i].'" title="открыть/скачать файл">'.$files[$i].'</a></br>'; //выводим все файлы
    //     }
    // }



//	savefiles('C:\server\OSPanel\domains\IT-kursovaya-master\excel\tempFiles');
	?>
