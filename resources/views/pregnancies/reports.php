<?php
$pregnancies = $pregnancies ?? [];
$statistics = $statistics ?? [];
$outcomes = $outcomes ?? [];
$pageIntro = '';
$pageActions = [['label' => 'All Reports', 'url' => '/reports', 'primary' => true]];
$summaryCards = [['label' => 'Active Pregnancies', 'value' => $statistics['ongoing'] ?? 0], ['label' => 'Total Registrations', 'value' => $statistics['total'] ?? count($pregnancies)], ['label' => 'High Risk', 'value' => $statistics['high_risk'] ?? 0], ['label' => 'Outcomes Recorded', 'value' => count($outcomes)]];
$tableColumns = ['Status', 'Count'];
$tableRows = array_map(fn($status) => [$status, count(array_filter($pregnancies, fn($p) => $p['current_status'] === $status))], ['Ongoing', 'Delivered', 'Transferred', 'Terminated']);
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
