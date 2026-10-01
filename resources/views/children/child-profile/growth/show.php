<?php
$child = $child ?? [];
$growthRecords = $growthRecords ?? [];
//TEST
//dd($growthRecords);

// lowercase gender
$gender = strtolower(trim((string) ($child['gender'] ?? '')));

// find folder name for charts
$genderFolder = match ($gender) {
    'male' => 'boys',
    'female' => 'girls',
    default => null,
};

// validate child age in months
$childAgeMonths = isset($child['age_months'])
    ? (int) $child['age_months']
    : null;

// charts for age groups
$birthToSixMonthCharts = [
    'weight_for_age_0_6m',
    'length_for_age_0_6m',
    'weight_for_length_0_6m',
    'bmi_for_age_0_6m',
];
$sixToTwentyFourMonthCharts = [
    'weight_for_age_6_24m',
    'length_for_age_6_24m',
    'weight_for_length_0_24m',
    'bmi_for_age_6_24m',
];
$twoToFiveYearCharts = [
    'weight_for_age_24_60m',
    'height_for_age_24_60m',
    'weight_for_height_24_60m',
    'bmi_for_age_24_60m',
];

$chartIds = [];

// find which charts to display based on child age
if ($genderFolder !== null && $childAgeMonths !== null) {
    if ($childAgeMonths >= 0 && $childAgeMonths < 6) {
        $chartIds = $birthToSixMonthCharts;
    } elseif ($childAgeMonths < 24) {
        $chartIds = array_merge(
            $birthToSixMonthCharts,
            $sixToTwentyFourMonthCharts
        );
    } else {
        $chartIds = array_merge(
            $birthToSixMonthCharts,
            $sixToTwentyFourMonthCharts,
            $twoToFiveYearCharts
        );
    }
}

$numberOrNull = static function (mixed $value): ?float {
    return $value !== null
        && $value !== ''
        && is_numeric($value)
        ? (float) $value
        : null;
};

$chartMeasurements = [];

foreach ($growthRecords as $row) {
    $weight = $numberOrNull($row['weight_kg'] ?? null);
    $height = $numberOrNull($row['height_cm'] ?? null);
    $bmi = $numberOrNull($row['bmi'] ?? null);

    // calculate BMI if not provided, but weight and height are available
    if ($bmi === null && $weight !== null && $height !== null && $height > 0) {
        $heightMetres = $height / 100;
        $bmi = $weight / ($heightMetres * $heightMetres);
    }

    $chartMeasurements[] = [
        'date' => (string) ($row['measurement_date'] ?? ''),
        'ageMonths' => (int) (
            $row['chart_age_months']
            ?? $row['age_in_months']
            ?? 0
        ),
        'weight' => $weight,
        'height' => $height,
        'bmi' => $bmi,
    ];
}

$jsonFlags = JSON_HEX_TAG
    | JSON_HEX_AMP
    | JSON_HEX_APOS
    | JSON_HEX_QUOT
    | JSON_THROW_ON_ERROR;


