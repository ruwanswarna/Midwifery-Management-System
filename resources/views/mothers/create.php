<!-- <?php $oldData = $_SESSION['motherData'] ?? [];
		unset($_SESSION['motherData']); ?>
<form method="post" action="<?= e(APP_URL . '/mothers/create') ?>" class="space-y-6">
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="border-b border-slate-200 px-6 py-4">
			<h2 class="font-semibold text-slate-900">Select an existing family member</h2>
			<p class="mt-1 text-sm text-slate-500"></p>
		</div>
		<div class="p-6"><label class="text-sm font-medium text-slate-700">Female family member<select required name="person_id" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
					<option value="">Select person</option><?php foreach ($eligibleWomen ?? [] as $woman): ?><option value="<?= (int)$woman['person_id'] ?>" <?= (int)($oldData['person_id'] ?? 0) === (int)$woman['person_id'] ? 'selected' : '' ?>><?= e($woman['full_name'] . ' · ' . ($woman['nic'] ?: 'No NIC') . ' · ' . $woman['family_code'] . ' · current role: ' . $woman['role_name']) ?></option><?php endforeach; ?>
				</select></label><?php if (($eligibleWomen ?? []) === []): ?><p class="mt-3 rounded-lg bg-amber-50 p-3 text-sm text-amber-800">No eligible female family members are available. Add the person to a family first.</p><?php endif; ?></div>
	</section>
	<div class="flex justify-end gap-3"><a href="<?= e(APP_URL . '/mothers/registry') ?>" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Cancel</a><button <?= ($eligibleWomen ?? []) === [] ? 'disabled' : '' ?> class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white disabled:opacity-50">Create Maternal Profile</button></div>
</form> -->