<?php
$families = $families ?? [];


$pageActions = [['label' => 'Open Registry', 'url' => '/families/registry'], ['label' => 'Register Family', 'url' => '/families/create', 'primary' => true]];

$summaryCards = [
    ['label' => 'Registered Families', 'value' => count($families), 'hint' => 'All family records'],
    ['label' => 'Active Families', 'value' => count(array_filter($families, fn($f) => ($f['status'] ?? '') === 'Active'))],
    ['label' => 'Inactive Families', 'value' => count(array_filter($families, fn($f) => ($f['status'] ?? '') === 'Inactive'))],
    ['label' => 'Follow-ups Due', 'value' => 0, 'hint' => 'Connect field-visit data'],
];

$tableColumns = ['Registration No.', 'Address', 'PHM Area', 'Status'];

$tableRows = array_map(fn($f) => [$f['family_code'] ?? $f['family_id'] ?? '—', $f['address'] ?? 'Not recorded', $f['phm_area_name'] ?? 'Not assigned', $f['status'] ?? 'Unknown'], array_slice($families, 0, 8));

$emptyTitle = 'No family summary is available';

$emptyMessage = '';

require ROOT_PATH . '/resources/views/partials/module-page.php';
