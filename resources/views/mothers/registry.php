<?php $mothers = $mothers ?? []; ?>

<div class="space-y-5">
	<section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
		<div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
			<form method="get" action="<?= e(APP_URL . '/mothers/registry') ?>" class="flex w-full max-w-xl gap-2"><input name="search" value="<?= e($search ?? '') ?>" placeholder="Search name, NIC or family number" class="min-w-0 flex-1 rounded-lg border border-slate-300 px-3 py-2.5 text-sm"><button class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold">Search</button></form><a href="<?= e(APP_URL . '/mothers/create') ?>" class="rounded-lg bg-blue-600 px-4 py-2.5 text-center text-sm font-semibold text-white">Register Mother</a>
		</div>
	</section>
	<section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-slate-200">
				<thead class="bg-slate-50">
					<tr><?php foreach (['Mother', 'NIC', 'Family', 'Contact', 'Pregnancies', 'Current Status', 'Action'] as $h): ?><th class="px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500"><?= e($h) ?></th><?php endforeach; ?></tr>
				</thead>
				<tbody class="divide-y divide-slate-100"><?php foreach ($mothers as $m): ?><tr>
							<td class="px-5 py-4"><a class="font-semibold text-slate-900 hover:text-blue-600" href="<?= e(APP_URL . '/mothers/' . (int)$m['person_id']) ?>"><?= e($m['full_name']) ?></a>
								<div class="text-xs text-slate-500"><?= e($m['phm_area_name']) ?></div>
							</td>
							<td class="px-5 py-4 text-sm"><?= e($m['nic'] ?? '—') ?></td>
							<td class="px-5 py-4 text-sm"><?= e($m['family_code']) ?></td>
							<td class="px-5 py-4 text-sm"><?= e($m['phone'] ?? '—') ?></td>
							<td class="px-5 py-4 text-sm"><?= (int)$m['pregnancy_count'] ?></td>
							<td class="px-5 py-4 text-sm font-semibold"><?= e($m['maternal_status']) ?></td>
							<td class="px-5 py-4"><a class="text-sm font-semibold text-blue-600" href="<?= e(APP_URL . '/mothers/' . (int)$m['person_id']) ?>">View</a></td>
						</tr><?php endforeach; ?><?php if ($mothers === []): ?><tr>
							<td colspan="7" class="px-6 py-12 text-center text-sm text-slate-500">No mothers match this search.</td>
						</tr><?php endif; ?></tbody>
			</table>
		</div>
	</section>
</div>