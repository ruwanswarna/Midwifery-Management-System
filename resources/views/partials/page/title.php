<div
    class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between"
>
    <!-- Page title and description -->
    <div class="min-w-0">
        <h1 class="truncate text-2xl font-bold tracking-tight text-slate-900">
            <?= e($title ?? '') ?>
        </h1>

        <?php if (!empty($description)) : ?>
            <p class="mt-1 hidden max-w-3xl text-sm leading-6 text-slate-500 sm:block">
                <?= e($description) ?>
            </p>
        <?php endif; ?>
    </div>

    <!-- Page-specific actions -->
    <?php if (!empty($pageActions)) : ?>
        <div class="flex shrink-0 flex-wrap items-center gap-2">
            <?= $pageActions ?>
        </div>
    <?php endif; ?>
</div>
