<?php
  require 'env.php';
  require 'bootstrap.php';
  require 'Core.php';
  $core = new Core();
  $core->configure();
  $core->routing();