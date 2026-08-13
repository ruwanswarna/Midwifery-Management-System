<?php $result = $_SESSION['eddResult'] ?? null;
unset($_SESSION['eddResult']); ?>
<div class="mx-auto max-w-2xl">
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="border-b border-slate-200 px-6 py-4">
			<h2 class="font-semibold text-slate-900">Expected Delivery Date Calculator</h2>
			<p class="text-sm text-slate-500">Uses 280 days from LMP, adjusted for cycle length.</p>
		</div>
		<form method="post" action="<?= e(APP_URL . '/pregnancies/edd-calculator') ?>" class="grid gap-5 p-6 sm:grid-cols-2"><label class="text-sm font-medium text-slate-700">Last menstrual period<input required type="date" name="last_menstrual_period" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5"></label><label class="text-sm font-medium text-slate-700">Cycle length (days)<input required type="number" min="21" max="40" name="cycle_length" value="28" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5"></label><button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white sm:col-span-2">Calculate EDD</button></form><?php if ($result): ?><div class="border-t border-slate-200 bg-blue-50 px-6 py-5">
				<p class="text-sm text-blue-700">Estimated delivery date</p>
				<p class="mt-1 text-2xl font-bold text-blue-900"><?= e(date('d M Y', strtotime($result))) ?></p>
			</div><?php endif; ?>
	</section>
</div>