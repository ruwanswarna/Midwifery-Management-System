<?php
$observations = $observations ?? [];
$alerts = $alerts ?? [];
$pageIntro = '';
$summaryCards = [['label' => 'Recorded Observations', 'value' => count($observations)], ['label' => 'Needs Follow-up', 'value' => count($alerts)], ['label' => 'Achieved', 'value' => count(array_filter($observations, static fn($o) => $o['observation_status'] === 'Achieved'))], ['label' => 'Delayed / Not Achieved', 'value' => count(array_filter($observations, static fn($o) => $o['observation_status'] !== 'Achieved'))]];
$tableColumns = ['Child', 'Milestone', 'Expected Age', 'Observed Date', 'Status', 'Follow-up', 'Action'];
$tableRows = array_map(static fn($o) => [$o['child_name'], $o['milestone_name'], $o['expected_age_from_month'] . '–' . $o['expected_age_to_month'] . ' months', $o['observation_date'], $o['observation_status'], $o['follow_up_date'] ?? '—', ['text' => 'View child', 'url' => '/children/' . $o['child_id'] . '/observations']], $observations);
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
