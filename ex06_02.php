<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Cache-Control" content="no-store">
  <meta http-equiv="Expires" content = "0">
  <title>ex06_02.php</title>
</head>
<?php
  $errmsg = array();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (strlen($_FILES["upfile"]["name"]) <= 0) {
      $errmsg[] = "ファイルが指定されていません";
    }
    else {
      $filename = $_FILES["upfile"]["name"];
      $fileinfo = pathinfo($filename);
      $ext = strtolower($fileinfo["extension"]);
      if ($ext != "jpg" && $ext != "gif" && $ext != "bmp") {
        $errmsg[] = "jpgかgifかbmpファイルを指定してください";
      }
      elseif ($_FILES["upfile"]["size"] == 0) {
        $errmsg[] = "指定されたファイルが存在しないか空です";
      }

      if ((int)PHP_VERSION < 7) {
        if (strncmp(strtoupper(PHP_OS), "WIN", 3) == 0) {
          $filename = mb_convert_encoding($filename, "SJIS", "UTF-8");
        }
      }
      
      if ($ext == "jpg" || $ext == "gif" || $ext == "bmp") {
        $movepath = "img/" . $filename;
        $moveok = move_uploaded_file($_FILES["upfile"]["tmp_name"], $movepath);
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
  <div><br/><a href="ex06_02.html">アップロード指定に戻る</a></div>
<?php
 } else {
?>
  アップロード成功！<br/>
  <?= $filename ?>をアップロードしました<br/>

<?php 
  } 
?>
</body>