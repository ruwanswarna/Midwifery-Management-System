<?php
$mothers = $mothers ?? [];
$pageIntro = 'Plan follow-ups for pregnancies approaching their estimated delivery date.';
$pageActions = [['label' => 'Pregnancy Registry', 'url' => '/pregnancies/registry', 'primary' => true]];
$summaryCards = [['label' => 'Due in 7 Days', 'value' => $dueSevenDays ?? 0], ['label' => 'Due in 30 Days', 'value' => count($mothers)], ['label' => 'High Risk', 'value' => $highRiskCount ?? 0], ['label' => 'Overdue', 'value' => $overdueCount ?? 0]];
$tableColumns = ['Mother', 'Expected Delivery', 'Gestation', 'Risk', 'Contact'];
$tableRows = array_map(fn($m) => [['text' => $m['full_name'] ?? 'Unnamed', 'url' => '/mothers/' . $m['person_id']], $m['expected_delivery_date'] ?? 'Not recorded', 'Ongoing', $m['risk_status'] ?? 'Low', $m['phone'] ?? 'Not recorded'], $mothers);
$emptyTitle = 'No upcoming deliveries';
$emptyMessage = 'Pregnancies with an expected delivery date in the selected period will appear here.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
