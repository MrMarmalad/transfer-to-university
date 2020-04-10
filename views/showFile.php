<?php

require_once (__DIR__ . '\\..\\php\\readPlan.php');



//$filename = '2.xlsx';
// $path = '\\..\\excel\\tempFiles\\';
//$path = '\\..\\excel\\';
function split($str)
{
  return preg_split("/[\s,.]+/", $str, 0, PREG_SPLIT_NO_EMPTY);
}
function showFile($filename, $path)
{
  $excel = readPlan($filename, $path);

  $content= <<<FORM
  <form action="\\..\\php\\applyChanges.php" method="POST">
    <div class="container-fluid border  border-dark">

    <div class="form-group row">
      <div class="col-md-12">
        <label for="fio">Ф.И.О студента</label>
        <input type="text" class="form-control" aria-describedby="fioHelp" name="fio" id="fio" placeholder="Введите ФИО" pattern="^[А-Яа-яЁё\s]+$">
        <small id="fioHelp" class="form-text text-muted">Ввод осуществляется кириллицей через пробел</small>
      </div>
    </div>
    <div class="form-group">
      <label for="direction">Направление/специальность</label>
      <select class="form-control" name="direction" id="direction">
        <option value="09.03.01 Информатика и вычислительная техника">09.03.01 Информатика и вычислительная техника</option>
        <option value="01.03.04 Прикладная математика">01.03.04 Прикладная математика</option>
        <option value="10.05.02 Информационная безопасность телекоммуникационных сетей">10.05.02 Информационная безопасность телекоммуникационных сетей</option>
      </select>
    </div>

    <div class="form-group">
      <label for="educationForm">Форма обучения</label>
      <select class="form-control" name="educationForm" id="educationForm">
        <option value="Очная">Очная</option>
        <option value="Заочная">Заочная</option>
        <option value="Очно-заочная">Очно-заочная</option>
      </select>
    </div>
    <div class="btn-group" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-primary base_js">Базовая часть</button>
      <button type="button" class="btn btn-primary required_js">Обязательные дисциплины</button>
      <button type="button" class="btn btn-primary optionally_js">Дисциплины по выбору</button>
      <button type="button" class="btn btn-primary electives_js">Факультативы</button>
    </div>
FORM;
$hiddenClass = "basic";
  foreach ($excel as $key => $array) {

  //  foreach ($array as $index => $value) {
      if (($array[3] == "х") || ($array[4] == "х") || ($array[5] == "х") || ($array[6] == "х"))
      {
        //echo "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
        continue;
      }
      //($row[2] == 'Обязательные дисциплины') || ($row[2] == "Дисциплины по выбору") || ($row[2] == 'Факультативы')
      if ($array[2] == "Обязательные дисциплины")
      {
        $hiddenClass="required";
        //echo $hiddenClass;
        continue;
        //$content .= "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
      }
      if ($array[2] == "Дисциплины по выбору")
      {
        $hiddenClass="optionally";
        //echo $hiddenClass;
        continue;
        //$content .= "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
      }
      if ($array[2] == "Факультативы")
      {
        $hiddenClass="electives";
        //echo $hiddenClass;
        continue;
        //$content .= "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
      }
      $content .= <<<NAME
        <div class="form-group row ${hiddenClass}">
          <label for="staticEmail" class="col-md-3 col-form-label ${hiddenClass}">Название предмета</label>
          <div class="col-md">
            <input type="text" readonly class="form-control-plaintext ${hiddenClass}"  value="${array[2]}">
          </div>
        </div>
        <div class="container-fluid border ${hiddenClass}">
NAME;
      if ($array[3] != NULL)
      {
      $content .=<<< EXAM
      <div class="form-group row ${hiddenClass}">
      <label for="inputPassword" class="col-md-12 col-form-label ${hiddenClass}">Экзамены</label>
      <div class="form-check ${hiddenClass}">
EXAM;
      $tmpStr=split($array[3]);
      foreach ($tmpStr as $value) {
      $content .= <<<ALLEXAMS
        <input name="exam${key}[]" class="form-check-input ${hiddenClass}" type="checkbox" value="${value}" id="defaultCheck1" checked="checked">
          <label class="form-check-label ${hiddenClass}" for="defaultCheck1">
          ${value} семестр
          </label>
          <br>
ALLEXAMS;
      }
      $content .=<<< ENDEXAMS
      </div>
      </div>
ENDEXAMS;
      }
/////////////////////////////
      if ($array[4] != NULL)
      {
      $content .= <<< ZACHET
      <div class="form-group row ${hiddenClass}">
      <label for="inputPassword" class="col-md-12 col-form-label ${hiddenClass}">Зачеты</label>
        <div class="form-check ${hiddenClass}">
ZACHET;
      $tmpStr=split($array[4]);
      foreach ($tmpStr as $value) {
      $content .=<<<ALLZACHET
          <input name="zachet${key}[]" class="form-check-input ${hiddenClass}" type="checkbox" value="${value}" id="defaultCheck1" checked="checked">
          <label class="form-check-label ${hiddenClass}" for="defaultCheck1">
            ${value} семестр
          </label>
          <br>
ALLZACHET;
      }
      $content .= <<<ENDZACHET
        </div>
      </div>
ENDZACHET;
      }
////////////////
      if ($array[5] != NULL)
      {
      $content .= <<< KP
      <div class="form-group row ${hiddenClass}">
      <label for="inputPassword" class="col-md-12 col-form-label ${hiddenClass}">Курсовые проекты</label>
      <div class="form-check ${hiddenClass}">
        <input name="kp${key}[]" class="form-check-input ${hiddenClass}" type="checkbox" value="${array[5]}" id="defaultCheck1" checked="checked">
        <label class="form-check-label ${hiddenClass}" for="defaultCheck1">
          ${array[5]}
        </label>
        <br>
    </div>
    </div>
KP;
      }
      if ($array[6] != NULL)
      {
      $content .= <<< KR
      <div class="form-group row ${hiddenClass}">
      <label for="inputPassword" class="col-md-12 col-form-label ${hiddenClass}">Курсовые работы</label>
      <div class="form-check ${hiddenClass}">
        <input name="kr${key}[]" class="form-check-input ${hiddenClass}" type="checkbox" value="${array[6]}" id="defaultCheck1" checked="checked">
        <label class="form-check-label ${hiddenClass}" for="defaultCheck1">
          ${array[6]} семестр
        </label>
        <br>
        </div>
        </div>
KR;
      }
    //}

//      $content .= "<input type=\"hidden\" name=\"row\" value=\"$key\">";
      $content .= "</div>";
  }
      $content .= <<<ENDFORM
      <input type="submit" class="btn btn-primary" value="Отправить">
      </div>
  	</div>

    </form>
ENDFORM;
      //$content .= "<script src=\"\\..\\resources\\categories.js\"></script>";
return $content;
}


//echo "$content";
// foreach ($excel as $key => $value) {
//   $content.=<<<FORM
//   <div class="row">
//     <div class="col md-10"
//     <input type="hidden" id="key">
//     ${value[2]}
//     </div>
// FORM;
//    foreach ($value as $row => $val) {
//      if ($val !=NULL)
//      {
//        $content.=<<<ATT
//        <div class="form-check">
//         <input class="form-check-input" type="checkbox" value="${val}" id="">
//         <label class="form-check-label" for="defaultCheck1">
//         ${val}
//         </label>
//        </div>
// ATT;
//      }
//    }
// }
// $content.="</div>"
// $value<br>
//
// <input type="hidden" id="key">
// </div>
//
// FORM
  //echo 'key  ' . $key . '   value '. $value .'<br>';


?>
