<?php
$children = $children ?? [];
$pageIntro = 'Children due or overdue for routine growth measurements.';
$pageActions = [['label' => 'View Alerts', 'url' => '/children/growth/alerts', 'primary' => true]];
$summaryCards = [['label' => 'Due / Overdue', 'value' => count($children)], ['label' => 'Never Measured', 'value' => count(array_filter($children, fn($c) => $c['last_measurement_date'] === null))], ['label' => 'Overdue', 'value' => count(array_filter($children, fn($c) => $c['due_status'] === 'Overdue'))], ['label' => 'Due Soon', 'value' => count(array_filter($children, fn($c) => $c['due_status'] === 'Due'))]];
$tableColumns = ['Child', 'Date of Birth', 'Family', 'Last Measurement', 'Next Due Date', 'Status'];
$tableRows = array_map(fn($c) => [['text' => $c['full_name'] ?? 'Unnamed', 'url' => '/children/' . $c['child_id'] . '/growth'], $c['date_of_birth'] ?? '—', $c['family_code'] ?? '—', $c['last_measurement_date'] ?? 'Never', $c['next_due_date'] ?? '—', $c['due_status']], $children);
$emptyTitle = 'No growth measurements due';
$emptyMessage = 'All registered children are up to date for the configured monthly interval.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
