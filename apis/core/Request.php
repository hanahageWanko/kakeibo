<?php
  class Request
  {
      public function isPost()
      {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              return true;
          }
      }

      public function isGet()
      {
          if ($_SERVER['REQUEST_METHOD'] === 'GET') {
              return true;
          }
      }

      public function isDelete()
      {
          if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
              return true;
          }
      }

      public function isPut()
      {
          if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
              return true;
          }
      }

      public function getGet($name, $default = null)
      {
          if (isset($_GET[$name])) {
              return $_GET[$name];
          }
          return $default;
      }

      public function getPost($name, $default = null)
      {
          if (isset($_POST[$name])) {
              return $_POST[$name];
          }
          return $default;
      }

      public function getHost()
      {
          if (!empty($_SERVER['HTTP_HOST'])) {
              return $_SERVER['HTTP_HOST'];
          }
          return $_SERVER['SERVER_NAME'];
      }

      public function isSsl()
      {
          if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
              return true;
          }
          return false;
      }

      public function getRequestUri()
      {
          return $_SERVER['REQUEST_URI'];
      }

      public function getBaseUrl() {
        $script_name = $_SERVER['SCRIPT_NAME'];
        $request_uri = $this->getRequestUri();

        if(0 === strpos($request_uri, $script_name)) {
          return $script_name;
        } else if (0 === strpos($request_name, dirname($script_name))) {
          return rtrim(driname($script_name), '/');
        }
      }

      public function getPathInfo() {
        $base_url = $this->getBaseUrl();
        $request_uri = $this->getRequestUri();

        if(false !== ($post = strpos($request_uri, '?'))) {
          $request_uri = substr($request_uri, 0, $pos);
        }

        $path_info = (string)substr($request_uri, strlen($base_url));

        return $path_info;
      }
      
  }
