<?php
// セッション開始
session_start();

// 既にログインしている場合にはメインページに遷移
if (isset($_SESSION['USERID'])) {
    header('Location:../main.php');
    exit;
}

$db['host'] = 'localhost';
$db['user'] = 'root';
$db['pass'] = 'Coffee522jelly';
$db['dbname'] = 'mydb';

$error = '';

// ログインボタンが押されたら
if (isset($_POST['signUp'])) {

    if (empty($_POST['username'])) {
        $error = 'ユーザーIDが未入力です。';
    }else if (empty($_POST['password'])) {
        $error = 'パスワードが未入力です。';
    }

    if (!empty($_POST['username']) && !empty($_POST['password'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $dsn = sprintf('mysql:host=%s; dbname=%s; utf8', $db['host'], $db['dbname']);

        $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

        // idの重複とパスワードの桁数チェック
        function cheak($id,$count){
            if($count > 0){
                throw new Exception('そのユーザーIDは既に使用されています。');
            }
            if ($id < 8) {
                throw new Exception('パスワードは8桁以上で入力してください。');
            }
        }

        try{

            $sqlname = "SELECT COUNT(*) FROM userData WHERE `name` = '$username'";
            $ss = $pdo->query($sqlname);
            $count = $ss->fetchColumn();

            $id = strlen($_POST['password']);
            cheak($id,$count);

            $stmt = $pdo->prepare('INSERT INTO `userData`(`name`, `password`) VALUES (:username, :password)');
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
            $stmt->execute();

            $_SESSION['USERID'] = $username;
            echo '<script>
                    alert("登録が完了しました。");
                    location.href="../main.php";
                  </script>';
        } catch(Exception $e){
            $error = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="../../../../favicon.ico">

      <title>Signin Template for Bootstrap</title>

      <!-- Bootstrap core CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

      <!-- Custom styles for this template -->
      <link href="../css/signin.css" rel="stylesheet">
        <title>新規登録</title>
    </head>
    <body class="text-center">
            <form id="loginForm" name="loginForm" action="" method="POST">
              <img src="../img/Recippist.jpg" alt="" width="72" height="72">
              <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
              <p style="color:red;"><?php echo $error ?></p>
              <label for="username" class="sr-only">User ID</label>
              <input type="text" id="username" name="username" class="form-control" placeholder="User ID" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>" required autofocus>
              <label for="password" class="sr-only">Password</label>
              <input type="password" id="password" name="password" value="" class="form-control" placeholder="Password" required>*8桁以上のパスワードを入力
              <button class="btn btn-lg btn-primary btn-block" type="submit" id="singUp" name="signUp">新規登録</button>
              <p class="mt-5 mb-3 text-muted">&copy; 2018 Recippist.</p>
            </form>
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
