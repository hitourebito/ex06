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
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Cache-Control" content="no-store">
  <meta http-equiv="Expires" content = "0">
  <title>ex06_03.php</title>
</head>
<body>
  <form action="<?= $_SERVER["SCRIPT_NAME"]?>" method="POST" enctype="multipart/form-data">
    <div>
      <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
      アップロードする画像ファイル名とコメントを入力してください<br/><br/>
      ファイル:
      <input type="file" name="upfile" size="60">
      <br/><br/>
      コメント:
      <input type="text" name="comment" size="60">
      <br/><br/>
      <input type="submit" name="btn" value="アップロード">
    </div>
  </form>
<?php
  }
?>
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
  <div><br/><a href="ex06_03.php">アップロード指定に戻る</a></div>
<?php
 } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
?>
  アップロード成功！<br/>

  <?= $filename ?>をアップロードしました<br/>
  <?php echo '<img width="50%" height="50%" src="img/' . $filename . '" /><br />'; ?>
  <?= $_POST["comment"] ?>
<?php 
  } 
?>
</body>