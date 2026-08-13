<?php
$record = $record ?? [];
$oldData = $_SESSION['observationData'] ?? [];
unset($_SESSION['observationData']);
$value = static fn(string $key, mixed $default = ''): mixed => array_key_exists($key, $oldData) ? $oldData[$key] : ($record[$key] ?? $default);
$class = 'mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500';
?>
<form method="post" action="<?= e($formAction) ?>" class="space-y-6">
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="border-b border-slate-200 px-6 py-4">
			<h2 class="font-semibold text-slate-900"><?= e($child['full_name']) ?></h2>
			<p class="text-sm text-slate-500">Record one age-appropriate developmental milestone per observation.</p>
		</div>
		<div class="grid gap-5 p-6 md:grid-cols-2">
			<label class="text-sm font-medium text-slate-700">Milestone<select required name="milestone_id" class="<?= $class ?>">
					<option value="">Select milestone</option><?php foreach ($milestones ?? [] as $m): ?><option value="<?= (int)$m['milestone_id'] ?>" <?= (int)$value('milestone_id') === (int)$m['milestone_id'] ? 'selected' : '' ?>><?= e($m['milestone_name'] . ' · ' . $m['milestone_category'] . ' · ' . $m['expected_age_from_month'] . '–' . $m['expected_age_to_month'] . ' months') ?></option><?php endforeach; ?>
				</select></label>
			<label class="text-sm font-medium text-slate-700">Observed by<select required name="observed_by" class="<?= $class ?>">
					<option value="">Select staff</option><?php foreach ($staff ?? [] as $s): ?><option value="<?= (int)$s['staff_id'] ?>" <?= (int)$value('observed_by') === (int)$s['staff_id'] ? 'selected' : '' ?>><?= e($s['full_name']) ?></option><?php endforeach; ?>
				</select></label>
			<label class="text-sm font-medium text-slate-700">Observation date<input required type="date" name="observation_date" value="<?= e($value('observation_date', date('Y-m-d'))) ?>" class="<?= $class ?>"></label>
			<label class="text-sm font-medium text-slate-700">Result<select required name="observation_status" class="<?= $class ?>">
					<option value="">Select result</option><?php foreach (['Achieved', 'Delayed', 'Not Achieved'] as $status): ?><option <?= $value('observation_status') === $status ? 'selected' : '' ?>><?= e($status) ?></option><?php endforeach; ?>
				</select></label>
			<label class="flex items-center gap-3 text-sm font-medium text-slate-700"><input type="checkbox" name="follow_up_required" value="1" <?= $value('follow_up_required') ? 'checked' : '' ?> class="rounded border-slate-300 text-blue-600">Follow-up required</label>
			<label class="text-sm font-medium text-slate-700">Follow-up date<input type="date" name="follow_up_date" value="<?= e($value('follow_up_date')) ?>" class="<?= $class ?>"></label>
			<label class="text-sm font-medium text-slate-700 md:col-span-2">Remarks<textarea name="remarks" rows="4" class="<?= $class ?>"><?= e($value('remarks')) ?></textarea></label>
		</div>
	</section>
	<div class="flex justify-end gap-3"><a href="<?= e(APP_URL . '/children/' . (int)$child['person_id'] . '/observations') ?>" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Cancel</a><button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white"><?= e($submitLabel) ?></button></div>
</form>