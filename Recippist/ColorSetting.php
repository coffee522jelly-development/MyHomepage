<?php

      $pass[0] = htmlspecialchars($_SESSION["USERID"],ENT_QUOTES);

      try {
        // DBへ接続
        $dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');
        // SQL作成
        $sql = "SELECT * FROM ColorSetting WHERE account = '$pass[0]' and created = (select max(created) from ColorSetting)";
        // SQL実行
        $res = $dbh->query($sql);
        // 取得したデータを出力
        foreach( $res as $value ) {
          echo "<p >設定中のテーマカラー:</p><p id=\"color-setting\">$value[color]</p>";
        };

      } catch(PDOException $e) {
        echo $e->getMessage();
        die('接続エラー:' .$Exception->getMessage());
      }

      // 接続を閉じる
      $dbh = null;
?>