<?php

$auth = new Auth();

$user = $auth->check()
    ? $auth->user()
    : null;

$fullName = $user['full_name'] ?? 'Guest User';
$roleName = $user['role_name'] ?? 'User';

$avatarInitial = strtoupper(
    mb_substr($fullName, 0, 1)
);

?>

<nav class="h-16 border-b border-slate-200 bg-white shadow-sm">

    <div class="flex h-16 items-center justify-between gap-6 px-6">

        <!-- Left side -->
        <div class="flex min-w-0 flex-1 items-center gap-4">

            <!-- Sidebar toggle -->
            <button
                type="button"
                id="sidebar-toggle"
                class="flex h-10 w-10 shrink-0 items-center justify-center
                       rounded-lg text-slate-500 transition
                       hover:bg-slate-100 hover:text-slate-800"
                aria-label="Toggle sidebar"
                aria-controls="sidebar-wrapper"
                aria-expanded="true"
                >
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
                        d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                </svg>
            </button>

            <!-- Search -->
            <form
                action="<?= APP_URL ?>/search"
                method="GET"
                class="hidden w-full max-w-md md:block">
                <label for="global-search" class="sr-only">
                    Search records
                </label>

                <div class="relative">

                    <svg
                        class="pointer-events-none absolute left-3 top-1/2
                               h-5 w-5 -translate-y-1/2 text-slate-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        aria-hidden="true">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m21 21-4.35-4.35m1.35-5.4
                               a6.75 6.75 0 1 1-13.5 0
                               6.75 6.75 0 0 1 13.5 0Z" />
                    </svg>

                    <input
                        type="search"
                        id="global-search"
                        name="query"
                        placeholder="Search families, mothers or children..."
                        class="w-full rounded-lg border border-slate-200
                               bg-slate-50 py-2.5 pl-10 pr-4 text-sm
                               text-slate-800 outline-none transition
                               placeholder:text-slate-400
                               focus:border-blue-500 focus:bg-white
                               focus:ring-2 focus:ring-blue-500/20">

                </div>
            </form>

        </div>

        <!-- Right side -->
        <div class="flex shrink-0 items-center gap-2">

            <!-- Mobile search button -->
            <button
                type="button"
                class="flex h-10 w-10 items-center justify-center rounded-lg
                       text-slate-500 transition hover:bg-slate-100
                       hover:text-slate-800 md:hidden"
                aria-label="Search">
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
                        d="m21 21-4.35-4.35m1.35-5.4
                           a6.75 6.75 0 1 1-13.5 0
                           6.75 6.75 0 0 1 13.5 0Z" />
                </svg>
            </button>

            <!-- Notifications -->
            <button
                type="button"
                class="relative flex h-10 w-10 items-center justify-center
                       rounded-lg text-slate-500 transition
                       hover:bg-slate-100 hover:text-slate-800"
                aria-label="Notifications">
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
                        d="M14.25 18.75a2.25 2.25 0 0 1-4.5 0
                           m8.25-3H6
                           c1.5-1.5 1.5-3 1.5-5.25
                           a4.5 4.5 0 1 1 9 0
                           c0 2.25 0 3.75 1.5 5.25Z" />
                </svg>

                <span
                    class="absolute right-2 top-2 h-2 w-2 rounded-full
                           bg-red-500 ring-2 ring-white"></span>
            </button>

            <div class="mx-2 hidden h-8 w-px bg-slate-200 sm:block"></div>

            <?php if ($user) : ?>

                <!-- Profile dropdown wrapper -->
                <div class="relative">

                    <button
                        type="button"
                        id="profile-menu-button"
                        class="flex items-center gap-3 rounded-lg p-1.5
                               transition hover:bg-slate-100"
                        aria-expanded="false"
                        aria-controls="profile-menu">
                        <!-- User information -->
                        <div class="hidden text-right sm:block">

                            <p class="max-w-48 truncate text-sm font-medium text-slate-800">
                                <?= e($fullName) ?>
                            </p>

                            <p class="text-xs text-slate-500">
                                <?= e($roleName) ?>
                            </p>

                        </div>

                        <!-- Avatar -->
                        <div
                            class="flex h-10 w-10 items-center justify-center
                                   rounded-full bg-blue-600 text-sm font-semibold
                                   text-white">
                            <?= e($avatarInitial) ?>
                        </div>

                        <svg
                            class="hidden h-4 w-4 text-slate-400 sm:block"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            aria-hidden="true">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m19.5 9-7.5 7.5L4.5 9" />
                        </svg>

                    </button>

                    <!-- Dropdown -->
                    <div
                        id="profile-menu"
                        class="absolute right-0 mt-2 hidden w-56 overflow-hidden
                               rounded-xl border border-slate-200 bg-white
                               shadow-lg">
                        <div class="border-b border-slate-100 px-4 py-3">

                            <p class="truncate text-sm font-medium text-slate-800">
                                <?= e($fullName) ?>
                            </p>

                            <p class="text-xs text-slate-500">
                                <?= e($roleName) ?>
                            </p>

                        </div>

                        <div class="p-1.5">

                            <a
                                href="<?= APP_URL ?>/profile"
                                class="flex items-center gap-3 rounded-lg px-3 py-2
                                       text-sm text-slate-600 transition
                                       hover:bg-slate-100 hover:text-slate-900">
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
                                        d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0
                                           3.75 3.75 0 0 1 7.5 0ZM4.5 20.25
                                           a7.5 7.5 0 0 1 15 0" />
                                </svg>

                                My Profile
                            </a>

                            <a
                                href="<?= APP_URL ?>/settings"
                                class="flex items-center gap-3 rounded-lg px-3 py-2
                                       text-sm text-slate-600 transition
                                       hover:bg-slate-100 hover:text-slate-900">
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
                                        d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.592
                                           c.55 0 1.02.398 1.11.94l.213 1.281
                                           c.063.374.313.686.645.87.074.04.147.083.219.127
                                           .325.198.72.247 1.075.118l1.217-.44
                                           a1.125 1.125 0 0 1 1.37.49l1.296 2.247
                                           a1.125 1.125 0 0 1-.26 1.431l-1.003.827
                                           c-.293.241-.438.613-.43.992a6.76 6.76 0 0 1 0 .254
                                           c-.008.378.137.75.43.992l1.003.827
                                           c.424.35.534.954.26 1.43l-1.296 2.247
                                           a1.125 1.125 0 0 1-1.37.491l-1.217-.441
                                           c-.355-.129-.75-.08-1.075.118a6.6 6.6 0 0 1-.219.127
                                           c-.332.183-.582.495-.645.87l-.213 1.28
                                           c-.09.543-.56.941-1.11.941h-2.592
                                           c-.55 0-1.02-.398-1.11-.94l-.213-1.281
                                           c-.063-.374-.313-.686-.645-.87a6.52 6.52 0 0 1-.219-.127
                                           c-.325-.198-.72-.247-1.075-.118l-1.217.44
                                           a1.125 1.125 0 0 1-1.37-.49L3.46 15.17
                                           a1.125 1.125 0 0 1 .26-1.431l1.003-.827
                                           c.293-.241.438-.613.43-.992a6.76 6.76 0 0 1 0-.254
                                           c.008-.378-.137-.75-.43-.992L3.72 9.847
                                           a1.125 1.125 0 0 1-.26-1.43l1.296-2.247
                                           a1.125 1.125 0 0 1 1.37-.491l1.217.441
                                           c.355.129.75.08 1.075-.118.072-.044.145-.087.219-.127
                                           .332-.183.582-.495.645-.87l.213-1.28Z" />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>

                                Settings
                            </a>

                        </div>

                        <div class="border-t border-slate-100 p-1.5">

                            <form
                                action="<?= APP_URL ?>/logout"
                                method="POST">
                                <button
                                    type="submit"
                                    class="flex w-full items-center gap-3 rounded-lg
                                           px-3 py-2 text-left text-sm text-red-600
                                           transition hover:bg-red-50">
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
                                            d="M15.75 9V5.25A2.25 2.25 0 0 0
                                               13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25
                                               v13.5A2.25 2.25 0 0 0 7.5 21h6
                                               a2.25 2.25 0 0 0 2.25-2.25V15
                                               m3-3H9.75m9 0-3-3m3 3-3 3" />
                                    </svg>

                                    Sign Out
                                </button>
                            </form>

                        </div>
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</nav>