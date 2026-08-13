<?php if (empty($pregnancies)) : ?>

	<div class="rounded-lg border border-slate-200 bg-white p-6 text-slate-500">
		No pregnancy records found.
	</div>

<?php else : ?>

	<div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

		<table class="w-full">

			<thead class="bg-slate-50">
				<tr>
					<th class="px-6 py-3 text-left">Mother</th>
					<th class="px-6 py-3 text-left">Expected Delivery</th>
					<th class="px-6 py-3 text-left">Risk</th>
					<th class="px-6 py-3 text-left">Status</th>
					<th class="px-6 py-3 text-right">Action</th>
				</tr>
			</thead>

			<tbody>

				<?php foreach ($pregnancies as $pregnancy) : ?>

					<tr class="border-t border-slate-200">

						<td class="px-6 py-4">
							<?= e($pregnancy['mother_name']) ?>
						</td>

						<td class="px-6 py-4">
							<?= e($pregnancy['expected_delivery_date']) ?>
						</td>

						<td class="px-6 py-4">
							<?= e($pregnancy['risk_status']) ?>
						</td>

						<td class="px-6 py-4">
							<?= e($pregnancy['status']) ?>
						</td>

						<td class="px-6 py-4 text-right">

							<a
								href="<?= APP_URL ?>/pregnancies/<?= $pregnancy['pregnancy_id'] ?>"
								class="text-blue-600 hover:underline">

								View

							</a>

						</td>

					</tr>

				<?php endforeach; ?>

			</tbody>

		</table>

	</div>

<?php endif; ?>