<?php
$distributions = $distributions ?? [];
$statistics = $statistics ?? [];
$dueRecipients = $dueRecipients ?? [];
$pageIntro = '';
$pageActions = [['label' => 'Mothers', 'url' => '/supplements/mothers'], ['label' => 'Children', 'url' => '/supplements/children', 'primary' => true]];
$summaryCards = [['label' => 'Total Distributions', 'value' => $statistics['total_distributions'] ?? count($distributions)], ['label' => 'Distributed This Month', 'value' => $statistics['distributed_this_month'] ?? 0], ['label' => 'Recipients Due', 'value' => count(array_filter($dueRecipients, fn($r) => $r['due_status'] === 'Due Soon'))], ['label' => 'Overdue', 'value' => count(array_filter($dueRecipients, fn($r) => $r['due_status'] === 'Overdue'))]];
$tableColumns = ['Recipient', 'Recipient Type', 'Supplement', 'Quantity', 'Distribution Date', 'Next Due'];
$tableRows = array_map(fn($d) => [$d['recipient_name'] ?? 'Unnamed', $d['recipient_type'] ?? 'Person', $d['supplement_name'] ?? 'Not recorded', ($d['quantity'] ?? '—') . ' ' . ($d['unit'] ?? ''), $d['distribution_date'] ?? '—', $d['next_distribution_due'] ?? '—'], array_slice($distributions, 0, 10));
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
