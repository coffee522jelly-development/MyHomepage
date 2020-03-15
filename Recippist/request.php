<?php
    header('Content-type: text/plain; charset= UTF-8');

    if(isset($_POST['name'])){
        $name = htmlspecialchars($_POST['name'],ENT_QUOTES);
        $str = "検索ワード:".$name."\n";
        $result = nl2br($str);
        echo $result;

        session_start();
        // ログイン状態チェック
        if (!isset($_SESSION["USERID"])) {
            header("Location:main.php");
            exit;
        }

        $sql = null;
        $res = null;
        $dbh = null;
        $pass[0] = $_SESSION["USERID"];
        try {
          // DBへ接続

          $dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');

          // SQL作成
          $sql = "SELECT * FROM Recipe WHERE name ='$name' and account = '$pass[0]'";

          // SQL実行
          $res = $dbh->query($sql);
            echo "<table><tr><th>検索レシピ一覧</th></tr></table>";
            echo "<table class=\"table\"><tr><th>id</th><th>name</th><th>1</th><th>2</th><th>3</th><th>4</th>";
          // 取得したデータを出力
          foreach( $res as $value ) {
            echo "<tr><td>$value[id]</td><td>$value[name]</td><td>$value[process1]</td><td>$value[process2]</td><td>$value[process3]</td><td>$value[process4]</td>";
          }
            echo "</table>";

        } catch(PDOException $e) {
          echo $e->getMessage();
          die('接続エラー:' .$Exception->getMessage());
        }

        // 接続を閉じる
        $dbh = null;
    }
    else if(isset($_POST['number'])){
        $num = htmlspecialchars($_POST['number'],ENT_QUOTES);
        $str = "検索ID:".$num."\n";
        $result = nl2br($str);
        echo $result;

        session_start();
        // ログイン状態チェック
        if (!isset($_SESSION["USERID"])) {
            header("Location:main.php");
            exit;
        }

        $sql = null;
        $res = null;
        $dbh = null;
        $pass[0] = $_SESSION["USERID"];
        try {
          // DBへ接続

          $dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');

          // SQL作成
          $sql = "SELECT * FROM Recipe WHERE id ='$num' and account = '$pass[0]'";

          // SQL実行
          $res = $dbh->query($sql);
            echo "<table><tr><th>検索レシピ一覧</th></tr></table>";
            echo "<table class=\"table\"><tr><th>id</th><th>name</th><th>1</th><th>2</th><th>3</th><th>4</th>";
          // 取得したデータを出力
          foreach( $res as $value ) {
            echo "<tr><td>$value[id]</td><td>$value[name]</td><td>$value[process1]</td><td>$value[process2]</td><td>$value[process3]</td><td>$value[process4]</td>";
          }
            echo "</table>";
            echo "<br />";

        } catch(PDOException $e) {
          echo $e->getMessage();
          die('接続エラー:' .$Exception->getMessage());
        }

        // 接続を閉じる
        $dbh = null;
    }
    else{
        echo 'FAIL TO AJAX REQUEST';
    }
?>
