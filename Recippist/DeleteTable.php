<?php

$id = htmlspecialchars($_POST["dbtable"],ENT_QUOTES);
$x = 0;
$sql = null;
$res = null;
$dbh = null;

if($id === "Recipe"){
try {
	// DBへ接続
	$dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');
	// SQL作成
	$sql = "DELETE FROM Recipe";
	// SQL実行
	$res = $dbh->query($sql);

  echo $id;
  echo 'テーブルを全件削除しました。';

} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
// 接続を閉じる
$dbh = null;
}

else if($id === "VoiceBM"){
try {
	// DBへ接続
	$dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');
	// SQL作成
	$sql = "DELETE FROM VoiceBM";
	// SQL実行
	$res = $dbh->query($sql);

  echo $id;
  echo 'テーブルを全件削除しました。';

} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
// 接続を閉じる
$dbh = null;
}

else if($id === "test"){
try {
	// DBへ接続
	$dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');
	// SQL作成
	$sql = "DELETE FROM test";
	// SQL実行
	$res = $dbh->query($sql);

  echo $id;
  echo 'テーブルを全件削除しました。';

} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
// 接続を閉じる
$dbh = null;
}
?>
