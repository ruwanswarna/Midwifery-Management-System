<?php
$alerts = $alerts ?? [];
$pageIntro = 'Children whose latest recorded growth status requires clinical review.';
$pageActions = [['label' => 'Children Due', 'url' => '/children/growth/overdue', 'primary' => true]];
$summaryCards = [['label' => 'Active Alerts', 'value' => count($alerts)], ['label' => 'Severe', 'value' => count(array_filter($alerts, fn($a) => str_starts_with($a['growth_status'] ?? '', 'Severely')))], ['label' => 'Underweight', 'value' => count(array_filter($alerts, fn($a) => str_contains($a['growth_status'] ?? '', 'Underweight')))], ['label' => 'Wasted', 'value' => count(array_filter($alerts, fn($a) => str_contains($a['growth_status'] ?? '', 'Wasted')))]];
$tableColumns = ['Child', 'Alert Type', 'Latest Status', 'Severity', 'Measured Date'];
$tableRows = array_map(fn($a) => [['text' => $a['child_name'] ?? 'Unnamed', 'url' => '/children/' . $a['child_id'] . '/growth'], 'Growth review', $a['growth_status'] ?? 'Needs review', str_starts_with($a['growth_status'] ?? '', 'Severely') ? 'Severe' : 'Moderate', $a['measurement_date'] ?? 'Not recorded'], $alerts);
$emptyTitle = 'No active growth alerts';
$emptyMessage = 'All latest recorded growth statuses are normal.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
