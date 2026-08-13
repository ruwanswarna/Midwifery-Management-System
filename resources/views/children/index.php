<?php
$children = $children ?? [];
$statistics = $statistics ?? [];
$pageIntro = '';
$pageActions = [['label' => 'Open Registry', 'url' => '/children/registry'], ['label' => 'Register Child', 'url' => '/children/create', 'primary' => true]];
$summaryCards = [
    ['label' => 'Registered Children', 'value' => $statistics['total'] ?? 0, 'hint' => 'All child health records'],
    ['label' => 'Under One Year', 'value' => $statistics['under_one'] ?? 0, 'hint' => 'Priority infant-care group'],
    ['label' => 'Under Five Years', 'value' => $statistics['under_five'] ?? 0, 'hint' => 'Growth monitoring group'],
    ['label' => 'Special Needs', 'value' => $statistics['special_needs'] ?? 0, 'hint' => 'Recorded at registration'],
];
$tableColumns = ['Child', 'Age', 'Family', 'Latest Growth', 'Vaccination', 'Registered'];
$tableRows = array_map(static fn(array $c): array => [
    ['text' => $c['full_name'] ?? 'Unnamed', 'url' => '/children/' . (int) $c['person_id']],
    isset($c['age_months']) ? $c['age_months'] . ' months' : 'Not recorded',
    $c['family_code'] ?? '—',
    $c['growth_status'] ?? 'Not assessed',
    $c['vaccination_status'] ?? 'No records',
    $c['registered_date'] ?? '—',
], $children);
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
