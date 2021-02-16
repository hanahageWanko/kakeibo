<?php
  class UserRepository extends DbRepository
  {
      public function insert($user_name, $email, $password, $is_auth)
      {
          $password = $this->hashPasssword($password);
          $now = new DateTime();

          $sql = '
        insert into user(user_name, email, password, is_auth, created_at)
        value (:user_name, :email, :password, :is_auth, :created_at)
      ';

          $stmt = $this->execute($sql, [
            ':user_name' => $user_name,
            ':email' => $email,
            ':password' => $password,
            ':is_auth' => $is_auth,
            ':created_at' => $now->format('Y-m-d')
          ]);
      }

      public function hashPassword($password)
      {
          return password_hash($password, PASSWORD_DEFAULT);
      }

      public function isUniqueName($user_name)
      {
          $sql = "select count(id) as count 
                  from {$_ENV['USER_DATA']} 
                  where user_name = :user_name";

          $row = $this->fetch($sql, [':user_name' => $user_name]);
          if ($row['count'] === '0') {
              return true;
          }

          return false;
      }
  }
