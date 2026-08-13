<form
	action="<?= APP_URL ?>/families/registry"
	method="GET"
	class="mb-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
	<div class="flex flex-col gap-3 xl:flex-row xl:items-center">

		<div class="relative min-w-0 flex-1">

			<svg
				class="pointer-events-none absolute left-3 top-1/2 h-5 w-5
                       -translate-y-1/2 text-slate-400"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="1.8"
				stroke="currentColor"
				aria-hidden="true">
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					d="m21 21-4.35-4.35m1.35-5.4
                       a6.75 6.75 0 1 1-13.5 0
                       6.75 6.75 0 0 1 13.5 0Z" />
			</svg>

			<input
				type="search"
				name="search"
				value="<?= e($_GET['search'] ?? '') ?>"
				placeholder="Search registration number or family head..."
				class="w-full rounded-lg border border-slate-300 bg-white
                       py-2.5 pl-10 pr-4 text-sm text-slate-800 outline-none
                       transition placeholder:text-slate-400
                       focus:border-blue-500 focus:ring-2
                       focus:ring-blue-500/20">

		</div>

		<select
			name="phm_area"
			class="rounded-lg border border-slate-300 bg-white px-3 py-2.5
                   text-sm text-slate-700 outline-none
                   focus:border-blue-500 focus:ring-2
                   focus:ring-blue-500/20">
			<option value="">All PHM Areas</option>

			<?php foreach ($phmAreas ?? [] as $area) : ?>
				<option
					value="<?= (int) $area['phm_area_id'] ?>"
					<?= ((string) ($_GET['phm_area'] ?? '')) ===
						((string) $area['phm_area_id'])
						? 'selected'
						: ''
					?>>
					<?= e($area['phm_area_name']) ?>
				</option>
			<?php endforeach; ?>
		</select>

		<select
			name="status"
			class="rounded-lg border border-slate-300 bg-white px-3 py-2.5
                   text-sm text-slate-700 outline-none
                   focus:border-blue-500 focus:ring-2
                   focus:ring-blue-500/20">
			<option value="">All Statuses</option>
			<option
				value="Active"
				<?= ($_GET['status'] ?? '') === 'Active'
					? 'selected'
					: ''
				?>>
				Active
			</option>
			<option
				value="Inactive"
				<?= ($_GET['status'] ?? '') === 'Inactive'
					? 'selected'
					: ''
				?>>
				Inactive
			</option>
			<option
				value="Follow-up Due"
				<?= ($_GET['status'] ?? '') === 'Follow-up Due'
					? 'selected'
					: ''
				?>>
				Follow-up Due
			</option>
		</select>

		<button
			type="submit"
			class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm
                   font-semibold text-white transition hover:bg-blue-700">
			Apply Filters
		</button>

		<a
			href="<?= APP_URL ?>/families/registry"
			class="rounded-lg border border-slate-300 bg-white px-4 py-2.5
                   text-center text-sm font-medium text-slate-700
                   transition hover:bg-slate-50">
			Reset
		</a>

	</div>
