<?php

// $recentActivities2 = [
// 	[
// 		'type'        => 'Family',
// 		'reference'   => 'FAM-2026-0101',
// 		'description' => 'Kamal & Kamala Perera',
// 		'date_group'  => 'Today',
// 		'time'        => '10:32 AM',
// 		'url'         => APP_URL . '/families/101',
// 	],
// 	[
// 		'type'        => 'Pregnancy',
// 		'reference'   => 'PRG-2026-0021',
// 		'description' => 'Nadeesha Silva',
// 		'date_group'  => 'Today',
// 		'time'        => '09:15 AM',
// 		'url'         => APP_URL . '/pregnancies/201',
// 	],
// 	[
// 		'type'        => 'Child',
// 		'reference'   => 'CH-2026-0045',
// 		'description' => 'Amara Silva',
// 		'date_group'  => 'Today',
// 		'time'        => '08:42 AM',
// 		'url'         => APP_URL . '/children/301',
// 	],
// 	[
// 		'type'        => 'Family',
// 		'reference'   => 'FAM-2026-0102',
// 		'description' => 'Anura & Nadeesha Silva',
// 		'date_group'  => 'Yesterday',
// 		'time'        => '04:20 PM',
// 		'url'         => APP_URL . '/families/102',
// 	],
// 	[
// 		'type'        => 'Child',
// 		'reference'   => 'CH-2026-0044',
// 		'description' => 'Kasun Perera',
// 		'date_group'  => 'Yesterday',
// 		'time'        => '11:05 AM',
// 		'url'         => APP_URL . '/children/302',
// 	],
// 	[
// 		'type'        => 'Pregnancy',
// 		'reference'   => 'PRG-2026-0020',
// 		'description' => 'Shalini Perera',
// 		'date_group'  => 'Earlier',
// 		'time'        => '01 Aug 2026',
// 		'url'         => APP_URL . '/pregnancies/200',
// 	],
// 	[
// 		'type'        => 'Family',
// 		'reference'   => 'FAM-2026-0098',
// 		'description' => 'Ruwan & Dilani Fernando',
// 		'date_group'  => 'Earlier',
// 		'time'        => '31 Jul 2026',
// 		'url'         => APP_URL . '/families/98',
// 	],
// 	[
// 		'type'        => 'Child',
// 		'reference'   => 'CH-2026-0040',
// 		'description' => 'Dinuka Fernando',
// 		'date_group'  => 'Earlier',
// 		'time'        => '31 Jul 2026',
// 		'url'         => APP_URL . '/children/298',
// 	],
// ];
//dd($recentActivities);
?>

