<?php

$errors = $_SESSION['errors'] ?? [];
$formData = $_SESSION['form_data'] ?? [];

unset($_SESSION['errors'], $_SESSION['form_data']);

$personData = $formData['personData'] ?? [];
$childData = $formData['childData'] ?? [];

$personValue = static function (
	string $key,
	mixed $default = ''
) use ($personData): mixed {
	return array_key_exists($key, $personData)
		? $personData[$key]
		: $default;
};

$childValue = static function (
	string $key,
	mixed $default = ''
) use ($childData): mixed {
	return array_key_exists($key, $childData)
		? $childData[$key]
		: $default;
};

$inputClass = static function (string $field) use ($errors): string {
	$base = 'mt-1 block w-full rounded-lg border bg-white px-3 py-2.5 '
		. 'text-sm text-slate-900 shadow-sm transition '
		. 'focus:outline-none focus:ring-2';

	if (isset($errors[$field])) {
		return $base
			. ' border-red-400 focus:border-red-500 focus:ring-red-200';
	}

	return $base
		. ' border-slate-300 focus:border-blue-500 focus:ring-blue-100';
};

$fieldError = static function (string $field) use ($errors): void {
	if (!isset($errors[$field])) {
		return;
	}

	$message = is_array($errors[$field])
		? reset($errors[$field])
		: $errors[$field];
?>

	<p class="mt-1 text-xs text-red-600">
		<?= e((string) $message) ?>
	</p>

<?php
};

$selectedFamilyId = (int) $personValue('family_id', 0);
$selectedBirthOutcomeId = (int) $childValue('birth_outcome_id', 0);
?>

