<?php

// $fields = ['fields' => ['id']];

// if (!Validate::dataValidate($_GET['id'], $fields['fields'])) {
//   echo json_encode(Validate::resultMessage(0, 422, 'Please Fill in all Required Fields!', $fields['fields']));
//   return;
// }

if ($_GET && $_GET['id'] !== null && is_numeric($_GET['id'])) {
    if ($getAuthRepository->read($_GET['id'])) {
        echo json_encode($getAuthRepository->read($_GET['id']));
    } else {
        echo json_encode(Validate::resultMessage(0, 401, 'This id does not exist.'));
    }
} else {
    echo json_encode(Validate::resultMessage(0, 401, 'This id does not exist.'));
}
