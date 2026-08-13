<?php
$distributions = $distributions ?? [];
$statistics = $statistics ?? [];
$pageIntro = '';
$pageActions = [['label' => 'All Reports', 'url' => '/reports', 'primary' => true]];
$summaryCards = [['label' => 'Total Distributions', 'value' => $statistics['total_distributions'] ?? 0], ['label' => 'This Month', 'value' => $statistics['distributed_this_month'] ?? 0], ['label' => 'Due Soon', 'value' => $statistics['due_count'] ?? 0], ['label' => 'Overdue', 'value' => $statistics['overdue_count'] ?? 0]];
$tableColumns = ['Supplement', 'Recipient Type', 'Distribution Records', 'Total Quantity'];
$groups = [];
foreach ($distributions as $d) {
	$key = $d['supplement_name'] . '|' . $d['recipient_type'];
	$groups[$key] ??= ['name' => $d['supplement_name'], 'type' => $d['recipient_type'], 'count' => 0, 'qty' => 0, 'unit' => $d['unit']];
	$groups[$key]['count']++;
	$groups[$key]['qty'] += (float)$d['quantity'];
}
$tableRows = array_map(static fn($g) => [$g['name'], $g['type'], $g['count'], $g['qty'] . ' ' . $g['unit']], array_values($groups));
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
