<?php
// 渡される予定のキーを定義
$fields = ['fields' => ['email', 'password', 'user_name']];

if (!Validate::dataValidate($getData, $fields['fields'])) {
  echo json_encode(Validate::resultMessage(0, 422, 'Please Fill in all Required Fields!', $fields['fields']));
  return;
}

if (!Validate::mailFormat($getData->email, 'Invalid Email Address!')) {
  return;
}

if (!Validate::lessThanStr($getData->password, 8, 'Your password must be at least 8 characters long!')) {
  return;
}

if (!Validate::lessThanStr($getData->user_name, 3, 'Your name must be at least 3 characters long!')) {
  return;
}

$getAuthRepository->insert($getData->email, $getData->password, $getData->user_name);