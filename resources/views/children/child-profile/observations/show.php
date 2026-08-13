<?php

$observations = $observations ?? [];
$milestones = $milestones ?? [];

/*
 * Temporary milestone chart demonstration data.
 * Remove this block when database data is available.
 */
$child['date_of_birth'] = '2024-01-15';
$child['age_months'] = 30;

$milestones = [
	[
		'milestone_id' => 8,
		'milestone_name' => 'Runs',
		'expected_age_from_month' => 18,
		'expected_age_to_month' => 24,
	],
	[
		'milestone_id' => 7,
		'milestone_name' => 'Walks Independently',
		'expected_age_from_month' => 12,
		'expected_age_to_month' => 18,
	],
	[
		'milestone_id' => 6,
		'milestone_name' => 'Pulls to Stand',
		'expected_age_from_month' => 9,
		'expected_age_to_month' => 11,
	],
	[
		'milestone_id' => 5,
		'milestone_name' => 'Crawls',
		'expected_age_from_month' => 7,
		'expected_age_to_month' => 10,
	],
	[
		'milestone_id' => 4,
		'milestone_name' => 'Sits Without Support',
		'expected_age_from_month' => 6,
		'expected_age_to_month' => 8,
	],
	[
		'milestone_id' => 3,
		'milestone_name' => 'Rolls Over',
		'expected_age_from_month' => 4,
		'expected_age_to_month' => 6,
	],
	[
		'milestone_id' => 2,
		'milestone_name' => 'Head Control',
		'expected_age_from_month' => 3,
		'expected_age_to_month' => 4,
	],
];

/*
 * Ordered newest first, matching the repository query.
 *
 * This test history includes:
 * - Milestones achieved within their expected windows
 * - Delayed milestones
 * - Not-achieved observations
 * - Follow-up assessments
 * - Later achievement after intervention
 */
