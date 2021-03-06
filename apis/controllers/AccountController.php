<?php

class AccountController extends Controller
{
    protected $auth_actions = ['index', 'signout', 'authenticateAction'];

    public function signupAction()
    {
        if (!$this->session->isAuthenticated()) {
            return $this->redirect('/error');
        }

        return $this->render([
            'user_name' => '',
            'password'  => '',
            '_token'    => $this->generateCsrfToken('account/signup'),
        ]);
    }

 

    // アカウント情報TOP
    public function indexAction()
    {
        $user = $this->session->get('user');
        return $this->render([
            'user' => $user
        ]);
    }

    public function signinAction()
    {
        // if (!$this->session->isAuthenticated()) {
        //     return $this->redirect('/error');
        // }
        // $this->db_manager->get('Account')->start();
        return $this->render([
            'user_name' => '',
            'password'  => '',
            'login_key' => '',
            '_token'    => $this->db_manager->get('Account')->get_token(),
            'getAccountRepository' => $this->db_manager->get('Account'),
            'getData' => $this->getContents()
        ]);
    }

    public function authenticateAction()
    {
        if ($this->session->isAuthenticated()) {
            return $this->redirect('/');
        }

        if (!$this->request->isPost()) {
            $this->forward404();
        }

        $token = $this->request->getPost('_token');
        if (!$this->checkCsrfToken('account/signin', $token)) {
            return $this->redirect('/account/signin');
        }

        $user_name = $this->request->getPost('user_name');
        $password = $this->request->getPost('password');

        $errors = [];

        if (!strlen($user_name)) {
            $errors[] = 'ユーザIDを入力してください';
        }

        if (!strlen($password)) {
            $errors[] = 'パスワードを入力してください';
        }

        if (count($errors) === 0) {
            $user_repository = $this->db_manager->get('User');
            $user = $user_repository->fetchByUserName($user_name);

            if (!$user || !password_verify($password, $user['password'])
            ) {
                $errors[] = 'ユーザIDかパスワードが不正です';
            } else {
                $this->session->setAuthenticated(true);
                $this->session->set('user', $user);

                return $this->redirect('/');
            }
        }

        return $this->render([
            'user_name' => $user_name,
            'password'  => $password,
            'errors'    => $errors,
            '_token'    => $this->generateCsrfToken('account/signin'),
        ], 'signin');
    }

    public function signoutAction()
    {
        $this->session->clear();
        $this->session->setAuthenticated(false);
        // return $this->render([
        //   'getUserRepository' => $this->db_manager->get('User')
        // ]);
        // return $this->redirect('/account/signin');
    }



}
