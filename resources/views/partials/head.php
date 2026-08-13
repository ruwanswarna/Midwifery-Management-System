<meta charset="UTF-8">
<!-- Put links to CSS files here. if you're experimenting with the CDN -->
<!-- Later, if you install Tailwind properly, this is the only file you'll change. -->

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

<title><?= APP_NAME ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
<script>
    /*
     * Apply sidebar state before the page is rendered.
     * This prevents the sidebar from expanding briefly during navigation.
     */
    try {
        const sidebarCollapsed =
            localStorage.getItem('sidebar-collapsed') === 'true';

        if (sidebarCollapsed) {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    } catch (error) {
        console.warn('Unable to restore sidebar state.', error);
    }
</script>
<style>
    .hide-scrollbar {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>
<link
    rel="stylesheet"
    href="<?= APP_URL ?>/public/css/app.css">

<!-- If using Tailwind via a compiled CSS file, you would also link it here because it's just another stylesheet. -->