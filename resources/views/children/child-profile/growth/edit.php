<?php $formAction = APP_URL . '/children/' . (int) $child['person_id'] . '/growth/' . (int) $record['measurement_id'] . '/update';
$submitLabel = 'Save Measurement';
require ROOT_PATH . '/resources/views/children/child-profile/growth/_form.php';
