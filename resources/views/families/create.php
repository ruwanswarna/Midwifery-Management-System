<?php
// TEST
//dd($phmAreas);

//hardcoded test data
$educationLevels = [
	'No Formal Education',
	'Primary',
	'Secondary',
	'O/L',
	'A/L',
	'Certificate',
	'Diploma',
	'Undergraduate',
	'Graduate',
	'Postgraduate',
	'Other',
];

$bloodGroups = [
	'A+',
	'A-',
	'B+',
	'B-',
	'AB+',
	'AB-',
	'O+',
	'O-',
];

$maritalStatuses = [
	'Single',
	'Married',
	'Divorced',
	'Widowed',
];

$personStatuses = [
	'Active',
	'Inactive',
	'Deceased',
];
?>
<?php
$errors = $_SESSION['errors'] ?? [];
$familyData = $_SESSION['familyData'] ?? [];
$personData = $_SESSION['personData'] ?? [];

unset($_SESSION['errors'], $_SESSION['familyData'], $_SESSION['personData']);

$fieldError = static function (string $field) use ($errors): ?string {
	return $errors[$field] ?? null;
};

$inputClass = static function (string $field) use ($errors): string {
	$base = 'block w-full rounded-lg border bg-white px-3 py-2.5 text-sm
             text-slate-900 outline-none transition
             placeholder:text-slate-400 focus:ring-2';

	if (isset($errors[$field])) {
		return $base . ' border-red-300 focus:border-red-500 focus:ring-red-100';
	}

	return $base . ' border-slate-300 focus:border-blue-500 focus:ring-blue-100';
};
?>

