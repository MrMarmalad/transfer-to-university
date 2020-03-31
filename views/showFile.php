<?php

require_once (__DIR__ . '\\..\\php\\readPlan.php');



$filename = '2.xlsx';
// $path = '\\..\\excel\\tempFiles\\';
$path = '\\..\\excel\\';
$excel = readPlan($filename, $path);
$content='';
foreach ($excel as $key => $value) {
  $content.=<<<FORM
  <div class="row">
    <div class="col md-10"
    <input type="hidden" id="key">
    ${value[2]}
    </div>
FORM;
   foreach ($value as $row => $val) {
     if ($val !=NULL)
     {
       $content.=<<<ATT
       <div class="form-check">
        <input class="form-check-input" type="checkbox" value="${val}" id="">
        <label class="form-check-label" for="defaultCheck1">
        ${val}
        </label>
       </div>
ATT;
     }
   }
}
$content.="</div>"
// $value<br>
//
// <input type="hidden" id="key">
// </div>
//
// FORM
  //echo 'key  ' . $key . '   value '. $value .'<br>';


?>
