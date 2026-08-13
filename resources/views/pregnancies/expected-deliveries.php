<?php
$pregnancies = $pregnancies ?? [];
$pageIntro = '';
$pageActions = [['label' => 'Pregnancy Registry', 'url' => '/pregnancies/registry', 'primary' => true]];
$summaryCards = [['label' => 'Next 7 Days', 'value' => count(array_filter($pregnancies, fn($p) => $p['expected_delivery_date'] <= date('Y-m-d', strtotime('+7 days'))))], ['label' => 'Next 60 Days', 'value' => count($pregnancies)], ['label' => 'High Risk', 'value' => count(array_filter($pregnancies, fn($p) => $p['risk_status'] === 'High'))], ['label' => 'Moderate Risk', 'value' => count(array_filter($pregnancies, fn($p) => $p['risk_status'] === 'Moderate'))]];
$tableColumns = ['Mother', 'Expected Delivery', 'Days Remaining', 'Delivery Plan', 'Risk'];
$tableRows = array_map(fn($p) => [['text' => $p['mother_name'] ?? 'Unnamed', 'url' => '/pregnancies/' . $p['pregnancy_id']], $p['expected_delivery_date'] ?? 'Not recorded', max(0, (int) floor((strtotime($p['expected_delivery_date']) - time()) / 86400)) . ' days', $p['delivery_place'] ?? 'Not recorded', $p['risk_status'] ?? 'Low'], $pregnancies);
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
