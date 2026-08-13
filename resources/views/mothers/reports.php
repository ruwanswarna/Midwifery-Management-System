<?php
$mothers = $mothers ?? [];
$statistics = $statistics ?? [];

$pageActions = [['label' => 'All Reports', 'url' => '/reports', 'primary' => true]];
$summaryCards = [['label' => 'Registered Mothers', 'value' => $statistics['total'] ?? count($mothers)], ['label' => 'Currently Pregnant', 'value' => $statistics['pregnant'] ?? 0], ['label' => 'High Risk', 'value' => $statistics['high_risk'] ?? 0], ['label' => 'Deliveries Due', 'value' => $statistics['deliveries_due'] ?? 0]];
$tableColumns = ['PHM Area', 'Registered Mothers', 'Active Pregnancies', 'High Risk'];
$areas = [];
foreach ($mothers as $mother) { $area=$mother['phm_area_name']; $areas[$area]??=['total'=>0,'pregnant'=>0,'high'=>0]; $areas[$area]['total']++; $areas[$area]['pregnant'] += $mother['maternal_status']==='Pregnant'; $areas[$area]['high'] += $mother['risk_status']==='High'; }
$tableRows = array_map(fn($area,$counts)=>[$area,$counts['total'],$counts['pregnant'],$counts['high']],array_keys($areas),array_values($areas));
$emptyTitle = 'No maternal reports generated';

require ROOT_PATH . '/resources/views/partials/module-page.php';
