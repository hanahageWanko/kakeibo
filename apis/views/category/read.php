<?php
if ($_GET && $_GET['user_id'] !== null && is_numeric($_GET['user_id'])) {
    if ($getCategoryRepository->read($_GET['user_id'])) {
        echo json_encode($getCategoryRepository->read($_GET['user_id']));
    } else {
        echo json_encode(Validate::resultMessage(0, 401, 'This id does not exist.'));
    }
} else {
    echo json_encode(Validate::resultMessage(0, 401, 'This id does not exist.'));
}
