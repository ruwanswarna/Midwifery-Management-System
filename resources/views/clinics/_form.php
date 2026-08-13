<?php $data = $_SESSION['clinicData'] ?? ($clinic ?? []);
unset($_SESSION['clinicData']); ?>
<div class="grid gap-5 md:grid-cols-2">
	<?php foreach ([['moh_area_id', 'MOH Area', $mohAreas, 'moh_area_id', 'moh_name'], ['conducted_by', 'Conducted By', $staff, 'staff_id', 'full_name']] as [$name, $label, $options, $key, $text]): ?>
		<label class="text-sm font-medium text-slate-700"><?= e($label) ?><select name="<?= $name ?>" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5">
				<option value="">Select</option><?php foreach ($options as $option): ?><option value="<?= (int)$option[$key] ?>" <?= (string)($data[$name] ?? '') === (string)$option[$key] ? 'selected' : '' ?>><?= e($option[$text]) ?></option><?php endforeach; ?>
			</select></label>
	<?php endforeach; ?>
	<label class="text-sm font-medium text-slate-700">Session Type<select name="session_type" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5"><?php foreach (['Antenatal', 'Postnatal', 'Child Welfare', 'Immunization', 'Nutrition', 'Family Planning', 'Special Clinic'] as $type): ?><option <?= ($data['session_type'] ?? '') === $type ? 'selected' : '' ?>><?= e($type) ?></option><?php endforeach; ?></select></label>
	<label class="text-sm font-medium text-slate-700">Clinic Date<input type="date" name="clinic_date" required value="<?= e($data['clinic_date'] ?? '') ?>" class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5"></label>
	<label class="text-sm font-medium text-slate-700">Start Time<input type="time" name="start_time" value="<?= e($data['start_time'] ?? '') ?>" class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5"></label>
	<label class="text-sm font-medium text-slate-700">End Time<input type="time" name="end_time" value="<?= e($data['end_time'] ?? '') ?>" class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5"></label>
	<label class="text-sm font-medium text-slate-700 md:col-span-2">Location<input name="location" required value="<?= e($data['location'] ?? '') ?>" class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5"></label>
	<label class="text-sm font-medium text-slate-700">Maximum Capacity<input type="number" min="1" name="maximum_capacity" value="<?= e($data['maximum_capacity'] ?? '') ?>" class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5"></label>
	<label class="text-sm font-medium text-slate-700 md:col-span-2">Remarks<textarea name="remarks" rows="3" class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5"><?= e($data['remarks'] ?? '') ?></textarea></label>
</div>
<div class="mt-6 flex gap-3"><button class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white">Save Clinic</button><a href="<?= APP_URL ?>/clinics" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm">Cancel</a></div>