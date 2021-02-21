<?php
  require 'core/ClassLoader.php';

  $loader = new ClassLoader();
  $loader->registerDir(dirname(__FILE__).'/core');
  $loader->registerDir(dirname(__FILE__).'/models');
  $loader->register();
  // users
  Router::set('users', function () {
    View::make('users/index');
  });

  Router::set('users/read', function () {
    View::make('users/read');
  });
