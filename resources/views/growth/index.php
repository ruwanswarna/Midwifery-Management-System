<?php
$growthRecords = $growthRecords ?? [];
$statistics = $statistics ?? [];
$dueChildren = $dueChildren ?? [];
$alerts = $alerts ?? [];
$pageIntro = '';
$pageActions = [['label' => 'Measurements Due', 'url' => '/children/growth/overdue'], ['label' => 'Growth Alerts', 'url' => '/children/growth/alerts', 'primary' => true]];
$summaryCards = [['label' => 'Measurements', 'value' => $statistics['total_measurements'] ?? 0], ['label' => 'Measured This Month', 'value' => $statistics['measured_this_month'] ?? 0], ['label' => 'Monitoring Due', 'value' => count($dueChildren)], ['label' => 'Current Alerts', 'value' => count($alerts)]];
$tableColumns = ['Child', 'Family', 'Measured', 'Weight', 'Height', 'Growth Status', 'Measured By', 'Action'];
$tableRows = array_map(static fn($r) => [$r['child_name'], $r['family_code'], $r['measurement_date'], $r['weight_kg'] !== null ? $r['weight_kg'] . ' kg' : '—', $r['height_cm'] !== null ? $r['height_cm'] . ' cm' : '—', $r['growth_status'] ?? 'Not assessed', $r['measured_by_name'], ['text' => 'History', 'url' => '/children/' . $r['child_id'] . '/growth']], array_slice($growthRecords, 0, 15));
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