<div class="mx-auto max-w-6xl space-y-6">

	<?php if (isset($errors['general'])): ?>
		<div
			class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700"
			role="alert">
			<?= e($errors['general']) ?>
		</div>
	<?php endif; ?>

	<form
		action="<?= APP_URL ?>/families/create"
		method="POST"
		id="family-registration-form"
		class="space-y-6">
		<?php if (function_exists('csrf_field')): ?>
			<?= csrf_field() ?>
		<?php endif; ?>

		<div class="grid items-start gap-6 xl:grid-cols-3">
			<!-- Main form -->
			<div class="space-y-6 xl:col-span-2">

				<!-- Family identification -->
				<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
					<div class="border-b border-slate-200 px-6 py-4">
						<div class="flex items-start gap-3">
							<div>
								<h2 class="font-semibold text-slate-900">
									Family Registration Form
								</h2>
							</div>
						</div>
					</div>

					<fieldset class="grid gap-5 p-6 sm:grid-cols-2">
						<legend class="sr-only">Family details</legend>

						<!-- PHM area -->
						<div>
							<label
								for="phm_area_id"
								class="mb-1.5 block text-sm font-medium text-slate-700">
								PHM area
								<span class="text-red-500">*</span>
							</label>

							<select
								id="phm_area_id"
								name="familyData[phm_area_id]"
								class="<?= $inputClass('phm_area_id') ?>"
								required>
								<option value="">Select a PHM area</option>

								<?php foreach (($phmAreas ?? []) as $area): ?>
									<option
										value="<?= e($area['phm_area_id']) ?>"
										<?= (string) ($familyData['phm_area_id'] ?? '')
											=== (string) $area['phm_area_id']
											? 'selected'
											: '' ?>>

										<?php if (!empty($area['district_name'])): ?>
											<?= e($area['district_name']) ?>
										<?php endif; ?>
										<?php if (!empty($area['moh_name'])): ?>
											,<?= e($area['moh_name']) ?>
										<?php endif; ?>
										<?php if (!empty($area['phm_area_name'])): ?>
											,<?= e($area['phm_area_name']) ?>
										<?php endif; ?>
									</option>
								<?php endforeach; ?>
							</select>

							<?php if ($fieldError('phm_area_id')): ?>
								<p class="mt-1.5 text-xs text-red-600">
									<?= e($fieldError('phm_area_id')) ?>
								</p>
							<?php endif; ?>
						</div>

						<!-- Family status -->
						<div>
							<label
								for="family_status"
								class="mb-1.5 block text-sm font-medium text-slate-700">
								Family status
								<span class="text-red-500">*</span>
							</label>

							<select
								id="family_status"
								name="familyData[status]"
								class="<?= $inputClass('family_status') ?>"
								required>
								<?php
								$selectedStatus =
									$familyData['status'] ?? 'Active';
								?>

								<option
									value="Active"
									<?= $selectedStatus === 'Active'
										? 'selected'
										: '' ?>>
									Active
								</option>

								<option
									value="Inactive"
									<?= $selectedStatus === 'Inactive'
										? 'selected'
										: '' ?>>
									Inactive
								</option>
							</select>

							<?php if ($fieldError('status')): ?>
								<p class="mt-1.5 text-xs text-red-600">
									<?= e($fieldError('status')) ?>
								</p>
							<?php endif; ?>
						</div>

						<!-- Address -->
						<div>
							<label
								for="address"
								class="mb-1.5 block text-sm font-medium text-slate-700">
								Address
								<span class="text-red-500">*</span>
							</label>

							<textarea
								id="address"
								name="familyData[address]"
								rows="1"
								maxlength="100"
								class="<?= $inputClass('address') ?> resize-y"
								placeholder=""
								required><?= e($familyData['address'] ?? '') ?></textarea>

							<div class="mt-1.5 flex items-start justify-between gap-4">
								<?php if ($fieldError('address')): ?>
									<p class="text-xs text-red-600">
										<?= e($fieldError('address')) ?>
									</p>
								<?php else: ?>
									<p class="text-xs text-slate-500">
										Enter the family member's present address.
									</p>
								<?php endif; ?>

								<p class="shrink-0 text-xs text-slate-400">
									<span id="address-character-count">0</span>/100
								</p>
							</div>
						</div>
					</fieldset>

					<div class="border-b border-slate-200 px-6 py-4">
						<div class="flex items-start gap-3">

							<div>
								<h2 class="font-semibold text-slate-900">
									Primary Contact Person Details
								</h2>
							</div>
						</div>
					</div>

					<fieldset class="grid gap-5 p-6 sm:grid-cols-2">
						<legend class="sr-only">Primary contact person details</legend>

						<!-- Name -->
						<fieldset class="sm:col-span-2">
							<legend class="mb-1.5 text-sm font-medium text-slate-700">
								Full name
								<span class="text-red-500">*</span>
							</legend>

							<div class="grid gap-5 sm:grid-cols-3">

								<!-- First name -->
								<div>
									<label
										class="mb-1.5 block text-sm font-medium text-slate-700">
										First name
										<span class="text-red-500">*</span>
									</label>

									<input
										type="text"
										id="first_name"
										name="personData[first_name]"
										value="<?= e(
													$personData['first_name'] ?? ''
												) ?>"
										class="<?= $inputClass('first_name') ?>"
										maxlength="100"
										autocomplete="given-name"
										required>

									<?php if ($fieldError('first_name')): ?>
										<p class="mt-1.5 text-xs text-red-600">
											<?= e($fieldError('first_name')) ?>
										</p>
									<?php endif; ?>
								</div>
								<!-- Middle name -->
								<div>
									<label
										class="mb-1.5 block text-sm font-medium text-slate-700">
										Middle name
										<!-- <span class="text-red-500">*</span> -->
									</label>

									<input
										type="text"
										id="middle_name"
										name="personData[middle_name]"
										value="<?= e(
													$personData['middle_name'] ?? ''
												) ?>"
										class="<?= $inputClass('middle_name') ?>"
										maxlength="100"
										autocomplete="given-name">

									<?php if ($fieldError('middle_name')): ?>
										<p class="mt-1.5 text-xs text-red-600">
											<?= e($fieldError('middle_name')) ?>
										</p>
									<?php endif; ?>
								</div>

								<!-- Last name -->
								<div>
									<label
										class="mb-1.5 block text-sm font-medium text-slate-700">
										Last name
										<span class="text-red-500">*</span>
									</label>

									<input
										type="text"
										id="last_name"
										name="personData[last_name]"
										value="<?= e(
													$personData['last_name'] ?? ''
												) ?>"
										class="<?= $inputClass('last_name') ?>"
										maxlength="100"
										autocomplete="family-name"
										required>

									<?php if ($fieldError('last_name')): ?>
										<p class="mt-1.5 text-xs text-red-600">
											<?= e($fieldError('last_name')) ?>
										</p>
									<?php endif; ?>
								</div>
							</div>
						</fieldset>
						<!-- Date of birth -->
						<div>
							<label
								class="mb-1.5 block text-sm font-medium text-slate-700">
								Date of birth
								<span class="text-red-500">*</span>
							</label>

							<input
								type="date"
								id="date_of_birth"
								name="personData[date_of_birth]"
								value="<?= e(
											$personData['date_of_birth'] ?? ''
										) ?>"
								max="<?= date('Y-m-d') ?>"
								class="<?= $inputClass('date_of_birth') ?>"
								required>

							<?php if ($fieldError('date_of_birth')): ?>
								<p class="mt-1.5 text-xs text-red-600">
									<?= e($fieldError('date_of_birth')) ?>
								</p>
							<?php endif; ?>
						</div>
						<!-- Gender -->
						<div>
							<label
								class="mb-1.5 block text-sm font-medium text-slate-700">
								Gender
								<span class="text-red-500">*</span>
							</label>

							<select
								id="gender"
								name="personData[gender]"
								class="<?= $inputClass('gender') ?>"
								required>
								<option value="">Select Gender</option>
								<option
									value="Male"
									<?= ($personData['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>
									Male
								</option>
								<option
									value="Female"
									<?= ($personData['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>
									Female
								</option>
							</select>

							<?php if ($fieldError('gender')): ?>
								<p class="mt-1.5 text-xs text-red-600">
									<?= e($fieldError('gender')) ?>
								</p>
							<?php endif; ?>
						</div>
						<!-- NIC -->
						<div>
							<label
								class="mb-1.5 block text-sm font-medium text-slate-700">
								NIC number
								<!-- <span class="text-red-500">*</span> -->
							</label>

							<input
								type="text"
								id="nic"
								name="personData[nic]"
								value="<?= e(
											$personData['nic'] ?? ''
										) ?>"
								class="<?= $inputClass('nic') ?>"
								placeholder="901234567V"
								maxlength="12"
								autocomplete="off"
								required>

							<?php if ($fieldError('nic')): ?>
								<p class="mt-1.5 text-xs text-red-600">
									<?= e($fieldError('nic')) ?>
								</p>
							<?php else: ?>
								<p class="mt-1.5 text-xs text-slate-500">
									Enter the NIC number
								</p>
							<?php endif; ?>
						</div>

						<!-- Contacts -->
						<div>
							<label
								for="phone"
								class="mb-1.5 block text-sm font-medium text-slate-700">
								Contact number
								<!-- <span class="text-red-500">*</span> -->
							</label>

							<input
								type="tel"
								id="phone"
								name="personData[phone]"
								class="<?= $inputClass("phone") ?>"
								placeholder="Example: 0771234567"
								maxlength="10"
								required
								value="<?= e($personData['phone'] ?? '') ?>">
							<div class="mt-1.5 flex items-start justify-between gap-4">
								<p class="text-xs text-slate-500">
									Enter phone number if available.
								</p>
								<?php if ($fieldError("phone")): ?>
									<p class="mt-1.5 text-xs text-red-600">
										<?= e($fieldError("phone")) ?>
									</p>
								<?php endif; ?>
							</div>
						</div>
						<!-- email -->
						<div>
							<label
								for="email"
								class="mb-1.5 block text-sm font-medium text-slate-700">
								Email address
								<!-- <span class="text-red-500">*</span> -->
							</label>

							<input
								type="email"
								id="email"
								name="personData[email]"
								class="<?= $inputClass("email") ?>"
								placeholder="example@domain.com"
								maxlength="100"
								required
								value="<?= e($personData['email'] ?? '') ?>">
							<div class="mt-1.5 flex items-start justify-between gap-4">
								<p class="text-xs text-slate-500">
									Enter email address if available.
								</p>
								<?php if ($fieldError("email")): ?>
									<p class="mt-1.5 text-xs text-red-600">
										<?= e($fieldError("email")) ?>
									</p>
								<?php endif; ?>
							</div>
						</div>



						<!-- Marital status -->
						<div>
							<label
								class="mb-1.5 block text-sm font-medium text-slate-700">
								Marital status
							</label>

							<?php
							$maritalStatus =
								$personData['marital_status'] ?? '';
							?>

							<select
								id="marital_status"
								name="personData[marital_status]"
								class="<?= $inputClass(
											'marital_status'
										) ?>">
								<option value="">Select marital status</option>

								<?php foreach (
									['Single', 'Married']
									as $status
								): ?>
									<option
										value="<?= e($status) ?>"
										<?= $maritalStatus === $status
											? 'selected'
											: '' ?>>
										<?= e($status) ?>
									</option>
								<?php endforeach; ?>
							</select>

							<?php if ($fieldError('marital_status')): ?>
								<p class="mt-1.5 text-xs text-red-600">
									<?= e(
										$fieldError('marital_status')
									) ?>
								</p>
							<?php endif; ?>
						</div>

						<!-- Occupation -->
						<div>
							<label
								class="mb-1.5 block text-sm font-medium text-slate-700">
								Occupation
							</label>

							<input
								type="text"
								id="occupation"
								name="personData[occupation]"
								value="<?= e(
											$personData['occupation'] ?? ''
										) ?>"
								class="<?= $inputClass('occupation') ?>"
								maxlength="100">

							<?php if ($fieldError('occupation')): ?>
								<p class="mt-1.5 text-xs text-red-600">
									<?= e($fieldError('occupation')) ?>
								</p>
							<?php endif; ?>
						</div>

						<!-- Education level -->
						<div>
							<label
								for="education_level"
								class="mb-1.5 block text-sm font-medium text-slate-700">
								Education level
							</label>

							<select
								id="education_level"
								name="personData[education_level]"
								class="<?= $inputClass('education_level') ?>">

								<option value="">Select education level</option>

								<?php foreach ($educationLevels as $educationLevel): ?>
									<option
										value="<?= e($educationLevel) ?>"
										<?= ($personData['education_level'] ?? '') === $educationLevel
											? 'selected'
											: '' ?>>
										<?= e($educationLevel) ?>
									</option>
								<?php endforeach; ?>
							</select>

							<?php if ($fieldError('education_level')): ?>
								<p class="mt-1.5 text-xs text-red-600">
									<?= e($fieldError('education_level')) ?>
								</p>
							<?php endif; ?>
						</div>

						<!-- Blood group -->
						<div>
							<label
								for="blood_group"
								class="mb-1.5 block text-sm font-medium text-slate-700">
								Blood group
							</label>

							<select
								id="blood_group"
								name="personData[blood_group]"
								class="<?= $inputClass('blood_group') ?>">

								<option value="">Select blood group</option>

								<?php foreach ($bloodGroups as $bloodGroup): ?>
									<option
										value="<?= e($bloodGroup) ?>"
										<?= ($personData['blood_group'] ?? '') === $bloodGroup
											? 'selected'
											: '' ?>>
										<?= e($bloodGroup) ?>
									</option>
								<?php endforeach; ?>
							</select>

							<?php if ($fieldError('blood_group')): ?>
								<p class="mt-1.5 text-xs text-red-600">
									<?= e($fieldError('blood_group')) ?>
								</p>
							<?php endif; ?>
						</div>

						<!-- Guardian status -->
						<div>
							<span class="mb-1.5 block text-sm font-medium text-slate-700">
								Guardian
							</span>

							<input
								type="hidden"
								name="personData[is_guardian]"
								value="0">

							<label
								for="is_guardian"
								class="flex min-h-11 cursor-pointer items-center gap-3 rounded-lg
			   border border-slate-300 bg-white px-3 py-2.5">

								<input
									type="checkbox"
									id="is_guardian"
									name="personData[is_guardian]"
									value="1"
									class="h-4 w-4 rounded border-slate-300 text-blue-600
				   focus:ring-blue-500"
									<?= (int) ($personData['is_guardian'] ?? 0) === 1
										? 'checked'
										: '' ?>>

								<span class="text-sm text-slate-700">
									This person is a guardian
								</span>
							</label>

							<?php if ($fieldError('is_guardian')): ?>
								<p class="mt-1.5 text-xs text-red-600">
									<?= e($fieldError('is_guardian')) ?>
								</p>
							<?php endif; ?>
						</div>

						<!-- Person status -->
						<div>
							<label
								for="status"
								class="mb-1.5 block text-sm font-medium text-slate-700">
								Status
								<span class="text-red-500">*</span>
							</label>

							<select
								id="status"
								name="personData[status]"
								class="<?= $inputClass('status') ?>"
								required>

								<option value="">Select status</option>

								<?php foreach ($personStatuses as $personStatus): ?>
									<option
										value="<?= e($personStatus) ?>"
										<?= ($personData['status'] ?? 'Active') === $personStatus
											? 'selected'
											: '' ?>>
										<?= e($personStatus) ?>
									</option>
								<?php endforeach; ?>
							</select>

							<?php if ($fieldError('status')): ?>
								<p class="mt-1.5 text-xs text-red-600">
									<?= e($fieldError('status')) ?>
								</p>
							<?php endif; ?>
						</div>
					</fieldset>

					<!-- Actions -->
					<div>
						<div
							class="sticky bottom-0 z-20 flex gap-3
                    				bg-white px-6 py-4
                    				sm:flex-row sm:items-center
                   					sm:justify-end">
							<a
								href="<?= APP_URL ?>/families"
								class="inline-flex items-center justify-center rounded-lg
                       					border border-slate-300 bg-white px-5 py-2.5
                       					text-sm font-medium text-slate-700 transition
                       					hover:bg-slate-50">
								Cancel
							</a>

							<button
								type="submit"
								class="inline-flex items-center justify-center gap-2 rounded-lg
                       					bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700
                       					focus:outline-none focus:ring-2 focus:ring-blue-500
                       					focus:ring-offset-2">
								Register family
							</button>
						</div>
					</div>

				</section>
			</div>
		</div>
	</form>
</div>
<script>
	document.addEventListener('DOMContentLoaded', () => {

		const address = document.getElementById('address');
		const addressCount = document.getElementById('address-character-count');


		const updateAddressCount = () => {
			addressCount.textContent = address.value.length;
		};

		address?.addEventListener('input', updateAddressCount);

		updateAddressCount();
		updateContactLabels();
		updateRemoveButtons();
	});
</script>