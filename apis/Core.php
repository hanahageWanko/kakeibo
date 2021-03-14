<?php
class Core extends Application
{
    //protected $login_action = ['account', 'signin'];

    public function getRootDir()
    {
        return __DIR__;
    }

    protected function registerRoutes()
    {
        return [
        '/user/read'
            => ['controller' => 'user', 'action' => 'read'],
        '/user/insert'
            => ['controller' => 'user', 'action' => 'insert'],
        '/access/generateToken'
            => ['controller' => 'access', 'action' => 'generateToken'],
    ];
    }

    protected function configure()
    {
        $this->db_manager->connect('master', [
            'dsn' => "mysql:dbname={$_ENV['DB_NAME']};host={$_ENV['DB_HOST']}",
            'user' =>$_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD']
          ]);
    }
}
