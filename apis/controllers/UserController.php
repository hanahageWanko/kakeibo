<?php
class UserController extends Controller
{
    public function readAction()
    {
      
      return $this->render([
        'user_name' => '',
        'password'  => '',
        '_token'    => $this->generateCsrfToken('user/read'),
        'repository' => $this->db_manager->get('User')
    ]);

        // echo 'readAction';
    }
}
