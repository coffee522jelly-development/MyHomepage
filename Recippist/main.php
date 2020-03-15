<?php
session_start();
?>
<!doctype html>
<html lang="ja">
<head>

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- CSS&JS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<script  type="text/javascript" src="js/speak.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script  type="text/javascript" src="js/jquery.validate.min.js"></script>
</head>
  <body>

    <!--上部ナビゲーションバー-->
    <nav id="top_bar" class="navbar fixed-top navbar-expand-sm">
       <a class="navbar-brand" href="main.php">Vookmark</a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarCollapse">
         <ul class="navbar-nav mr-auto">
           <li class="nav-item">
             <a id="home" class="nav-link active" href="#">
               <span data-feather="home"></span>
               <i class="fas fa-home"></i>&nbsp;ホーム <span class="sr-only">(current)</span>
             </a>
           </li>
          <li>
           <div class="dropdown">
              <button class="btn  dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-pen"></i>&nbsp;登録
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <!--<button id="submit" class="dropdown-item" type="button" href="#">
                  <span data-feather="shopping-cart"></span>
                  Submit
                </button>-->
                <button id="submitBM" class="dropdown-item" type="button" href="#">
                  <span data-feather="shopping-cart"></span>
                  ブックマークの登録
                </button>
              </div>
            </div>
          </li>

          <li>
           <div class="dropdown">
              <button class="btn  dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-list-ul">&nbsp;</i>ブックマーク
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <!--<button id="allview" class="dropdown-item" type="button" href="#">
                  <span data-feather="shopping-cart"></span>
                  Allview
                </button>-->
                <button id="allviewBM" class="dropdown-item" type="button" href="#">
                  <span data-feather="shopping-cart"></span>
                  ブックマークの一覧
                </button>
              </div>
            </div>
          </li>
          <!--<li class="nav-item">
             <a id="Recipe" class="nav-link" href="Recipe.php">
               <span data-feather="layers"></span>
               <i class="fas fa-sticky-note">&nbsp;</i>みんなのレシピ
             </a>
           </li>-->
           <!--<li class="nav-item">
             <a id="myRecipe" class="nav-link" href="myRecipe.php">
               <span data-feather="layers"></span>
               <i class="fas fa-sticky-note">&nbsp;</i>マイレシピ
             </a>
           </li>-->
           <!--<li class="nav-item">
              <a id="Search" class="nav-link" href="#">
                <span data-feather="layers"></span>
                <i class="fas fa-search">&nbsp;</i>Search
              </a>
            </li>-->
           <!--<li class="nav-item">
              <a id="readid" class="nav-link" href="#">
                <span data-feather="layers"></span>
                <i class="fas fa-volume-up">&nbsp;</i>Speak
              </a>
            </li>-->
            <!--<li class="nav-item">
               <a id="upload" class="nav-link" href="#">
                 <span data-feather="layers"></span>
                 <i class="fas fa-upload">&nbsp;</i>Upload
               </a>
             </li>-->
            <!--
           <li class="nav-item">
              <a id="delete" class="nav-link" href="#">
                <span data-feather="layers"></span>
                <i class="fas fa-trash-alt">&nbsp;</i>Delete
              </a>
            </li>-->
		    <li class="nav-item">
              <a id="Help" class="nav-link" href="#">
                <span data-feather="layers"></span>
                <i class="fas fa-hands-helping"></i>&nbsp;</i>ヘルプ
              </a>
            </li>
            <li class="nav-item">
              <a id="Setting" class="nav-link" href="#">
                <span data-feather="layers"></span>
                <i class="fas fa-cog"></i>&nbsp;</i>設定
              </a>
            </li>
           <li class="nav-item">
             <a class="nav-link" href="Login/logout.php">
               <span data-feather="layers"></span>
               <i class="fas fa-sign-out-alt">&nbsp;</i>サインアウト
             </a>
           </li>
         </ul>
       </div>
     </nav>

        <main id="main" role="main" class="col-md-12">
        <!--音声認識ボタン-->
        <div id="Speechrecog" class="input-group col-md-12">
          <input id="Hello" type="text" class="form-control text" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" value="こんにちは、何をしますか？">
          <div class="input-group-append">
            <button id="btn" class="btn btn-outline-secondary" type="button" onclick="recog()"><i class="fa fa-microphone"></i>&nbsp;音声認識</button>
          </div>
          <script>speak();</script>
        </div>

          <div id="content">
          </div>

          <!--結果表示ウィンドウ-->
          <div class="result" >
          <h2>このアプリについて</h2>
            <p>こんにちは。Vookmarkへようこそ。</p>
            <p>このアプリは、音声ブックマーク登録サイトです。</p>
            <p>登録したブックマークを音声で呼び出すことができます。</p>
            <p>お気に入りのサイトを「登録」してみましょう！</p><br>
            <h2>認識する語句の一覧</h2>
            <table class="table col-md-6 float-left">
              <thead>
                  <tr>
                      <th>音声コマンド</th>
                      <th>#</th>
                      <th>##</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <th>1</th>
                      <td>ホーム</td>
                      <td></td>
                  </tr>
                  <tr>
                      <th>2</th>
                      <td>登録</td>
                      <td></td>
                  </tr>
                  <tr>
                      <th>3</th>
                      <td>ブックマーク</td>
                      <td>登録したWebサイト名</td>
                  </tr>
                  <tr>
                      <th>4</th>
                      <td>設定</td>
                      <td></td>
                  </tr>
                  <tr>
                      <th>5</th>
                      <td>ヘルプ</td>
                      <td></td>
                  </tr>
                  <tr>
                      <th>6</th>
                      <td>ログアウト</td>
                      <td></td>
                  </tr>
              </tbody>
          </table>

            <!--<br><br><p class="col-12">このサイトを共有する:</p>
            <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" data-text="音声ブックマークアプリRecippist" class="twitter-share-button" data-show-count="false">Tweet</a>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>-->
          <div class="result2">
          </div>

        </main>

        <!--読み込みスクリプト-->
        <script  type="text/javascript" src="js/controller.js"></script>
        <script  type="text/javascript" src="js/buttons.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      </body>
</html>
<?php
      // $pass[0] = $_SESSION["USERID"];

      // try {
      //   // DBへ接続
      //   $dbh = new PDO("mysql:host=localhost; dbname=mydb; charset=utf8mb4", 'root', 'jyxQJM.Bi3my');
      //   // SQL作成
      //   $sql = "SELECT * FROM ColorSetting WHERE created = (select max(created) from ColorSetting WHERE account='$pass[0]')";
      //   // SQL実行

      //   $res = $dbh->query($sql);
      //   // 取得したデータを出力

      //   foreach( $res as $value ) {
      //     echo "<p class=\"invisible\" id=\"color-setting\">$value[color]</p>";
      //   }
      // } catch(PDOException $e) {
      //   echo $e->getMessage();

      //   die('接続エラー:' .$Exception->getMessage());
      // }

      // 接続を閉じる
      $dbh = null;
?>


