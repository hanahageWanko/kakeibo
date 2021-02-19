<?php
class Core extends Application
{
    public function getRootDir()
    {
        return __DIR__;
    }

    public function routing()
    {
        // users
        Router::set('user/read', function () {
            View::make('user/read', 'userRepository');
            $this->findController('AccountController');
        });

        // Router::set('users/insert', function () {
        //     View::make('users/insert');
        // });

        // Router::set('users/update', function () {
        //     View::make('users/update');
        // });

        // Router::set('users/delete', function () {
        //     View::make('users/delete');
        // });
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
