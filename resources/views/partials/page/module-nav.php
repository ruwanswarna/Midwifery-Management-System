<?php if (!empty($moduleNav)) : ?>

    <nav
        class="hide-scrollbar mt-4 flex gap-7 overflow-x-auto"
        aria-label="Module navigation"
    >
        <?php foreach ($moduleNav as $item) : ?>
            <?php
            $itemUrl = $item['url'] ?? '';
            $itemTitle = $item['title'] ?? '';
            $isActive = ($activeModuleNav ?? null) === $itemUrl;
            ?>

            <a
                href="<?= APP_URL . e($itemUrl) ?>"
                class="shrink-0 whitespace-nowrap border-b-2 pb-3
                       text-sm font-medium transition
                       <?= $isActive
                            ? 'border-blue-600 text-blue-600'
                            : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'
                       ?>"
                <?= $isActive ? 'aria-current="page"' : '' ?>
            >
                <?= e($itemTitle) ?>
            </a>

        <?php endforeach; ?>
    </nav>

<?php endif; ?>
