<?php $formAction = APP_URL . '/mothers/' . (int)$person['person_id'] . '/supplements/create';
$cancelUrl = APP_URL . '/mothers/' . (int)$person['person_id'] . '/supplements';
$submitLabel = 'Record Distribution';
require ROOT_PATH . '/resources/views/supplements/_distribution-form.php';
