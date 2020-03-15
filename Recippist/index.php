<?php
    // セッション開始
    session_start();
    // 既にログインしている場合にはメインページに遷移
    if (isset($_SESSION["USERID"])) {
        header('Location:main.php');
        exit;
    }
    $db['host'] = 'localhost';
    $db['user'] = 'root';
    $db['pass'] = 'Coffee522jelly';
    $db['dbname'] = 'mydb';
    $error = '';
    // ログインボタンが押されたら
    if (isset($_POST['login'])) {
        if (empty($_POST['username'])) {
            $error = 'ユーザーIDが未入力です。';
        } else if (empty($_POST['password'])) {
            $error = 'パスワードが未入力です。';
        }
        if (!empty($_POST['username']) && !empty($_POST['password'])) {

            $username = $_POST['username'];

            $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
            try {
                $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
                $stmt = $pdo->prepare('SELECT * FROM userData WHERE name = ?');
                $stmt->execute(array($username));
                $password = $_POST['password'];

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['password'])) {
                    $_SESSION['USERID'] = $username;
                    header('Location:main.php');
                    exit();
                } else {
                    $error = 'ユーザーIDあるいはパスワードに誤りがあります。';
                }

            } catch (PDOException $e) {
                echo $e->getMessage();
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

      <title>Signin</title>

      <!-- Bootstrap core CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

      <!-- Custom styles for this template -->
      <link href="css/signin.css" rel="stylesheet">
        <title>ログイン</title>
    </head>
    <body class="text-center">
      <form class="form-signin" id="loginForm" name="loginform" action="" method="POST">
        <img src="img/Recippist.jpg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputEmail" class="sr-only">User ID</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="User ID" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="login" name="login">サインイン</button>
        <p><a href="Login/signup.php">アカウント登録はこちら</a></p>
        <p class="mt-5 mb-3 text-muted">&copy; 2018 Recippist.</p>
      </form>
    </body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>