<section
	class="flex h-full min-h-0 flex-col overflow-hidden
	       rounded-xl border border-slate-200 bg-white shadow-sm">

	<!-- Header -->
	<div
		class="flex shrink-0 flex-col gap-3 border-b border-slate-200
		       px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

		<div>
			<h2 class="text-base font-semibold text-slate-900">
				Recent Activity
			</h2>

		</div>

	</div>


	<!-- Activity Type Tabs -->
	<div class="shrink-0 border-b border-slate-200 px-5 py-3">

		<div
			class="flex flex-wrap gap-1 rounded-lg bg-slate-100 p-1"
			role="tablist"
			aria-label="Recent activity filters">

			<button
				type="button"
				data-activity-filter="all"
				class="activity-tab rounded-md bg-white px-3 py-1.5
				       text-sm font-medium text-slate-900 shadow-sm"
				role="tab"
				aria-selected="true">
				All
			</button>

			<button
				type="button"
				data-activity-filter="Family"
				class="activity-tab rounded-md px-3 py-1.5
				       text-sm font-medium text-slate-600
				       transition hover:text-slate-900"
				role="tab"
				aria-selected="false">
				Families
			</button>

			<button
				type="button"
				data-activity-filter="Pregnancy"
				class="activity-tab rounded-md px-3 py-1.5
				       text-sm font-medium text-slate-600
				       transition hover:text-slate-900"
				role="tab"
				aria-selected="false">
				Pregnancies
			</button>

			<button
				type="button"
				data-activity-filter="Child"
				class="activity-tab rounded-md px-3 py-1.5
				       text-sm font-medium text-slate-600
				       transition hover:text-slate-900"
				role="tab"
				aria-selected="false">
				Children
			</button>

		</div>

	</div>

	<div
		id="recent-activity-feed"
		class="min-h-0 flex-1 overflow-auto px-5 py-3">

		<?php foreach (['Today', 'Yesterday', 'Earlier'] as $index => $group) : ?>

			<?php
			$groupActivities = array_filter(
				$recentActivities,
				fn($activity) => $activity['date_group'] === $group
			);
			?>

			<?php if (!empty($groupActivities)) : ?>

				<div
					class="activity-group border-b border-slate-100 last:border-b-0"
					data-group="<?= e($group) ?>">

					<!-- Group Header -->
					<button
						type="button"
						class="activity-group-toggle flex w-full
						       items-center justify-start gap-1.5 py-3
						       text-left focus:outline-none"
						aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>">

						<!-- Arrow -->
						<svg
							class="activity-chevron h-3.5 w-3.5 shrink-0
							       text-slate-400 transition-transform
							       duration-200
							       <?= $index === 0 ? 'rotate-90' : '' ?>"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="2"
							stroke="currentColor"
							aria-hidden="true">

							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="m9 5 7 7-7 7" />

						</svg>


						<!-- Group Name -->
						<h3
							class="text-xs font-semibold uppercase
							       tracking-wide text-slate-500">
							<?= e($group) ?>
						</h3>


						<!-- Count -->
						<span
							class="activity-count rounded-full bg-slate-100
							       px-2 py-0.5 text-xs font-medium
							       text-slate-500">
							<?= count($groupActivities) ?>
						</span>

					</button>


					<!-- Group Content -->
					<div
						class="activity-group-content pb-2
						       <?= $index === 0 ? '' : 'hidden' ?>">

						<div class="space-y-1">

							<?php foreach ($groupActivities as $activity) : ?>

								<?php
								$typeClass = match ($activity['type']) {
									'Family' =>
									'bg-blue-50 text-blue-700',

									'Pregnancy' =>
									'bg-pink-50 text-pink-700',

									'Child' =>
									'bg-emerald-50 text-emerald-700',

									default =>
									'bg-slate-100 text-slate-600',
								};
								?>

								<a
									href="<?= e($activity['url']) ?>"
									class="activity-item group flex items-center
									       gap-3 rounded-lg px-3 py-2.5
									       transition hover:bg-slate-50"
									data-activity-type="<?= e($activity['type']) ?>">

									<!-- Type Icon -->
									<div
										class="flex h-8 w-8 shrink-0 items-center
										       justify-center rounded-full
										       <?= $typeClass ?>">

										<?php if ($activity['type'] === 'Family') : ?>

											<svg
												class="h-4 w-4"
												fill="none"
												viewBox="0 0 24 24"
												stroke-width="1.8"
												stroke="currentColor">
												<path
													stroke-linecap="round"
													stroke-linejoin="round"
													d="M15 19a4 4 0 0 0-8 0m4-8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm7 8a4 4 0 0 0-3-3.87M17 5a3 3 0 0 1 0 6" />
											</svg>

										<?php elseif ($activity['type'] === 'Pregnancy') : ?>

											<svg
												class="h-4 w-4"
												fill="none"
												viewBox="0 0 24 24"
												stroke-width="1.8"
												stroke="currentColor">
												<path
													stroke-linecap="round"
													stroke-linejoin="round"
													d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0-13v4l2.5 1.5" />
											</svg>

										<?php else : ?>

											<svg
												class="h-4 w-4"
												fill="none"
												viewBox="0 0 24 24"
												stroke-width="1.8"
												stroke="currentColor">
												<path
													stroke-linecap="round"
													stroke-linejoin="round"
													d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 8a7 7 0 0 1 14 0" />
											</svg>

										<?php endif; ?>

									</div>


									<!-- Activity Details -->
									<div class="min-w-0 flex-1">

										<p class="truncate text-sm text-slate-700">
											<?php if ($activity['type'] === 'Family'): ?>
												
												<span class="text-slate-500">
													<?= e($activity['description']) ?>
												</span>				
												<span
													class="font-semibold text-slate-900">
													(<?= e($activity['reference']) ?>)
												</span>

												
											<?php endif; ?>
											<?php if ($activity['type'] === 'Pregnancy'): ?>
												<span class="text-slate-500">
													<?= e($activity['description']) ?>
												</span>
												<span
													class="font-semibold text-slate-900">
													(<?= e($activity['reference']) ?>)
												</span>


											<?php endif; ?>
											<?php if ($activity['type'] === 'Child'): ?>
												<span class="text-slate-500">
													<?= e($activity['description']) ?>
												</span>
												<span
													class="font-semibold text-slate-900">
													(<?= e($activity['reference']) ?>)
												</span>
											<?php endif; ?>
										</p>

										<p class="mt-0.5 text-xs text-slate-400">
											<?= e($activity['type']) ?> registered
										</p>

									</div>


									<!-- Time -->
									<span
										class="shrink-0 text-xs text-slate-400">
										<?= e($activity['time']) ?>
									</span>


									<!-- Arrow -->
									<svg
										class="h-4 w-4 shrink-0 text-slate-300
										       transition
										       group-hover:translate-x-0.5
										       group-hover:text-slate-500"
										fill="none"
										viewBox="0 0 24 24"
										stroke-width="1.8"
										stroke="currentColor">
										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="m9 5 7 7-7 7" />
									</svg>

								</a>

							<?php endforeach; ?>

						</div>

					</div>

				</div>

			<?php endif; ?>

		<?php endforeach; ?>

	</div>


	<!-- Footer -->
	<div
		class="shrink-0 border-t border-slate-200 px-5 py-3 text-center">

		<a
			href="<?= APP_URL ?>/dashboard#"
			class="text-sm font-medium text-blue-600
			       hover:text-blue-700 hover:underline">
			View all activity
		</a>

	</div>

