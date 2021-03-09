<?php
  class UserRepository extends DbRepository
  {

    public function insert($user_name, $email, $password, $auth_id) {
      $password = $this->hashPassword($password);
      $now = new DateTime();
      $tablename = $_ENV["TB_USER"];

      $sql = "INSERT INTO $this->tablename(user_name, email, password, auth_id, created_at)
              VALUE(:user_name, :email, :password, :auth_id, :created_at)
      ";

      $stmt = $this->execute($sql, [
        ':user_name'  => $user_name,
        ':email'      => $email,
        ':password'   => $password,
        ':auth_id'    => $auth_id,
        ':created_at' => $now
      ]);
    }

    public function read() {
      $tablename = $_ENV["TB_USER"];
      $sql = "SELECT * FROM $tablename";
      $this->fetch($sql);
    }



    private function hashPassword($password) {
      return password_hash($password, PASSWORD_DEFAULT);
    }

    // TODO : fetch類のmethod
  }
