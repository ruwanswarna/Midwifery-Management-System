<?php $formAction = APP_URL . '/children/' . (int)$person['person_id'] . '/supplements/' . (int)$record['distribution_id'] . '/update';
$cancelUrl = APP_URL . '/children/' . (int)$person['person_id'] . '/supplements';
$submitLabel = 'Save Distribution';
require ROOT_PATH . '/resources/views/supplements/_distribution-form.php';
