<?php
$pregnancies = $pregnancies ?? [];
$statistics = $statistics ?? [];
$pageIntro = '';
$pageActions = [['label' => 'Open Registry', 'url' => '/pregnancies/registry'], ['label' => 'Register Pregnancy', 'url' => '/pregnancies/create', 'primary' => true]];
$summaryCards = [['label' => 'Active Pregnancies', 'value' => $statistics['ongoing'] ?? 0], ['label' => 'High Risk', 'value' => $statistics['high_risk'] ?? 0], ['label' => 'Deliveries Due', 'value' => $statistics['deliveries_due'] ?? 0, 'hint' => 'Within 30 days'], ['label' => 'Delivered', 'value' => $statistics['delivered'] ?? 0]];
$tableColumns = ['Mother', 'Registration Date', 'Expected Delivery', 'Risk', 'Status'];
$tableRows = array_map(fn($p) => [['text' => $p['mother_name'] ?? 'Unnamed', 'url' => '/pregnancies/' . $p['pregnancy_id']], $p['registration_date'] ?? '—', $p['expected_delivery_date'] ?? 'Not recorded', $p['risk_status'] ?? 'Low', $p['current_status'] ?? 'Ongoing'], array_slice($pregnancies, 0, 8));
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
