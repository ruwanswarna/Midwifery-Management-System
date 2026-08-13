<?php
$children = $children ?? [];
$statistics = $statistics ?? [];
$pageIntro = '';
$pageActions = [['label' => 'All Reports', 'url' => '/reports', 'primary' => true]];
$summaryCards = [['label' => 'Registered Children', 'value' => $statistics['total'] ?? 0], ['label' => 'Under One', 'value' => $statistics['under_one'] ?? 0], ['label' => 'Under Five', 'value' => $statistics['under_five'] ?? 0], ['label' => 'Special Needs', 'value' => $statistics['special_needs'] ?? 0]];
$tableColumns = ['Child', 'Family', 'Age', 'Growth Status', 'Latest Measurement', 'Action'];
$tableRows = array_map(fn($c) => [$c['full_name'], $c['family_code'], $c['age_months'] . ' months', $c['growth_status'] ?? 'Not assessed', $c['measurement_date'] ?? 'Never', ['text' => 'View', 'url' => '/children/' . $c['person_id']]], $children);
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