$observations = [
	[
		'observation_id' => 8010,
		'child_id' => (int) $child['person_id'],
		'milestone_id' => 8,
		'milestone_name' => 'Runs',
		'milestone_category' => 'Gross Motor',
		'expected_age_from_month' => 18,
		'expected_age_to_month' => 24,
		'observation_date' => '2026-02-15',
		'observation_age_months' => 25,
		'observation_status' => 'Achieved',
		'follow_up_required' => 0,
		'follow_up_date' => null,
		'observed_by' => 1,
		'observed_by_name' => 'Test PHM Officer',
		'remarks' =>
		'Running achieved after continued motor-development activities.',
	],
	[
		'observation_id' => 8009,
		'child_id' => (int) $child['person_id'],
		'milestone_id' => 8,
		'milestone_name' => 'Runs',
		'milestone_category' => 'Gross Motor',
		'expected_age_from_month' => 18,
		'expected_age_to_month' => 24,
		'observation_date' => '2025-11-15',
		'observation_age_months' => 22,
		'observation_status' => 'Not Achieved',
		'follow_up_required' => 1,
		'follow_up_date' => '2026-02-15',
		'observed_by' => 1,
		'observed_by_name' => 'Test PHM Officer',
		'remarks' =>
		'Unable to run steadily; follow-up exercises recommended.',
	],
	[
		'observation_id' => 8008,
		'child_id' => (int) $child['person_id'],
		'milestone_id' => 7,
		'milestone_name' => 'Walks Independently',
		'milestone_category' => 'Gross Motor',
		'expected_age_from_month' => 12,
		'expected_age_to_month' => 18,
		'observation_date' => '2025-07-15',
		'observation_age_months' => 18,
		'observation_status' => 'Achieved',
		'follow_up_required' => 0,
		'follow_up_date' => null,
		'observed_by' => 1,
		'observed_by_name' => 'Test PHM Officer',
		'remarks' =>
		'Independent walking achieved following home exercises.',
	],
	[
		'observation_id' => 8007,
		'child_id' => (int) $child['person_id'],
		'milestone_id' => 7,
		'milestone_name' => 'Walks Independently',
		'milestone_category' => 'Gross Motor',
		'expected_age_from_month' => 12,
		'expected_age_to_month' => 18,
		'observation_date' => '2025-05-15',
		'observation_age_months' => 16,
		'observation_status' => 'Not Achieved',
		'follow_up_required' => 1,
		'follow_up_date' => '2025-07-15',
		'observed_by' => 1,
		'observed_by_name' => 'Test PHM Officer',
		'remarks' =>
		'Can walk while holding furniture but not independently.',
	],
	[
		'observation_id' => 8006,
		'child_id' => (int) $child['person_id'],
		'milestone_id' => 6,
		'milestone_name' => 'Pulls to Stand',
		'milestone_category' => 'Gross Motor',
		'expected_age_from_month' => 9,
		'expected_age_to_month' => 11,
		'observation_date' => '2025-01-15',
		'observation_age_months' => 12,
		'observation_status' => 'Delayed',
		'follow_up_required' => 1,
		'follow_up_date' => '2025-02-15',
		'observed_by' => 1,
		'observed_by_name' => 'Test PHM Officer',
		'remarks' =>
		'Achieved slightly later than the expected age window.',
	],
	[
		'observation_id' => 8005,
		'child_id' => (int) $child['person_id'],
		'milestone_id' => 5,
		'milestone_name' => 'Crawls',
		'milestone_category' => 'Gross Motor',
		'expected_age_from_month' => 7,
		'expected_age_to_month' => 10,
		'observation_date' => '2024-11-15',
		'observation_age_months' => 10,
		'observation_status' => 'Achieved',
		'follow_up_required' => 0,
		'follow_up_date' => null,
		'observed_by' => 1,
		'observed_by_name' => 'Test PHM Officer',
		'remarks' =>
		'Crawling achieved within the expected age window.',
	],
	[
		'observation_id' => 8004,
		'child_id' => (int) $child['person_id'],
		'milestone_id' => 4,
		'milestone_name' => 'Sits Without Support',
		'milestone_category' => 'Gross Motor',
		'expected_age_from_month' => 6,
		'expected_age_to_month' => 8,
		'observation_date' => '2024-10-15',
		'observation_age_months' => 9,
		'observation_status' => 'Delayed',
		'follow_up_required' => 1,
		'follow_up_date' => '2024-11-15',
		'observed_by' => 1,
		'observed_by_name' => 'Test PHM Officer',
		'remarks' =>
		'Sitting achieved one month after the expected age window.',
	],
	[
		'observation_id' => 8003,
		'child_id' => (int) $child['person_id'],
		'milestone_id' => 3,
		'milestone_name' => 'Rolls Over',
		'milestone_category' => 'Gross Motor',
		'expected_age_from_month' => 4,
		'expected_age_to_month' => 6,
		'observation_date' => '2024-07-15',
		'observation_age_months' => 6,
		'observation_status' => 'Achieved',
		'follow_up_required' => 0,
		'follow_up_date' => null,
		'observed_by' => 1,
		'observed_by_name' => 'Test PHM Officer',
		'remarks' =>
		'Rolling over achieved within the expected age window.',
	],
	[
		'observation_id' => 8002,
		'child_id' => (int) $child['person_id'],
		'milestone_id' => 2,
		'milestone_name' => 'Head Control',
		'milestone_category' => 'Gross Motor',
		'expected_age_from_month' => 3,
		'expected_age_to_month' => 4,
		'observation_date' => '2024-05-15',
		'observation_age_months' => 4,
		'observation_status' => 'Achieved',
		'follow_up_required' => 0,
		'follow_up_date' => null,
		'observed_by' => 1,
		'observed_by_name' => 'Test PHM Officer',
		'remarks' =>
		'Head control achieved within the expected age window.',
	],
];

$grossMotorObservations = array_values(
	array_filter(
		$observations,
		static fn(array $observation): bool => ($observation['milestone_category'] ?? '')
			=== 'Gross Motor'
	)
);

$milestoneChartHeight = max(
	420,
	count($milestones) * 62 + 120
);

$jsonFlags = JSON_HEX_TAG
	| JSON_HEX_AMP
	| JSON_HEX_APOS
	| JSON_HEX_QUOT
	| JSON_THROW_ON_ERROR;
