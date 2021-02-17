
<?php
  if($session->isAuthenticated()) {
    echo $_content;
  } else {
    echo $_content;
    echo "エラー";
  }
?>