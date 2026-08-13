<?php
$outcomes = $outcomes ?? [];
$pageIntro = '';
$pageActions = [['label' => 'Pregnancy Registry', 'url' => '/pregnancies/registry', 'primary' => true]];
$summaryCards = [['label' => 'Recorded Outcomes', 'value' => count($outcomes)], ['label' => 'Live Births', 'value' => count(array_filter($outcomes, fn($o) => str_starts_with($o['outcome_type'] ?? '', 'Live Birth')))], ['label' => 'Still Births', 'value' => count(array_filter($outcomes, fn($o) => ($o['outcome_type'] ?? '') === 'Still Birth'))], ['label' => 'Pending Records', 'value' => $pendingCount ?? 0]];
$tableColumns = ['Mother', 'Delivery Date', 'Outcome', 'Delivery Mode', 'Mother Status', 'Children Registered'];
$tableRows = array_map(fn($o) => [$o['mother_name'] ?? 'Unnamed', $o['delivery_date'] ?? 'Not recorded', $o['outcome_type'] ?? 'Not recorded', $o['delivery_mode'] ?? 'Not recorded', $o['mother_status'] ?? 'Not recorded', $o['registered_children'] ?? 0], $outcomes);
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
