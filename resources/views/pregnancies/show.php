<?php $show = static fn($v) => $v === null || trim((string)$v) === '' ? 'Not recorded' : (string)$v; ?>
<div class="space-y-6">
	<section class="flex flex-col gap-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
		<div>
			<p class="text-sm font-medium text-blue-600">Pregnancy #<?= (int)$pregnancy['pregnancy_id'] ?></p>
			<h2 class="mt-1 text-2xl font-bold text-slate-900"><?= e($pregnancy['mother_name']) ?></h2>
			<p class="mt-1 text-sm text-slate-500"><?= e($pregnancy['family_code'] . ' · ' . $pregnancy['phm_area_name']) ?></p>
		</div>
		<div class="flex flex-wrap gap-2"><a href="<?= e(APP_URL . '/pregnancies/' . (int)$pregnancy['pregnancy_id'] . '/edit') ?>" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Edit</a><?php if ($pregnancy['current_status'] === 'Ongoing'): ?><a href="<?= e(APP_URL . '/pregnancies/' . (int)$pregnancy['pregnancy_id'] . '/birth-outcome') ?>" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white">Record Outcome</a><?php endif; ?></div>
	</section>
	<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4"><?php foreach ([['Current Status', $pregnancy['current_status']], ['Risk Status', $pregnancy['risk_status']], ['Expected Delivery', $pregnancy['expected_delivery_date']], ['Pregnancy Type', $pregnancy['pregnancy_type']]] as [$l, $v]): ?><article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
				<p class="text-sm text-slate-500"><?= e($l) ?></p>
				<p class="mt-2 text-lg font-bold text-slate-900"><?= e($v) ?></p>
			</article><?php endforeach; ?></section>
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="border-b border-slate-200 px-6 py-4">
			<h3 class="font-semibold text-slate-900">Clinical details</h3>
		</div>
		<dl class="grid gap-5 p-6 sm:grid-cols-2 lg:grid-cols-4"><?php foreach ([['Registered', $show($pregnancy['registered_date'])], ['Booking date', $show($pregnancy['booking_date'])], ['LMP', $show($pregnancy['last_menstrual_period'])], ['Pregnancy age', $show($pregnancy['pregnancy_age_at_registration']) . ' weeks'], ['Gravida', $show($pregnancy['gravida'])], ['Para', $show($pregnancy['para'])], ['Abortions', $show($pregnancy['abortions'])], ['Living children', $show($pregnancy['living_children'])], ['BMI', $show($pregnancy['bmi_at_booking'])], ['Hemoglobin', $show($pregnancy['hemoglobin_level'])], ['Blood pressure', $show($pregnancy['blood_pressure'])], ['Outcome', $show($pregnancy['outcome_type'], 'Not recorded')]] as [$l, $v]): ?><div>
					<dt class="text-xs font-semibold uppercase text-slate-400"><?= e($l) ?></dt>
					<dd class="mt-1 text-sm text-slate-800"><?= e($v) ?></dd>
				</div><?php endforeach; ?></dl><?php if (!empty($pregnancy['remarks'])): ?><div class="border-t border-slate-100 px-6 py-4 text-sm text-slate-700"><?= nl2br(e($pregnancy['remarks'])) ?></div><?php endif; ?>
	</section>
</div>