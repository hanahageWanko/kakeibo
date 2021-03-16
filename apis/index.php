<?php
  date_default_timezone_set('Asia/Tokyo');
  require 'env.php';
  require 'bootstrap.php';
  require 'Core.php';
  $core = new Core(true);
  $core->run();