?>
<div class="space-y-5">
    <div class="flex justify-end"><a href="<?= e(APP_URL . '/children/' . (int) $child['person_id'] . '/growth/create') ?>" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Add Measurement</a></div>

    <!-- chart section -->
    <section
        class="overflow-hidden rounded-xl border border-slate-200
           bg-white shadow-sm">

        <?php if ($chartIds !== []): ?>
            <div class="space-y-8 p-4 sm:p-6">
                <?php foreach ($chartIds as $index => $chartId): ?>
                    <details
                        open
                        class="group overflow-hidden rounded-xl
               border border-slate-200 bg-slate-50"
                        data-growth-card="<?= e($chartId) ?>">
                        <summary
                            class="flex cursor-pointer list-none items-center
                   justify-between gap-4 px-4 py-3
                   hover:bg-slate-100
                   [&::-webkit-details-marker]:hidden">
                            <h3
                                class="font-semibold text-slate-900"
                                data-chart-title>
                                Loading chart…
                            </h3>

                            <svg
                                class="h-5 w-5 shrink-0 text-slate-500
                       transition-transform duration-200
                       group-open:rotate-180"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m19 9-7 7-7-7" />
                            </svg>
                        </summary>

                        <div class="border-t border-slate-200 bg-white p-4">
                            <div class="relative h-[420px] sm:h-[600px]">
                                <canvas
                                    id="growth-chart-<?= (int) $index ?>"
                                    aria-label="WHO growth chart"
                                    role="img"></canvas>
                            </div>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="px-6 py-12 text-center">
                <p class="font-medium text-slate-700">
                    Growth charts are not available.
                </p>
            </div>
        <?php endif; ?>
    </section>

    <!-- table section -->
    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr><?php foreach (['Date', 'Age', 'Weight', 'Height', 'Head', 'MUAC', 'W/A Z', 'H/A Z', 'W/H Z', 'Status', 'Action'] as $h): ?><th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500"><?= e($h) ?></th><?php endforeach; ?></tr>
                </thead>
                <tbody class="divide-y divide-slate-100"><?php foreach ($growthRecords as $row): ?><tr>
                            <td class="px-4 py-4 text-sm">
                                <?= e($row['measurement_date']) ?>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <?= e((string) ($row['chart_age_months'] ?? $row['age_in_months'])) ?> mo
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <?= e($row['weight_kg'] ?? '—') ?>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <?= e($row['height_cm'] ?? '—') ?>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <?= e($row['head_circumference_cm'] ?? '—') ?>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <?= e($row['muac_cm'] ?? '—') ?>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <?= e($row['weight_for_age_z_score'] ?? '—') ?>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <?= e($row['height_for_age_z_score'] ?? '—') ?>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <?= e($row['weight_for_height_z_score'] ?? '—') ?>
                            </td>
                            <td class="px-4 py-4 text-sm font-semibold">
                                <?= e($row['growth_status'] ?? 'Not assessed') ?>
                            </td>
                            <td class="px-4 py-4">
                                <a class="text-sm font-semibold text-blue-600" href="<?= e(APP_URL . '/children/' . (int) $child['person_id'] . '/growth/' . (int) $row['measurement_id'] . '/edit') ?>">Edit</a>
                            </td>
                        </tr><?php endforeach; ?><?php if ($growthRecords === []): ?><tr>
                            <td colspan="11" class="px-6 py-12 text-center text-sm text-slate-500">No growth measurements available.</td>
                        </tr><?php endif; ?></tbody>
            </table>
        </div>
    </section>
