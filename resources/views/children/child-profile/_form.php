<?php
$oldData = $_SESSION['childData'] ?? [];
unset($_SESSION['childData']);
$value = static fn(string $key, mixed $default = ''): mixed => array_key_exists($key, $oldData) ? $oldData[$key] : $default;
$inputClass = 'mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:ring-blue-500';
?>
<form method="post" action="<?= e($formAction) ?>" class="space-y-6">
    <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="font-semibold text-slate-900">Child and birth record</h2>
            <p class="mt-1 text-sm text-slate-500"></p>
        </div>
        <div class="grid gap-5 p-6 md:grid-cols-2">
            <?php if ($child === null): ?>
                <label class="text-sm font-medium text-slate-700">Existing child family member
                    <select name="person_id" required class="<?= $inputClass ?>">
                        <option value="">Select a person</option><?php foreach (($people ?? []) as $person): ?><option value="<?= (int) $person['person_id'] ?>" <?= (int) $value('person_id') === (int) $person['person_id'] ? 'selected' : '' ?>><?= e($person['full_name'] . ' · ' . $person['registration_number'] . ' · ' . $person['date_of_birth']) ?></option><?php endforeach; ?>
                    </select>
                </label>
            <?php else: ?><div>
                    <p class="text-sm font-medium text-slate-700">Child</p>
                    <p class="mt-2 text-sm font-semibold text-slate-900"><?= e($child['full_name']) ?></p>
                    <p class="text-xs text-slate-500"><?= e($child['family_code']) ?></p>
                </div><?php endif; ?>
            <label class="text-sm font-medium text-slate-700">Live birth outcome
                <select name="birth_outcome_id" required class="<?= $inputClass ?>">
                    <option value="">Select an outcome</option>
                    <?php if ($child !== null): ?><option value="<?= (int) $child['birth_outcome_id'] ?>" selected><?= e($child['mother_name'] . ' · ' . $child['delivery_date']) ?></option><?php endif; ?>
                    <?php foreach (($birthOutcomes ?? []) as $outcome): ?><option value="<?= (int) $outcome['birth_outcome_id'] ?>" <?= (int) $value('birth_outcome_id', $child['birth_outcome_id'] ?? 0) === (int) $outcome['birth_outcome_id'] ? 'selected' : '' ?>><?= e($outcome['mother_name'] . ' · ' . $outcome['delivery_date'] . ' · ' . $outcome['registration_number']) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label class="text-sm font-medium text-slate-700">Registered date<input type="date" name="registered_date" required value="<?= e($value('registered_date', $child['registered_date'] ?? date('Y-m-d'))) ?>" class="<?= $inputClass ?>"></label>
            <label class="text-sm font-medium text-slate-700">Breastfeeding status<select name="breastfeeding_status" class="<?= $inputClass ?>">
                    <option value="">Not recorded</option><?php foreach (['Exclusive', 'Mixed', 'Formula', 'Stopped'] as $option): ?><option <?= $value('breastfeeding_status', $child['breastfeeding_status'] ?? '') === $option ? 'selected' : '' ?>><?= e($option) ?></option><?php endforeach; ?>
                </select></label>
        </div>
    </section>
    <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="font-semibold text-slate-900">Measurements at birth</h2>
        </div>
        <div class="grid gap-5 p-6 sm:grid-cols-2 lg:grid-cols-3">
            <label class="text-sm font-medium text-slate-700">Birth weight (kg)<input type="number" step="0.01" min="0.30" max="8" name="birth_weight_kg" value="<?= e($value('birth_weight_kg', $child['birth_weight_kg'] ?? '')) ?>" class="<?= $inputClass ?>"></label>
            <label class="text-sm font-medium text-slate-700">Birth length (cm)<input type="number" step="0.01" min="20" max="70" name="birth_length_cm" value="<?= e($value('birth_length_cm', $child['birth_length_cm'] ?? '')) ?>" class="<?= $inputClass ?>"></label>
            <label class="text-sm font-medium text-slate-700">Head circumference (cm)<input type="number" step="0.01" min="20" max="60" name="head_circumference_cm" value="<?= e($value('head_circumference_cm', $child['head_circumference_cm'] ?? '')) ?>" class="<?= $inputClass ?>"></label>
            <label class="flex items-center gap-3 text-sm font-medium text-slate-700"><input type="checkbox" name="special_needs" value="1" <?= $value('special_needs', $child['special_needs'] ?? 0) ? 'checked' : '' ?> class="rounded border-slate-300 text-blue-600">Special needs identified</label>
            <label class="sm:col-span-2 text-sm font-medium text-slate-700">Neonatal complications<textarea name="neonatal_complications" rows="3" class="<?= $inputClass ?>"><?= e($value('neonatal_complications', $child['neonatal_complications'] ?? '')) ?></textarea></label>
        </div>
    </section>
    <div class="flex justify-end gap-3"><a href="<?= e(APP_URL . '/children') ?>" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a><button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"><?= e($submitLabel) ?></button></div>
</form>