<form
	method="post"
	action="<?= e(APP_URL . '/children/create') ?>"
	class="space-y-6">
	<!-- General validation error -->
	<?php if (isset($errors['general'])): ?>
		<div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3">
			<p class="text-sm text-red-700">
				<?= e((string) $errors['general']) ?>
			</p>
		</div>
	<?php endif; ?>

	<!-- Family selection -->
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">


		<div class="p-3">
			<label
				for="family_id"
				class="block text-sm font-medium text-slate-700">
				Family
				<span class="text-red-500">*</span>
			</label>

			<select
				id="family_id"
				name="personData[family_id]"
				required
				class="<?= $inputClass('family_id') ?>">
				<option value="">Select a family - <?php if (empty($families)): ?>No families available<?php endif; ?></option>

				<?php foreach (($families ?? []) as $family): ?>
					<?php
					$familyId = (int) $family['family_id'];

					$familyLabel = $family['registration_number'] ?? '';

					if (!empty($family['contact_person_name'])) {
						$familyLabel .= ' · ' . $family['contact_person_name'];
					}

					if (!empty($family['address'])) {
						$familyLabel .= ' · ' . $family['address'];
					}
					?>

					<option
						value="<?= $familyId ?>"
						<?= $selectedFamilyId === $familyId
							? 'selected'
							: '' ?>>
						<?= e($familyLabel) ?>
					</option>
				<?php endforeach; ?>
			</select>

			<?php $fieldError('family_id'); ?>

		</div>
		<div class="p-3">
			<label
				for="birth_outcome_id"
				class="block text-sm font-medium text-slate-700">
				Birth Outcome
				<span class="text-red-500">*</span>
			</label>

			<select
				id="birth_outcome_id"
				name="personData[birth_outcome_id]"
				required
				class="<?= $inputClass('birth_outcome_id') ?>">
				<option value="">Select a birth outcome <?php if (empty($birthOutcomes)): ?>No birth outcomes available<?php endif; ?></option>

				<?php foreach (($birthOutcomes ?? []) as $outcome): ?>
					<?php
					$outcomeId = (int) $outcome['birth_outcome_id'];

					$familyLabel = $family['registration_number'] ?? '';

					if (!empty($family['contact_person_name'])) {
						$familyLabel .= ' · ' . $family['contact_person_name'];
					}

					if (!empty($family['address'])) {
						$familyLabel .= ' · ' . $family['address'];
					}
					?>

					<option
						value="<?= $familyId ?>"
						<?= $selectedFamilyId === $familyId
							? 'selected'
							: '' ?>>
						<?= e($familyLabel) ?>
					</option>
				<?php endforeach; ?>
			</select>

			<?php $fieldError('family_id'); ?>

		</div>
	</section>

	<!-- Personal information -->
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="border-b border-slate-200 px-6 py-4">
			<h2 class="font-semibold text-slate-900">
				Personal details
			</h2>

		</div>

		<div class="grid gap-5 p-6 md:grid-cols-2 xl:grid-cols-3">
			<!-- First name -->
			<div>
				<label
					for="first_name"
					class="block text-sm font-medium text-slate-700">
					First name
					<span class="text-red-500">*</span>
				</label>

				<input
					type="text"
					id="first_name"
					name="personData[first_name]"
					maxlength="100"
					required
					autocomplete="given-name"
					value="<?= e((string) $personValue('first_name')) ?>"
					class="<?= $inputClass('first_name') ?>">

				<?php $fieldError('first_name'); ?>
			</div>

			<!-- Middle name -->
			<div>
				<label
					for="middle_name"
					class="block text-sm font-medium text-slate-700">
					Middle name
				</label>

				<input
					type="text"
					id="middle_name"
					name="personData[middle_name]"
					maxlength="100"
					autocomplete="additional-name"
					value="<?= e((string) $personValue('middle_name')) ?>"
					class="<?= $inputClass('middle_name') ?>">

				<?php $fieldError('middle_name'); ?>
			</div>

			<!-- Last name -->
			<div>
				<label
					for="last_name"
					class="block text-sm font-medium text-slate-700">
					Last name
					<span class="text-red-500">*</span>
				</label>

				<input
					type="text"
					id="last_name"
					name="personData[last_name]"
					maxlength="100"
					required
					autocomplete="family-name"
					value="<?= e((string) $personValue('last_name')) ?>"
					class="<?= $inputClass('last_name') ?>">

				<?php $fieldError('last_name'); ?>
			</div>

			<!-- Gender -->
			<div>
				<label
					for="gender"
					class="block text-sm font-medium text-slate-700">
					Gender
					<span class="text-red-500">*</span>
				</label>

				<select
					id="gender"
					name="personData[gender]"
					required
					class="<?= $inputClass('gender') ?>">
					<option value="">Select gender</option>

					<?php foreach (['Male', 'Female'] as $gender): ?>
						<option
							value="<?= e($gender) ?>"
							<?= $personValue('gender') === $gender
								? 'selected'
								: '' ?>>
							<?= e($gender) ?>
						</option>
					<?php endforeach; ?>
				</select>

				<?php $fieldError('gender'); ?>
			</div>

			<!-- Date of birth -->
			<div>
				<label
					for="date_of_birth"
					class="block text-sm font-medium text-slate-700">
					Date of birth
					<span class="text-red-500">*</span>
				</label>

				<input
					type="date"
					id="date_of_birth"
					name="personData[date_of_birth]"
					required
					max="<?= date('Y-m-d') ?>"
					value="<?= e((string) $personValue('date_of_birth')) ?>"
					class="<?= $inputClass('date_of_birth') ?>">

				<?php $fieldError('date_of_birth'); ?>
			</div>

			<!-- Blood group -->
			<div>
				<label
					for="blood_group"
					class="block text-sm font-medium text-slate-700">
					Blood group
				</label>

				<select
					id="blood_group"
					name="personData[blood_group]"
					class="<?= $inputClass('blood_group') ?>">
					<option value="">Not recorded</option>

					<?php
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
					?>

					<?php foreach ($bloodGroups as $bloodGroup): ?>
						<option
							value="<?= e($bloodGroup) ?>"
							<?= $personValue('blood_group') === $bloodGroup
								? 'selected'
								: '' ?>>
							<?= e($bloodGroup) ?>
						</option>
					<?php endforeach; ?>
				</select>

				<?php $fieldError('blood_group'); ?>
			</div>

		</div>
	</section>

	<!-- Child and birth information -->
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="border-b border-slate-200 px-6 py-4">
			<h2 class="font-semibold text-slate-900">
				Birth details
			</h2>

		</div>

		<div class="grid gap-5 p-6 md:grid-cols-2">
		

			<!-- Registered date -->
			<div>
				<label
					for="registered_date"
					class="block text-sm font-medium text-slate-700">
					Registered date
					<span class="text-red-500">*</span>
				</label>

				<input
					type="date"
					id="registered_date"
					name="childData[registered_date]"
					required
					max="<?= date('Y-m-d') ?>"
					value="<?= e((string) $childValue(
								'registered_date',
								date('Y-m-d')
							)) ?>"
					class="<?= $inputClass('registered_date') ?>">

				<?php $fieldError('registered_date'); ?>
			</div>

			<!-- Breastfeeding -->
			<div>
				<label
					for="breastfeeding_status"
					class="block text-sm font-medium text-slate-700">
					Breastfeeding status
				</label>

				<select
					id="breastfeeding_status"
					name="childData[breastfeeding_status]"
					class="<?= $inputClass('breastfeeding_status') ?>">
					<option value="">Not recorded</option>

					<?php
					$breastfeedingStatuses = [
						'Exclusive',
						'Mixed',
						'Formula',
						'Stopped',
					];
					?>

					<?php foreach ($breastfeedingStatuses as $status): ?>
						<option
							value="<?= e($status) ?>"
							<?= $childValue('breastfeeding_status') === $status
								? 'selected'
								: '' ?>>
							<?= e($status) ?>
						</option>
					<?php endforeach; ?>
				</select>

				<?php $fieldError('breastfeeding_status'); ?>
			</div>

			<!-- Special needs -->
			<div class="flex items-center">
				<label
					for="special_needs"
					class="flex cursor-pointer items-center gap-3">
					<input
						type="checkbox"
						id="special_needs"
						name="childData[special_needs]"
						value="1"
						<?= (int) $childValue('special_needs', 0) === 1
							? 'checked'
							: '' ?>
						class="h-4 w-4 rounded border-slate-300 text-blue-600
                               focus:ring-blue-500">

					<span class="text-sm font-medium text-slate-700">
						Special needs identified
					</span>
				</label>

				<?php $fieldError('special_needs'); ?>
			</div>
		</div>
	</section>

	<!-- Birth measurements -->
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="border-b border-slate-200 px-6 py-4">
			<h2 class="font-semibold text-slate-900">
				Birth measurements
			</h2>

		</div>

		<div class="grid gap-5 p-6 sm:grid-cols-2 xl:grid-cols-3">
			<!-- Weight -->
			<div>
				<label
					for="birth_weight_kg"
					class="block text-sm font-medium text-slate-700">
					Birth weight (kg)
				</label>

				<div class="relative">
					<input
						type="number"
						id="birth_weight_kg"
						name="childData[birth_weight_kg]"
						step="0.01"
						min="0.30"
						max="8"
						value="<?= e((string) $childValue(
									'birth_weight_kg'
								)) ?>"
						class="<?= $inputClass('birth_weight_kg') ?> pr-12">

					<span
						class="pointer-events-none absolute right-3 top-1/2
                               -translate-y-1/2 text-xs text-slate-400">
						kg
					</span>
				</div>

				<?php $fieldError('birth_weight_kg'); ?>
			</div>

			<!-- Length -->
			<div>
				<label
					for="birth_length_cm"
					class="block text-sm font-medium text-slate-700">
					Birth length (cm)
				</label>

				<div class="relative">
					<input
						type="number"
						id="birth_length_cm"
						name="childData[birth_length_cm]"
						step="0.01"
						min="20"
						max="70"
						value="<?= e((string) $childValue(
									'birth_length_cm'
								)) ?>"
						class="<?= $inputClass('birth_length_cm') ?> pr-12">

					<span
						class="pointer-events-none absolute right-3 top-1/2
                               -translate-y-1/2 text-xs text-slate-400">
						cm
					</span>
				</div>

				<?php $fieldError('birth_length_cm'); ?>
			</div>

			<!-- Head circumference -->
			<div>
				<label
					for="head_circumference_cm"
					class="block text-sm font-medium text-slate-700">
					Head circumference (cm)
				</label>

				<div class="relative">
					<input
						type="number"
						id="head_circumference_cm"
						name="childData[head_circumference_cm]"
						step="0.01"
						min="20"
						max="60"
						value="<?= e((string) $childValue(
									'head_circumference_cm'
								)) ?>"
						class="<?= $inputClass(
									'head_circumference_cm'
								) ?> pr-12">

					<span
						class="pointer-events-none absolute right-3 top-1/2
                               -translate-y-1/2 text-xs text-slate-400">
						cm
					</span>
				</div>

				<?php $fieldError('head_circumference_cm'); ?>
			</div>

			<!-- Complications -->
			<div class="sm:col-span-2 xl:col-span-3">
				<label
					for="neonatal_complications"
					class="block text-sm font-medium text-slate-700">
					Neonatal complications
				</label>

				<textarea
					id="neonatal_complications"
					name="childData[neonatal_complications]"
					rows="4"
					placeholder="Describe any neonatal complications..."
					class="<?= $inputClass('neonatal_complications') ?>"><?= e((string) $childValue(
																				'neonatal_complications'
																			)) ?></textarea>

				<?php $fieldError('neonatal_complications'); ?>
			</div>
		</div>
	</section>

	<!-- Actions -->
	<div
		class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6
               sm:flex-row sm:justify-end">
		<a
			href="<?= e(APP_URL . '/children') ?>"
			class="inline-flex items-center justify-center rounded-lg border
                   border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold
                   text-slate-700 hover:bg-slate-50">
			Cancel
		</a>

		<button
			type="submit"
			<?= empty($families) ? 'disabled' : '' ?>
			class="inline-flex items-center justify-center rounded-lg
                   bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white
                   hover:bg-blue-700 focus:outline-none focus:ring-2
                   focus:ring-blue-500 focus:ring-offset-2
                   disabled:cursor-not-allowed disabled:bg-slate-400">
			Register Child
		</button>
	</div>
</form>