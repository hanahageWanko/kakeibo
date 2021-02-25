<?php
  abstract class DbRepository
  {
      protected $con;

      public function __construct($con)
      {
          $this->setConnection($con);
      }

      public function setConnection($con)
      {

          $this->con = $con;
          
      }

      public function execute($sql, $params = [])
      {
          $stmt = $this->con->prepare($sql);
          $stmt->execute($params);
          return $stmt;
      }

      public function fetch($sql)
      {
        $stmt = $this->execute($sql);
        if ($stmt->rowCount() > 0) {
            $result = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($result, $row);
            }
            return $result;
        }
      }

      public function updateBindValue($old_value, $new_value) {
        return !empty($new_value) ? $new_value : $old_value;
      }

      public function getNow() {
        date_default_timezone_set('Asia/Tokyo');
        return date('Y-m-d H:i:s');
      }
  }
