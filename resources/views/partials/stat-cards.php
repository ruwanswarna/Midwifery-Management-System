<?php

$stats = [
	[
		'title' => 'Registered Families',
		'value' => $dashboardStats['families']['value'] ?? 0,
		'period' => $dashboardStats['families']['period'] ?? 'month',

		'periods' => [
			'week',
			'month',
			'year',
			'total'
		],
		'trend'       => [
			'value' => $dashboardStats['families']['trend']['value'] ?? 0,
			'percentage' => $dashboardStats['families']['trend']['percentage'] ?? 0,
			'direction' => $dashboardStats['families']['trend']['direction'] ?? 'up',
			'period' => $dashboardStats['families']['trend']['period'] ?? '',
			'type' => $dashboardStats['families']['trend']['direction'] === 'up' ? 'positive' : 'negative',
		],

		'description' => 'Total registered families',
		'url'         => APP_URL . '/families',
		'iconClass'   => 'bg-blue-50 text-blue-600',
		'icon'        => '
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 10.5 12 3l9 7.5M5.25 9.75V21h13.5V9.75" />
        ',
	],
	[
		'title'       => 'Registered Pregnancies',
		'value'       => $dashboardStats['pregnancies']['value'] ?? 0,
		'period' => $dashboardStats['pregnancies']['period'] ?? 'month',
		'periods' => [
			'week',
			'month',
			'year',
			'total'
		],
		'trend'       => [
			'value' => $dashboardStats['pregnancies']['trend']['value'] ?? 0,
			'percentage' => $dashboardStats['pregnancies']['trend']['percentage'] ?? 0,
			'direction' => $dashboardStats['pregnancies']['trend']['direction'] ?? '',
			'period' => $dashboardStats['pregnancies']['trend']['period'] ?? '',
			'type' => $dashboardStats['pregnancies']['trend']['direction'] === 'up' ? 'positive' : 'negative',
		],
		'description' => 'Women receiving maternal care',
		'url'         => APP_URL . '/mothers',
		'iconClass'   => 'bg-rose-50 text-rose-600',
		'icon'        => '
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0
                   3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5
                   7.5 0 0 1 15 0" />
        ',
	],
	[
		'title'       => 'Active Pregnancies',
		'value'       => $dashboardStats['activePregnancies']['value'] ?? 0,
		'trend'       => [
			'value' => ($dashboardStats['activePregnancies']['dueSoon'] ?? 0) . ' due soon',
			'type'   => 'warning',
		],
		'description' => 'Currently monitored pregnancies',
		'url'         => APP_URL . '/pregnancies',
		'iconClass'   => 'bg-violet-50 text-violet-600',
		'icon'        => '
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.1-4.5-4.688-4.5
                   -1.935 0-3.597 1.126-4.312 2.733
                   C11.285 4.876 9.623 3.75 7.688 3.75
                   5.1 3.75 3 5.765 3 8.25
                   c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        ',
	],
	[
		'title'       => 'Registered Children',
		'value'       => $dashboardStats['children']['value'] ?? 0,
		'trend'       => [
			'value' => $dashboardStats['children']['registeredCount']['value'] . ' ' .
				$dashboardStats['children']['registeredCount']['period'],
			'type'   => 'positive',
		],
		'description' => 'Children receiving routine care',
		'url'         => APP_URL . '/children',
		'iconClass'   => 'bg-emerald-50 text-emerald-600',
		'icon'        => '
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 8.25a3 3 0 1 0 0-6
                   3 3 0 0 0 0 6ZM6.75 21a5.25
                   5.25 0 0 1 10.5 0" />
        ',
	],
	[
		'title'       => 'Growth Alerts',
		'value'       => $dashboardStats['growthAlerts']['value'] ?? 0,
		'trend'       => [
			'value' => ($dashboardStats['growthAlerts']['newCases'] ?? 0) . ' new cases',
			'type'   => 'warning',
		],
		'description' => 'Children requiring follow-up',
		'url'         => APP_URL . '/children/growth?status=alert',
		'iconClass'   => 'bg-amber-50 text-amber-600',
		'icon'        => '
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 18.75 9 13.5l3.75 3.75
                   7.5-9" />
        ',
	],
	[
		'title'       => 'High-Risk Pregnancies',
		'value'       => $dashboardStats['highRiskPregnancies']['value'] ?? 0,
		'trend'       => [
			'value' => ($dashboardStats['highRiskPregnancies']['needFollowup'] ?? 0) . ' need follow-up',
			'type'   => 'danger',
		],
		'description' => 'Pregnancies needing attention',
		'url'         => APP_URL . '/pregnancies?risk_level=high',
		'iconClass'   => 'bg-red-50 text-red-600',
		'icon'        => '
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v3.75" />
        ',
	],
];

