<?php
$upcomingFollowUps = [
    ['subject_name' => 'Family #102', 'follow_up_type' => 'Antenatal Visit', 'follow_up_date' => '26 Jul 2026'],
    ['subject_name' => 'Child #084', 'follow_up_type' => 'Growth Review', 'follow_up_date' => '28 Jul 2026'],
];
$upcomingFollowUps = $upcomingFollowUps ?? []; ?>
<section class="flex h-full flex-col overflow-hidden rounded-xl
           border border-slate-200 bg-white shadow-sm">
    <div class="flex shrink-0 items-center justify-between border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Upcoming Follow-ups</h2>
            <p class="mt-1 text-sm text-slate-500">Scheduled follow-up activities</p>
        </div>
        <a href="<?= APP_URL ?>/field-visits" class="text-sm font-medium text-blue-600 hover:underline">View all</a>
    </div>

    <?php if (!empty($upcomingFollowUps)) : ?>
        <div class="max-h-[21rem] overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="sticky top-0 z-10 bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Family / Person</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Follow-up</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php foreach ($upcomingFollowUps as $followUp) : ?>
                        <tr class="h-14 transition hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900"><?= e($followUp['subject_name'] ?? '—') ?></td>
                            <td class="px-6 py-4 text-sm text-slate-700"><?= e($followUp['follow_up_type'] ?? '—') ?></td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600"><?= e($followUp['follow_up_date'] ?? '—') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="px-6 py-12 text-center text-sm text-slate-500">No upcoming follow-ups.</div>
    <?php endif; ?>
</section>