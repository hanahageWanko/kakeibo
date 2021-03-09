<?php
if($session->isAuthenticated()) {
  json_encode($_content);
} else {
  json_encode('認証がありません');
}