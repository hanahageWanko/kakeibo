<?php
// 渡される予定のキーを定義
$fields = ['fields' => ['id', 'category_name']];

if (!Validate::dataValidate($getData, $fields['fields'])) {
  echo json_encode(Validate::resultMessage(0, 422, 'Please Fill in all Required Fields!', $fields['fields']));
  return;
}

$getCategoryRepository->update($getData->id, $getData->category_name);