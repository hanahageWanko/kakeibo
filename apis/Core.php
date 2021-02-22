<?php
class Core extends Application
{
    protected $login_action = ['user', 'account', 'signin'];

    public function getRootDir()
    {
        return __DIR__;
    }

    // ルーティング定義
    protected function registerRoutes()
    {
        return [
        '/user'
            => ['controller' => 'account', 'action' => 'index'],
        '/user/insert'
            => ['controller' => 'account'],
        '/account'
            => ['controller' => 'account'],
        '/account/:action'
            => ['controller' => 'account'],
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
