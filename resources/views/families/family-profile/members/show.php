<?php

$fullName = trim(implode(' ', array_filter([
	$familyMember['first_name'] ?? '',
	$memberMember['middle_name'] ?? '',
	$memberMember['last_name'] ?? '',
])));

$fullName = $fullName !== ''
	? $fullName
	: '---';

//$status = $member['status'] ?? 'Unknown';

// $statusClasses = match ($status) {
// 	'Active' => 'bg-emerald-100 text-emerald-700',
// 	'Inactive' => 'bg-slate-100 text-slate-600',
// 	'Deceased' => 'bg-rose-100 text-rose-700',
// 	default => 'bg-amber-100 text-amber-700',
// };

$gender = $member['gender'] ?? '';
$profileImage = APP_URL . '/resources/assets/images/profile-placeholder.jpg';

$editUrl = APP_URL
	. '/families/' . (int) $familyId
	. '/members/' . (int) $familyMember['person_id']
	. '/edit';

$familyUrl = APP_URL . '/families/' . (int) $familyId;

$formatValue = static function (
	mixed $value,
	string $fallback = '---'
): string {
	if ($value === null || trim((string) $value) === '') {
		return $fallback;
	}

	return (string) $value;
};

$formatDate = static function (mixed $date): string {
	if (empty($date)) {
		return '---';
	}

	$timestamp = strtotime((string) $date);

	return $timestamp
		? date('d M Y', $timestamp)
		: '---';
};

$age = '---';

// if ($familyMember['age'] !== null) {
// 	$years = (int) $member['age_years'];
// 	$months = (int) ($member['age_months'] ?? 0);

// 	$age = $years . ($years === 1 ? ' year' : ' years');

// 	if ($years < 5 && $months > 0) {
// 		$age .= ' ' . $months
// 			. ($months === 1 ? ' month' : ' months');
// 	}
// }
?>

