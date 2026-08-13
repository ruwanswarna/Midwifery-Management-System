<?php
$children = $children ?? [];
$pageIntro = 'Children with vaccine doses due within 30 days or already overdue.';
$pageActions = [['label' => 'Vaccination Alerts', 'url' => '/children/vaccinations/alerts', 'primary' => true]];
$summaryCards = [['label' => 'Doses Due', 'value' => count($children)], ['label' => 'Due Soon', 'value' => count(array_filter($children, fn($c) => $c['due_status'] === 'Due Soon'))], ['label' => 'Overdue', 'value' => count(array_filter($children, fn($c) => $c['due_status'] === 'Overdue'))], ['label' => 'Children Affected', 'value' => count(array_unique(array_column($children, 'child_id')))]];
$tableColumns = ['Child', 'Family', 'Vaccine / Dose', 'Due Date', 'Status', 'Action'];
$tableRows = array_map(fn($c) => [['text' => $c['child_name'] ?? 'Unnamed', 'url' => '/children/' . $c['child_id'] . '/vaccinations'], $c['family_code'] ?? '—', trim(($c['vaccine_name'] ?? 'Not recorded') . ' dose ' . ($c['dose_number'] ?? '')), $c['due_date'] ?? '—', $c['due_status'], ['text' => 'Record', 'url' => '/children/' . $c['child_id'] . '/vaccinations/create']], $children);
$emptyTitle = 'No vaccinations due';
$emptyMessage = 'Scheduled doses will appear according to each child’s date of birth.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
