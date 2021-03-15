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

    public function insertAction()
    {
        // TODO: フロント実実装時にcsrfチェック用処理を作成すること
        // $token = $this->request->getPost('_token');
        // if (!$this->checkCsrfToken('user/insert', $token)) {
        //     return $this->redirect('user/insert');
        // }
        return $this->render([
       'getUserRepository' => $this->db_manager->get('User'),
       'getData' => $this->getContents()
      ]);
    }

    public function updateAction()
    {
        // TODO: フロント実実装時にcsrfチェック用処理を作成すること
        // $token = $this->request->getPost('_token');
        // if (!$this->checkCsrfToken('user/update', $token)) {
        //     return $this->redirect('/user/update');
        // }
        return $this->render([
        'getUserRepository' => $this->db_manager->get('User'),
        'getData' => $this->getContents()
       ]);
    }
}
