<?php
$clinicSchedule = [
    ['time' => '8:30 AM', 'clinic_name' => 'Antenatal Clinic', 'location' => 'Main Clinic'],
    ['time' => '10:30 AM', 'clinic_name' => 'Child Welfare Clinic', 'location' => 'Main Clinic'],
    ['time' => '2:00 PM', 'clinic_name' => 'Nutrition Clinic', 'location' => 'Community Centre'],
];
$clinicSchedule = $clinicSchedule ?? [];
?>
<section
    class="flex h-full min-h-0 flex-col overflow-hidden
           rounded-xl border border-slate-200 bg-white shadow-sm">
    <!-- Fixed card header -->
    <div
        class="flex shrink-0 items-center justify-between
               border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">
                Clinic Schedule
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Today's scheduled clinics
            </p>
        </div>

        <a
            href="<?= APP_URL ?>/clinics"
            class="text-sm font-medium text-blue-600
                   hover:text-blue-700 hover:underline">
            View all
        </a>
    </div>

    <?php if (!empty($clinicSchedule)) : ?>

        <!-- Scroll only this section -->
        <div class="min-h-0 flex-1 overflow-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="sticky top-0 z-10 bg-slate-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wide text-slate-500">
                            Time
                        </th>

                        <th
                            class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wide text-slate-500">
                            Clinic
                        </th>

                        <th
                            class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wide text-slate-500">
                            Location
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">

                    <?php foreach ($clinicSchedule as $clinic) : ?>

                        <tr class="transition hover:bg-slate-50">

                            <td
                                class="whitespace-nowrap px-6 py-4
                                       text-sm font-medium text-slate-900">
                                <?= e($clinic['time'] ?? '—') ?>
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-700">
                                <?= e($clinic['clinic_name'] ?? '—') ?>
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-500">
                                <?= e($clinic['location'] ?? '—') ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>

    <?php else : ?>

        <div
            class="flex min-h-0 flex-1 items-center justify-center
                   px-6 py-12 text-center">
            <div>
                <p class="text-sm font-medium text-slate-700">
                    No clinics scheduled today
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Today's clinic schedule will appear here.
                </p>
            </div>
        </div>

    <?php endif; ?>
</section>