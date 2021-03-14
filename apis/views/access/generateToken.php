<?php
$fields = ['fields' => ['token']];

if (!Validate::dataValidate($getData, $fields['fields'])) {
  echo json_encode(Validate::resultMessage(0, 422, 'Please Fill in all Required Fields!', $fields['fields']));
  return;
}
$publishToken->generateCsrfToken($getData->token);
