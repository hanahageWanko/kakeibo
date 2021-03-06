<?php
  class ExpensesRepository extends DbRepository
  {
      public function insert($money, $user_id, $category_id)
      {
          try {
              $tablename = $_ENV["TB_EXPENSES"];
              // 同じカテゴリ名称が既にDBに登録されているか確認

              $sql = "INSERT INTO $tablename(money, user_id, category_id, created_at, updated_at)
            VALUES (:money, :user_id, :category_id, :created_at, :updated_at)";
              $params = [
                ':money'         => $money,
                ':user_id'       => $user_id,
                ':category_id'   => $category_id,
                ':created_at'    => $this->getNow(),
                ':updated_at'    => $this->getNow()
              ];
              $this->execute($sql, $params);
              echo json_encode(Validate::resultMessage(0, 200, 'Data inserted successfully'));
          } catch (PDOException $e) {
              echo json_encode(Validate::resultMessage(0, 500, $e->getMessage()));
          }
      }

      public function read($user_id) {
          try {
              $expenses_table = $_ENV["TB_EXPENSES"];
              $category_table = $_ENV["TB_CATEGORY"];
              $sql = "SELECT
                        expenses.id
                        ,expenses.money
                        ,expenses.user_id
                        ,category.category_name
                        ,category.color
                        ,expenses.created_at
                        ,expenses.updated_at
                      FROM $expenses_table as expenses
                      JOIN $category_table as category
                      ON expenses.category_id = category.id
                      WHERE expenses.user_id = :user_id";
              return $this->execute($sql, [":user_id" => $user_id])->fetchAll(PDO::FETCH_ASSOC);
          } catch (PDOException $e) {
              echo json_encode(Validate::resultMessage(0, 500, $e->getMessage()));
              return;
          }
      }

      public function update($id, $money, $user_id, $category_id)
      {
          try {
              $tablename = $_ENV["TB_EXPENSES"];
              $getTargetRecode = $this->checkRecodeById($tablename, $id)->fetch(PDO::FETCH_ASSOC);
              // 対象のIDを持つレコードがなければエラーを返却
              if ($this->checkRecodeById($tablename, $id)->rowCount() === 0) {
                  echo json_encode(Validate::resultMessage(0, 401, 'Not Exist ID'));
                  return;
              }

              $postItem = [
                  ':id'          => $id,
                  ':money'       => $money,
                  ':user_id'     => $user_id,
                  ':category_id' => $category_id,
                  ':created_at'  => $getTargetRecode['created_at'],
                  ':updated_at'  => $this->getNow()
              ];

              $sql = "UPDATE $tablename
                      SET 
                        money = :money,
                        user_id       = :user_id,
                        category_id   = :category_id,
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

      public function delete($id) {
        try {
            $tablename = $_ENV["TB_EXPENSES"];
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
  }
