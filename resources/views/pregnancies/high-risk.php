<?php
$pregnancies = $pregnancies ?? [];
$pageIntro = '';
$pageActions = [['label' => 'Pregnancy Registry', 'url' => '/pregnancies/registry', 'primary' => true]];
$summaryCards = [['label' => 'High-risk Cases', 'value' => count($pregnancies)], ['label' => 'Urgent', 'value' => $urgentCount ?? 0], ['label' => 'Referral Required', 'value' => $referralCount ?? 0], ['label' => 'Follow-up Overdue', 'value' => $overdueCount ?? 0]];
$tableColumns = ['Mother', 'Risk Factors', 'Gestation', 'Next Review', 'Priority'];
$tableRows = array_map(fn($p) => [['text' => $p['mother_name'] ?? 'Unnamed', 'url' => '/pregnancies/' . $p['pregnancy_id']], $p['remarks'] ?? 'High-risk classification', $p['pregnancy_age_at_registration'] ? $p['pregnancy_age_at_registration'] . ' weeks at registration' : '—', $p['expected_delivery_date'] ?? 'Not scheduled', $p['risk_status'] ?? 'High'], $pregnancies);
$emptyTitle = 'No high-risk pregnancies found';
$emptyMessage = 'Pregnancies marked with risk factors will appear here.';
require ROOT_PATH . '/resources/views/partials/module-page.php';
