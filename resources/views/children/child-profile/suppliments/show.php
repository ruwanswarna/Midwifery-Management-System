<?php $distributions = $distributions ?? [];
$person = $person ?? $child ?? []; ?>
<div class="space-y-5">
	<div class="flex justify-end"><a href="<?= e(APP_URL . '/children/' . (int)$person['person_id'] . '/supplements/create') ?>" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white">Record Distribution</a></div>
	<section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-slate-200">
				<thead class="bg-slate-50">
					<tr><?php foreach (['Supplement', 'Quantity', 'Distributed', 'Next Due', 'Status', 'Recorded By', 'Remarks', 'Action'] as $h): ?><th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500"><?= e($h) ?></th><?php endforeach; ?></tr>
				</thead>
				<tbody class="divide-y divide-slate-100">
					<?php foreach ($distributions as $row): ?><tr>
							<td class="px-4 py-4 text-sm font-semibold text-slate-900"><?= e($row['supplement_name']) ?></td>
							<td class="px-4 py-4 text-sm"><?= e($row['quantity'] . ' ' . $row['unit']) ?></td>
							<td class="px-4 py-4 text-sm"><?= e($row['distribution_date']) ?></td>
							<td class="px-4 py-4 text-sm"><?= e($row['next_distribution_due'] ?? '—') ?></td>
							<td class="px-4 py-4 text-sm font-semibold"><?= e($row['due_status']) ?></td>
							<td class="px-4 py-4 text-sm"><?= e($row['distributed_by_name']) ?></td>
							<td class="px-4 py-4 text-sm"><?= e($row['remarks'] ?? '—') ?></td>
							<td class="px-4 py-4"><a class="text-sm font-semibold text-blue-600" href="<?= e(APP_URL . '/children/' . (int)$person['person_id'] . '/supplements/' . (int)$row['distribution_id'] . '/edit') ?>">Edit</a></td>
						</tr><?php endforeach; ?><?php if ($distributions === []): ?><tr>
							<td colspan="8" class="px-6 py-12 text-center text-sm text-slate-500">No supplement distributions recorded.</td>
						</tr><?php endif; ?></tbody>
			</table>
		</div>
	</section>
</div>