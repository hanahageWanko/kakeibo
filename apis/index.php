<?php
  require 'core/ClassLoader.php';

  $loader = new ClassLoader();
  $loader->registerDir(__DIR__ . '/core');
  $loader->registerDir(__DIR__ . '/models');
  $loader->register();
  var_dump($loader);