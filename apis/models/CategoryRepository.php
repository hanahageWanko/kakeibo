<?php
  class CategoryRepository extends DbRepository
  {
      public function insert($user_id, $color, $category_name)
      {
          try {
              $tablename = $_ENV["TB_CATEGORY"];
              // 同じカテゴリ名称が既にDBに登録されているか確認
              // $checkUseName = $this->checkRecodeByName($tablename, $category_name);

              // if ($checkUseName->rowCount() > 0) {
              //     echo json_encode(Validate::resultMessage(0, 422, 'This CategoryName already in use!'));
              //     return;
              // }
              $sql = "INSERT INTO $tablename(category_name, user_id, color, created_at, updated_at)
            VALUES (:category_name, :user_id, :color, :created_at, :updated_at)";
              $params = [
                ':category_name' => $category_name,
                ':user_id'       => $user_id,
                ':color'         => $color,
                ':created_at'    => $this->getNow(),
                ':updated_at'    => $this->getNow()
              ];
              $this->execute($sql, $params);
              echo json_encode(Validate::resultMessage(0, 200, 'Data inserted successfully'));
          } catch (PDOException $e) {
              echo json_encode(Validate::resultMessage(0, 500, $e->getMessage()));
          }
      }

      public function update($id, $user_id, $color, $category_name)
      {
          try {
              $tablename = $_ENV["TB_CATEGORY"];
              $getTargetRecode = $this->checkRecodeById($tablename, $id)->fetch(PDO::FETCH_ASSOC);
              // 対象のIDを持つレコードがなければエラーを返却
              if ($this->checkRecodeById($tablename, $id)->rowCount() === 0) {
                  echo json_encode(Validate::resultMessage(0, 401, 'Not Exist ID'));
                  return;
              }

              // $checkUseCategoyName = $this->checkRecodeByCategoryName($tablename, $category_name);
              // if ($checkUseCategoyName->rowCount() > 0 && $getTargetRecode['category_name'] !== $category_name) {
              //     echo json_encode(Validate::resultMessage(0, 422, 'This CategoryName already in use!'));
              //     return;
              // }
              $postItem = [
                  ':id'             => $id,
                  ':category_name'  => $category_name,
                  ':user_id'        => $getTargetRecode['user_id'],
                  ':color'          => $color,
                  ':created_at'     => $getTargetRecode['created_at'],
                  ':updated_at'     => $this->getNow()
              ];

              $sql = "UPDATE $tablename
                      SET 
                        category_name = :category_name,
                        user_id       = :user_id,
                        color         = :color,
                        created_at    = :created_at,
                        updated_at    = :updated_at
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
          try {
              $tablename = $_ENV["TB_CATEGORY"];
              $sql = "DELETE FROM $tablename WHERE id = :id";

              $this->execute($sql, [':id' => $id]);
              echo json_encode(Validate::resultMessage(0, 200, 'Data deleted successfully'));
          } catch (PDOException $e) {
              echo json_encode(Validate::resultMessage(0, 500, $e->getMessage()));
              return;
          }
      }

      private function checkRecodeById($tablename, $id)
      {
          // 同じメールアドレスが既にDBに登録されているか確認
          $sql = "SELECT *
                  FROM $tablename
                  WHERE `id`=:id";
          return  $this->execute($sql, [':id' => $id]);
      }

      private function checkRecodeByCategoryName($tablename, $category_name)
      {
          // 同じメールアドレスが既にDBに登録されているか確認
          $sql = "SELECT *
                  FROM $tablename
                  WHERE `category_name`=:category_name";
          return  $this->execute($sql, [':category_name' => $category_name]);
      }

      private function checkRecodeByName($tablename, $category_name)
      {
          $sql = " SELECT * FROM $tablename WHERE category_name = :category_name";
          return $this->execute($sql, [':category_name' => $category_name]);
      }
  }
