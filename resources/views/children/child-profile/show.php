<?php
$growthRecords = $growthRecords ?? [];
$vaccinationSchedule = $vaccinationSchedule ?? [];
$observations = $observations ?? [];
$supplements = $supplements ?? [];
$latestGrowth = $growthRecords[0] ?? null;
$nextVaccine = current(array_filter($vaccinationSchedule, static fn (array $row): bool => in_array($row['schedule_status'], ['Overdue', 'Due Soon', 'Scheduled'], true))) ?: null;
$profileImage = APP_URL . '/resources/assets/images/profile-placeholder.jpg';
$show = static fn (mixed $value, string $fallback = 'Not recorded'): string => $value === null || trim((string) $value) === '' ? $fallback : (string) $value;
?>
<div class="space-y-6">
    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="h-24 bg-gradient-to-r from-cyan-600 to-blue-600"></div>
        <div class="flex flex-col gap-5 px-6 pb-6 sm:flex-row sm:items-end sm:justify-between">
            <div class="flex flex-col items-center gap-4 sm:flex-row sm:items-end">
                <img src="<?= e($profileImage) ?>" alt="Child profile placeholder" class="-mt-12 h-24 w-24 rounded-full border-4 border-white bg-slate-100 object-cover shadow">
                <div class="text-center sm:text-left"><h2 class="text-xl font-bold text-slate-900"><?= e($child['full_name']) ?></h2><p class="text-sm text-slate-500"><?= e($child['family_code']) ?> · <?= e((string) $child['age_months']) ?> months old</p></div>
            </div>
            <div class="flex flex-wrap justify-center gap-2"><a href="<?= e(APP_URL . '/families/' . (int) $child['family_id']) ?>" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">View Family</a><a href="<?= e(APP_URL . '/children/' . (int) $child['person_id'] . '/edit') ?>" class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">Edit Child</a></div>
        </div>
    </section>
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <?php foreach ([['Birth Weight', $show($child['birth_weight_kg']) . ($child['birth_weight_kg'] ? ' kg' : '')], ['Growth Status', $latestGrowth['growth_status'] ?? 'Not assessed'], ['Next Vaccine', $nextVaccine['vaccine_name'] ?? 'No pending dose'], ['Observations', count($observations) . ' recorded']] as [$label, $value]): ?><article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm"><p class="text-sm text-slate-500"><?= e($label) ?></p><p class="mt-2 text-lg font-bold text-slate-900"><?= e($value) ?></p></article><?php endforeach; ?>
    </section>
    <div class="grid gap-6 xl:grid-cols-2">
        <section class="rounded-xl border border-slate-200 bg-white shadow-sm"><div class="border-b border-slate-200 px-6 py-4"><h3 class="font-semibold text-slate-900">Personal and family details</h3></div><dl class="grid gap-x-6 gap-y-5 p-6 sm:grid-cols-2">
            <?php foreach ([['Date of birth',$show($child['date_of_birth'])],['Gender',$show($child['gender'])],['NIC',$show($child['nic'])],['Mother',$show($child['mother_name'])],['Family',$show($child['family_code'])],['Address',$show($child['family_address'])]] as [$label,$value]): ?><div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-400"><?= e($label) ?></dt><dd class="mt-1 text-sm text-slate-800"><?= e($value) ?></dd></div><?php endforeach; ?>
        </dl></section>
        <section class="rounded-xl border border-slate-200 bg-white shadow-sm"><div class="border-b border-slate-200 px-6 py-4"><h3 class="font-semibold text-slate-900">Birth and neonatal details</h3></div><dl class="grid gap-x-6 gap-y-5 p-6 sm:grid-cols-2">
            <?php foreach ([['Delivery date',$show($child['delivery_date'])],['Delivery place',$show($child['delivery_place'])],['Delivery mode',$show($child['delivery_mode'])],['Gestation',$child['gestational_age_weeks'] ? $child['gestational_age_weeks'].' weeks' : 'Not recorded'],['Birth length',$child['birth_length_cm'] ? $child['birth_length_cm'].' cm' : 'Not recorded'],['Head circumference',$child['head_circumference_cm'] ? $child['head_circumference_cm'].' cm' : 'Not recorded'],['Feeding',$show($child['breastfeeding_status'])],['Complications',$show($child['neonatal_complications'],'None recorded')]] as [$label,$value]): ?><div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-400"><?= e($label) ?></dt><dd class="mt-1 text-sm text-slate-800"><?= e($value) ?></dd></div><?php endforeach; ?>
        </dl></section>
    </div>
    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <?php foreach ([['Record Growth','/children/'.$child['person_id'].'/growth/create'],['Record Observation','/children/'.$child['person_id'].'/observations/create'],['Record Vaccination','/children/'.$child['person_id'].'/vaccinations/create'],['Record Supplement','/children/'.$child['person_id'].'/supplements/create']] as [$label,$url]): ?><a href="<?= e(APP_URL . $url) ?>" class="rounded-xl border border-slate-200 bg-white p-5 text-center text-sm font-semibold text-blue-600 shadow-sm transition hover:border-blue-300 hover:bg-blue-50"><?= e($label) ?></a><?php endforeach; ?>
    </section>
</div>
