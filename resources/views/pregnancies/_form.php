<?php
$oldData = $_SESSION['pregnancyData'] ?? [];
unset($_SESSION['pregnancyData']);
$value = static fn(string $k, mixed $d = ''): mixed => array_key_exists($k, $oldData) ? $oldData[$k] : ($pregnancy[$k] ?? $d);
$class = 'mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500';
?>
<form method="post" action="<?= e($formAction) ?>" class="space-y-6">
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="border-b border-slate-200 px-6 py-4">
			<h2 class="font-semibold text-slate-900">Pregnancy registration</h2>
			<p class="text-sm text-slate-500"></p>
		</div>
		<div class="grid gap-5 p-6 md:grid-cols-2 lg:grid-cols-3">
			<label class="text-sm font-medium text-slate-700 md:col-span-2 lg:col-span-3">Mother<select required name="mother_id" class="<?= $class ?>">
					<option value="">Select registered mother</option><?php foreach ($mothers ?? [] as $m): ?><option value="<?= (int)$m['mother_id'] ?>" <?= (int)$value('mother_id') === (int)$m['mother_id'] ? 'selected' : '' ?>><?= e($m['full_name'] . ' · ' . ($m['nic'] ?: 'No NIC') . ' · ' . $m['family_code']) ?></option><?php endforeach; ?>
				</select></label>
			<label class="text-sm font-medium text-slate-700">Registered date<input required type="date" name="registered_date" value="<?= e($value('registered_date', date('Y-m-d'))) ?>" class="<?= $class ?>"></label><label class="text-sm font-medium text-slate-700">Booking date<input type="date" name="booking_date" value="<?= e($value('booking_date')) ?>" class="<?= $class ?>"></label><label class="text-sm font-medium text-slate-700">Pregnancy age at registration (weeks)<input min="0" max="45" type="number" name="pregnancy_age_at_registration" value="<?= e($value('pregnancy_age_at_registration')) ?>" class="<?= $class ?>"></label>
			<label class="text-sm font-medium text-slate-700">Last menstrual period<input id="lmp" required type="date" name="last_menstrual_period" value="<?= e($value('last_menstrual_period')) ?>" class="<?= $class ?>"></label><label class="text-sm font-medium text-slate-700">Expected delivery date<input id="edd" required type="date" name="expected_delivery_date" value="<?= e($value('expected_delivery_date')) ?>" class="<?= $class ?>"></label><label class="text-sm font-medium text-slate-700">Blood pressure<input name="blood_pressure" maxlength="10" placeholder="120/80" value="<?= e($value('blood_pressure')) ?>" class="<?= $class ?>"></label>
			<?php foreach ([['gravida', 'Gravida'], ['para', 'Para'], ['abortions', 'Abortions'], ['living_children', 'Living children']] as [$n, $l]): ?><label class="text-sm font-medium text-slate-700"><?= e($l) ?><input min="0" type="number" name="<?= e($n) ?>" value="<?= e($value($n, 0)) ?>" class="<?= $class ?>"></label><?php endforeach; ?>
			<label class="text-sm font-medium text-slate-700">BMI at booking<input type="number" min="10" max="60" step="0.1" name="bmi_at_booking" value="<?= e($value('bmi_at_booking')) ?>" class="<?= $class ?>"></label><label class="text-sm font-medium text-slate-700">Hemoglobin (g/dL)<input type="number" min="1" max="25" step="0.1" name="hemoglobin_level" value="<?= e($value('hemoglobin_level')) ?>" class="<?= $class ?>"></label>
			<label class="text-sm font-medium text-slate-700">Pregnancy type<select name="pregnancy_type" class="<?= $class ?>"><?php foreach (['Singleton', 'Twins', 'Triplets', 'Other'] as $v): ?><option <?= $value('pregnancy_type', 'Singleton') === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?></select></label><label class="text-sm font-medium text-slate-700">Risk status<select name="risk_status" class="<?= $class ?>"><?php foreach (['Low', 'Moderate', 'High'] as $v): ?><option <?= $value('risk_status', 'Low') === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?></select></label><label class="text-sm font-medium text-slate-700">Current status<select name="current_status" class="<?= $class ?>"><?php foreach (['Ongoing', 'Delivered', 'Transferred', 'Terminated'] as $v): ?><option <?= $value('current_status', 'Ongoing') === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?></select></label>
			<label class="text-sm font-medium text-slate-700 md:col-span-2 lg:col-span-3">Remarks<textarea name="remarks" rows="4" class="<?= $class ?>"><?= e($value('remarks')) ?></textarea></label>
		</div>
	</section>
	<div class="flex justify-end gap-3"><a href="<?= e(APP_URL . '/pregnancies/registry') ?>" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Cancel</a><button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white"><?= e($submitLabel) ?></button></div>
</form>
<script>
	document.getElementById('lmp')?.addEventListener('change', function() {
		if (!this.value) return;
		const date = new Date(this.value + 'T00:00:00');
		date.setDate(date.getDate() + 280);
		document.getElementById('edd').value = date.toISOString().slice(0, 10);
	});
</script>