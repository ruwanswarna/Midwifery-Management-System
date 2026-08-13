<?php $visits = $visits ?? [];
$pageIntro = 'Field visits recorded for ' . $family['registration_number'] . '.';
$pageActions = [['label' => 'Record Field Visit', 'url' => '/field-visits/create', 'primary' => true]];
$summaryCards = [['label' => 'Total Visits', 'value' => count($visits)], ['label' => 'Completed', 'value' => count(array_filter($visits, fn($v) => $v['visit_status'] === 'Completed'))], ['label' => 'Risks Identified', 'value' => count(array_filter($visits, fn($v) => (int)$v['risk_identified'] === 1))], ['label' => 'Follow-ups', 'value' => count(array_filter($visits, fn($v) => (int)$v['follow_up_required'] === 1))]];
$tableColumns = ['Date', 'Type', 'Person', 'Staff', 'Status', 'Risk', 'Follow-up', 'Action'];
$tableRows = array_map(fn($v) => [$v['visit_date'], $v['visit_type'], $v['person_name'] ?? 'Whole family', $v['staff_name'], $v['visit_status'], (int)$v['risk_identified'] === 1 ? 'Identified' : 'No', $v['follow_up_date'] ?? '—', ['text' => 'View', 'url' => '/field-visits/' . $v['visit_id']]], $visits);
$emptyTitle = 'No family field visits';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
