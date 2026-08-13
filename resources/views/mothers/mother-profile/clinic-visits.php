<?php $rows = $clinicVisits ?? [];
$pageIntro = 'Clinic appointments and attendance recorded for ' . $mother['full_name'] . '.';
$pageActions = [];
$summaryCards = [['label' => 'Appointments', 'value' => count($rows)], ['label' => 'Completed', 'value' => count(array_filter($rows, static fn($r) => $r['appointment_status'] === 'Completed'))], ['label' => 'Missed', 'value' => count(array_filter($rows, static fn($r) => $r['appointment_status'] === 'Missed'))], ['label' => 'Follow-up Required', 'value' => count(array_filter($rows, static fn($r) => (int)$r['follow_up_required'] === 1))]];
$tableColumns = ['Date and Time', 'Clinic', 'Type', 'Location', 'Status', 'Follow-up'];
$tableRows = array_map(static fn($r) => [$r['appointment_datetime'], $r['session_type'], $r['appointment_type'], $r['location'], $r['appointment_status'], (int)$r['follow_up_required'] === 1 ? 'Required' : 'No'], $rows);
$emptyTitle = 'No clinic visits';
$emptyMessage = 'Clinic appointments for this mother will appear here.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
