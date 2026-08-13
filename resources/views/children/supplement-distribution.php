<?php
$distributions = $distributions ?? [];
$pageIntro = 'Track child supplement eligibility, distribution history and overdue requirements.';
$pageActions = [['label' => 'Supplement Dashboard', 'url' => '/supplements/children', 'primary' => true]];
$summaryCards = [['label' => 'Distributed This Month', 'value' => count($distributions)], ['label' => 'Due Soon', 'value' => $dueCount ?? 0], ['label' => 'Overdue', 'value' => $overdueCount ?? 0], ['label' => 'Stock Alerts', 'value' => $stockAlertCount ?? 0]];
$tableColumns = ['Child', 'Supplement', 'Quantity', 'Distributed Date', 'Next Due', 'Recorded By'];
$tableRows = array_map(fn($d) => [$d['full_name'] ?? 'Unnamed', $d['supplement_name'] ?? 'Not recorded', $d['quantity'] ?? '—', $d['distribution_date'] ?? '—', $d['next_due_date'] ?? '—', $d['staff_name'] ?? 'Not recorded'], $distributions);
$emptyTitle = '';
$emptyMessage = 'Supplement distributions recorded for children will appear here.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
