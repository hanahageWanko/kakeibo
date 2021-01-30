<?php
  abstract class Controller
  {
      protected $controller_name;
      protected $action_name;
      protected $application;
      protected $request;
      protected $response;
      protected $session;
      protected $db_manager;
      protected $auth_actions = [];
    
      public function __construct($appklication)
      {
          $this->controller_name = strtolower(substr(get_class($this), 0, -10));

          $this->application = $application;
          $this->request     = $application->getRequest();
          $this->response    = $application->getResponse();
          $this->session     = $application->getSession();
          $this->db_manager  = $application->getDbManager();
      }

      public function run($action, $params = [])
      {
          $this->action_name = $action;

          $action_method = $action . 'Action';
          if (!method_exists($this, $action_method)) {
              $this->forward404();
          }

          $content = $this->$action_method($params);
          return $content;
      }

      public function forward404()
      {
      }
  }