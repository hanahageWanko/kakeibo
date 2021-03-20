<?php
  class AuthRepository extends DbRepository
  {
      public function insert($email, $password, $user_name)
      {
          try {
              $auth_table = $_ENV["TB_AUTH"];
              $user_table = $_ENV["TB_USER"];
              // 同じメールアドレスが既にDBに登録されているか確認
              $checkUseEmail = $this->checkRecodeByEmail($auth_table, $email);

              if ($checkUseEmail->rowCount() > 0) {
                  echo json_encode(Validate::resultMessage(0, 422, 'This E-mail already in use!'));
                  return;
              } else {
                  $password = $this->hashPassword($password);

                  $sql = "INSERT INTO $auth_table(email, created_at, updated_at)
                          VALUES (:email, :created_at, :updated_at)";

                  $insert =$this->execute($sql, [
                                ':email'      => $email,
                                ':created_at' => $this->getNow(),
                                ':updated_at' => $this->getNow()
                            ]);
                  if ($insert->rowCount() > 0) {
                      $selectSql = "SELECT `id` FROM $auth_table WHERE email=:email";
                      $auth_data = $this->execute($selectSql, [":email" => $email])->fetch(PDO::FETCH_ASSOC);
                      $password = $this->hashPassword($password);

                      $userInsertSql = "INSERT INTO $user_table(user_name, email, password, auth_id, is_auth, created_at, updated_at)
                          VALUES (:user_name, :email, :password, :auth_id, :is_auth,  :created_at, :updated_at)";
                          var_dump($auth_data['id']);
                       var_dump((int) $auth_data['id']);
                      $this->execute($userInsertSql, [
												':user_name'  => $user_name,
												':email'      => $email,
												':password'   => $password,
												':auth_id'    => intval($auth_data['id']),
												':is_auth'    => 1,
												':created_at' => $this->getNow(),
												':updated_at' => $this->getNow()
											]);
                      echo json_encode(Validate::resultMessage(0, 200, 'Data inserted successfully'));
                  } else {
                      echo json_encode(Validate::resultMessage(0, 422, 'Auth insert not success!'));
                      return;
                  }
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

      public function update($auth_id, $email, $user_name)
      {
        $auth_table = $_ENV["TB_AUTH"];
        $user_table = $_ENV["TB_USER"];
          try {
              // 対象のIDを持つレコードを取得
              $checkTargetRecode = $this->checkRecodeById($auth_table, $auth_id);
							$getTargetRecode = $checkTargetRecode->fetch(PDO::FETCH_ASSOC);
							$beforeEmail = $getTargetRecode['email'];
              // 対象のIDを持つレコードがなければエラーを返却
              if ($checkTargetRecode->rowCount() === 0) {
                  echo json_encode(Validate::resultMessage(0, 401, 'Not Exist ID'));
                  return;
              }
          
              $checkUseEmail = $this->checkRecodeByEmail($auth_table, $email);
              if ($checkUseEmail->rowCount() > 0 && $beforeEmail !== $email) {
                  echo json_encode(Validate::resultMessage(0, 422, 'This E-mail already in use!'));
                  return;
							}
							
							$authUpdateSql = "UPDATE $auth_table
																SET
																	email = :email,
																	created_at = :created_at,
																	updated_at = :updated_at
																WHERE id = :id
															 ";
							$authUpdateItem = [
								':id' => $auth_id,
								':email' => $email,
								':created_at' => $getTargetRecode['created_at'],
								':updated_at' => $this->getNow()
							];

							$authUpdateExecute = $this->execute($authUpdateSql, $authUpdateItem);
						  if($authUpdateExecute) {
								$selectSql = "SELECT * FROM $user_table WHERE email=:email";
								$targetRecode = $this->execute($selectSql, [":email" => $beforeEmail])->fetch(PDO::FETCH_ASSOC);
								$udpateSql = "UPDATE $user_table
								SET 
									user_name   = :user_name, 
									email       = :email,
									password    = :password,
									auth_id     = :auth_id,
									is_auth     = :is_auth,
									created_at  = :created_at,
									updated_at  = :updated_at
								WHERE id = :id";

								$updateItem = [
									':id'         => $targetRecode['id'],
									':user_name'  => $this->updateBindValue($targetRecode, $user_name),
									':email'      => $this->updateBindValue($targetRecode, $email),
									':password'   => $targetRecode['password'],
									':auth_id'    => $targetRecode['auth_id'],
									':is_auth'    => $targetRecode['is_auth'],	
									':created_at' => $targetRecode['created_at'],
									':updated_at' => $this->getNow()
								];
								$this->execute($udpateSql, $updateItem);
								echo json_encode(Validate::resultMessage(0, 200, 'Data updated successfully'));
							} else {
								$rollbackSql = "UPDATE $auth_table
																	SET
																		email = :email,
																		created_at = :created_at,
																		updated_at = :updated_at
																	WHERE id = :id
																 ";
								$rollbackItem = [
								':id' => $auth_id,
								':email' => $beforeEmail,
								':created_at' => $getTargetRecode['created_at'],
								':updated_at' => $this->getNow()
								];
								$this->execute($rollbackSql, $rollbackItem);
								echo json_encode(Validate::resultMessage(0, 401, 'There was a problem during the update.'));
							}

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
