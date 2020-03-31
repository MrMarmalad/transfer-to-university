<?php

$content = <<<EOC
<div class="row">
  <div class="col md-3">
  <form enctype="multipart/form-data" method="POST" action="\php\addExcel.php">
    <div class="form-group">
      <label for="exampleFormControlFile1">Загрузите учебный план</label>
      <input name="tmpFile" type="file" class="form-control-file" id="excel">
    </div>
    <input class="btn btn-primary" type="submit" value="Отправить файл" />
  </form>
  </div>
</div>
EOC;
 ?>
