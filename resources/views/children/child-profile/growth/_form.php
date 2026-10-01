<?php
$record = $record ?? [];
$oldData = $_SESSION['growthData'] ?? [];
unset($_SESSION['growthData']);
$value = static fn(string $key, mixed $default = ''): mixed => array_key_exists($key, $oldData) ? $oldData[$key] : ($record[$key] ?? $default);
$class = 'mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500';
?>
<form method="post" action="<?= e($formAction) ?>" class="space-y-6">
    <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="font-semibold text-slate-900"><?= e($child['full_name']) ?></h2>
        </div>
        <div class="grid gap-5 p-6 md:grid-cols-2 lg:grid-cols-3">
            <label class="text-sm font-medium text-slate-700">
                Measurement date
                <input required type="date" name="measurement_date" value="<?= e($value('measurement_date', date('Y-m-d'))) ?>" class="<?= $class ?>">
            </label>

            <label class="text-sm font-medium text-slate-700">
                Weight (kg)
                <input
                    type="number"
                    step="0.01"
                    min="0.60"
                    name="weight_kg"
                    value="<?= e($value('weight_kg')) ?>"
                    class="<?= $class ?>">
            </label>

            <label class="text-sm font-medium text-slate-700">
                Height / length (cm)
                <input
                    type="number"
                    step="0.1"
                    min="20"
                    name="height_cm"
                    value="<?= e($value('height_cm')) ?>"
                    class="<?= $class ?>">
            </label>

            <label class="text-sm font-medium text-slate-700">
                Head circumference (cm)
                <input
                    type="number"
                    step="0.1"
                    min="30"
                    name="head_circumference_cm"
                    value="<?= e($value('head_circumference_cm')) ?>"
                    class="<?= $class ?>">
            </label>

            <label class="text-sm font-medium text-slate-700">
                MUAC (cm)
                <input
                    type="number"
                    step="0.1"
                    min="5"
                    name="muac_cm"
                    value="<?= e($value('muac_cm')) ?>"
                    class="<?= $class ?>">
            </label>
            <label class="text-sm font-medium text-slate-700">
                Measured by
                <select required name="measured_by" class="<?= $class ?>">
                    <option value="">Select staff</option>
                    <?php foreach ($staff ?? [] as $member): ?><option value="<?= (int) $member['staff_id'] ?>" <?= (int) $value('measured_by') === (int) $member['staff_id'] ? 'selected' : '' ?>><?= e($member['full_name']) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label class="text-sm font-medium text-slate-700 md:col-span-2 lg:col-span-3">
                Remarks
                <textarea name="remarks" rows="3" class="<?= $class ?>"><?= e($value('remarks')) ?>
                </textarea>
            </label>
        </div>
    </section>
    <div class="flex justify-end gap-3">
        <a href="<?= e(APP_URL . '/children/' . (int) $child['person_id'] . '/growth') ?>" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Cancel</a>
        <button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"><?= e($submitLabel) ?>
        </button>
    </div>
</form>