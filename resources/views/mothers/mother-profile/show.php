<?php
$pregnancies = $pregnancies ?? [];
$clinicVisits = $clinicVisits ?? [];
$fieldVisits = $fieldVisits ?? [];
$supplements = $supplements ?? [];
$activePregnancy = current(array_filter($pregnancies, static fn($p) => $p['current_status'] === 'Ongoing')) ?: null;
$profileImage = APP_URL . '/resources/assets/images/profile-placeholder.jpg';
$show = static fn($v) => $v === null || trim((string)$v) === '' ? 'Not recorded' : (string)$v;
?>
<div class="space-y-6">
	<section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="h-24 bg-gradient-to-r from-fuchsia-600 to-rose-500"></div>
		<div class="flex flex-col gap-5 px-6 pb-6 sm:flex-row sm:items-end sm:justify-between">
			<div class="flex flex-col items-center gap-4 sm:flex-row sm:items-end"><img src="<?= e($profileImage) ?>" alt="Profile placeholder" class="-mt-12 h-24 w-24 rounded-full border-4 border-white object-cover">
				<div>
					<h2 class="text-xl font-bold text-slate-900"><?= e($mother['full_name']) ?></h2>
					<p class="text-sm text-slate-500"><?= e($mother['family_code'] . ' · ' . $mother['phm_area_name']) ?></p>
				</div>
			</div><a href="<?= e(APP_URL . '/mothers/' . (int)$mother['person_id'] . '/edit') ?>" class="rounded-lg bg-blue-600 px-4 py-2.5 text-center text-sm font-semibold text-white">Edit Details</a>
		</div>
	</section>
	<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4"><?php foreach ([['Pregnancies', count($pregnancies)], ['Current Status', $mother['maternal_status']], ['Risk Status', $activePregnancy['risk_status'] ?? 'No active pregnancy'], ['Expected Delivery', $activePregnancy['expected_delivery_date'] ?? 'Not applicable']] as [$label, $value]): ?><article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
				<p class="text-sm text-slate-500"><?= e($label) ?></p>
				<p class="mt-2 text-lg font-bold text-slate-900"><?= e((string)$value) ?></p>
			</article><?php endforeach; ?></section>
	<div class="grid gap-6 xl:grid-cols-2">
		<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
			<div class="border-b border-slate-200 px-6 py-4">
				<h3 class="font-semibold text-slate-900">Personal information</h3>
			</div>
			<dl class="grid gap-5 p-6 sm:grid-cols-2"><?php foreach ([['NIC', $show($mother['nic'])], ['Date of birth', $show($mother['date_of_birth'])], ['Phone', $show($mother['phone'])], ['Email', $show($mother['email'])], ['Blood group', $show($mother['blood_group'])], ['Occupation', $show($mother['occupation'])], ['Marital status', $show($mother['marital_status'])], ['Status', $show($mother['status'])]] as [$l, $v]): ?><div>
						<dt class="text-xs font-semibold uppercase text-slate-400"><?= e($l) ?></dt>
						<dd class="mt-1 text-sm text-slate-800"><?= e($v) ?></dd>
					</div><?php endforeach; ?></dl>
		</section>
		<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
			<div class="border-b border-slate-200 px-6 py-4">
				<h3 class="font-semibold text-slate-900">Care summary</h3>
			</div>
			<div class="divide-y divide-slate-100"><?php foreach ([['Pregnancy records', count($pregnancies), '/mothers/' . $mother['person_id'] . '/pregnancies'], ['Clinic appointments', count($clinicVisits), '/mothers/' . $mother['person_id'] . '/clinic-visits'], ['Field visits', count($fieldVisits), '/mothers/' . $mother['person_id'] . '/field-visits'], ['Supplement distributions', count($supplements), '/mothers/' . $mother['person_id'] . '/supplements']] as [$l, $v, $u]): ?><a href="<?= e(APP_URL . $u) ?>" class="flex items-center justify-between px-6 py-4 hover:bg-slate-50"><span class="text-sm font-medium text-slate-700"><?= e($l) ?></span><span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700"><?= (int)$v ?></span></a><?php endforeach; ?></div>
		</section>
	</div>
</div>