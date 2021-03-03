<?php
  class AuthRepository extends DbRepository
  {
      public function insert($email, $password, $auth_name)
      {
          try {
              $tablename = $_ENV["TB_AUTH"];
              // 同じメールアドレスが既にDBに登録されているか確認
              $checkUseEmail = $this->checkRecodeByEmail($tablename, $email);

              if ($checkUseEmail->rowCount() > 0) {
                  echo json_encode(Validate::resultMessage(0, 422, 'This E-mail already in use!'));
                  return;
              } else {
                  $password = $this->hashPassword($password);

                  $sql = "INSERT INTO $tablename(auth_name, email, password, created_at, updated_at)
                        VALUES (:auth_name, :email, :password, :created_at, :updated_at)";

                  $this->execute($sql, [
                ':auth_name'  => $auth_name,
                ':email'      => $email,
                ':password'   => $password,
                ':created_at' => $this->getNow(),
                ':updated_at' => $this->getNow()
              ]);
                  echo json_encode(Validate::resultMessage(0, 200, 'Data inserted successfully'));
              }
          } catch (PDOException $e) {
              echo json_encode(Validate::resultMessage(0, 500, $e->getMessage()));
              return;
          }
      }

      public function read($id = "")
      {
          $tablename = $_ENV["TB_AUTH"];
          $sql = is_numeric($id)
              ? "SELECT * FROM $tablename WHERE id = ${id}"
              : "SELECT * FROM $tablename";
          return $this->fetch($sql);
      }

      public function update($id, $email, $auth_name)
      {
          $tablename = $_ENV["TB_AUTH"];
          try {
              // 対象のIDを持つレコードを取得
              $checkTargetRecode = $this->checkRecodeById($tablename, $id);
              $getTargetRecode = $checkTargetRecode->fetch(PDO::FETCH_ASSOC);
              // 対象のIDを持つレコードがなければエラーを返却
              if ($checkTargetRecode->rowCount() === 0) {
                  echo json_encode(Validate::resultMessage(0, 401, 'Not Exist ID'));
                  return;
              }
          
              $checkUseEmail = $this->checkRecodeByEmail($tablename, $email);
              if ($checkUseEmail->rowCount() > 0 && $getTargetRecode['email'] !== $email) {
                  echo json_encode(Validate::resultMessage(0, 422, 'This E-mail already in use!'));
                  return;
              }
              $postItem = [
									':id'         => $id,
									':auth_name'  => $this->updateBindValue($getTargetRecode, $auth_name),
									':email'      => $this->updateBindValue($getTargetRecode, $email),
									':password'   => $getTargetRecode['password'],
									':updated_at' => $this->getNow(),
									':created_at' => $getTargetRecode['created_at']
							];

              $sql = "UPDATE $tablename
                  SET 
                    auth_name   = :auth_name, 
                    email       = :email,
                    password    = :password,
                    updated_at  = :updated_at,
                    created_at  = :created_at
                  WHERE id = :id";
              $this->execute($sql, $postItem);
              echo json_encode(Validate::resultMessage(0, 200, 'Data updated successfully'));
          } catch (PDOException $e) {
              echo json_encode(Validate::resultMessage(0, 500, $e->getMessage()));
              return;
          }
      }

      private function checkRecodeByEmail($tablename, $email)
      {
          // 同じメールアドレスが既にDBに登録されているか確認
          $sql = "SELECT `email`
                FROM $tablename
                WHERE `email`=:email";
          return  $this->execute($sql, [':email' => $email]);
      }

      private function checkRecodeById($tablename, $id)
      {
          // 同じメールアドレスが既にDBに登録されているか確認
          $sql = "SELECT *
                FROM $tablename
                WHERE `id`=:id";
          return  $this->execute($sql, [':id' => $id]);
      }


    
      private function hashPassword($password)
      {
          return password_hash($password, PASSWORD_DEFAULT);
      }

      // TODO : fetch類のmethod
  }
