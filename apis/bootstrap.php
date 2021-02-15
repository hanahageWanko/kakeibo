<?php
  require 'vendor/autoload.php';
  require 'core/ClassLoader.php';
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();

  $loader = new ClassLoader();
  $loader->registerDir(__DIR__ . '/core');
  $loader->registerDir(__DIR__ . '/models');
  $loader->register();

