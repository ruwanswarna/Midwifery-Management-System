<?php
//TEST
//dd($family);
//dd($family_members);


$statusClass = match (strtolower($family['status'])) {
	'active' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
	'inactive' => 'bg-slate-100 text-slate-600 ring-slate-500/20',
	default => 'bg-amber-50 text-amber-700 ring-amber-600/20',
};


?>

<div class="space-y-6">

	<!-- Profile heading -->
	<section class="overflow-hidden rounded-xl border border-slate-200 bg-white">
		<div class="bg-gradient-to-r from-blue-700 to-cyan-600 px-6 py-6">
			<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

				<div class="flex items-center gap-4">
					<div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/15 text-xl font-bold text-white ring-1 ring-white/20">
						<?= e(
							strtoupper(
								"FAM" . $family['family_id'] ?? 'F'
							)
						) ?>
					</div>

					<div>
						<p class="text-sm font-medium text-blue-100">

						</p>

						<h1 class="mt-1 text-2xl font-semibold text-white">
							<?= "" //e($family['family_id'] ?? null) 
							?>
						</h1>

					</div>
				</div>

				<div class="flex flex-wrap gap-2">
					<a
						href="<?= APP_URL ?>/families/<?= e($family['family_id']) ?>/edit"
						class="rounded-lg bg-white px-4 py-2 text-sm font-medium text-blue-700 shadow-sm hover:bg-blue-50">
						Edit family
					</a>
				</div>

			</div>
		</div>

		<div class="grid gap-4 px-6 py-5 sm:grid-cols-2 lg:grid-cols-4">
			<div>
				<p class="text-xs font-medium uppercase tracking-wide text-slate-500">
					Status
				</p>

				<span class="mt-2 inline-flex rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset <?= $statusClass ?>">
					<?= e($family['status']) ?>
				</span>
			</div>

			<div>
				<p class="text-xs font-medium uppercase tracking-wide text-slate-500">
					Registered Date
				</p>

				<p class="mt-2 text-sm font-medium text-slate-900">
					<?=
					e(date(
						'd M Y',
						strtotime($family['registered_date'])
					)) ?? "---"
					?>
				</p>
			</div>

			<div>
				<p class="text-xs font-medium uppercase tracking-wide text-slate-500">
					Family ID
				</p>

				<p class="mt-2 text-sm font-medium text-slate-900">
					#<?= str_pad(e($family['family_id']), 4, '0', STR_PAD_LEFT) ?>
				</p>
			</div>

			<div>
				<p class="text-xs font-medium uppercase tracking-wide text-slate-500">
					Registered Members
				</p>

				<p class="mt-2 text-sm font-medium text-slate-900">
					<?= e($family['member_count'] ?? 0) ?>
				</p>
			</div>
		</div>
	</section>

	<!-- Summary cards -->
	<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

		<?php
		$statistics = [
			[
				'label' => 'Family members',
				'value' => $family['member_count'] ?? 0,
				'colour' => 'bg-blue-50 text-blue-700',
			],
			[
				'label' => 'Children under 5',
				'value' => $family['under_five_count'] ?? 0,
				'colour' => 'bg-violet-50 text-violet-700',
			],
			[
				'label' => 'Total pregnancies',
				'value' => $summary['total_pregnancies'] ?? 0,
				'colour' => 'bg-rose-50 text-rose-700',
			],
			[
				'label' => 'Registered Children',
				'value' => $summary['registered_children'] ?? 0,
				'colour' => 'bg-emerald-50 text-emerald-700',
			],
		];
		?>

		<?php foreach ($statistics as $statistic): ?>
			<article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-sm text-slate-500">
							<?= e($statistic['label']) ?>
						</p>

						<p class="mt-2 text-2xl font-semibold text-slate-900">
							<?= e($statistic['value']) ?>
						</p>
					</div>

					<div class="flex h-11 w-11 items-center justify-center rounded-xl <?= $statistic['colour'] ?>">
						<span class="text-lg font-semibold">
							<?= e(substr($statistic['label'], 0, 1)) ?>
						</span>
					</div>
				</div>
			</article>
		<?php endforeach; ?>

	</section>

	<div class="grid items-start gap-6 xl:grid-cols-3">

		<!-- Family information -->
		<section class="rounded-xl border border-slate-200 bg-white shadow-sm xl:col-span-1">
			<div class="border-b border-slate-200 px-6 py-4">
				<h2 class="font-semibold text-slate-900">
					Family information
				</h2>
			</div>

			<dl class="divide-y divide-slate-100 px-6">
				<div class="py-4">
					<dt class="text-xs font-medium uppercase tracking-wide text-slate-500">
						Address
					</dt>

					<dd class="mt-1 text-sm leading-6 text-slate-900">
						<?= e($family['address'] ?? null) ?>
					</dd>
				</div>

				<div class="py-4">
					<dt class="text-xs font-medium uppercase tracking-wide text-slate-500">
						PHM area
					</dt>

					<dd class="mt-1 text-sm text-slate-900">
						<?= e($family['phm_name'] ?? null) ?>
					</dd>
				</div>

				<div class="py-4">
					<dt class="text-xs font-medium uppercase tracking-wide text-slate-500">
						Phone
					</dt>

					<dd class="mt-1 text-sm text-slate-900">
						<?php foreach ($family['contacts'] as $phone) : ?>
							<div><?= "0" . e($phone) ?></div>
						<?php endforeach; ?>
					</dd>
				</div>



				<div class="py-4">
					<dt class="text-xs font-medium uppercase tracking-wide text-slate-500">
						Last field visit date
					</dt>

					<dd class="mt-1 text-sm text-slate-900">
						<?= !empty($summary['latest_field_visit_date'])
							? e(date(
								'd M Y',
								strtotime($summary['latest_field_visit_date'])
							))
							: 'No visits yet' ?>
					</dd>
				</div>
			</dl>
		</section>

		<!-- Family members -->
		<section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm xl:col-span-2">
			<div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
				<div>
					<h2 class="font-semibold text-slate-900">
						Family members
					</h2>

					<p class="mt-1 text-sm text-slate-500">
						People registered under this family
					</p>
				</div>

				<a
					href="<?= APP_URL ?>/families/<?= e($family['family_id']) ?>/members/create"
					class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">
					Add member
				</a>
			</div>

			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-slate-200">
					<thead class="bg-slate-50">
						<tr>
							<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
								Member
							</th>

							<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
								Relationship
							</th>

							<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
								Age
							</th>

							<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
								Registration Status
							</th>

							<th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">
								Action
							</th>
						</tr>
					</thead>

					<tbody class="divide-y divide-slate-100 bg-white">
						<?php if (empty($family_members)): ?>
							<tr>
								<td
									colspan="5"
									class="px-6 py-12 text-center text-sm text-slate-500">
									No family members have been registered.
								</td>
							</tr>
						<?php else: ?>
							<?php foreach ($family_members as $member): ?>
								<tr class="hover:bg-slate-50">
									<td class="whitespace-nowrap px-6 py-4">
										<div class="flex items-center gap-3">
											<div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700">
												<?= e(
													strtoupper(
														substr(
															(string) ($member['first_name'] ?? '?'),
															0,
															1
														)
															. substr(
																(string) ($member['last_name'] ?? '?'),
																0,
																1
															)
													)
												) ?>
											</div>

											<div>
												<div class="flex items-center gap-2">
													<p class="text-sm font-medium text-slate-900">
														<?= e($member['full_name'] ?? null) ?>
													</p>

													<?php if (!empty($member['is_head_of_family'])): ?>
														<span class="rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-medium text-amber-700">
															Head
														</span>
													<?php endif; ?>
												</div>

												<p class="mt-0.5 text-xs text-slate-500">
													<?= e($member['nic'] ?? null) ?>
												</p>
											</div>
										</div>
									</td>

									<td class="whitespace-nowrap px-4 py-4 text-sm text-slate-600">
										<?= e(
											$member['person_role'] ?? null
										) ?>
									</td>

									<td class="whitespace-nowrap px-4 py-4 text-sm text-slate-600">
										<?= $member['age'] !== null
											? e($member['age']) . ' years'
											: '---' ?>
									</td>

									<td class="px-4 py-4">
										<div class="flex flex-wrap gap-1.5">
											<?php if (!empty($member['is_registered_child'])): ?>
												<span class="rounded-full bg-violet-50 px-2 py-1 text-xs font-medium text-violet-700">
													Child
												</span>
											<?php endif; ?>

											<?php if (!empty($member['has_active_pregnancy'])): ?>
												<span class="rounded-full bg-rose-50 px-2 py-1 text-xs font-medium text-rose-700">
													Active pregnancy
												</span>
											<?php endif; ?>

											<?php if (
												empty($member['is_registered_child'])
												&& empty($member['has_active_pregnancy'])
											): ?>
												<span class="text-xs text-slate-400">
													No active records
												</span>
											<?php endif; ?>
										</div>
									</td>

									<td class="whitespace-nowrap px-6 py-4 text-right">
										<a
											href="<?= APP_URL ?>/persons/<?= e($member['person_id']) ?>"
											class="text-sm font-medium text-blue-600 hover:text-blue-800">
											View
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</section>

	</div>
</div>