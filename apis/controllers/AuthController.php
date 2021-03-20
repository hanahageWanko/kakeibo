<?php
class AuthController extends Controller
{
    public function readAction()
    {
        return $this->render([
        'user_name' => '',
        'password'  => '',
        // '_token'    => $this->generateCsrfToken('auth/read'),
        'read_data' => $this->db_manager->get('Auth')->read()
      ]);
    }

    public function insertAction()
    {
        // TODO: フロント実実装時にcsrfチェック用処理を作成すること
        // $token = $this->request->getPost('_token');
        // if (!$this->checkCsrfToken('auth/insert', $token)) {
        //     return $this->redirect('auth/insert');
        // }
        return $this->render([
       'getAuthRepository' => $this->db_manager->get('Auth'),
       'getData' => $this->getContents()
      ]);
    }

    public function updateAction()
    {
        // TODO: フロント実実装時にcsrfチェック用処理を作成すること
        // $token = $this->request->getPost('_token');
        // if (!$this->checkCsrfToken('auth/update', $token)) {
        //     return $this->redirect('auth/update');
        // }
        return $this->render([
        'getAuthRepository' => $this->db_manager->get('Auth'),
        'getData' => $this->getContents()
       ]);
    }
}
