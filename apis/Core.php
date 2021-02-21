<?php
class Core extends Application
{

    public function getRootDir()
    {
        return __DIR__;
    }


     public function configure()
    {
        $this->db_manager->connect('master', [
        'dsn' => "mysql:dbname={$_ENV['DB_NAME']};host={$_ENV['DB_HOST']}",
        'user' =>$_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
      ]);
    }
}