</div>
<?php if ($chartIds !== []): ?>
    <script type="module">
        import {
            whoGrowthBackground,
            loadGrowthBackground,
            growthChartOptions,
        } from <?= json_encode(
                    APP_URL . '/resources/assets/images/growth-charts/who-growth-background.js',
                    $jsonFlags
                ) ?>;

        const chartIds = <?= json_encode($chartIds, $jsonFlags) ?>;

        const measurements = <?= json_encode(
                                    $chartMeasurements,
                                    $jsonFlags
                                ) ?>;

        const assetRoot = <?= json_encode(
                                APP_URL . '/resources/assets/images/growth-charts/' . $genderFolder,
                                $jsonFlags
                            ) ?>;

        /*
         * A chart may cover a different measurement-age range from the
         * currently selected page group. In particular, the 6–24-month
         * group uses the WHO birth-to-24-month weight-for-length chart.
         */
        const chartAgeRanges = {
            weight_for_age_0_6m: [0, 6],
            length_for_age_0_6m: [0, 6],
            weight_for_length_0_6m: [0, 6],
            bmi_for_age_0_6m: [0, 6],

            weight_for_age_6_24m: [6, 24],
            length_for_age_6_24m: [6, 24],
            weight_for_length_0_24m: [0, 24],
            bmi_for_age_6_24m: [6, 24],

            weight_for_age_24_60m: [24, 60],
            height_for_age_24_60m: [24, 60],
            weight_for_height_24_60m: [24, 60],
            bmi_for_age_24_60m: [24, 60],
        };

        function measurementValue(measure, record) {
            switch (measure) {
                case 'ageMonths':
                    return record.ageMonths;

                case 'weight':
                    return record.weight;

                case 'length':
                case 'height':
                    return record.height;

                case 'bmi':
                    return record.bmi;

                default:
                    return null;
            }
        }

        function createPoints(chartId, spec) {
            const [minimumAge, maximumAge] =
            chartAgeRanges[chartId] ?? [0, 60];

            return measurements
                .filter((record) => {
                    return record.ageMonths >= minimumAge &&
                        record.ageMonths <= maximumAge;
                })
                .sort((first, second) => {
                    return first.ageMonths - second.ageMonths;
                })
                .map((record) => {
                    const x = measurementValue(spec.x.measure, record);
                    const y = measurementValue(spec.y.measure, record);

                    if (!Number.isFinite(x) || !Number.isFinite(y)) {
                        return null;
                    }

                    return {
                        x,
                        y,
                        measurementDate: record.date,
                        ageMonths: record.ageMonths,
                    };
                })
                .filter(Boolean);
        }

        async function renderGrowthChart(chartId, index, layouts) {
            const card = document.querySelector(
                `[data-growth-card="${chartId}"]`
            );

            const titleElement = card.querySelector('[data-chart-title]');
            const canvas = document.getElementById(
                `growth-chart-${index}`
            );

            const spec = layouts.charts[chartId];

            if (!spec) {
                titleElement.textContent =
                    'Chart definition not available';

                titleElement.classList.add('text-rose-600');
                return;
            }

            titleElement.textContent = spec.title.replace(
                /\s+(BOYS|GIRLS)(?=,)/i,
                ''
            );

            const backgroundImage = await loadGrowthBackground(
                `${assetRoot}/${spec.background}`
            );

            const points = createPoints(chartId, spec);
            const options = growthChartOptions(spec, backgroundImage);

            options.interaction = {
                mode: 'nearest',
                intersect: false,
            };

            options.elements = {
                line: {
                    tension: 0,
                },
            };

            options.plugins.tooltip = {
                callbacks: {
                    label(context) {
                        const point = context.raw;

                        return `Child: ${point.y} ${spec.y.unit}`;
                    },

                    afterLabel(context) {
                        const point = context.raw;

                        return [
                            `Age: ${point.ageMonths} months`,
                            `Measured: ${point.measurementDate}`,
                        ];
                    },
                },
            };


            new Chart(canvas, {
                type: 'line',

                data: {
                    datasets: [{
                        label: 'Child measurements',
                        data: points,
                        borderColor: '#1d4ed8',
                        backgroundColor: '#1d4ed8',
                        borderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        fill: false,
                        spanGaps: true,
                    }],
                },

                options,
            });
        }

        try {
            Chart.register(whoGrowthBackground);

            const response = await fetch(
                `${assetRoot}/chart-layouts.json`
            );

            if (!response.ok) {
                throw new Error(
                    `Unable to load chart layouts: ${response.status}`
                );
            }

            const layouts = await response.json();

            await Promise.all(
                chartIds.map((chartId, index) => {
                    return renderGrowthChart(chartId, index, layouts);
                })
            );
        } catch (error) {
            console.error('Unable to render WHO growth charts.', error);

            document
                .querySelectorAll('[data-chart-title]')
                .forEach((element) => {
                    if (element.textContent === 'Loading chart…') {
                        element.textContent =
                            'The WHO chart could not be loaded.';

                        element.classList.add('text-rose-600');
                    }
                });
        }
    </script>
<?php endif; ?>