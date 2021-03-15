<?php
  
  if (!isset($getData->id) || empty($getData->id)) {
    echo json_encode(Validate::resultMessage(0, 422, 'empty id', $fields['fields']));
    return;
  }
  
  if ($getData->email && !Validate::mailFormat($getData->email, 'Invalid Email Address!')) {
    return;
  }
  
  if ($getData->password && !Validate::lessThanStr($getData->password, 8, 'Your password must be at least 8 characters long!')) {
    return;
  }
  
  $getUserRepository->update($getData->id, $getData->email, $getData->user_name);