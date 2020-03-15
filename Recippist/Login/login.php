<?php
    // セッション開始
    session_start();
    // 既にログインしている場合にはメインページに遷移
    if (isset($_SESSION["USERID"])) {
        header('Location:../main.php');
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
                    header('Location:../main.php');
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
      <link rel="stylesheet" type="text/css" href="css/style.css">
  <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <title>ログイン</title>
    </head>
    <body>
    <main>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <p style="color:red;"><?php echo $error ?></p>
            <br>
            <label for="username">ユーザーID<br>
                <input type="text" id="username" name="username" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
            </label><br>
            <label for="password">パスワード<br>
                <input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
            </label>
            <input class="btn btn-primary" type="submit" id="login" name="login" value="ログイン">
        </form>
        <p><a href="signup.php">新規登録はこちら</a></p>
    </main>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
