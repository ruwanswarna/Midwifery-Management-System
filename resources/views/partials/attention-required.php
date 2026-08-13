<?php
///////////////////////////// Sample data
$attentionItems = [
	[
		'title'       => 'Overdue childhood vaccinations',
		'description' => 'Children whose scheduled vaccination date has passed.',
		'count'       => 8,
		'level'       => 'critical',
		'url'         => APP_URL . '/children/vaccinations?status=overdue',
	],
	[
		'title'       => 'Prenatal follow-ups due',
		'description' => 'Pregnant mothers requiring a scheduled follow-up.',
		'count'       => 5,
		'level'       => 'warning',
		'url'         => APP_URL . '/pregnancies?follow_up=due',
	],
	[
		'title'       => 'Field visits scheduled today',
		'description' => 'Home visits assigned for the current day.',
		'count'       => 3,
		'level'       => 'info',
		'url'         => APP_URL . '/field-visits?date=today',
	],
];
/////////////////////////////////////
$attentionItems = $attentionItems ?? [];

$statusStyles = [
	'critical' => [
		'container' => 'border-red-200 bg-red-50',
		'icon'      => 'bg-red-100 text-red-700',
		'badge'     => 'bg-red-100 text-red-700',
	],
	'warning' => [
		'container' => 'border-amber-200 bg-amber-50',
		'icon'      => 'bg-amber-100 text-amber-700',
		'badge'     => 'bg-amber-100 text-amber-700',
	],
	'info' => [
		'container' => 'border-blue-200 bg-blue-50',
		'icon'      => 'bg-blue-100 text-blue-700',
		'badge'     => 'bg-blue-100 text-blue-700',
	],
];

?>

<section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

	<div class="flex items-center justify-between gap-4 border-b border-slate-200 px-5 py-4">
		<div>
			<h2 class="text-base font-semibold text-slate-900">
				Attention Required
			</h2>

			<p class="mt-1 text-sm text-slate-500">
				Records requiring follow-up or action.
			</p>
		</div>

		<a
			href="<?= APP_URL ?>/dashboard#"
			class="shrink-0 text-sm font-medium text-blue-600
                   hover:text-blue-700 hover:underline">
			View all
		</a>
	</div>

	<?php if (!empty($attentionItems)) : ?>

		<div class="divide-y divide-slate-100">

			<?php foreach ($attentionItems as $item) : ?>
				<?php
				$level = $item['level'] ?? 'warning';
				$styles = $statusStyles[$level] ?? $statusStyles['warning'];
				?>

				<a
					href="<?= e($item['url'] ?? '#') ?>"
					class="group flex items-start gap-4 px-5 py-4
                           transition hover:bg-slate-50">
					<div
						class="flex h-10 w-10 shrink-0 items-center
                               justify-center rounded-lg
                               <?= e($styles['icon']) ?>">
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
								d="M12 9v3.75m9.303 3.376
                                   c.866 1.5-.217 3.374-1.948
                                   3.374H4.645c-1.73 0-2.813-1.874
                                   -1.948-3.374L10.05 3.378
                                   c.865-1.5 3.03-1.5 3.896 0
                                   l7.357 12.748ZM12 15.75h.008v.008H12v-.008Z" />
						</svg>
					</div>

					<div class="min-w-0 flex-1">
						<div class="flex flex-wrap items-center gap-2">
							<h3 class="text-sm font-semibold text-slate-800">
								<?= e($item['title'] ?? '') ?>
							</h3>

							<?php if (isset($item['count'])) : ?>
								<span
									class="rounded-full px-2 py-0.5 text-xs
                                           font-semibold <?= e($styles['badge']) ?>">
									<?= number_format((int) $item['count']) ?>
								</span>
							<?php endif; ?>
						</div>

						<?php if (!empty($item['description'])) : ?>
							<p class="mt-1 text-sm text-slate-500">
								<?= e($item['description']) ?>
							</p>
						<?php endif; ?>
					</div>

					<svg
						class="mt-2 h-4 w-4 shrink-0 text-slate-400
                               transition group-hover:translate-x-0.5
                               group-hover:text-blue-600"
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
				</a>

			<?php endforeach; ?>

		</div>

	<?php else : ?>

		<div class="px-5 py-10 text-center">
			<div
				class="mx-auto flex h-12 w-12 items-center justify-center
                       rounded-full bg-emerald-50 text-emerald-600">
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
						d="m4.5 12.75 6 6 9-13.5" />
				</svg>
			</div>

			<h3 class="mt-3 text-sm font-semibold text-slate-900">
				No urgent follow-ups
			</h3>

			<p class="mt-1 text-sm text-slate-500">
				All currently monitored records are up to date.
			</p>
		</div>

	<?php endif; ?>

</section>