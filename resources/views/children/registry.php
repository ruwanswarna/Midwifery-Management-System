<?php $children = $children ?? []; ?>
<div class="space-y-5">
    <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <form method="get" action="<?= e(APP_URL . '/children/registry') ?>" class="flex w-full max-w-xl gap-2">
                <label class="sr-only" for="child-search">Search children</label>
                <input id="child-search" name="search" value="<?= e($search ?? '') ?>" placeholder="Search name, NIC or family number" class="min-w-0 flex-1 rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                <button class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Search</button>
            </form>
            <a href="<?= e(APP_URL . '/children/create') ?>" class="inline-flex justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Register Child</a>
        </div>
    </section>
    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50"><tr><?php foreach (['Child', 'DOB / Age', 'Family', 'Mother', 'Growth', 'Actions'] as $heading): ?><th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"><?= e($heading) ?></th><?php endforeach; ?></tr></thead>
            <tbody class="divide-y divide-slate-100">
            <?php foreach ($children as $child): ?><tr class="hover:bg-slate-50">
                <td class="px-5 py-4"><a href="<?= e(APP_URL . '/children/' . (int) $child['person_id']) ?>" class="font-semibold text-slate-900 hover:text-blue-600"><?= e($child['full_name']) ?></a><div class="text-xs text-slate-500"><?= e($child['nic'] ?: 'No NIC recorded') ?></div></td>
                <td class="px-5 py-4 text-sm text-slate-700"><?= e($child['date_of_birth']) ?><div class="text-xs text-slate-500"><?= e((string) $child['age_months']) ?> months</div></td>
                <td class="px-5 py-4 text-sm text-slate-700"><?= e($child['family_code']) ?></td>
                <td class="px-5 py-4 text-sm text-slate-700"><?= e($child['mother_name']) ?></td>
                <td class="px-5 py-4 text-sm text-slate-700"><?= e($child['growth_status'] ?? 'Not assessed') ?></td>
                <td class="px-5 py-4 text-sm"><a class="font-semibold text-blue-600 hover:text-blue-800" href="<?= e(APP_URL . '/children/' . (int) $child['person_id']) ?>">View profile</a></td>
            </tr><?php endforeach; ?>
            <?php if ($children === []): ?><tr><td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">No child records match the current search.</td></tr><?php endif; ?>
            </tbody>
        </table></div>
    </section>
</div>
