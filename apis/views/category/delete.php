<?php
  
  $fields = ['fields' => ['id']];
  if (!isset($getData->id) || empty($getData->id)) {
      echo json_encode(Validate::resultMessage(0, 422, 'Missing elements！', $fields['fields']));
      return;
  }
  
  $getCategoryRepository->delete($getData->id);
