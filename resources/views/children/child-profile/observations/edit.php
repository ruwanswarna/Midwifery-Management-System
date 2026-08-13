<?php $formAction = APP_URL . '/children/' . (int) $child['person_id'] . '/observations/' . (int) $record['observation_id'] . '/update';
$submitLabel = 'Save Observation';
require ROOT_PATH . '/resources/views/children/child-profile/observations/_form.php';
