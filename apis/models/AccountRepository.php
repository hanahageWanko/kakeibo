<?php
  class AccountRepository extends DbRepository
  {
      private $term = "-1days";
      private $period = 1;
      private $cookie_param_secure_value = false;
      private $cookie_param_httponly_value = false;

      public function get_token()
      {
          $TOKEN_LENGTH = 16;//16*2=32桁
          $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
          return bin2hex($bytes);
      }

      public function login($user_id, $password, $token)
      {
          $cookie_token = isset($_COOKIE['cookie_token']) ? $_COOKIE['cookie_token'] : '';
          //CSRF チェック
          if (empty($cookie_token) && $token != $_SESSION['csrf_token']) {
              $_SESSION = [];
              session_destroy();
              session_start();
              echo "初回ログイン";
              
              exit();
          }
          echo "すでにログイン済み";
          //ログイン判定フラグ
          $normal_result = false;
          $auto_result = false;

          try {
              //簡易ログイン
              if (empty($cookie_token)) {
                  if ($this->check_user($user_id, $password)) {
                      $normal_result = true;
                  }
              }

              //自動ログイン
              if (!empty($cookie_token)) {
                  if ($this->check_auto_login($cookie_token)) {
                      $auto_result = true;
                      $id = $_SESSION['user_id']; // 後続の処理のため格納
                  }
              }

              if (($normal_result && !$auto_result) || $auto_result) {
                  $token = $this->get_token();
                  $this->register_token($user_id, $token);
                  setCookie("cookie_token", $token, time()+60*60*24*$this->period , "/", null, $this->cookie_param_secure_value, $this->cookie_param_httponly_value); // secure, httponly
              }

              if ($auto_result) {
                  //古いトークンの削除
                  $this->delete_old_token($cookie_token);
                  var_dump('auto_login完了');
                  exit();
              } elseif ($normal_result) {
                  // リダイレクト
                  var_dump('通常ログイン完了');
              } else {
                  // リダイレクト
                  var_dump('loginが必要');
                  exit();
              };

              // DBとの接続
          } catch (PDOException $e) {
              die($e->getMessage());
          }
      }

      public function check_user($user_id, $password)
      {
          $res = false;
          $tablename = $_ENV["TB_USER"];
          $sql = "SELECT * FROM $tablename WHERE id = :id";
          $params = [
          ':id' => $user_id,
        ];
          $user = $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
          // 対象のIDを持つレコードがなければエラーを返却
          if ($this->execute($sql, $params)->rowCount() > 0) {
              if (password_verify($password, $user['password'])) {
                  $_SESSION['user_id'] = $user_id;
                  $res = true;
              }
          }
          return $res;
      }

      public function check_auto_login($cookie_token)
      {
          $tablename = $_ENV["TB_LOGIN"];
          $sql = "SELECT * FROM $tablename WHERE login_key = :login_key AND created_at >= :created_at";
          $date = new DateTime($this->term);
          $params = [
          ":login_key" => $cookie_token,
          ":created_at" => $date->format('Y-m-d H:i:s')
        ];
          $row = $this->execute($sql, $params);
          if ($row->rowCount() > 0) {
              $_SESSION['user_id'] = $row->fetch(PDO::FETCH_ASSOC)["user_id"] ?? '';
              return true;
          } else {
              // Cookieのトークンを削除
              // setCookie(名称, 値, 有効期限, クッキーを有効にしたいパス, サブドメイン, HTTPSの場合のみクッキーを送信する, HTTPonly)
              setCookie("cookie_token", '', -1, "/", null, $this->cookie_param_secure_value, $this->cookie_param_httponly_value);
              return false;
          }
      }


      public function register_token($user_id, $login_key) {
        //プレースホルダで SQL 作成
        $tablename = $_ENV['TB_LOGIN'];
        $sql = "INSERT INTO $tablename ( user_id, login_key, created_at)
                VALUES (:user_id, :login_key, :created_at)";
        // 現在日時を取得
        $date = date('Y-m-d H:i:s');
        $params= [
          ':user_id' => $user_id,
          ':login_key' => $login_key,
          ':created_at' => $date
        ];
        $this->execute($sql, $params);
      }
      public function delete_old_token($login_key)
      {
          $tablename = $_ENV["TB_LOGIN"];
          //プレースホルダで SQL 作成
          $sql = "DELETE FROM $tablename WHERE login_key = :login_key";
          $this->execute($sql, [':login_key' => $login_key]);
      }
  }
