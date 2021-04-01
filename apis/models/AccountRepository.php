<?php
  class AccountRepository extends DbRepository
  {
      public function get_token()
      {
          $TOKEN_LENGTH = 16;//16*2=32桁
          $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
          return bin2hex($bytes);
      }

      public function login($user_id, $password, $login_key)
      {
          //パラメーター取得
          // $id = $user_id;
          // $password = $password;
          // $csrf_token = $login_key;
          // if (! empty($_COOKIE['auto_login'])) {
          //     $this->delete_auto_login($_COOKIE['auto_login']);
          // }
          // // 新たにauto_loginをセット
          // if (!empty($auto_login)) {
          //     $this->setup_auto_login($user_name);
          // }
      }
  }
