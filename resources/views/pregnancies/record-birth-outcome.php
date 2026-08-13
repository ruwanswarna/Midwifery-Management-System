<?php $oldData = $_SESSION['outcomeData'] ?? [];
unset($_SESSION['outcomeData']);
$value = static fn($k, $d = '') => $oldData[$k] ?? $d;
$class = 'mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm'; ?>
<form method="post" action="<?= e(APP_URL . '/pregnancies/' . (int)$pregnancy['pregnancy_id'] . '/birth-outcome') ?>" class="space-y-6">
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="border-b border-slate-200 px-6 py-4">
			<h2 class="font-semibold text-slate-900"><?= e($pregnancy['mother_name']) ?></h2>
			<p class="text-sm text-slate-500">Pregnancy #<?= (int)$pregnancy['pregnancy_id'] ?> · EDD <?= e($pregnancy['expected_delivery_date']) ?></p>
		</div>
		<div class="grid gap-5 p-6 md:grid-cols-2 lg:grid-cols-3">
			<label class="text-sm font-medium text-slate-700">Outcome type<select required name="outcome_type" class="<?= $class ?>">
					<option value="">Select outcome</option><?php foreach (['Live Birth', 'Live Birth - Expired', 'Still Birth', 'Miscarriage', 'Abortion'] as $v): ?><option <?= $value('outcome_type') === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?>
				</select></label><label class="text-sm font-medium text-slate-700">Delivery / outcome date<input required type="date" name="delivery_date" value="<?= e($value('delivery_date', date('Y-m-d'))) ?>" class="<?= $class ?>"></label><label class="text-sm font-medium text-slate-700">Gestational age (weeks)<input type="number" min="20" max="45" name="gestational_age_weeks" value="<?= e($value('gestational_age_weeks')) ?>" class="<?= $class ?>"></label>
			<label class="text-sm font-medium text-slate-700">Place<input name="delivery_place" maxlength="150" value="<?= e($value('delivery_place')) ?>" class="<?= $class ?>"></label><label class="text-sm font-medium text-slate-700">Delivery mode<select name="delivery_mode" class="<?= $class ?>">
					<option value="">Not applicable / not recorded</option><?php foreach (['Normal Vaginal', 'Caesarean', 'Assisted', 'Home Delivery'] as $v): ?><option <?= $value('delivery_mode') === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?>
				</select></label><label class="text-sm font-medium text-slate-700">Mother status<select name="mother_status" class="<?= $class ?>">
					<option value="">Not recorded</option><?php foreach (['Healthy', 'Complication', 'Deceased'] as $v): ?><option <?= $value('mother_status') === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?>
				</select></label>
			<label class="text-sm font-medium text-slate-700 md:col-span-2">Complications<textarea name="complications" rows="3" class="<?= $class ?>"><?= e($value('complications')) ?></textarea></label><label class="text-sm font-medium text-slate-700">Notes<textarea name="notes" rows="3" class="<?= $class ?>"><?= e($value('notes')) ?></textarea></label>
		</div>
	</section>
	<div class="flex justify-end gap-3"><a href="<?= e(APP_URL . '/pregnancies/' . (int)$pregnancy['pregnancy_id']) ?>" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Cancel</a><button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white">Save Outcome</button></div>
</form>