<?php
  class UserRepository extends DbRepository
  {
      public function insert($email, $password, $user_name, $auth_id = null)
      {
        try {
            $tablename = $_ENV["TB_USER"];
            // 同じメールアドレスが既にDBに登録されているか確認
            $checkEmail = "SELECT `email`
                           FROM $tablename
                           WHERE `email`=:email";
            $checkItem = $this->execute($checkEmail, [':email' => $email]);

            if ($checkItem->rowCount() > 0) {
                echo json_encode(Validate::resultMessage(0, 422, 'This E-mail already in use!'));
                return;
            } else {
                $password = $this->hashPassword($password);
                $now = new DateTime();
                $now = $now->format('Y-m-d h:m:s');

                $sql = "INSERT INTO $tablename(user_name, email, password, auth_id, created_at, updated_at)
                        VALUES (:user_name, :email, :password, :auth_id, :created_at, :updated_at)";

                $stmt = $this->execute($sql, [
                ':user_name'  => $user_name,
                ':email'      => $email,
                ':password'   => $password,
                ':auth_id'    => $auth_id,
                ':created_at' => $now,
                ':updated_at' => $now
              ]);
            }
        } catch ( PDOException $e ) {
          echo json_encode(Validate::resultMessage(0, 500, $e->getMessage()));
          return;
        }
      }

      public function read($id = "")
      {
          $tablename = $_ENV["TB_USER"];
          $sql = is_numeric($id)
              ? "SELECT * FROM $tablename WHERE id = ${id}"
              : "SELECT * FROM $tablename";
          return $this->fetch($sql);
      }


    
      private function hashPassword($password)
      {
          return password_hash($password, PASSWORD_DEFAULT);
      }

      // TODO : fetch類のmethod
  }
