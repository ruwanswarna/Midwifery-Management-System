<?php

$auth = new Auth();

$partialPath = ROOT_PATH . '/resources/views/partials';

?>

<div class="space-y-6">

    <!-- Stat cards -->
    <?php require $partialPath . '/stat-cards.php'; ?>


    <!-- ======================================================
         Row 1
         Recent Families controls: scrollable target
         Attention Required controls: natural-height source
    ======================================================= -->
    <div
        class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3"
        data-height-pair>
        <!-- Match Attention Required height -->
        <div
            class="min-h-0 overflow-hidden xl:col-span-2"
            data-height-target>
            <?php require $partialPath . '/recent-activity.php'; ?>
        </div>

        <!-- Natural content height -->
        <div
            class="w-full self-start"
            data-height-source>
            <?php require $partialPath . '/attention-required.php'; ?>
        </div>
    </div>


    <!-- ======================================================
         Row 2
         Quick Actions controls: natural-height source
         Clinic Schedule: scrollable target
    ======================================================= -->
    <div
        class="grid grid-cols-1 items-start gap-6 xl:grid-cols-2"
        data-height-pair>
        <!-- Natural content height -->
        <div
            class="w-full self-start"
            data-height-source>
            <?php require $partialPath . '/quick-actions.php'; ?>
        </div>

        <!-- Match Quick Actions height -->
        <div
            class="min-h-0 overflow-hidden"
            data-height-target>
            <?php require $partialPath . '/clinic-schedule.php'; ?>
        </div>
    </div>


    <!-- ======================================================
         Row 3
         Both cards stretch to the height of the taller card.
         Each table shows up to five rows before scrolling.
    ======================================================= -->
    <div class="grid grid-cols-1 items-stretch gap-6 xl:grid-cols-2">

        <div class="min-w-0">
            <?php
            require $partialPath
                . '/upcoming-followups.php';
            ?>
        </div>

        <div class="min-w-0">
            <?php
            require $partialPath
                . '/upcoming-births.php';
            ?>
        </div>

    </div>


    <!-- ======================================================
         Row 4
         Charts remain unchanged
    ======================================================= -->
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        <div class="min-w-0">
            <?php
            require $partialPath
                . '/monthly-mother-registrations.php';
            ?>
        </div>

        <div class="min-w-0">
            <?php
            require $partialPath
                . '/pregnancy-status-distribution.php';
            ?>
        </div>

    </div>

</div>

<script src="<?= APP_URL ?>/public/js/dashboard.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const desktopMedia = window.matchMedia(
            '(min-width: 1280px)'
        );

        const heightPairs = document.querySelectorAll(
            '[data-height-pair]'
        );

        let animationFrameId = null;

        function synchronizeCardHeights() {
            cancelAnimationFrame(animationFrameId);

            animationFrameId = requestAnimationFrame(function() {
                heightPairs.forEach(function(pair) {
                    const source = pair.querySelector(
                        '[data-height-source]'
                    );

                    const target = pair.querySelector(
                        '[data-height-target]'
                    );

                    if (!source || !target) {
                        return;
                    }

                    /*
                     * Remove the fixed height on smaller screens.
                     * Cards should stack naturally on mobile/tablet.
                     */
                    target.style.height = '';

                    if (!desktopMedia.matches) {
                        return;
                    }

                    const sourceHeight = Math.ceil(
                        source.getBoundingClientRect().height
                    );

                    target.style.height = sourceHeight + 'px';
                });
            });
        }

        /*
         * Automatically update the matched card whenever the source
         * card's content height changes.
         */
        const heightObserver = new ResizeObserver(function() {
            synchronizeCardHeights();
        });

        heightPairs.forEach(function(pair) {
            const source = pair.querySelector(
                '[data-height-source]'
            );

            if (source) {
                heightObserver.observe(source);
            }
        });

        window.addEventListener(
            'resize',
            synchronizeCardHeights
        );

        desktopMedia.addEventListener(
            'change',
            synchronizeCardHeights
        );

        synchronizeCardHeights();
    });
</script>