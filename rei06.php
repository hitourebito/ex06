<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Cache-Control" content="no-store">
  <meta http-equiv="Expires" content = "0">
  <title>rei06.php</title>
</head>
<?php
  $errmsg[] = array();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (strlen($_FILES["upfile"]["name"]) <= 0) {
      $errmsg[] = "ファイルが指定されていません";
    }
    else {
      $filename = $_FILES["upfile"]["name"];
      $fileinfo = pathinfo($filename);
      $ext = strtolower($fileinfo["extension"]);
      if ($ext != "txt" && $ext != "ini") {
        $errmsg[] = "textかiniのファイルを指定してください";
      }
      elseif ($_FILES["upfile"]["size"] == 0) {
        $errmsg[] = "指定されたファイルが存在しないか空です";
      }
      else {
        $movepath = "img/" . mb_convert_encoding($_FILES["upfile"]["tmp_name"], $movepath);
        $moveok = move_uploaded_file($_FILES["upfile"]["tmp_name"], $movepath);

        if (!$moveok) {
          $errmsg[] = "アップロードに失敗しました";
        }
      }
    }
  }
  else {
    $errmsg[] = "正しいリンク元からお越しください";
  }
?>
<body>
  <div id="err">
<?php
  foreach ($errmsg as $val) {
    echo $val . "<br/>";
  }
?>
  </div>
<?php
  if (count($errmsg)) {
?>
  <div><br/><a href="rei06.html">アップロード指定に戻る</a></div>
<?php
  } else {
?>
  アップロード成功！<br/>
  <?= $filename?>をアップロードしました
  <?php } ?>
</body>