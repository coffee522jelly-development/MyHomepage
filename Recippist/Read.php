<?php
//表示するだけの処理
// 変数の初期化
session_start();

$sql = null;
$res = null;
$dbh = null;
$pass[0] = $_SESSION["USERID"];
$ReadId[0] = $_POST["number"];

try {
	// DBへ接続

	$dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');

	// SQL作成
	$sql = "SELECT * FROM Recipe WHERE id = '$ReadId[0]'";

	// SQL実行
	$res = $dbh->query($sql);
    echo "<main id=\"Tab\"><table class=\"table\"><tr><th>id</th><th>name</th><th>1</th><th>2</th><th>3</th><th>4</th>";
	// 取得したデータを出力
	foreach( $res as $value ) {
		echo "読み上げ内容<input id=\"Read\" type=\"text\" class=\"col-12\" value=\"$value[id],$value[name],$value[process1],$value[process2],$value[process3],$value[process4]\">";
    echo "<tr><td>$value[id]</td><td>$value[name]</td><td>$value[process1]</td><td>$value[process2]</td><td>$value[process3]</td><td>$value[process4]</td>";
	}
    echo "</table></main>";

} catch(PDOException $e) {
	echo $e->getMessage();
  die('接続エラー:' .$Exception->getMessage());
}

// 接続を閉じる
$dbh = null;

?>
