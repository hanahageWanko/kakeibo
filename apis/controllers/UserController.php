<?php
class UserController extends Controller
{
    public function readAction()
    {
      // $this->db_manager->get('User')->insert('ユーザー1', '111@111.jp', 'password', null);
      $read_data = $this->db_manager->get('User')->read();
      foreach($read_data as $key =>$loop){
            echo $read_data[$key].PHP_EOL;
        }
      return $this->render([
        'user_name' => '',
        'password'  => '',
        '_token'    => $this->generateCsrfToken('user/read'),
        'repository' => $this->db_manager->get('User')
    ]);

        // echo 'readAction';
    }
}
