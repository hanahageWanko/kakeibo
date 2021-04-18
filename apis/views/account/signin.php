<?php
  $_SESSION['csrf_token'] = $this->escape($_token); // CSRFのトークンを取得する
  $token = $_SESSION['csrf_token'];
  //トークンがセットされていたらリダイレクト
  if (isset($_COOKIE['cookie_token'])) {
    header("HTTP/1.1 301 Moved Permanently");
  }
   $getAccountRepository->login($getData->id, $getData->password, $token);