</form>
<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

	<!-- Table header -->
	<div
		class="flex flex-col gap-4 border-b border-slate-200 px-5 py-4
               sm:flex-row sm:items-center sm:justify-between">
		<div>
			<h2 class="text-base font-semibold text-slate-900">
				Family Registry
			</h2>
			<p class="mt-1 text-sm text-slate-500">
				<?= number_format((int) ($pagination['total'] ?? 0)) ?>
				registered families
			</p>
		</div>

		<!-- + Register Family Button -->
		<a
			href="<?= APP_URL ?>/families/register"
			class="inline-flex items-center justify-center gap-2
                   rounded-lg bg-blue-600 px-4 py-2.5 text-sm
                   font-semibold text-white shadow-sm transition
                   hover:bg-blue-700">
			<svg
				class="h-5 w-5"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="2"
				stroke="currentColor"
				aria-hidden="true">
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					d="M12 4.5v15m7.5-7.5h-15" />
			</svg>

			Register Family
		</a>
	</div>
	<?php
	//TEST
	//dd($families); 
	//d($families);
	?>
	<?php if (!empty($families)) : ?>
		<div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
			<div class="max-h-[600px] overflow-auto">

				<table class="min-w-full divide-y divide-slate-200">

					<thead class="sticky top-0 z-10 bg-slate-50">
						<tr>
							<th
								scope="col"
								class="whitespace-nowrap px-5 py-3 text-left
                                   text-xs font-semibold uppercase
                                   tracking-wide text-slate-500">
								Registration No.
							</th>

							<th
								scope="col"
								class="whitespace-nowrap px-5 py-3 text-left
                                   text-xs font-semibold uppercase
                                   tracking-wide text-slate-500">
								Address
							</th>

							<th
								scope="col"
								class="whitespace-nowrap px-5 py-3 text-left
                                   text-xs font-semibold uppercase
                                   tracking-wide text-slate-500">
								PHM Area
							</th>

							<th
								scope="col"
								class="whitespace-nowrap px-5 py-3 text-left
                                   text-xs font-semibold uppercase
                                   tracking-wide text-slate-500">
								Registration Date
							</th>

							<th
								scope="col"
								class="whitespace-nowrap px-5 py-3 text-left
                                   text-xs font-semibold uppercase
                                   tracking-wide text-slate-500">
								Status
							</th>

							<th
								scope="col"
								class="whitespace-nowrap px-5 py-3 text-right
                                   text-xs font-semibold uppercase
                                   tracking-wide text-slate-500">
								Actions
							</th>
						</tr>
					</thead>

					<tbody class="divide-y divide-slate-100 bg-white">

						<?php foreach ($families as $family) : ?>
							<?php
							$status = $family['status'] ?? 'Active';
							$statusClass = match ($status) {  // match does not need break; statements like switch
								'Active' =>
								'bg-emerald-100 text-emerald-700',

								'Inactive' =>
								'bg-slate-100 text-slate-600',

								'Follow-up Due' =>
								'bg-amber-100 text-amber-700',

								default =>
								'bg-slate-100 text-slate-600',
							}; // resolve to a string value - nothing is returned
							?>

							<tr class="transition hover:bg-slate-50">

								<td class="whitespace-nowrap px-5 py-4">
									<a
										href="<?= APP_URL ?>/families/<?= (int) $family['family_id'] ?>"
										class="text-sm font-semibold text-blue-600
                                           hover:text-blue-700 hover:underline">
										<?= e($family['registration_number']) ?>
									</a>
								</td>

								<td class="px-5 py-4">
									<?php if (!empty($family['address'])) : ?>
										<p class="mt-0.5 text-xs text-slate-500">
											<?= e($family['address']) ?>
										</p>
									<?php endif; ?>
								</td>

								<td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
									<?= e($family['phm_area'] ?? '—') ?>
								</td>

								<td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
									<?= e($family['registered_date'] ?? '—') ?>
								</td>

								<!-- <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
								<?= number_format((int) ($family['member_count'] ?? 0)) ?>
							</td> -->

								<td class="whitespace-nowrap px-5 py-4">
									<span
										class="inline-flex rounded-full px-2.5 py-1
                                           text-xs font-medium
                                           <?= e($statusClass) ?>">
										<?= e($status) ?>
									</span>
								</td>

								<td class="whitespace-nowrap px-5 py-4 text-right">
									<div class="flex items-center justify-end gap-2">

										<a
											href="<?= APP_URL ?>/families/<?= (int) $family['family_id'] ?>"
											class="rounded-lg p-2 text-slate-500
                                               transition hover:bg-blue-50
                                               hover:text-blue-600"
											aria-label="View family"
											title="View">
											<svg
												class="h-5 w-5"
												fill="none"
												viewBox="0 0 24 24"
												stroke-width="1.8"
												stroke="currentColor"
												aria-hidden="true">
												<path
													stroke-linecap="round"
													stroke-linejoin="round"
													d="M2.25 12s3.75-6.75 9.75-6.75
                                                   S21.75 12 21.75 12
                                                   18 18.75 12 18.75 2.25 12 2.25 12Z" />
												<path
													stroke-linecap="round"
													stroke-linejoin="round"
													d="M15 12a3 3 0 1 1-6 0
                                                   3 3 0 0 1 6 0Z" />
											</svg>
										</a>

										<a
											href="<?= APP_URL ?>/families/<?= (int) $family['family_id'] ?>/edit"
											class="rounded-lg p-2 text-slate-500
                                               transition hover:bg-amber-50
                                               hover:text-amber-600"
											aria-label="Edit family"
											title="Edit">
											<svg
												class="h-5 w-5"
												fill="none"
												viewBox="0 0 24 24"
												stroke-width="1.8"
												stroke="currentColor"
												aria-hidden="true">
												<path
													stroke-linecap="round"
													stroke-linejoin="round"
													d="m16.862 4.487 1.687-1.688
                                                   a1.875 1.875 0 1 1 2.652 2.652
                                                   L10.582 16.07a4.5 4.5 0 0 1
                                                   -1.897 1.13L6 18l.8-2.685
                                                   a4.5 4.5 0 0 1 1.13-1.897
                                                   l8.932-8.931Z" />
												<path
													stroke-linecap="round"
													stroke-linejoin="round"
													d="M19.5 7.125 16.862 4.487" />
											</svg>
										</a>

									</div>
								</td>

							</tr>

						<?php endforeach; ?>

					</tbody>
				</table>
				<?php if ($pagination['totalRecords'] > 0): ?>
					<div class="sticky bottom-0 z-10 bg-white py-5 px-5 flex flex-col gap-3 border-t border-slate-200 pt-4 sm:flex-row sm:items-center sm:justify-between">

						<p class="text-sm text-slate-600">
							Showing
							<span class="font-medium">
								<?= e((string) $pagination['from']) ?>
							</span>
							to
							<span class="font-medium">
								<?= e((string) $pagination['to']) ?>
							</span>
							of
							<span class="font-medium">
								<?= e((string) $pagination['totalRecords']) ?>
							</span>
							families
						</p>

						<?php if ($pagination['totalPages'] > 1): ?>
							<nav class="flex flex-wrap items-center gap-1"
								aria-label="Family registry pagination">

								<!-- Previous -->
								<?php if ($pagination['currentPage'] > 1): ?>
									<a
										href="<?= APP_URL ?>/families/registry?page=<?= $pagination['currentPage'] - 1 ?>"
										class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
										Previous
									</a>
								<?php else: ?>
									<span
										class="cursor-not-allowed rounded-md border border-slate-200 bg-slate-100 px-3 py-2 text-sm text-slate-400">
										Previous
									</span>
								<?php endif; ?>

								<!-- Page numbers -->
								<?php for ($page = 1; $page <= $pagination['totalPages']; $page++): ?>
									<a
										href="<?= APP_URL ?>/families/registry?page=<?= $page ?>"
										class="rounded-md border px-3 py-2 text-sm
                            <?= $page === $pagination['currentPage']
										? 'border-blue-600 bg-blue-600 text-white'
										: 'border-slate-300 bg-white text-slate-700 hover:bg-slate-50' ?>"
										<?= $page === $pagination['currentPage']
											? 'aria-current="page"'
											: '' ?>>
										<?= $page ?>
									</a>
								<?php endfor; ?>

								<!-- Next -->
								<?php if ($pagination['currentPage'] < $pagination['totalPages']): ?>
									<a
										href="<?= APP_URL ?>/families/registry?page=<?= $pagination['currentPage'] + 1 ?>"
										class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
										Next
									</a>
								<?php else: ?>
									<span
										class="cursor-not-allowed rounded-md border border-slate-200 bg-slate-100 px-3 py-2 text-sm text-slate-400">
										Next
									</span>
								<?php endif; ?>

							</nav>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</div>
		</div>



	<?php else : ?>

		<div class="px-6 py-14 text-center">

			<div
				class="mx-auto flex h-12 w-12 items-center justify-center
                       rounded-full bg-slate-100 text-slate-400">
				<svg
					class="h-6 w-6"
					fill="none"
					viewBox="0 0 24 24"
					stroke-width="1.8"
					stroke="currentColor"
					aria-hidden="true">
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="M3 10.5 12 3l9 7.5M5.25
                           9.75V21h13.5V9.75" />
				</svg>
			</div>

			<h3 class="mt-4 text-sm font-semibold text-slate-900">
				No families registered
			</h3>

			<a
				href="<?= APP_URL ?>/families/register"
				class="mt-5 inline-flex rounded-lg bg-blue-600 px-4 py-2.5
                       text-sm font-semibold text-white hover:bg-blue-700">
				Register Family
			</a>

		</div>

	<?php endif; ?>

</div>