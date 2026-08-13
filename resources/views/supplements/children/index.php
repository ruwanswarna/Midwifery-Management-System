<?php
$distributions = $distributions ?? [];
$dueRecipients = $dueRecipients ?? [];
$pageIntro = '';
$pageActions = [['label' => 'Due & Overdue', 'url' => '/supplements/due'], ['label' => 'Find Child', 'url' => '/children/registry', 'primary' => true]];
$summaryCards = [['label' => 'Recent Distributions', 'value' => count($distributions)], ['label' => 'Due Recipients', 'value' => count(array_filter($dueRecipients, static fn($r) => $r['due_status'] === 'Due Soon'))], ['label' => 'Overdue', 'value' => count(array_filter($dueRecipients, static fn($r) => $r['due_status'] === 'Overdue'))], ['label' => 'Children Reached', 'value' => count(array_unique(array_column($distributions, 'person_id')))]];
$tableColumns = ['Child', 'Family', 'Supplement', 'Quantity', 'Distributed', 'Next Due', 'Status', 'Action'];
$tableRows = array_map(static fn($d) => [$d['recipient_name'], $d['family_code'], $d['supplement_name'], $d['quantity'] . ' ' . $d['unit'], $d['distribution_date'], $d['next_distribution_due'] ?? '—', $d['due_status'], ['text' => 'History', 'url' => '/children/' . $d['person_id'] . '/supplements']], $distributions);
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
