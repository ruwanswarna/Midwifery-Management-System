<div class="rounded-xl border border-slate-200 bg-white p-8 text-center shadow-sm">
	<h2 class="text-lg font-semibold text-slate-900">Edit household information</h2>
	<p class="mt-2 text-sm text-slate-500">Address, status and household remarks are maintained on the Household tab.</p><?php if (isset($family['family_id'])): ?><a href="<?= e(APP_URL . '/families/' . (int)$family['family_id'] . '/home/edit') ?>" class="mt-5 inline-flex rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white">Edit Household</a><?php endif; ?>
</div>