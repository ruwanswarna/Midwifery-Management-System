<?php
$upcomingBirths = [
    ['mother_name' => 'N. Perera', 'expected_date' => '30 Jul 2026', 'days_left' => 6],
    ['mother_name' => 'S. Fernando', 'expected_date' => '07 Aug 2026', 'days_left' => 14],
];
$upcomingBirths = $upcomingBirths ?? []; ?>
<section class="flex h-full flex-col overflow-hidden rounded-xl
           border border-slate-200 bg-white shadow-sm">
    <div class="flex shrink-0 items-center justify-between border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Upcoming Births</h2>
            <p class="mt-1 text-sm text-slate-500">Expected deliveries approaching soon</p>
        </div>
        <a href="<?= APP_URL ?>/pregnancies" class="text-sm font-medium text-blue-600 hover:underline">View all</a>
    </div>

    <?php if (!empty($upcomingBirths)) : ?>
        <div class="max-h-[21rem] overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="sticky top-0 z-10 bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Mother</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Expected Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Days Left</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php foreach ($upcomingBirths as $birth) : ?>
                        <?php $daysLeft = (int) ($birth['days_left'] ?? 0); ?>
                        <tr class="h-14 transition hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900"><?= e($birth['mother_name'] ?? '—') ?></td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600"><?= e($birth['expected_date'] ?? '—') ?></td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-700">
                                    <?= $daysLeft ?> day<?= $daysLeft === 1 ? '' : 's' ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="px-6 py-12 text-center text-sm text-slate-500">No upcoming births.</div>
    <?php endif; ?>
</section>