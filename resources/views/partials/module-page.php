<?php

$pageActions = $pageActions ?? [];
$summaryCards = $summaryCards ?? [];
$tableColumns = $tableColumns ?? [];
$tableRows = $tableRows ?? [];
$emptyTitle = $emptyTitle ?? 'No records found';
?>

<div class="space-y-6">
    <section class="flex flex-col gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-slate-900"><?= e($title ?? 'Module') ?></h2>
        </div>
        <?php if ($pageActions !== []): ?>
            <div class="flex flex-wrap gap-2">
                <?php foreach ($pageActions as $action): ?>
                    <a href="<?= e(APP_URL . $action['url']) ?>" class="inline-flex items-center rounded-lg <?= !empty($action['primary']) ? 'bg-blue-600 text-white hover:bg-blue-700' : 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50' ?> px-4 py-2.5 text-sm font-semibold transition">
                        <?= e($action['label']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <?php if ($summaryCards !== []): ?>
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <?php foreach ($summaryCards as $card): ?>
                <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500"><?= e($card['label']) ?></p>
                    <p class="mt-2 text-2xl font-bold text-slate-900"><?= e((string) ($card['value'] ?? 0)) ?></p>
                    <?php if (!empty($card['hint'])): ?><p class="mt-1 text-xs text-slate-400"><?= e($card['hint']) ?></p><?php endif; ?>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <?php if ($tableColumns !== []): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <?php foreach ($tableColumns as $column): ?><th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"><?= e($column) ?></th><?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($tableRows as $row): ?><tr class="hover:bg-slate-50">
                                <?php foreach ($row as $cell): ?><td class="whitespace-nowrap px-5 py-4 text-sm text-slate-700">
                                        <?php if (is_array($cell) && isset($cell['url'])): ?>
                                            <a class="font-semibold text-blue-600 hover:text-blue-800" href="<?= e(APP_URL . $cell['url']) ?>"><?= e($cell['text'] ?? 'View') ?></a>
                                        <?php else: ?>
                                            <?= e((string) $cell) ?>
                                        <?php endif; ?>
                                    </td><?php endforeach; ?>
                            </tr><?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($tableRows === []): ?>
            <div class="px-6 py-12 text-center">

                <h3 class="mt-4 font-semibold text-slate-900"><?= e($emptyTitle) ?></h3>
            </div>
        <?php endif; ?>
    </section>
</div>