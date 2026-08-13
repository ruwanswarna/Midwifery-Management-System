<?php
$mothers = $mothers ?? [];
$statistics = $statistics ?? [];
$pageIntro = '';
$pageActions = [['label' => 'Open Registry', 'url' => '/mothers/registry'], ['label' => 'Register Mother', 'url' => '/mothers/create', 'primary' => true]];
$summaryCards = [['label' => 'Registered Mothers', 'value' => $statistics['total'] ?? 0], ['label' => 'Currently Pregnant', 'value' => $statistics['pregnant'] ?? 0], ['label' => 'High Risk', 'value' => $statistics['high_risk'] ?? 0], ['label' => 'Deliveries Due', 'value' => $statistics['deliveries_due'] ?? 0, 'hint' => 'Within the next 30 days']];
$tableColumns = ['Mother', 'NIC', 'Family', 'PHM Area', 'Maternal Status', 'Risk', 'Action'];
$tableRows = array_map(static fn($m) => [$m['full_name'], $m['nic'] ?? 'Not recorded', $m['family_code'], $m['phm_area_name'], $m['maternal_status'], $m['risk_status'] ?? '—', ['text' => 'View profile', 'url' => '/mothers/' . $m['person_id']]], $mothers);
$emptyTitle = 'No maternal profiles';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
