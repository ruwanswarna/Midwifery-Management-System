<?php
$alerts = $alerts ?? [];
$pageIntro = 'Delayed, missed, contraindicated and adverse-event vaccination records requiring review.';
$pageActions = [['label' => 'Children Due', 'url' => '/children/vaccinations/overdue', 'primary' => true]];
$summaryCards = [['label' => 'Active Alerts', 'value' => count($alerts)], ['label' => 'Delayed Doses', 'value' => count(array_filter($alerts, fn($a) => $a['vaccination_status'] === 'Delayed'))], ['label' => 'Missed Doses', 'value' => count(array_filter($alerts, fn($a) => $a['vaccination_status'] === 'Missed'))], ['label' => 'Adverse Events', 'value' => count(array_filter($alerts, fn($a) => (int)$a['adverse_event_reported'] === 1))]];
$tableColumns = ['Child', 'Alert Type', 'Vaccine', 'Status', 'Next Due', 'Action'];
$tableRows = array_map(fn($a) => [['text' => $a['child_name'] ?? 'Unnamed', 'url' => '/children/' . $a['child_id'] . '/vaccinations'], (int)$a['adverse_event_reported'] === 1 ? 'Adverse event' : $a['vaccination_status'], $a['vaccine_name'] ?? '—', $a['vaccination_status'], $a['next_due_date'] ?? 'Not scheduled', ['text' => 'Edit record', 'url' => '/children/' . $a['child_id'] . '/vaccinations/' . $a['vaccination_id'] . '/edit']], $alerts);
$emptyTitle = 'No vaccination alerts';
$emptyMessage = 'No delayed, missed, contraindicated or adverse-event records are active.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
