<?php
$households = $households ?? [];
$pageIntro = 'Review housing conditions, water, sanitation and household facilities recorded during family assessments.';
$pageActions = [['label' => 'Family Registry', 'url' => '/families/registry', 'primary' => true]];
$summaryCards = [['label' => 'Households Assessed', 'value' => count($households)], ['label' => 'Safe Water Access', 'value' => 0], ['label' => 'Sanitation Alerts', 'value' => 0], ['label' => 'Assessments Due', 'value' => 0]];
$tableColumns = ['Family', 'Housing Type', 'Water Source', 'Sanitation', 'Last Assessed'];
$tableRows = array_map(fn($h) => [$h['family_code'] ?? '—', $h['housing_type'] ?? 'Not recorded', $h['water_source'] ?? 'Not recorded', $h['sanitation_type'] ?? 'Not recorded', $h['updated_at'] ?? '—'], $households);
$emptyTitle = 'No household assessments found';
$emptyMessage = 'Household details recorded from a family profile will appear here.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
