<div class="rounded-xl border border-slate-200 bg-white shadow-sm">
	<div class="flex justify-between border-b p-5">
		<div>
			<h2 class="font-semibold">Field Visit Register</h2>
			<p class="text-sm text-slate-500">Home visits and required follow-ups</p>
		</div><a href="<?= APP_URL ?>/field-visits/create" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white">Record Visit</a>
	</div>
	<div class="overflow-x-auto">
		<table class="min-w-full divide-y"><?php foreach ($visits as $v): ?><tr class="border-b">
					<td class="p-4 text-sm"><?= e($v['visit_date']) ?></td>
					<td class="p-4 text-sm"><?= e($v['registration_number']) ?></td>
					<td class="p-4 text-sm"><?= e($v['person_name'] ?: 'Whole family') ?></td>
					<td class="p-4 text-sm"><?= e($v['visit_type']) ?></td>
					<td class="p-4 text-sm"><?= e($v['visit_status']) ?></td>
					<td class="p-4 text-right"><a href="<?= APP_URL ?>/field-visits/<?= (int)$v['visit_id'] ?>" class="text-sm font-semibold text-blue-600">View</a></td>
				</tr><?php endforeach; ?><?php if (!$visits): ?><tr>
					<td class="p-8 text-center text-sm text-slate-500">No field visits found.</td>
				</tr><?php endif; ?></table>
	</div>
</div>