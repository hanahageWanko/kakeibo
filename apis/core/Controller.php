<?php
  class Controller {
    protected $controller_name;
    protected $action_name;
    protected $application;
    protected $request;
    protected $response;
    protected $session;
    protected $db_manager;
    protected $auth_actions = [];

    public function __construct($application)
    {
      var_dump('sssss');
        // 自分自身のクラス名を取得し、Controllerの文字数分を取り除き小文字に変換
        $this->application = $application;
        $this->request     = $application->getRequest();
        $this->response    = $application->getResponse();
        $this->session     = $application->getSession();
        $this->db_manager  = $application->getDbManager();
    }

    protected function generateCsrfToken($form_name)
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->session->get($key, []);
        if (count($tokens >= 10)) {
            array_shift($tokens);
        }

        $token = sha1($form_name . session_id() . microtime());
        $tokens[] = $token;

        $this->session->set($key, $tokens);

        return $token;
    }

    protected function checkCsrfToken($form_name, $token)
    {
        $key = 'csrf_tokens' . $form_name;
        $tokens = $this->session->get($key, []);

        if (false !== ($pos = array_search($token, $tokens, true))) {
            unset($tokens[$pos]);
            $this->session->set($key, $tokens);

            return true;
        }
        return false;
    }
}