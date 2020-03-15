<?php
$color = htmlspecialchars($_POST['color'],ENT_QUOTES);

echo '設定中のテーマカラーは';
echo $color;
echo 'です。';

session_start();
$dsn = 'mysql:host=localhost;dbname=mydb;charset=utf8mb4';
date_default_timezone_set('Asia/Tokyo');
$username = 'root';
$password = 'jyxQJM.Bi3my';

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

	// SQL文 :nameと:romajiは、名前付きプレースホルダ
	$stmt = $dbh->prepare("INSERT INTO ColorSetting(color,account,created) VALUES (:color,:account,:created)");

	//トランザクション処理
	$dbh->beginTransaction();

	try{
    $stmt->bindParam(':color', $color);
    $stmt->bindParam(':account', $account);
    $stmt->bindParam(':created', $created);
	$stmt->execute();

		//コミット
		$dbh->commit();

	}catch (PDOException $e) {
		//ロールバック
		$dbh->rollback();
		throw $e; //
	}
	// 接続を閉じる
	$dbh = null;
  /*データベースへの登録完了*/
}catch (PDOException $e) {
	// UTF8に文字エンコーディングを変換します
	echo mb_convert_encoding($e->getMessage(),'UTF-8','SJIS-win');
	die();
}

?>