<?php
$x = 0;
$id = htmlspecialchars($_POST["dbtable2"],ENT_QUOTES);
$sql = null;
$res = null;
$dbh = null;


if($id == 'Recipe'){

try {
	// DBへ接続
	$dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');
	// SQL作成
	$sql = "ALTER TABLE Recipe drop column id";
	// SQL実行
	$res = $dbh->query($sql);

	$sql = "ALTER TABLE Recipe add id int(11) primary key not null auto_increment first";

	$res = $dbh->query($sql);

	$sql = "ALTER TABLE Recipe AUTO_INCREMENT = 1";

	$res = $dbh->query($sql);

	echo "Recipeテーブルのidを振り直しました。";

} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
}

else if($id == 'test'){
try {
	// DBへ接続
	$dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');
	// SQL作成
	$sql = "ALTER TABLE test drop column id";
	// SQL実行
	$res = $dbh->query($sql);

	$sql = "ALTER TABLE test add id int(11) primary key not null auto_increment first";

	$res = $dbh->query($sql);

	$sql = "ALTER TABLE test AUTO_INCREMENT = 1";

	$res = $dbh->query($sql);

	echo "testテーブルのidを振り直しました。";

} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
}

else if($id == 'VoiceBM'){
try {
	// DBへ接続
	$dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');
	// SQL作成
	$sql = "ALTER TABLE VoiceBM drop column id";
	// SQL実行
	$res = $dbh->query($sql);

	$sql = "ALTER TABLE VoiceBM add id int(11) primary key not null auto_increment first";

	$res = $dbh->query($sql);

	$sql = "ALTER TABLE VoiceBM AUTO_INCREMENT = 1";

	$res = $dbh->query($sql);

	echo "testテーブルのidを振り直しました。";

} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
}
// 接続を閉じる
$dbh = null;
?>
