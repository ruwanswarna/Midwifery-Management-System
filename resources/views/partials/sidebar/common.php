<!-- Account -->
<p class="px-6 mt-8 mb-2 text-xs font-semibold uppercase tracking-widest text-slate-500">

    Account

</p>

<a
    href="<?= APP_URL ?>/profile"
    class="<?= active('/profile', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M5.121 17.804A9 9 0 1118.88 17.8" />

    </svg>

    Profile

</a>

<a
    href="<?= APP_URL ?>/change-password"
    class="<?= active('/change-password', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2h-1V9a5 5 0 00-10 0v2H6a2 2 0 00-2 2v6a2 2 0 002 2zm3-10V9a3 3 0 016 0v2" />

    </svg>

    Change Password

</a>
<!-- Logout -->

<div class="border-t border-slate-800">

    <a
        href="<?= APP_URL ?>/logout"
        class="flex items-center gap-3 px-6 py-4 text-red-300 hover:bg-red-700 hover:text-white transition">

        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M17 16l4-4m0 0l-4-4m4 4H9m4 8H5a2 2 0 01-2-2V6a2 2 0 012-2h8" />

        </svg>

        Logout

    </a>

</div>