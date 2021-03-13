<?php
  class UserRepository extends DbRepository
  {

    public function insert($user_name, $email, $password, $auth_id) {
      $password = $this->hashPassword($password);
      $now = new DateTime();
      $now = $now->format('Y-m-d h:m:s');
      $tablename = $_ENV["TB_USER"];

      $sql = "INSERT INTO $tablename(user_name, email, password, auth_id, created_at, updated_at)
              VALUES (:user_name, :email, :password, :auth_id, :created_at, :updated_at)
      ";

      $stmt = $this->execute($sql, [
        ':user_name'  => $user_name,
        ':email'      => $email,
        ':password'   => $password,
        ':auth_id'    => $auth_id,
        ':created_at' => $now,
        ':updated_at' => $now
      ]);
    }

    public function read($id = "") {
      $tablename = $_ENV["TB_USER"];
      $sql = is_numeric($id) 
              ? "SELECT * FROM $tablename WHERE id = ${id}" 
              : "SELECT * FROM $tablename";
      return $this->fetch($sql);
    }


    
    private function hashPassword($password) {
      return password_hash($password, PASSWORD_DEFAULT);
    }

    // TODO : fetch類のmethod
  }
