<!doctype html>
<html lang="ja">
<head>

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<script  type="text/javascript" src="js/speak.js"></script>
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script  type="text/javascript" src="js/convert.js"></script>
<body>

<?php

$totalPage = 10;
if (
  isset($_GET["page"]) &&
  $_GET["page"] > 0 &&
  $_GET["page"] <= $totalPage
) {
  $page = (int)$_GET["page"];
} else {
  $page = 0;
}

?>

<?php
//表示するだけの処理
// 変数の初期化
session_start();
$sql = null;
$res = null;
$dbh = null;
$pass[0] = $_SESSION["USERID"];


try {

  for($i=1;$i<5;$i++)
  {
    // DBへ接続
    $dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8", 'root', 'jyxQJM.Bi3my');

    // SQL作成
    $sql = "SELECT * FROM Recipe WHERE id = $i+$page*4";

    // SQL実行
    $res = $dbh->query($sql);

  foreach( $res as $value ) {
    //画像を埋め込む作業
    $photopass="$value[photoref]";

    if($photopass==""){
      $photopass2="photo%20uploader/";
      $photopass3="system/NoData.png";
    }
    else{
    $photopass2="photo%20uploader/";
    $photopass3="uploads/";
    }

    $photopass = str_replace( "\\", '/', $photopass);
    $filename = basename($photopass);
    $name = $filename;
    echo '<div id="flow" class="card col-md-12">';
    echo <<<HTM
    <img src=${photopass2}${photopass3}${name} height="198" width="352" class="rounded float-left" alt="..." id="icon" >
HTM;

    /*echo '<img id="thumb" src=<? =$photopass?> height="275" width="275" class="rounded float-left" alt="...">';*/
    echo '<div class="discription">';
    echo "<p id=\"vnum\">レシピID:$value[id]</p><p id=\"vname\">title:$value[name]</p><p class=\"vpro\">1.$value[process1]</p><p class=\"vpro\">2.$value[process2]</p><p class=\"vpro\">3.$value[process3]</p><p class=\"vpro\">4.$value[process4]</p><p id=\"vdate\">登録日時：$value[created]</p></div>";
    echo '</div>';
    echo '</div>';
  }
  }
} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
echo "$id";
$dbh = null;
?>

  <nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-warning">
     <a class="navbar-brand" href="main.php">Recippist</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
     </button>
     <div class="collapse navbar-collapse" id="navbarCollapse">
       <ul class="navbar-nav mr-auto">
         <li class="nav-item">
           <a class="nav-link active" href="main.php">
             <span data-feather="home"></span>
             <i class="fas fa-home"></i>&nbsp;HOME
           </a>
         </li>
         <li class="nav-item">
           <a id="Recipe" class="nav-link" href="Recipe.php">
             <span data-feather="layers"></span>
             <i class="fas fa-sticky-note">&nbsp;</i>みんなのレシピ
           </a>
         </li>
         <li class="nav-item">
           <a id="myRecipe" class="nav-link" href="myRecipe.php">
             <span data-feather="layers"></span>
             <i class="fas fa-sticky-note">&nbsp;</i>マイレシピ
           </a>
         </li>
         <li class="nav-item">
           <a class="nav-link" href="Login/logout.php">
             <span data-feather="layers"></span>
             <i class="fas fa-sign-out-alt">&nbsp;</i>Sign out
           </a>
         </li>
       </ul>
     </div>
   </nav>

  <div id="pagination"><p>現在 <?php echo $page+1; ?> ページ目です。</p>

  <p>
    <?php if ($page > 0) : ?>
      <a href="?page=<?php echo ($page - 1); ?>">前のページへ</a>
    <?php endif; ?>
    <?php if ($page < $totalPage) : ?>
    　　<a href="?page=<?php echo ($page + 1); ?>">次のページへ</a>
    <?php endif; ?>
  </p>
</div>
</body>
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</html>
