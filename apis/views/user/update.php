<?php
 $fields = ['fields' => ['email', 'user_name']];
 
  if (!isset($getData->id) || empty($getData->id)) {
    echo json_encode(Validate::resultMessage(0, 422, 'empty id', $fields['fields']));
    return;
  }
  
  if ($getData->email && !Validate::mailFormat($getData->email, 'Invalid Email Address!')) {
    return;
  }
  
  if ($getData->user_name && !Validate::lessThanStr($getData->user_name, 1, 'Your name must be at least 1 characters long!')) {
    return;
  }
  
  $getUserRepository->update($getData->id, $getData->email, $getData->user_name);