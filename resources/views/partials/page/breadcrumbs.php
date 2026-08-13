<?php if (!empty($breadcrumbs)) : ?>

    <nav class="mb-3 flex items-center gap-2 text-sm" aria-label="Breadcrumb">

        <?php

        $last = array_key_last($breadcrumbs);

        foreach ($breadcrumbs as $text => $url) :

        ?>

            <?php if ($url) : ?>

                <a

                    href="<?= APP_URL . $url ?>"

                    class="text-slate-500 transition hover:text-blue-600">

                    <?= $text ?>

                </a>

            <?php else : ?>

                <span
                    class="text-slate-700 font-medium">

                    <?= $text ?>

                </span>

            <?php endif; ?>

            <?php if ($text !== $last) : ?>

                <svg
                    class="h-4 w-4 text-slate-400"
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


            <?php endif; ?>

        <?php endforeach; ?>

    </nav>

<?php endif; ?>