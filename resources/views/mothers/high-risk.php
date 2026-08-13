<?php
$mothers = $mothers ?? [];
$pageIntro = 'Prioritize mothers with clinical, obstetric or social risk factors requiring closer follow-up.';
$pageActions = [['label' => 'Mother Registry', 'url' => '/mothers/registry', 'primary' => true]];
$summaryCards = [['label' => 'High-risk Mothers', 'value' => count($mothers)], ['label' => 'Urgent Review', 'value' => $urgentCount ?? 0], ['label' => 'Visit Due', 'value' => $visitDueCount ?? 0], ['label' => 'Clinic Due', 'value' => $clinicDueCount ?? 0]];
$tableColumns = ['Mother', 'Risk Factor', 'Pregnancy', 'Next Follow-up', 'Priority'];
$tableRows = array_map(fn($m) => [['text' => $m['full_name'] ?? 'Unnamed', 'url' => '/mothers/' . $m['person_id']], $m['risk_status'] ?? 'High', $m['maternal_status'] ?? 'Pregnant', $m['expected_delivery_date'] ?? 'Not scheduled', 'High'], $mothers);
$emptyTitle = 'No high-risk mothers found';
$emptyMessage = 'Mothers marked with risk factors will be listed here for follow-up.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
