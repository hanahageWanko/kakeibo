<?php
  
  $fields = ['fields' => ['auth_id', 'email', 'user_name']];
  if (!isset($getData->auth_id) || empty($getData->auth_id)) {
      echo json_encode(Validate::resultMessage(0, 422, 'Missing elements！', $fields['fields']));
      return;
  }
  
  if ($getData->email && !Validate::mailFormat($getData->email, 'Invalid Email Address!')) {
      return;
  }
  
  if (!Validate::lessThanStr($getData->user_name, 3, 'Your name must be at least 3 characters long!')) {
      return;
  }
  
  $getAuthRepository->update($getData->auth_id, $getData->email, $getData->user_name);
