<?php $guardians = $guardians ?? [];
$children = $children ?? [];
$pageActions = [['label' => 'Designate Guardian', 'url' => '/families/' . $family['family_id'] . '/guardianship/create', 'primary' => true]];
$summaryCards = [['label' => 'Guardians', 'value' => count($guardians)], ['label' => 'Registered Children', 'value' => count($children)], ['label' => 'Family', 'value' => $family['registration_number']], ['label' => 'Status', 'value' => $family['status']]];
$tableColumns = ['Guardian', 'NIC', 'Phone', 'Action'];
$tableRows = array_map(fn($g) => [$g['full_name'], $g['nic'] ?? '—', $g['phone'] ?? '—', ['text' => 'View member', 'url' => '/families/' . $family['family_id'] . '/members/' . $g['person_id']]], $guardians);
$emptyTitle = 'No household guardian designated';
require ROOT_PATH . '/resources/views/partials/module-page.php';
