<?php
class validationBM
{
    public static function check($params)
    {
        $respons = array(
            'cmd'      => '',
            'url'    => '',
        );

        if (!$params['cmd']) {
            $respons['cmd'] = '名前を入力してください';
            echo '名前を入力してください';
        }

        else if (!$params['url']) {
            $respons['url'] = 'URLを入力してください';
            echo 'URLを入力してください';
        }

        else{
          session_start();
          $dsn = 'mysql:host=localhost;dbname=mydb;charset=utf8mb4';
          date_default_timezone_set('Asia/Tokyo');
          $username = 'root';
          $password = 'jyxQJM.Bi3my';

          //バリデーションの作成
          $cmd = htmlspecialchars($_POST['cmd'],ENT_QUOTES);
          $url = htmlspecialchars($_POST['url'],ENT_QUOTES);

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
            $stmt = $dbh->prepare("INSERT INTO VoiceBM(cmd,url,account) VALUES(:cmd,:url,:account)");

            //トランザクション処理
            $dbh->beginTransaction();

            try{
              $stmt->bindParam(':cmd', $cmd);
              $stmt->bindParam(':url', $url);
              $stmt->bindParam(':account', $account);
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
          echo '登録を完了しました。';
        }
      }
}
