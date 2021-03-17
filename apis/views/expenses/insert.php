<?php
// 渡される予定のキーを定義
$fields = ['fields' => ['money', 'user_id', 'category_id']];

if (!Validate::dataValidate($getData, $fields['fields'])) {
    echo json_encode(Validate::resultMessage(0, 422, 'Please Fill in all Required Fields!', $fields['fields']));
    return;
}

if (!Validate::limitHalfSizeNumber($getData->money, 'Please enter half-size numbers')) {
    return;
}

$getExpensesRepository->insert($getData->money, $getData->user_id, $getData->category_id);