?>


<div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

	<?php foreach ($stats as $stat) : ?>

		<div
			onclick="window.location.href='<?= e($stat['url']) ?>'"
			class="group cursor-pointer rounded-xl border border-slate-200 bg-white p-5
                   shadow-sm transition duration-200
                   hover:-translate-y-0.5 hover:border-blue-200
                   hover:shadow-md">
			<div class="flex items-start justify-between gap-4">
				<div class="min-w-0 flex-1">
					<p class="text-sm font-medium text-slate-500">
						<?= e($stat['title']) ?>
					</p>

					<p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
						<?= number_format((int) $stat['value']) ?>
					</p>


				</div>
				<?php if (isset($stat['period'])): ?>

					<div class="mt-3 flex flex-wrap gap-1">

						<?php foreach ($stat['periods'] as $key): ?>

							<button
								type="button"
								data-period="<?= $key ?>"
								onclick="event.stopPropagation()"
								class="period-btn rounded-md px-2 py-1 text-xs transition
								 <?= $stat['period'] === $key
										? 'bg-blue-50 text-blue-600 font-medium'
										: 'text-slate-500 hover:bg-slate-50' ?>">
								<?= e($key) ?>
							</button>

						<?php endforeach; ?>

					</div>

				<?php endif; ?>

				<div
					class="flex h-12 w-12 shrink-0 items-center justify-center
                           rounded-xl <?= e($stat['iconClass']) ?>">
					<svg
						class="h-6 w-6"
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.8"
						stroke="currentColor"
						aria-hidden="true">
						<?= $stat['icon'] ?>
					</svg>
				</div>

			</div>

			<div class="mt-4 flex items-center justify-between gap-3">
				<div>
					<p class="text-xs text-slate-500">
						<?= e($stat['description']) ?>
					</p>

					<?php if (isset($stat['trend'])): ?>

						<p class="mt-1 text-xs font-medium <?= match ($stat['trend']['type'] ?? '') {
																'positive' => 'text-emerald-600',
																'warning' => 'text-amber-600',
																'danger' => 'text-red-600',
																default => 'text-slate-600'
															} ?>">

							<?php if (isset($stat['trend']['direction'])): ?>
								<?= $stat['trend']['direction'] === 'up' ? '↑' : '↓' ?>
							<?php endif; ?>
							<?php if (gettype($stat['trend']['value']) === 'integer'): ?>
								<?= number_format($stat['trend']['value']) ?>
							<?php else: ?>
								<?= $stat['trend']['value'] ?>
							<?php endif; ?>
							<?php if (isset($stat['trend']['percentage'])): ?>
								(<?= number_format($stat['trend']['percentage'], 1) ?>%)
							<?php endif; ?>
							<?php if (isset($stat['trend']['period'])): ?>
								<span class="font-normal text-slate-500">
									vs <?= e($stat['trend']['period']) ?>
								</span>
							<?php endif; ?>

						</p>

					<?php endif; ?>
				</div>

				<svg
					class="h-4 w-4 shrink-0 text-slate-400 transition
                           group-hover:translate-x-0.5 group-hover:text-blue-600"
					fill="none"
					viewBox="0 0 24 24"
					stroke-width="1.8"
					stroke="currentColor"
					aria-hidden="true">
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="m9 18 6-6-6-6" />
				</svg>
			</div>
		</div>

	<?php endforeach; ?>

</div>


<!-- <?php
		// Use this in dashboard/index.php: to display stat cards
		// '<div class="space-y-6"><?php require __DIR__ . '/partials/stat-cards.php'; 
		?></div>'
?> -->