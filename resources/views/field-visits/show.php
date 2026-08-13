<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
	<div class="flex justify-between">
		<h2 class="text-xl font-bold">Field Visit #<?= (int)$visit['visit_id'] ?></h2><a href="<?= APP_URL ?>/field-visits/<?= (int)$visit['visit_id'] ?>/edit" class="text-sm font-semibold text-blue-600">Edit</a>
	</div>
	<dl class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3"><?php foreach (['Family' => $visit['registration_number'], 'Person' => $visit['person_name'] ?: 'Whole family', 'Staff member' => $visit['staff_name'], 'Visit date' => $visit['visit_date'], 'Visit type' => $visit['visit_type'], 'Status' => $visit['visit_status'], 'Follow-up date' => $visit['follow_up_date'] ?: 'Not required', 'Risk identified' => !empty($visit['risk_identified']) ? 'Yes' : 'No', 'Observations' => $visit['observations'] ?: 'Not recorded'] as $l => $v): ?><div>
				<dt class="text-sm text-slate-500"><?= e($l) ?></dt>
				<dd class="mt-1 font-medium"><?= e((string)$v) ?></dd>
			</div><?php endforeach; ?></dl>
</div>