?>
<div class="space-y-5">
	<div class="flex justify-end"><a href="<?= e(APP_URL . '/children/' . (int) $child['person_id'] . '/observations/create') ?>" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white">Record Observation</a></div>
	<!-- chart section -->
	<?php if ($milestones !== []): ?>
		<details
			open
			id="milestone-chart-card"
			class="group overflow-hidden rounded-xl
               border border-slate-200 bg-white shadow-sm">
			<summary
				class="flex cursor-pointer list-none items-center
                   justify-between gap-4 px-5 py-4
                   hover:bg-slate-50
                   [&::-webkit-details-marker]:hidden">
				<div>
					<h2 class="font-semibold text-slate-900">
						Development Milestones
					</h2>

				</div>

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

			<div class="border-t border-slate-200 p-4 sm:p-6">
				<div
					class="relative"
					style="height: <?= (int) $milestoneChartHeight ?>px">
					<canvas
						id="gross-motor-milestone-chart"
						aria-label="Gross motor milestone chart"
						role="img"></canvas>
				</div>

				<div
					class="mt-4 flex flex-wrap gap-x-5 gap-y-2
                       border-t border-slate-100 pt-4 text-xs
                       text-slate-600">
					<span class="inline-flex items-center gap-2">
						<span
							class="h-3 w-6 rounded-sm bg-blue-100
                               ring-1 ring-blue-300"></span>
						Expected age window
					</span>

					<span class="inline-flex items-center gap-2">
						<span
							class="h-3 w-3 rounded-full bg-emerald-600"></span>
						Achieved
					</span>

					<span class="inline-flex items-center gap-2">
						<span
							class="h-3 w-3 rotate-45 bg-amber-500"></span>
						Delayed
					</span>

					<span class="inline-flex items-center gap-2">
						<span class="font-bold text-rose-600">
							×
						</span>
						Not achieved
					</span>
				</div>
			</div>
		</details>
	<?php endif; ?>
	<!-- table section -->
	<section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-slate-200">
				<thead class="bg-slate-50">
					<tr><?php foreach (['Milestone', 'Category', 'Expected Age', 'Observation Date', 'Result', 'Follow-up', 'Observed By', 'Action'] as $h): ?><th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500"><?= e($h) ?></th><?php endforeach; ?></tr>
				</thead>
				<tbody class="divide-y divide-slate-100">
					<?php foreach ($observations as $row): ?><tr>
							<td class="px-4 py-4 text-sm font-semibold text-slate-900"><?= e($row['milestone_name']) ?></td>
							<td class="px-4 py-4 text-sm"><?= e($row['milestone_category']) ?></td>
							<td class="px-4 py-4 text-sm"><?= e($row['expected_age_from_month'] . '–' . $row['expected_age_to_month'] . ' mo') ?></td>
							<td class="px-4 py-4 text-sm"><?= e($row['observation_date']) ?></td>
							<td class="px-4 py-4 text-sm font-semibold"><?= e($row['observation_status']) ?></td>
							<td class="px-4 py-4 text-sm"><?= e($row['follow_up_date'] ?? '—') ?></td>
							<td class="px-4 py-4 text-sm"><?= e($row['observed_by_name']) ?></td>
							<td class="px-4 py-4"><a class="text-sm font-semibold text-blue-600" href="<?= e(APP_URL . '/children/' . (int) $child['person_id'] . '/observations/' . (int) $row['observation_id'] . '/edit') ?>">Edit</a></td>
						</tr><?php endforeach; ?><?php if ($observations === []): ?><tr>
							<td colspan="8" class="px-6 py-12 text-center text-sm text-slate-500">No developmental observations recorded.</td>
						</tr><?php endif; ?></tbody>
			</table>
		</div>
	</section>
</div>

