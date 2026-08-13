<?php

$pageActions = [['label' => 'Family Registry', 'url' => '/families/registry'], ['label' => 'All Reports', 'url' => '/reports', 'primary' => true]];
$summaryCards = [['label' => 'Active Families', 'value' => $activeFamilies ?? 0], ['label' => 'New This Month', 'value' => $newFamilies ?? 0], ['label' => 'Inactive Families', 'value' => $inactiveFamilies ?? 0]];
$tableColumns = ['Report', 'Period', 'Status', 'Last Generated'];
$tableRows = $reportRows ?? [];
$emptyTitle = 'No family reports generated';
$emptyMessage = '';
require ROOT_PATH . '/resources/views/partials/module-page.php';
