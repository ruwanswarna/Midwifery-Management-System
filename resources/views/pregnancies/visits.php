<?php
$visits = $visits ?? [];
$pageIntro = '';
$pageActions = [['label' => 'Schedule Field Visit', 'url' => '/field-visits/create', 'primary' => true]];
$summaryCards = [['label' => 'Visits This Month', 'value' => count($visits)], ['label' => 'Due Today', 'value' => $dueTodayCount ?? 0], ['label' => 'Overdue', 'value' => $overdueCount ?? 0], ['label' => 'Completed', 'value' => $completedCount ?? 0]];
$tableColumns = ['Mother', 'Visit Type', 'Scheduled Date', 'Status', 'Follow-up'];
$tableRows = array_map(fn($v) => [$v['mother_name'] ?? 'Unnamed', $v['visit_type'] ?? 'Routine', $v['visit_date'] ?? 'Not scheduled', $v['visit_status'] ?? 'Completed', $v['follow_up_date'] ?? '—'], $visits);
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
