<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
	<div class="flex justify-between">
		<div>
			<h2 class="text-xl font-bold text-slate-900"><?= e($clinic['session_type']) ?></h2>
			<p class="mt-1 text-sm text-slate-500"><?= e($clinic['moh_name']) ?></p>
		</div><a href="<?= APP_URL ?>/clinics/<?= (int)$clinic['clinic_session_id'] ?>/edit" class="text-sm font-semibold text-blue-600">Edit</a>
	</div>
	<dl class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3"><?php foreach (['Clinic date' => $clinic['clinic_date'], 'Time' => trim(($clinic['start_time'] ?? '') . ' - ' . ($clinic['end_time'] ?? ''), ' -'), 'Location' => $clinic['location'], 'Conducted by' => $clinic['conducted_by_name'], 'Maximum capacity' => $clinic['maximum_capacity'] ?? 'Not set', 'Remarks' => $clinic['remarks'] ?? 'Not recorded'] as $label => $value): ?><div>
				<dt class="text-sm text-slate-500"><?= e($label) ?></dt>
				<dd class="mt-1 font-medium text-slate-900"><?= e((string)$value) ?></dd>
			</div><?php endforeach; ?></dl>
</div>