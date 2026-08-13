<div class="rounded-xl border border-slate-200 bg-white shadow-sm">
	<div class="flex items-center justify-between border-b border-slate-200 p-5">
		<div>
			<h2 class="font-semibold text-slate-900">Clinic Sessions</h2>
			<p class="text-sm text-slate-500">Scheduled and completed clinics</p>
		</div><a href="<?= APP_URL ?>/clinics/create" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white">Schedule Clinic</a>
	</div>
	<div class="overflow-x-auto">
		<table class="min-w-full divide-y divide-slate-200">
			<thead class="bg-slate-50">
				<tr><?php foreach (['Date', 'Type', 'Location', 'Conducted by', 'Appointments', ''] as $h): ?><th class="px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500"><?= e($h) ?></th><?php endforeach; ?></tr>
			</thead>
			<tbody class="divide-y divide-slate-100"><?php foreach ($clinics as $clinic): ?><tr>
						<td class="px-5 py-4 text-sm"><?= e(date('d M Y', strtotime($clinic['clinic_date']))) ?></td>
						<td class="px-5 py-4 text-sm"><?= e($clinic['session_type']) ?></td>
						<td class="px-5 py-4 text-sm"><?= e($clinic['location']) ?></td>
						<td class="px-5 py-4 text-sm"><?= e($clinic['conducted_by_name']) ?></td>
						<td class="px-5 py-4 text-sm"><?= (int)$clinic['appointment_count'] ?></td>
						<td class="px-5 py-4 text-right"><a class="text-sm font-semibold text-blue-600" href="<?= APP_URL ?>/clinics/<?= (int)$clinic['clinic_session_id'] ?>">View</a></td>
					</tr><?php endforeach; ?><?php if (!$clinics): ?><tr>
						<td colspan="6" class="p-8 text-center text-sm text-slate-500">No clinic sessions found.</td>
					</tr><?php endif; ?></tbody>
		</table>
	</div>
</div>