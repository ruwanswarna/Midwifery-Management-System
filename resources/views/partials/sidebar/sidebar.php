<?php
$currentUri = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
) ?? '/';

// Remove the application base path when it exists.
$currentUri = str_replace(
    '/moms/public',
    '',
    $currentUri
);

// Remove trailing slash, except for the root route.
$currentUri = rtrim($currentUri, '/');

if ($currentUri === '') {
    $currentUri = '/';
}

function active(string $path, string $current): string
{
    return $current === $path
        ? 'bg-blue-600 text-white'
        : 'text-slate-300 hover:bg-slate-800 hover:text-white';
}

function activeFor(
    string $current,
    array $exactRoutes = [],
    array $sections = [],
    array $patterns = []
): string {
    $activeStyles = 'bg-blue-600 text-white';
    $inactiveStyles = 'text-slate-300 hover:bg-slate-800 hover:text-white';

    if (in_array($current, $exactRoutes, true)) {
        return $activeStyles;
    }

    foreach ($sections as $section) {
        $section = rtrim($section, '/');

        if (
            $current === $section ||
            str_starts_with($current, $section . '/')
        ) {
            return $activeStyles;
        }
    }

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $current) === 1) {
            return $activeStyles;
        }
    }

    return $inactiveStyles;
}

$auth = new Auth();
?>

<aside
    id="sidebar"
    class="flex h-screen w-[240px] flex-col overflow-hidden
           bg-slate-900 text-slate-200 shadow-xl">
    <!-- Fixed logo area -->
    <div class="shrink-0 border-b border-slate-800 px-3 py-3">
        <img
            src="<?= APP_URL ?>/public/images/MOMS_logo_alt2.png"
            alt="MOMS Logo"
            class="mx-auto h-auto w-44 max-w-full">
    </div>

    <!-- Independently scrollable navigation -->
    <nav
        class="hide-scrollbar min-h-0 flex-1 overflow-y-auto px-0 py-2"
        aria-label="Primary navigation">
        <?php
        /*
         * Remove the temporary `|| true` expressions when role-based
         * navigation testing is complete.
         */
        if ($auth->hasRole('PHM') || true) {
            require ROOT_PATH . '/resources/views/partials/sidebar/phm.php';
        }

        if ($auth->hasRole('Parent') || true) {
            require ROOT_PATH . '/resources/views/partials/sidebar/parent.php';
        }

        if ($auth->hasRole('Administrator') || true) {
            require ROOT_PATH . '/resources/views/partials/sidebar/admin.php';
        }

        require ROOT_PATH . '/resources/views/partials/sidebar/common.php';
        ?>
    </nav>

    <!-- Fixed sidebar footer -->
    <footer
        class="shrink-0 border-t border-slate-800 bg-slate-900 px-4 py-3">
        <div class="flex items-center justify-between gap-3">


        </div>
    </footer>
</aside>