</section>


<script>
	document.addEventListener('DOMContentLoaded', () => {

		const tabs = document.querySelectorAll('.activity-tab');
		const groups = document.querySelectorAll('.activity-group');


		/*
		 * Activity type filtering
		 */
		tabs.forEach(tab => {

			tab.addEventListener('click', () => {

				const filter = tab.dataset.activityFilter;


				// Update active tab
				tabs.forEach(item => {

					item.classList.remove(
						'bg-white',
						'text-slate-900',
						'shadow-sm'
					);

					item.classList.add('text-slate-600');

					item.setAttribute(
						'aria-selected',
						'false'
					);

				});


				tab.classList.remove('text-slate-600');

				tab.classList.add(
					'bg-white',
					'text-slate-900',
					'shadow-sm'
				);

				tab.setAttribute(
					'aria-selected',
					'true'
				);


				// Filter activities
				groups.forEach(group => {

					let visibleCount = 0;

					const items = group.querySelectorAll(
						'.activity-item'
					);


					items.forEach(item => {

						const type =
							item.dataset.activityType;

						const visible =
							filter === 'all' ||
							type === filter;

						item.classList.toggle(
							'hidden',
							!visible
						);

						if (visible) {
							visibleCount++;
						}

					});


					// Hide group if nothing matches
					group.classList.toggle(
						'hidden',
						visibleCount === 0
					);


					// Update count
					const count =
						group.querySelector('.activity-count');

					if (count) {
						count.textContent = visibleCount;
					}

				});

			});

		});


		/*
		 * Expand / collapse date groups
		 */
		document
			.querySelectorAll('.activity-group-toggle')
			.forEach(button => {

				button.addEventListener('click', () => {

					const group =
						button.closest('.activity-group');

					const content =
						group.querySelector(
							'.activity-group-content'
						);

					const chevron =
						group.querySelector(
							'.activity-chevron'
						);

					const expanded =
						button.getAttribute(
							'aria-expanded'
						) === 'true';


					button.setAttribute(
						'aria-expanded',
						String(!expanded)
					);


					content.classList.toggle(
						'hidden',
						expanded
					);


					/*
					 * Collapsed:
					 *     >
					 *
					 * Expanded:
					 *     >
					 *      ↳ rotated 90°
					 */
					chevron.classList.toggle(
						'rotate-90',
						!expanded
					);

				});

			});

	});
</script>