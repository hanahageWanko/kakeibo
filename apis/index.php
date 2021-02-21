<?php
  require 'vendor/autoload.php';
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();
  require 'bootstrap.php';
  require 'Core.php';
  $core = new Core();
  $core->configure();