<div class="space-y-6">
	<!-- Page actions -->
	<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
		<div>
			<a
				href="<?= e($familyUrl) ?>"
				class="inline-flex items-center gap-2 text-sm font-medium
                       text-slate-500 hover:text-blue-600">
				<svg
					class="h-4 w-4"
					fill="none"
					viewBox="0 0 24 24"
					stroke="currentColor"
					aria-hidden="true">
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="1.8"
						d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
				</svg>

				Back to family
			</a>
		</div>

		<a
			href="<?= e($editUrl) ?>"
			class="inline-flex items-center justify-center gap-2 rounded-lg
                   bg-blue-600 px-4 py-2.5 text-sm font-medium text-white
                   shadow-sm hover:bg-blue-700">
			<svg
				class="h-4 w-4"
				fill="none"
				viewBox="0 0 24 24"
				stroke="currentColor"
				aria-hidden="true">
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="1.8"
					d="m16.862 3.487 3.651 3.651
                       M18.688 1.662a2.582 2.582 0 1 1 3.65 3.65
                       L8.157 19.495 3 21l1.505-5.157L18.688 1.662Z" />
			</svg>

			Edit member
		</a>
	</div>

	<div class="grid gap-6 xl:grid-cols-[320px_minmax(0,1fr)]">
		<!-- Profile summary -->
		<aside
			class="overflow-hidden rounded-xl border border-slate-200
                   bg-white shadow-sm">
			<div
				class="h-28 bg-gradient-to-r from-blue-600
                       via-blue-500 to-cyan-500"></div>

			<div class="px-6 pb-6 text-center">
				<img
					src="<?= e($profileImage) ?>"
					alt="Profile image of <?= e($fullName) ?>"
					class="mx-auto -mt-16 h-32 w-32 rounded-full
                           border-4 border-white bg-slate-100 object-cover
                           shadow-md">

				<h2 class="mt-4 text-xl font-bold text-slate-900">
					<?= e($fullName) ?>
				</h2>

				<p class="mt-1 text-sm text-slate-500">
					<?= e($formatValue($familyMember['role_name'] ?? null)) ?>
				</p>

				<!-- <span
					class="mt-3 inline-flex rounded-full px-3 py-1
                           text-xs font-semibold <?= $statusClasses ?>">
					<?= e($status) ?>
				</span> -->

				<div class="mt-6 border-t border-slate-200 pt-5 text-left">
					<dl class="space-y-4">
						<div>
							<dt
								class="text-xs font-medium uppercase
                                       tracking-wide text-slate-400">
								Family
							</dt>

							<dd class="mt-1 text-sm font-medium text-slate-800">
								<?= e(
									$formatValue(
										$familyMember['last_name'] ?? null
									)
								) ?>
							</dd>
						</div>

						<div>
							<dt
								class="text-xs font-medium uppercase
                                       tracking-wide text-slate-400">
								Member number
							</dt>

							<dd class="mt-1 text-sm font-medium text-slate-800">
								#<?= (int) $familyMember['person_id'] ?>
							</dd>
						</div>

						<div>
							<dt
								class="text-xs font-medium uppercase
                                       tracking-wide text-slate-400">
								Age
							</dt>

							<dd class="mt-1 text-sm font-medium text-slate-800">
								<?php //e($age) 
								?>
							</dd>
						</div>
					</dl>
				</div>
			</div>
		</aside>

		<div class="space-y-6">
			<!-- Personal details -->
			<section
				class="rounded-xl border border-slate-200
                       bg-white shadow-sm">
				<div class="border-b border-slate-200 px-6 py-4">
					<h2 class="font-semibold text-slate-900">
						Personal information
					</h2>
				</div>

				<dl class="grid sm:grid-cols-2 xl:grid-cols-3">
					<?php
					$personalFields = [
						'Full name' => $fullName,
						'NIC number' => $formatValue(
							$familyMember['nic'] ?? null
						),
						'Date of birth' => $formatDate(
							$familyMember['date_of_birth'] ?? null
						),
						'Age' => $age,
						'Gender' => $formatValue($familyMember['gender']),
						'Family role' => $formatValue(
							$familyMember['role_name'] ?? null
						),
					];
					?>

					<?php foreach ($personalFields as $label => $value): ?>
						<div
							class="border-b border-slate-100 px-6 py-5
                                   sm:[&:nth-last-child(-n+2)]:border-b-0
                                   xl:[&:nth-last-child(-n+3)]:border-b-0">
							<dt class="text-sm font-medium text-slate-500">
								<?= e($label) ?>
							</dt>

							<dd class="mt-1 break-words text-sm text-slate-900">
								<?= e($value) ?>
							</dd>
						</div>
					<?php endforeach; ?>
				</dl>
			</section>

			<!-- Contact details -->
			<section
				class="rounded-xl border border-slate-200
                       bg-white shadow-sm">
				<div class="border-b border-slate-200 px-6 py-4">
					<h2 class="font-semibold text-slate-900">
						Contact information
					</h2>
				</div>

				<dl class="grid sm:grid-cols-2">
					<div class="border-b border-slate-100 px-6 py-5">
						<dt class="text-sm font-medium text-slate-500">
							Phone
						</dt>

						<dd class="mt-1 text-sm text-slate-900">
							<?php if (!empty($familyMember['phone'])): ?>
								<a
									href="tel:<?= e($familyMember['phone']) ?>"
									class="text-blue-600 hover:underline">
									<?= e($familyMember['phone']) ?>
								</a>
							<?php else: ?>
								---
							<?php endif; ?>
						</dd>
					</div>

					<div class="border-b border-slate-100 px-6 py-5">
						<dt class="text-sm font-medium text-slate-500">
							Email
						</dt>

						<dd class="mt-1 break-words text-sm text-slate-900">
							<?php if (!empty($familyMember['email'])): ?>
								<a
									href="mailto:<?= e($familyMember['email']) ?>"
									class="text-blue-600 hover:underline">
									<?= e($familyMember['email']) ?>
								</a>
							<?php else: ?>
								---
							<?php endif; ?>
						</dd>
					</div>

					<div class="px-6 py-5 sm:col-span-2">

						<dd class="mt-1 whitespace-pre-line text-sm text-slate-900">
							<?= e(
								$formatValue(
									$familyMember['address']
										?? $familyMember['family_address']
										?? null
								)
							) ?>
						</dd>
					</div>
				</dl>
			</section>

			<!-- Record information -->
			<!-- <section
				class="rounded-xl border border-slate-200
                       bg-white shadow-sm">
				<div class="border-b border-slate-200 px-6 py-4">
					<h2 class="font-semibold text-slate-900">
						Record information
					</h2>
				</div>

				<dl class="grid sm:grid-cols-2">
					<div class="border-b border-slate-100 px-6 py-5 sm:border-b-0">
						<dt class="text-sm font-medium text-slate-500">
							Registered date
						</dt>

						<dd class="mt-1 text-sm text-slate-900">
							<?= e(
								$formatDate(
									$familyMember['registered_date']
										?? $familyMember['created_at']
										?? null
								)
							) ?>
						</dd>
					</div>

					<div class="px-6 py-5">
						<dt class="text-sm font-medium text-slate-500">
							Last updated
						</dt>

						<dd class="mt-1 text-sm text-slate-900">
							<?= e(
								$formatDate(
									$familyMember['updated_at'] ?? null
								)
							) ?>
						</dd>
					</div>
				</dl>
			</section> -->
		</div>
	</div>
</div>