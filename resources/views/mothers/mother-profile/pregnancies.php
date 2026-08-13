<?php $rows = $pregnancies ?? [];
$pageIntro = 'Complete pregnancy history for ' . $mother['full_name'] . '.';
$pageActions = [['label' => 'Register Pregnancy', 'url' => '/pregnancies/create', 'primary' => true]];
$summaryCards = [['label' => 'Total Pregnancies', 'value' => count($rows)], ['label' => 'Ongoing', 'value' => count(array_filter($rows, static fn($r) => $r['current_status'] === 'Ongoing'))], ['label' => 'Delivered', 'value' => count(array_filter($rows, static fn($r) => $r['current_status'] === 'Delivered'))], ['label' => 'High Risk', 'value' => count(array_filter($rows, static fn($r) => $r['risk_status'] === 'High'))]];
$tableColumns = ['Pregnancy', 'Registered', 'LMP', 'Expected Delivery', 'Risk', 'Status', 'Action'];
$tableRows = array_map(static fn($r) => ['#' . $r['pregnancy_id'], $r['registered_date'], $r['last_menstrual_period'], $r['expected_delivery_date'], $r['risk_status'], $r['current_status'], ['text' => 'View', 'url' => '/pregnancies/' . $r['pregnancy_id']]], $rows);
$emptyTitle = 'No pregnancy history';
$emptyMessage = 'No pregnancies have been registered for this mother.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
