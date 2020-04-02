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
FORM;
  foreach ($excel as $key => $array) {
  //  foreach ($array as $index => $value) {
      if (($array[3] == "х") || ($array[4] == "х") || ($array[5] == "х") || ($array[6] == "х"))
      {
        //echo "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
        continue;
      }
      $content .= <<<NAME
        <div class="form-group row ">
          <label for="staticEmail" class="col-md-6 col-form-label">Название предмета</label>
          <div class="col-md-6">
            <input type="text" readonly class="form-control-plaintext"  value="${array[2]}">
          </div>
        </div>
        <div class="container-fluid border ">
NAME;
      if ($array[3] != NULL)
      {
      $content .=<<< EXAM
      <div class="form-group row">
      <label for="inputPassword" class="col-md-6 col-form-label">Экзамены</label>
      <div class="form-check">
EXAM;
      $tmpStr=split($array[3]);
      foreach ($tmpStr as $value) {
      $content .= <<<ALLEXAMS
        <input name="exam${key}[]" class="form-check-input" type="checkbox" value="${value}" id="defaultCheck1" checked="checked">
          <label class="form-check-label" for="defaultCheck1">
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
      <div class="form-group row ">
      <label for="inputPassword" class="col-md-6 col-form-label">Зачеты</label>
        <div class="form-check">
ZACHET;
      $tmpStr=split($array[4]);
      foreach ($tmpStr as $value) {
      $content .=<<<ALLZACHET
          <input name="zachet${key}[]" class="form-check-input" type="checkbox" value="${value}" id="defaultCheck1" checked="checked">
          <label class="form-check-label" for="defaultCheck1">
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
      <div class="form-group row ">
      <label for="inputPassword" class="col-md-6 col-form-label">Курсовые проекты</label>
      <div class="form-check">
        <input name="kp${key}[]" class="form-check-input" type="checkbox" value="${array[5]}" id="defaultCheck1" checked="checked">
        <label class="form-check-label" for="defaultCheck1">
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
      <div class="form-group row ">
      <label for="inputPassword" class="col-md-6 col-form-label">Курсовые работы</label>
      <div class="form-check">
        <input name="kr${key}[]" class="form-check-input" type="checkbox" value="${array[6]}" id="defaultCheck1" checked="checked">
        <label class="form-check-label" for="defaultCheck1">
          ${array[6]}
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
