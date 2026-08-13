<?php
$records = $records ?? [];
$statistics = $statistics ?? [];
$dueChildren = $dueChildren ?? [];
$alerts = $alerts ?? [];
$pageIntro = '';
$pageActions = [['label' => 'Vaccinations Due', 'url' => '/children/vaccinations/overdue'], ['label' => 'Vaccination Alerts', 'url' => '/children/vaccinations/alerts', 'primary' => true]];
$summaryCards = [['label' => 'Administered', 'value' => $statistics['administered'] ?? 0], ['label' => 'This Month', 'value' => $statistics['administered_this_month'] ?? 0], ['label' => 'Doses Due', 'value' => count($dueChildren)], ['label' => 'Alerts', 'value' => count($alerts)]];
$tableColumns = ['Child', 'Family', 'Vaccine', 'Dose', 'Given Date', 'Status', 'Administered By', 'Action'];
$tableRows = array_map(static fn($r) => [$r['child_name'], $r['family_code'], $r['vaccine_name'], $r['dose_number'], $r['vaccination_date'], $r['vaccination_status'], $r['administered_by_name'], ['text' => 'Schedule', 'url' => '/children/' . $r['child_id'] . '/vaccinations']], array_slice($records, 0, 15));
$emptyTitle = 'No vaccination records';
$emptyMessage = 'Record a vaccination from an individual child profile.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
