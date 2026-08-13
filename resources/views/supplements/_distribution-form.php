<?php
$record = $record ?? [];
$oldData = $_SESSION['supplementData'] ?? [];
unset($_SESSION['supplementData']);
$value = static fn(string $key, mixed $default = ''): mixed => array_key_exists($key, $oldData) ? $oldData[$key] : ($record[$key] ?? $default);
$class = 'mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500';
?>
<form method="post" action="<?= e($formAction) ?>" class="space-y-6">
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="border-b border-slate-200 px-6 py-4">
			<h2 class="font-semibold text-slate-900"><?= e($person['full_name']) ?></h2>
			<p class="text-sm text-slate-500"><?= e($recipientType) ?> supplement distribution.</p>
		</div>
		<div class="grid gap-5 p-6 md:grid-cols-2">
			<label class="text-sm font-medium text-slate-700">Supplement<select required name="supplement_id" class="<?= $class ?>">
					<option value="">Select supplement</option><?php foreach ($supplements ?? [] as $s): ?><option value="<?= (int)$s['supplement_id'] ?>" <?= (int)$value('supplement_id') === (int)$s['supplement_id'] ? 'selected' : '' ?>><?= e($s['supplement_name'] . ' · ' . $s['dosage'] . ' ' . $s['unit'] . ' · ' . $s['frequency']) ?></option><?php endforeach; ?>
				</select></label>
			<label class="text-sm font-medium text-slate-700">Distributed by<select required name="distributed_by" class="<?= $class ?>">
					<option value="">Select staff</option><?php foreach ($staff ?? [] as $s): ?><option value="<?= (int)$s['staff_id'] ?>" <?= (int)$value('distributed_by') === (int)$s['staff_id'] ? 'selected' : '' ?>><?= e($s['full_name']) ?></option><?php endforeach; ?>
				</select></label>
			<label class="text-sm font-medium text-slate-700">Distribution date<input required type="date" name="distribution_date" value="<?= e($value('distribution_date', date('Y-m-d'))) ?>" class="<?= $class ?>"></label>
			<label class="text-sm font-medium text-slate-700">Quantity<input required type="number" min="0.01" step="0.01" name="quantity" value="<?= e($value('quantity')) ?>" class="<?= $class ?>"></label>
			<label class="text-sm font-medium text-slate-700">Expiry date<input type="date" name="expiry_date" value="<?= e($value('expiry_date')) ?>" class="<?= $class ?>"></label>
			<label class="text-sm font-medium text-slate-700">Next distribution due<input type="date" name="next_distribution_due" value="<?= e($value('next_distribution_due')) ?>" class="<?= $class ?>"></label>
			<label class="text-sm font-medium text-slate-700 md:col-span-2">Remarks<textarea name="remarks" rows="4" class="<?= $class ?>"><?= e($value('remarks')) ?></textarea></label>
		</div>
	</section>
	<div class="flex justify-end gap-3"><a href="<?= e($cancelUrl) ?>" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Cancel</a><button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white"><?= e($submitLabel) ?></button></div>
</form>