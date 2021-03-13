<?php
class UserController extends Controller
{
    public function readAction()
    {
      return $this->render([
        'user_name' => '',
        'password'  => '',
        // '_token'    => $this->generateCsrfToken('user/read'),
        'read_data' => $this->db_manager->get('User')->read()
    ]);

        // echo 'readAction';
    }
}
