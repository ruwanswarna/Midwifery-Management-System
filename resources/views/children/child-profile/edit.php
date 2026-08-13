<?php
$formAction = APP_URL . '/children/' . (int) $child['person_id'] . '/update';
$submitLabel = 'Save Changes';
require ROOT_PATH . '/resources/views/children/child-profile/_form.php';
