<?php

function parseKey($str) {
  $tmp=array();
  preg_match_all("~\d+$~", $str, $tmp, PREG_OFFSET_CAPTURE);
  if ($tmp[0][0][0] ==NULL) {
    return $str;
  }
  $tmp= array('str' => $tmp[0][0][0],'type'=>substr($str,0, $tmp[0][0][1]));
  return $tmp;
}

function FunctionName(iterable $strs)
{
  if (count($strs) == 0 || count($strs) == 1)
  {
    return $strs;
  }
  return implode("," , asort($strs));
}

$typeToCol = ["exam" =>3,
"zachet" =>4,
"kp" =>5,
"kr" =>6,];

$semestrToCol = [ "1" => 14,
  "2" =>15,
  "3" =>16,
  "4" =>17,
  "5" =>18,
  "6" =>19,
  "7" =>20,
  "8" =>21,
  "9" =>22,
  "10"=>23,
];
foreach ($_POST as $key => $value) {
  var_dump($key);
  echo "    <br>  ";
  //var_dump($value);
  var_dump(parseKey($key));
    var_dump($value);
  echo "<br>";
}

 ?>
