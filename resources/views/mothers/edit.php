<?php
$oldData = $_SESSION['motherData'] ?? [];
unset($_SESSION['motherData']);
$value = static fn($k, $d = '') => array_key_exists($k, $oldData) ? $oldData[$k] : ($mother[$k] ?? $d);
$class = 'mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm';
?>
<form method="post" action="<?= e(APP_URL . '/mothers/' . (int)$mother['person_id'] . '/edit') ?>" class="space-y-6">
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="border-b border-slate-200 px-6 py-4">
			<h2 class="font-semibold text-slate-900">Personal details</h2>
		</div>
		<div class="grid gap-5 p-6 md:grid-cols-2 lg:grid-cols-3">
			<?php foreach ([['first_name', 'First name', true], ['middle_name', 'Middle name', false], ['last_name', 'Last name', true], ['nic', 'NIC', false], ['phone', 'Phone', false], ['email', 'Email', false], ['occupation', 'Occupation', false], ['education_level', 'Education level', false]] as [$name, $label, $required]): ?><label class="text-sm font-medium text-slate-700"><?= e($label) ?><input <?= $required ? 'required' : '' ?> <?= $name === 'email' ? 'type="email"' : '' ?> name="<?= e($name) ?>" value="<?= e($value($name)) ?>" class="<?= $class ?>"></label><?php endforeach; ?>
			<label class="text-sm font-medium text-slate-700">Date of birth<input required type="date" name="date_of_birth" value="<?= e($value('date_of_birth')) ?>" class="<?= $class ?>"></label>
			<label class="text-sm font-medium text-slate-700">Blood group<select name="blood_group" class="<?= $class ?>">
					<option value="">Not recorded</option><?php foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $v): ?><option <?= $value('blood_group') === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?>
				</select></label>
			<label class="text-sm font-medium text-slate-700">Marital status<select name="marital_status" class="<?= $class ?>">
					<option value="">Not recorded</option><?php foreach (['Single', 'Married', 'Divorced', 'Widowed'] as $v): ?><option <?= $value('marital_status') === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?>
				</select></label>
			<label class="text-sm font-medium text-slate-700">Record status<select name="status" class="<?= $class ?>"><?php foreach (['Active', 'Deceased'] as $v): ?><option <?= $value('status', 'Active') === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?></select></label>
		</div>
	</section>
	<div class="flex justify-end gap-3"><a href="<?= e(APP_URL . '/mothers/' . (int)$mother['person_id']) ?>" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Cancel</a><button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white">Save Changes</button></div>
</form>