<!-- chart js -->
<?php if ($milestones !== []): ?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			if (typeof Chart === 'undefined') {
				console.error('Chart.js is not loaded.');
				return;
			}

			const canvas = document.getElementById(
				'gross-motor-milestone-chart'
			);

			const card = document.getElementById(
				'milestone-chart-card'
			);

			if (!canvas || !card) {
				return;
			}

			const milestones = <?= json_encode(
									$milestones,
									$jsonFlags
								) ?>;

			const observations = <?= json_encode(
										$grossMotorObservations,
										$jsonFlags
									) ?>;

			const milestoneNames = milestones.map(function(milestone) {
				return milestone.milestone_name;
			});

			const expectedWindows = milestones.map(
				function(milestone) {
					return [
						Number(milestone.expected_age_from_month),
						Number(milestone.expected_age_to_month),
					];
				}
			);

			function pointsForStatus(status) {
				return observations
					.filter(function(observation) {
						return observation.observation_status === status &&
							observation.observation_age_months !== null;
					})
					.map(function(observation) {
						return {
							x: Number(
								observation.observation_age_months
							),

							y: observation.milestone_name,

							observationDate: observation.observation_date,

							status: observation.observation_status,

							expectedFrom: Number(
								observation.expected_age_from_month
							),

							expectedTo: Number(
								observation.expected_age_to_month
							),
						};
					});
			}

			const allAges = [
				24,

				...milestones.map(function(milestone) {
					return Number(
						milestone.expected_age_to_month
					);
				}),

				...observations.map(function(observation) {
					return Number(
						observation.observation_age_months ?? 0
					);
				}),
			];

			const maximumAge = Math.ceil(
				Math.max(...allAges) + 1
			);

			const chart = new Chart(canvas, {
				type: 'bar',

				data: {
					labels: milestoneNames,

					datasets: [{
							type: 'bar',
							label: 'Expected age window',
							data: expectedWindows,
							backgroundColor: 'rgba(59, 130, 246, 0.16)',
							borderColor: 'rgba(59, 130, 246, 0.55)',
							borderWidth: 1,
							borderRadius: 4,
							borderSkipped: false,
							barPercentage: 0.55,
							categoryPercentage: 0.8,
							order: 4,
						},
						{
							type: 'scatter',
							label: 'Achieved',
							data: pointsForStatus('Achieved'),
							pointStyle: 'circle',
							pointRadius: 6,
							pointHoverRadius: 8,
							backgroundColor: '#059669',
							borderColor: '#ffffff',
							borderWidth: 2,
							order: 1,
						},
						{
							type: 'scatter',
							label: 'Delayed',
							data: pointsForStatus('Delayed'),
							pointStyle: 'triangle',
							pointRadius: 7,
							pointHoverRadius: 9,
							backgroundColor: '#d97706',
							borderColor: '#ffffff',
							borderWidth: 2,
							order: 1,
						},
						{
							type: 'scatter',
							label: 'Not achieved',
							data: pointsForStatus('Not Achieved'),
							pointStyle: 'crossRot',
							pointRadius: 8,
							pointHoverRadius: 10,
							backgroundColor: '#dc2626',
							borderColor: '#dc2626',
							borderWidth: 3,
							order: 1,
						},
					],
				},

				options: {
					indexAxis: 'y',
					responsive: true,
					maintainAspectRatio: false,
					animation: false,

					interaction: {
						mode: 'nearest',
						intersect: false,
					},

					plugins: {
						legend: {
							display: false,
						},

						tooltip: {
							callbacks: {
								label(context) {
									/*
									 * The floating bar contains an array:
									 * [expectedFrom, expectedTo].
									 */
									if (
										context.dataset.label ===
										'Expected age window'
									) {
										const range = context.raw;

										return `Expected: ${range[0]}–${range[1]} months`;
									}

									const point = context.raw;

									return [
										`${point.status}: ${point.x} months`,
										`Expected: ${point.expectedFrom}–${point.expectedTo} months`,
										`Observed: ${point.observationDate}`,
									];
								},
							},
						},
					},

					scales: {
						x: {
							type: 'linear',
							min: 0,
							max: maximumAge,

							title: {
								display: true,
								text: 'Age in completed months',
							},

							ticks: {
								stepSize: 1,
								precision: 0,
							},

							grid: {
								color: 'rgba(148, 163, 184, 0.22)',
							},
						},

						y: {
							type: 'category',

							title: {
								display: true,
								text: 'Gross motor milestone',
							},

							grid: {
								display: false,
							},

							ticks: {
								autoSkip: false,
							},
						},
					},
				},
			});

			/*
			 * Recalculate the canvas size whenever the collapsible
			 * chart is opened.
			 */
			card.addEventListener('toggle', function() {
				if (card.open) {
					requestAnimationFrame(function() {
						chart.resize();
					});
				}
			});
		});
	</script>
<?php endif; ?>