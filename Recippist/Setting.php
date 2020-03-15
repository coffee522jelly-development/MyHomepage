<?php
session_start();
$pass[0] = $_SESSION["USERID"];

echo "Settings";
echo '<br>';
echo '<div id="your_id">';
echo 'あなたのユーザーID:';
echo $_SESSION["USERID"];
echo '</div><br>';

try {
    // DBへ接続
    $dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');
    // SQL作成
    $sql = "SELECT * FROM ColorSetting WHERE created = (select max(created) from ColorSetting WHERE account='$pass[0]')";
    // SQL実行

    $res = $dbh->query($sql);
    // 取得したデータを出力

    foreach( $res as $value ) {
      echo "<p id=\"color-setting\">現在のテーマカラー:$value[color]</p>";
    }
  } catch(PDOException $e) {
    echo $e->getMessage();

    die('接続エラー:' .$Exception->getMessage());
  }

  // 接続を閉じる
  $dbh = null;

echo '<h4>テーマカラーの変更</h4>';
echo '
<div id="color_setting"><label><input type="radio" name="radio_group" id="radio1" value="ダーク">ダーク</label>
<label><input type="radio" name="radio_group" id="radio2" value="ブルー">ブルー</label>
<label><input type="radio" name="radio_group" id="radio3" value="レッド">レッド</label>
<input id="color-type" class="btn btn-primary btn-sm" type="button" value="変更"></div>';
?>