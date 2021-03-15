<?php
// 渡される予定のキーを定義
$fields = ['fields' => ['category_name']];

if (!Validate::dataValidate($getData, $fields['fields'])) {
  echo json_encode(Validate::resultMessage(0, 422, 'Please Fill in all Required Fields!', $fields['fields']));
  return;
}

$getCategoryRepository->insert($getData->category_name);