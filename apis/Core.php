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
        '/auth/read'
            => ['controller' => 'auth', 'action' => 'read'],
        '/auth/insert'
            => ['controller' => 'auth', 'action' => 'insert'],
        '/auth/update'
            => ['controller' => 'auth', 'action' => 'update'],
        '/auth/delete'
            => ['controller' => 'auth', 'action' => 'delete'],
        '/user/read'
            => ['controller' => 'user', 'action' => 'read'],
        '/user/insert'
            => ['controller' => 'user', 'action' => 'insert'],
        '/user/update'
            => ['controller' => 'user', 'action' => 'update'],
        '/user/delete'
            => ['controller' => 'user', 'action' => 'delete'],
        '/category/insert'
            => ['controller' => 'category', 'action' => 'insert'],
        '/category/update'
            => ['controller' => 'category', 'action' => 'update'],
        '/expenses/insert'
            => ['controller' => 'expenses', 'action' => 'insert'],
        '/expenses/update'
            => ['controller' => 'expenses', 'action' => 'update'],
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
