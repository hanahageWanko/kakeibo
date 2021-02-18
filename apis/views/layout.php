
<?php
  if($session->isAuthenticated()) {
    echo $_content;
    echo "OK";
  } else {
    echo $_content;
    echo "エラー";
  }
?>