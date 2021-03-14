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
    }

    public function insertAction() {
      $this->getContents();
      // TODO: フロント実実装時にコメントをとる
      // $token = $this->request->getPost('_token');
      // if (!$this->checkCsrfToken('user/insert', $token)) {
      //     return $this->redirect('/account/signup');
      // }
      return $this->render([
       'getUserRepository'    => $this->db_manager->get('User'),
       'getData' => $this->getContents()
      ]);
    }
}
