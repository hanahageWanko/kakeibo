<?php
if ($_GET && $_GET['id'] !== null && is_numeric($_GET['id'])) {
    if ($getUserRepository->read($_GET['id'])) {
        echo json_encode($getUserRepository->read($_GET['id']));
    } else {
        echo json_encode(Validate::resultMessage(0, 401, 'This id does not exist.'));
    }
} else {
    echo json_encode(Validate::resultMessage(0, 401, 'This id does not exist.'));
}
