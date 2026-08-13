<?php $formAction = APP_URL . '/supplements/distributions/' . (int)$record['distribution_id'] . '/update';
$cancelUrl = APP_URL . '/supplements';
$submitLabel = 'Save Distribution';
require ROOT_PATH . '/resources/views/supplements/_distribution-form.php';
