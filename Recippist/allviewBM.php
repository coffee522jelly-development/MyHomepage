<?php
//表示するだけの処理
// 変数の初期化
session_start();
$sql = null;
$res = null;
$dbh = null;
$bookmark = null;
$pass[0] = $_SESSION["USERID"];
header('Content-type: text/html');
try {
	// DBへ接続
	$dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');

	// SQL作成
	$sql = "SELECT * FROM VoiceBM WHERE account ='$pass[0]'";

	// SQL実行
	$res = $dbh->query($sql);
	echo "<h2>登録ブックマーク一覧</h2><br>";
	echo "こちらのページで、登録したWebサイトの音声コマンドが使用できます。";
  echo "<table id=\"BM\" class=\"table\"><tr><th>id</th><th>cmd</th><th>URL</th>";
// 取得したデータを出力
foreach( $res as $value ) {

  echo "<tr><td>$value[id]</td><td><p class=\"cmd\">$value[cmd]</p></td><td><a class=\"url\" href=\"$value[url]\"target=\"_blank\">$value[url]</a></td>";
}
  echo "</table>";

} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}

// 接続を閉じる
$dbh = null;
?>
