<?php $rows = $fieldVisits ?? [];
$pageIntro = 'Home and field visits recorded for ' . $mother['full_name'] . '.';
$pageActions = [];
$summaryCards = [['label' => 'Total Visits', 'value' => count($rows)], ['label' => 'Risks Identified', 'value' => count(array_filter($rows, static fn($r) => (int)$r['risk_identified'] === 1))], ['label' => 'Follow-ups', 'value' => count(array_filter($rows, static fn($r) => (int)$r['follow_up_required'] === 1))], ['label' => 'Completed', 'value' => count(array_filter($rows, static fn($r) => $r['visit_status'] === 'Completed'))]];
$tableColumns = ['Visit Date', 'Type', 'Status', 'Staff', 'Risk', 'Follow-up Date', 'Observations'];
$tableRows = array_map(static fn($r) => [$r['visit_date'], $r['visit_type'], $r['visit_status'], $r['staff_name'], (int)$r['risk_identified'] === 1 ? 'Identified' : 'No', $r['follow_up_date'] ?? '—', $r['observations'] ?? '—'], $rows);
$emptyTitle = 'No field visits';
$emptyMessage = 'Field visits for this mother will appear here.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
