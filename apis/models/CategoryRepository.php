<?php
  class CategoryRepository extends DbRepository{
    public function insert($category_name) {
      try {
        $tablename = $_ENV["TB_CATEGORY"];
        // 同じカテゴリ名称が既にDBに登録されているか確認
        $checkUseName = $this->checkRecodeByName($tablename, $category_name);

        if ($checkUseName->rowCount() > 0) {
            echo json_encode(Validate::resultMessage(0, 422, 'This Name already in use!'));
            return;
        }
        $sql = "INSERT INTO $tablename(category_name, created_at, updated_at)
                VALUES (:category_name, :created_at, :updated_at)";
        $params = [
          ':category_name' => $category_name,
          ':created_at'    => $this->getNow(),
          ':updated_at'    => $this->getNow()
        ];
        $this->execute($sql,$params);
        echo json_encode(Validate::resultMessage(0, 200, 'Data inserted successfully'));
    } catch (PDOException $e) {
        echo json_encode(Validate::resultMessage(0, 500, $e->getMessage()));
      }
    }

  public function checkRecodeByName($tablename, $category_name) {
    $sql = " SELECT * FROM $tablename WHERE category_name = :category_name";
    return $this->execute($sql, [':category_name' => $category_name]);
  }
}