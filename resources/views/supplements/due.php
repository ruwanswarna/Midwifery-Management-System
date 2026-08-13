<?php
$recipients = $recipients ?? [];
$pageIntro = '';
$pageActions = [['label' => 'All Supplements', 'url' => '/supplements', 'primary' => true]];
$summaryCards = [['label' => 'Due / Overdue', 'value' => count($recipients)], ['label' => 'Overdue', 'value' => count(array_filter($recipients, static fn($r) => $r['due_status'] === 'Overdue'))], ['label' => 'Due Soon', 'value' => count(array_filter($recipients, static fn($r) => $r['due_status'] === 'Due Soon'))], ['label' => 'Children', 'value' => count(array_filter($recipients, static fn($r) => $r['recipient_type'] === 'Child'))]];
$tableColumns = ['Recipient', 'Type', 'Family', 'Supplement', 'Last Distribution', 'Next Due', 'Status', 'Action'];
$tableRows = array_map(static fn($r) => [$r['recipient_name'], $r['recipient_type'], $r['family_code'], $r['supplement_name'], $r['distribution_date'], $r['next_distribution_due'], $r['due_status'], ['text' => 'Open profile', 'url' => ($r['recipient_type'] === 'Child' ? '/children/' : '/mothers/') . $r['person_id'] . '/supplements']], $recipients);
$emptyTitle = '';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
