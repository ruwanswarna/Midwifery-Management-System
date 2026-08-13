<?php if (($title ?? '') !== 'Dashboard') : ?>

	<section
		id="page-header"
		class="relative sticky top-0 z-30 bg-transparent">
		<!-- Collapsible header content -->
		<div id="page-header-content" class="page-header-collapsible border-b border-slate-200
           bg-slate-100/95 shadow-sm backdrop-blur">
			<div class="min-h-0 overflow-hidden">
				<div class="px-6 pt-3">
					<?php require __DIR__ . '/breadcrumbs.php'; ?>

					<div class="mt-3">
						<?php require __DIR__ . '/title.php'; ?>
					</div>

					<?php require __DIR__ . '/module-nav.php'; ?>
				</div>
			</div>
		</div>

		<!-- Toggle bar remains visible when collapsed -->
		<!-- Header expand/collapse toggle -->
		<!-- Header expand/collapse control -->
		<div class="relative h-10 bg-transparent">
			<div
				class="pointer-events-none absolute left-6 top-0
               flex h-10 items-start">
				<button
					id="page-header-toggle"
					type="button"
					class="pointer-events-auto inline-flex h-10 w-[4.5rem]
                   items-center justify-center rounded-b-md
                   border-x border-b border-slate-300 bg-white/90
                   text-slate-500 shadow-sm backdrop-blur
                   transition-colors hover:bg-white
                   hover:text-slate-700 focus:outline-none
                   focus-visible:ring-1 focus-visible:ring-slate-400"
					aria-controls="page-header-content"
					aria-expanded="true"
					aria-label="Collapse page header"
					title="Collapse page header">
					<svg
						class="page-header-toggle-icon h-4 w-4"
						fill="none"
						viewBox="0 0 24 24"
						stroke="currentColor"
						aria-hidden="true">
						<path
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2.25"
							d="m19 15-7-7-7 7" />
					</svg>
				</button>
			</div>
		</div>
	</section>

<?php endif; ?>