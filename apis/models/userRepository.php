<?php
  class UserRepository extends DbRepository
  {
      public function insert($email, $password, $user_name, $auth_id, $is_auth = 0)
      {
          try {
              $tablename = $_ENV["TB_USER"];
              // 同じメールアドレスが既にDBに登録されているか確認
              $checkUseEmail = $this->checkRecodeByEmail($tablename, $email);

              if ($checkUseEmail->rowCount() > 0) {
                  echo json_encode(Validate::resultMessage(0, 422, 'This E-mail already in use!'));
                  return;
              } else {
                  $password = $this->hashPassword($password);

                  $sql = "INSERT INTO $tablename(user_name, email, password, auth_id, is_auth, created_at, updated_at)
                        VALUES (:user_name, :email, :password, :auth_id, :is_auth,  :created_at, :updated_at)";

                  $this->execute($sql, [
                ':user_name'  => $user_name,
                ':email'      => $email,
                ':password'   => $password,
                ':auth_id'    => $auth_id,
                ':is_auth'    => $is_auth,
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

      public function read($id)
      {
          try{
            $tablename = $_ENV["TB_USER"];
            $sql = "SELECT * FROM $tablename WHERE id = :id";
            return $this->execute($sql, [":id" => $id])->fetch(PDO::FETCH_ASSOC);
          } catch(PDOexption $e) {
            echo json_encode(Validate::resultMessage(0, 422, 'The information could not be read.'));
            return;
          }
      }

      public function update($id, $email, $user_name)
      {
          $tablename = $_ENV["TB_USER"];
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
            ':user_name'  => $this->updateBindValue($getTargetRecode, $user_name),
            ':email'      => $this->updateBindValue($getTargetRecode, $email),
            ':password'   => $getTargetRecode['password'],
            ':auth_id'    => $getTargetRecode['auth_id'],
            ':is_auth'    => $getTargetRecode['is_auth'],
            ':updated_at' => $this->getNow(),
            ':created_at' => $getTargetRecode['created_at']
          ];

              $sql = "UPDATE $tablename
                  SET 
                    user_name   = :user_name, 
                    email       = :email,
                    password    = :password,
                    auth_id     = :auth_id,
                    is_auth     = :is_auth,
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

      public function delete($id)
      {
          $user_table = $_ENV['TB_USER'];
          $expenses_table = $_ENV['TB_EXPENSES'];
          $category_table = $_ENV['TB_CATEGORY'];
          $deletePost = "DELETE
													$user_table
													,$expenses_table
													,$category_table
												FROM
													$user_table
													,$expenses_table
													,$category_table
												WHERE $user_table.id = :id
												AND $expenses_table.user_id = $user_table.id
												AND $category_table.user_id = $user_table.id
											";
          try {
              $this->execute($deletePost, [":id" => $id]);
              echo json_encode(Validate::resultMessage(0, 200, 'Post Deleted Successfuly'));
          } catch (PDOException $e) {
              echo json_encode(Validate::resultMessage(0, 500, $e->getMessage()));
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
