<?php
session_start();
$dsn = 'mysql:host=localhost;dbname=mydb;charset=utf8mb4';
date_default_timezone_set('Asia/Tokyo');
$username = 'root';
$password = 'jyxQJM.Bi3my';

          //バリデーションの作成
  
$account = $_SESSION["USERID"];
$created = date("Y/m/d H:i:s");

          // try-catch
try{
            // データベースへの接続を表すPDOインスタンスを生成
$dbh = new PDO($dsn,$username,$password);

            // 静的プレースホルダを指定
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // DBエラー発生時は例外を投げる設定
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $dbh->prepare("SET @i:=0");
$stmt->execute();
$stmt = $dbh->prepare("UPDATE Recipe SET RecipeNo = (@i:=@i+1) WHERE account = :account");

            //トランザクション処理
$dbh->beginTransaction();

           
$stmt->bindParam(':account', $account);
$stmt->execute();

$dbh->commit();

$dbh = null;
/*データベースへの登録完了*/
}catch (PDOException $e) {
            // UTF8に文字エンコーディングを変換します
            echo mb_convert_encoding($e->getMessage(),'UTF-8','SJIS-win');
            die();
}
          echo '送信完了しました。';
?>