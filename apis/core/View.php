<?php
  class View
  {
      protected $base_dir;
      protected $defaults;
      protected $layout_variables = [];

      public function __construct($base_dir, $defaults = [])
      {
          $this->base_dir = $base_dir;
          $this->defaults = $defaults;
      }

      public function setLayoutVar($name, $value)
      {
          $this->layout_variables[$name] = $value;
      }

      // PHP-HTML-Templateを使用する場合
      public function render($_path, $_variables = [], $_layout = false)
      {
          $_file = $this->base_dir . '/' . $_path . '.php';
          extract(array_merge($this->defaults, $_variables));
          require $_file;
          $content ="";

          if ($_layout) {
              $content = $this->render(
                  $_layout,
                  array_merge($this->layout_variables, ['_content' => $content])
              );
          }
          // var_dump($content);
          return $content;
      }

      public function escape($string)
      {
          return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
      }
  }
