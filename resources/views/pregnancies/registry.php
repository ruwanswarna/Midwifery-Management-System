<?php
$pregnancies = $pregnancies ?? [];
$statistics = $statistics ?? [];
$pageIntro = 'Search and review all pregnancy registrations and their current care status.';
$pageActions = [['label' => 'Register Pregnancy', 'url' => '/pregnancies/create', 'primary' => true]];
$summaryCards = [['label' => 'Total Records', 'value' => $statistics['total'] ?? count($pregnancies)], ['label' => 'Ongoing', 'value' => $statistics['ongoing'] ?? 0], ['label' => 'Delivered', 'value' => $statistics['delivered'] ?? 0], ['label' => 'High Risk', 'value' => $statistics['high_risk'] ?? 0]];
$tableColumns = ['Registration No.', 'Mother', 'LMP', 'Expected Delivery', 'Status'];
$tableRows = array_map(fn($p) => ['#' . $p['pregnancy_id'], ['text' => $p['mother_name'] ?? 'Unnamed', 'url' => '/pregnancies/' . $p['pregnancy_id']], $p['last_menstrual_period'] ?? 'Not recorded', $p['expected_delivery_date'] ?? 'Not recorded', $p['current_status'] ?? 'Ongoing'], $pregnancies);
$emptyTitle = 'No pregnancies registered';
$emptyMessage = 'New pregnancy registrations will appear in this registry.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
