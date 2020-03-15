<?php
class validation
{
    public static function check($params)
    {
        $respons = array(
            'photoref'      => '',
            'name3'    => '',
            'pro1'      => '',
            'pro2'    => '',
            'pro3'      => '',
            'pro4'    => ''
        );

        if (!$params['name3']) {
            $respons['name3'] = 'レシピの名前を入力してください';
            echo 'レシピの名前を入力してください';
        }

        else if (!$params['pro1']) {
            $respons['pro1'] = '手順1を入力してください';
            echo '手順1を入力してください';
        }
        else if (!$params['pro2']) {
            $respons['pro2'] = '手順2を入力してください';
            echo '手順2を入力してください';
        }
        else if (!$params['pro3']) {
            $respons['pro3'] = '手順3を入力してください';
            echo '手順3を入力してください';
        }
        else{
          session_start();
          $dsn = 'mysql:host=localhost;dbname=mydb;charset=utf8mb4';
          date_default_timezone_set('Asia/Tokyo');
          $username = 'root';
          $password = 'jyxQJM.Bi3my';

          //バリデーションの作成
          $photoref = htmlspecialchars($_POST['photoref'],ENT_QUOTES);
          $name = htmlspecialchars($_POST['name3'],ENT_QUOTES);
          $pro1 = htmlspecialchars($_POST['pro1'],ENT_QUOTES);
          $pro2 = htmlspecialchars($_POST['pro2'],ENT_QUOTES);
          $pro3 = htmlspecialchars($_POST['pro3'],ENT_QUOTES);
          $pro4 = htmlspecialchars($_POST['pro4'],ENT_QUOTES);
          $account = $_SESSION["USERID"];
          $created = date("Y/m/d H:i:s");

          // try-catch
          try{
            // データベースへの接続を表すPDOインスタンスを生成
            $dbh = new PDO($dsn,$username,$password);

            // 静的プレースホルダを指定
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // DBエラー発生時は例外を投げる設定
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL文 :nameと:romajiは、名前付きプレースホルダ
            $stmt = $dbh->prepare("INSERT INTO Recipe(name,photoref,process1,process2,process3,process4,account,created) VALUES (:name3,:photoref,:pro1,:pro2,:pro3,:pro4,:account,:created)");

            //トランザクション処理
            $dbh->beginTransaction();

            try{
              $stmt->bindParam(':name3', $name);
          		$stmt->bindParam(':photoref', $photoref);
          		$stmt->bindParam(':pro1', $pro1);
              $stmt->bindParam(':pro2', $pro2);
              $stmt->bindParam(':pro3', $pro3);
              $stmt->bindParam(':pro4', $pro4);
              $stmt->bindParam(':account', $account);
              $stmt->bindParam(':created', $created);
          		$stmt->execute();

              //コミット
              $dbh->commit();

            }catch (PDOException $e) {
              //ロールバック
              $dbh->rollback();
              throw $e; //
            }
            // 接続を閉じる
            $dbh = null;
            /*データベースへの登録完了*/
          }catch (PDOException $e) {
            // UTF8に文字エンコーディングを変換します
            echo mb_convert_encoding($e->getMessage(),'UTF-8','SJIS-win');
            die();
          }
          echo '送信完了しました。';
        }
      }
}
