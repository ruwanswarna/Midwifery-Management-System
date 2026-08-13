<!DOCTYPE html>
<html lang="en">

<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>

<!--
    Restore the sidebar state before the body is painted.
    This prevents the expanded-sidebar flash during page navigation.
-->
<script>
    try {
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    } catch (error) {
        console.warn('Unable to restore sidebar state.', error);
    }

    try {
        if (
            localStorage.getItem('page-header-collapsed') ===
            'true'
        ) {
            document.documentElement.classList.add(
                'page-header-collapsed'
            );
        }
    } catch (error) {
        console.warn(
            'Unable to restore page header state.',
            error
        );
    }
</script>

<style>
    /*
 * Collapsible page header.
 *
 * Animating a grid row allows content with an unknown height to
 * transition smoothly between its full height and zero.
 */
    .page-header-collapsible {
        display: grid;
        grid-template-rows: 1fr;
        opacity: 1;

        transition:
            grid-template-rows 300ms ease-in-out,
            opacity 200ms ease-in-out;
    }

    .page-header-collapsed .page-header-collapsible {
        grid-template-rows: 0fr;
        opacity: 0;
    }

    .page-header-toggle-icon {
        transform: rotate(0deg);
        transition: transform 300ms ease-in-out;
    }

    /*
 * Point downward when collapsed to indicate that the header
 * can be expanded.
 */
    .page-header-collapsed .page-header-toggle-icon {
        transform: rotate(180deg);
    }

    /*
 * Prevent an animation flash while restoring saved state.
 */
    html:not(.page-header-ready) .page-header-collapsible,
    html:not(.page-header-ready) .page-header-toggle-icon {
        transition: none;
    }

    /*
     * The wrapper controls the sidebar's occupied layout width.
     * The aside itself remains 278px wide.
     */
    #sidebar-wrapper {
        width: 240px;
        flex-shrink: 0;
        overflow: hidden;
        transition: width 300ms ease-in-out;
    }

    .sidebar-collapsed #sidebar-wrapper {
        width: 0;
    }

    /*
     * Do not animate the initial state restoration.
     * Transitions are enabled after the first frame.
     */
    html:not(.sidebar-ready) #sidebar-wrapper {
        transition: none;
    }

    /* Hide scrollbars while preserving scrolling. */
    .hide-scrollbar {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>

<body class="h-screen overflow-hidden bg-slate-100">

    <div class="flex h-screen overflow-hidden">

        <!-- Collapsible sidebar wrapper -->
        <div id="sidebar-wrapper">
            <?php require ROOT_PATH . '/resources/views/partials/sidebar/sidebar.php'; ?>
        </div>

        <!-- Main application area -->
        <div
            id="application-content"
            class="flex min-w-0 flex-1 flex-col overflow-hidden">
            <!-- Navbar remains visible because it is outside the scrolling main area. -->
            <div class="relative z-40 shrink-0">
                <?php require ROOT_PATH . '/resources/views/partials/navbar.php'; ?>
            </div>

            <!-- Only this region scrolls. -->
            <main
                id="main-content"
                class="min-h-0 flex-1 overflow-y-auto">
                <?php require ROOT_PATH . '/resources/views/partials/alerts.php'; ?>

                <!-- Sticky breadcrumbs, page title and module navigation. -->
                <?php require ROOT_PATH . '/resources/views/partials/page/header.php'; ?>

                <!-- Page-specific content. -->
                <div class="p-6">
                    <?php
                    // View file specified by the controller.
                    require $viewPath;
                    ?>
                </div>

                <?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
            </main>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            /*
             * Profile dropdown
             */
            const profileButton = document.getElementById(
                'profile-menu-button'
            );

            const profileMenu = document.getElementById(
                'profile-menu'
            );

            profileButton?.addEventListener('click', function(event) {
                event.stopPropagation();

                const menuIsHidden = profileMenu.classList.toggle(
                    'hidden'
                );

                profileButton.setAttribute(
                    'aria-expanded',
                    String(!menuIsHidden)
                );
            });

            document.addEventListener('click', function(event) {
                if (
                    profileMenu &&
                    profileButton &&
                    !profileMenu.contains(event.target) &&
                    !profileButton.contains(event.target)
                ) {
                    profileMenu.classList.add('hidden');

                    profileButton.setAttribute(
                        'aria-expanded',
                        'false'
                    );
                }
            });

            /*
             * Sidebar state
             */
            const sidebarToggle = document.getElementById(
                'sidebar-toggle'
            );

            const documentRoot = document.documentElement;

            /*
             * Enable animation only after the stored state has already
             * been applied, preventing a flash on page load.
             */
            requestAnimationFrame(function() {
                documentRoot.classList.add('sidebar-ready');
            });

            function sidebarIsCollapsed() {
                return documentRoot.classList.contains(
                    'sidebar-collapsed'
                );
            }

            function updateSidebarButton() {
                sidebarToggle?.setAttribute(
                    'aria-expanded',
                    String(!sidebarIsCollapsed())
                );
            }

            updateSidebarButton();

            sidebarToggle?.addEventListener('click', function() {
                documentRoot.classList.toggle('sidebar-collapsed');

                const collapsed = sidebarIsCollapsed();

                try {
                    localStorage.setItem(
                        'sidebar-collapsed',
                        String(collapsed)
                    );
                } catch (error) {
                    console.warn('Unable to save sidebar state.', error);
                }

                updateSidebarButton();
            });

            /*
             * Page header state
             */
            const pageHeaderToggle = document.getElementById(
                'page-header-toggle'
            );

            function pageHeaderIsCollapsed() {
                return document.documentElement.classList.contains(
                    'page-header-collapsed'
                );
            }

            function updatePageHeaderButton() {
                if (!pageHeaderToggle) {
                    return;
                }

                const collapsed = pageHeaderIsCollapsed();

                const action = collapsed ?
                    'Expand' :
                    'Collapse';

                const label = `${action} page header`;

                pageHeaderToggle.setAttribute(
                    'aria-expanded',
                    String(!collapsed)
                );

                pageHeaderToggle.setAttribute(
                    'aria-label',
                    label
                );

                pageHeaderToggle.setAttribute(
                    'title',
                    label
                );

                const stateElement = document.getElementById(
                    'page-header-toggle-state'
                );

                if (stateElement) {
                    stateElement.textContent = action;
                }
            }

            updatePageHeaderButton();

            pageHeaderToggle?.addEventListener('click', function() {
                document.documentElement.classList.toggle(
                    'page-header-collapsed'
                );

                const collapsed = pageHeaderIsCollapsed();

                try {
                    localStorage.setItem(
                        'page-header-collapsed',
                        String(collapsed)
                    );
                } catch (error) {
                    console.warn(
                        'Unable to save page header state.',
                        error
                    );
                }

                updatePageHeaderButton();
            });

            requestAnimationFrame(function() {
                document.documentElement.classList.add(
                    'page-header-ready'
                );
            });
        });
    </script>

</body>

</html>