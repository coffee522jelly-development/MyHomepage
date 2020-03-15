<?php
//表示するだけの処理
// 変数の初期化
session_start();
$sql = null;
$res = null;
$dbh = null;
$pass[0] = $_SESSION["USERID"];
try {
	// DBへ接続
	$dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');

	// SQL作成
	$sql = "SELECT * FROM Recipe WHERE account ='$pass[0]'";

	// SQL実行
	$res = $dbh->query($sql);
	echo "登録レシピ一覧";
  echo "<table class=\"table\"><tr><th>id</th><th>name</th><th>1</th><th>2</th><th>3</th><th>4</th>";
// 取得したデータを出力
foreach( $res as $value ) {
  echo "<tr><td>$value[id]</td><td>$value[name]</td><td>$value[process1]</td><td>$value[process2]</td><td>$value[process3]</td><td>$value[process4]</td>";
}
  echo "</table>";

} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}

// 接続を閉じる
$dbh = null;
?>
