<?php
// 渡される予定のキーを定義
$fields = ['fields' => ['user_id', 'color', 'category_name']];

if (!Validate::dataValidate($getData, $fields['fields'])) {
    echo json_encode(Validate::resultMessage(0, 422, 'Please Fill in all Required Fields!', $fields['fields']));
    return;
}

if (!Validate::justSizeStr($getData->color, 6, 'The color must be 6 characters.')) {
    return;
}

$getCategoryRepository->insert($getData->user_id, $getData->color, $getData->category_name);
