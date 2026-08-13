<?php


$formatDate = static function (?string $date): string {
	if (empty($date)) {
		return 'Not recorded';
	}

	$timestamp = strtotime($date);

	return $timestamp ? date('d M Y', $timestamp) : 'Not recorded';
};

?>

<div class="space-y-5">

	<!-- Filter section -->
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">


		<form
			method="GET"
			action="<?= APP_URL ?>/family-members"
			class="flex items-center justify-between gap-4 p-5">
			<!-- Search and submit -->
			<div class="flex min-w-0 flex-1 items-center gap-2">
				<div class="relative w-full max-w-sm">
					<svg
						class="pointer-events-none absolute left-3 top-1/2 h-5 w-5
					   -translate-y-1/2 text-slate-400"
						fill="none"
						viewBox="0 0 24 24"
						stroke="currentColor"
						aria-hidden="true">
						<path
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="1.8"
							d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0
					   7 7 0 0 1 14 0Z" />
					</svg>

					<input
						id="search"
						name="search"
						type="search"
						value="<?= e($filters['search'] ?? '') ?>"
						placeholder="Search by name, NIC, phone or family..."
						class="w-full rounded-lg border border-slate-300 py-2.5
					   pl-10 pr-3 text-sm text-slate-900 outline-none
					   focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
				</div>

				<button
					type="submit"
					class="shrink-0 rounded-lg bg-blue-600 px-4 py-2.5
				   text-sm font-medium text-white hover:bg-blue-700">
					Search
				</button>
			</div>

			<!-- Right-side action -->
			<a
				href="<?= APP_URL ?>/families/<?= $familyId ?>/members/create"
				class="shrink-0 text-sm font-semibold text-blue-600 hover:text-blue-700">
				+ Add Member
			</a>
		</form>
	</section>

	<!-- Members table -->
	<section
		class="overflow-hidden rounded-xl border border-slate-200
               bg-white shadow-sm">
		<!--
            This wrapper controls the table height. Pagination remains visible
            at its bottom while table rows scroll.
        -->
		<div class="flex max-h-[calc(100vh-19rem)] min-h-[28rem] flex-col">
			<div class="flex-1 overflow-auto">
				<table class="min-w-full divide-y divide-slate-200">
					<thead class="sticky top-0 z-10 bg-slate-50 shadow-sm">
						<tr>
							<th
								class="whitespace-nowrap px-5 py-3 text-left
                                       text-xs font-semibold
                                       tracking-wide text-slate-500">
								Member
							</th>

							<th
								class="whitespace-nowrap px-5 py-3 text-left
                                       text-xs font-semibold
                                       tracking-wide text-slate-500">
								Age
							</th>


							<th
								class="whitespace-nowrap px-5 py-3 text-left
                                       text-xs font-semibold
                                       tracking-wide text-slate-500">
								Phone
							</th>

							<th
								class="whitespace-nowrap px-5 py-3 text-left
                                       text-xs font-semibold
                                       tracking-wide text-slate-500">
								Role
							</th>

							<th
								class="whitespace-nowrap px-5 py-3 text-left
                                       text-xs font-semibold
                                       tracking-wide text-slate-500">
								Guardian
							</th>

							<th
								class="whitespace-nowrap px-5 py-3 text-right
                                       text-xs font-semibold
                                       tracking-wide text-slate-500">
								Actions
							</th>
						</tr>
					</thead>

					<tbody class="divide-y divide-slate-100 bg-white">
						<?php if (!empty($familyMembers)): ?>
							<?php foreach ($familyMembers as $member): ?>
								<?php
								$secondInitial = $member['middle_name'] ? strtoupper(substr($member['middle_name'], 0, 1)) . '. ' : '';
								$fullName = $member['first_name'] . " " .
									$secondInitial .
									$member['last_name'];
								$initials = strtoupper(
									substr($member['first_name'], 0, 1) .
										substr($member['last_name'], 0, 1)
								);
								?>

								<tr class="hover:bg-slate-50">
									<!-- Member -->
									<td class="whitespace-nowrap px-5 py-4">
										<div class="flex items-center gap-3">
											<div
												class="flex h-10 w-10 shrink-0
                                                       items-center justify-center
                                                       rounded-full bg-blue-100
                                                       text-sm font-semibold
                                                       text-blue-700">
												<?= e($initials) ?>
											</div>

											<div>
												<a
													href="<?= APP_URL ?>/families/<?= (int) $familyId ?>/members/<?= (int) $member['person_id'] ?>"
													class="font-medium text-slate-900
                                                           hover:text-blue-600">
													<?= e($fullName) ?>
												</a>

												<?php if (!empty($member['nic'])): ?>
													<p class="mt-0.5 text-xs text-slate-500">
														<?= e($member['nic']) ?>
													</p>
												<?php endif; ?>
											</div>
										</div>
									</td>

									<!-- Age -->
									<td class="whitespace-nowrap px-5 py-4">
										<p class="text-sm text-slate-700">
											<?= e($member['age'] ?? '---') . ' years' ?>
										</p>
										<p class="mt-0.5 text-xs text-slate-500">
											<?= e(
												$formatDate(
													$member['date_of_birth'] ?? null
												)
											) ?>
										</p>
									</td>

									<!-- Phone -->
									<td class="whitespace-nowrap px-5 py-4">
										<p class="text-sm text-slate-700">
											<?= e($member['phone'] ?? '') ?>
										</p>
									</td>



									<!-- Role -->
									<td class="whitespace-nowrap px-5 py-4">
										<span
											class="inline-flex rounded-full
                                                   bg-violet-50 px-2.5 py-1
                                                   text-xs font-medium
                                                   text-violet-700">
											<?= e(
												$member['role_name']
													?? 'Not assigned'
											) ?>
										</span>

										<?php if (!empty($member['is_contact_person'])): ?>
											<p class="mt-1.5 text-xs font-medium text-amber-600">
												Contact person
											</p>
										<?php endif; ?>
									</td>

									<!-- Guardian yes or no -->
									<td class="whitespace-nowrap px-5 py-4">
										<span
											class="<?php $member['is_guardian'] ? 'inline-flex rounded-full
												   bg-green-50 px-2.5 py-1
												   text-xs font-medium
												   text-green-700' : 'inline-flex rounded-full' ?>">



											<?= e(
												$member['is_guardian'] ? 'Yes' : ' '
											) ?>
										</span>
									</td>


									<!-- Actions -->
									<td class="whitespace-nowrap px-5 py-4 text-right">
										<div
											class="flex items-center justify-end
                                                   gap-1">
											<a
												href="<?= APP_URL ?>/families/<?= (int) $familyId ?>/members/<?= (int) $member['person_id'] ?>"
												title="View member"
												aria-label="View <?= e($fullName) ?>"
												class="rounded-lg p-2 text-slate-500
                                                       hover:bg-blue-50
                                                       hover:text-blue-600">
												<svg
													class="h-5 w-5"
													fill="none"
													viewBox="0 0 24 24"
													stroke="currentColor"
													aria-hidden="true">
													<path
														stroke-linecap="round"
														stroke-linejoin="round"
														stroke-width="1.8"
														d="M2.25 12s3.5-6 9.75-6
                                                           9.75 6 9.75 6-3.5 6-9.75 6
                                                          S2.25 12 2.25 12Z
                                                           M15 12a3 3 0 1 1-6 0
                                                           3 3 0 0 1 6 0Z" />
												</svg>
											</a>

											<a
												href="<?= APP_URL ?>/families/<?= (int) $familyId ?>/members/<?= $member['person_id'] ?>/edit"
												title="Edit member"
												aria-label="Edit <?= e($fullName) ?>"
												class="rounded-lg p-2 text-slate-500
                                                       hover:bg-amber-50
                                                       hover:text-amber-600">
												<svg
													class="h-5 w-5"
													fill="none"
													viewBox="0 0 24 24"
													stroke="currentColor"
													aria-hidden="true">
													<path
														stroke-linecap="round"
														stroke-linejoin="round"
														stroke-width="1.8"
														d="m16.862 3.487 3.651 3.651
                                                           M18.688 1.662a2.582 2.582
                                                           0 1 1 3.65 3.65L8.157 19.495
                                                           3 21l1.505-5.157L18.688 1.662Z" />
												</svg>
											</a>

											<form
												method="POST"
												action="<?= APP_URL ?>/families/<?= $familyId ?>/members/<?= $member['person_id'] ?>/delete"
												onsubmit="return confirm(
                                                    'Are you sure you want to delete this member?'
                                                )">
												<button
													type="submit"
													title="Delete member"
													aria-label="Delete <?= e($fullName) ?>"
													class="rounded-lg p-2 text-slate-500
                                                           hover:bg-rose-50
                                                           hover:text-rose-600">
													<svg
														class="h-5 w-5"
														fill="none"
														viewBox="0 0 24 24"
														stroke="currentColor"
														aria-hidden="true">
														<path
															stroke-linecap="round"
															stroke-linejoin="round"
															stroke-width="1.8"
															d="m14.74 9-.346 9
                                                               M9.606 18 9.26 9
                                                               M19.228 5.79c.342.052
                                                               .682.107 1.022.166
                                                               M19.228 5.79 18.16 19.673
                                                               A2.25 2.25 0 0 1 15.916
                                                               21.75H8.084a2.25 2.25
                                                               0 0 1-2.244-2.077
                                                               L4.772 5.79
                                                               M19.228 5.79a48.108
                                                               48.108 0 0 0-3.478-.397
                                                               M4.772 5.79c-.342.052
                                                               -.682.107-1.022.166
                                                               M4.772 5.79a48.11 48.11
                                                               0 0 1 3.478-.397
                                                               M15.75 5.393V4.477
                                                               c0-1.18-.91-2.164-2.09
                                                               -2.201a51.964 51.964
                                                               0 0 0-3.32 0
                                                               c-1.18.037-2.09 1.022
                                                               -2.09 2.201v.916
                                                               M15.75 5.393a48.667
                                                               48.667 0 0 0-7.5 0" />
													</svg>
												</button>
											</form>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="7" class="px-6 py-16 text-center">
									<div
										class="mx-auto flex h-12 w-12 items-center
                                               justify-center rounded-full
                                               bg-slate-100 text-slate-400">
										<svg
											class="h-6 w-6"
											fill="none"
											viewBox="0 0 24 24"
											stroke="currentColor"
											aria-hidden="true">
											<path
												stroke-linecap="round"
												stroke-linejoin="round"
												stroke-width="1.8"
												d="M18 18.72a9.094 9.094 0 0 0
                                                   3.741-.479 3 3 0 0 0-4.682-2.72
                                                   M18 18.72v-.75c0-.984-.264-1.906
                                                   -.725-2.7M18 18.72a18.094 18.094
                                                   0 0 1-6 .968m5.275-3.418A5.97
                                                   5.97 0 0 0 12 12.75a5.97 5.97
                                                   0 0 0-5.275 3.52M12 12.75a3
                                                   3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
										</svg>
									</div>

									<h3 class="mt-4 font-semibold text-slate-900">
										No family members found
									</h3>

									<p class="mt-1 text-sm text-slate-500">
										Change the filters or register a new member.
									</p>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

		</div>
	</section>
</div>