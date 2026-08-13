<!-- Parent -->

<p class="px-6 mt-8 mb-2 text-xs font-semibold uppercase tracking-widest text-slate-500">

    Parent Portal

</p>

<!-- My Family -->

<a
    href="<?= APP_URL ?>/my-family"
    class="<?= active('/my-family', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M3 10.5L12 3l9 7.5V21H3V10.5z" />

    </svg>

    My Family

</a>

<!-- My Pregnancy -->

<a
    href="<?= APP_URL ?>/my-pregnancy"
    class="<?= active('/my-pregnancy', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />

    </svg>

    My Pregnancy

</a>

<!-- My Children -->

<a
    href="<?= APP_URL ?>/my-children"
    class="<?= active('/my-children', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <circle
            cx="12"
            cy="8"
            r="3"
            stroke-width="2" />

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M7 21a5 5 0 0110 0" />

    </svg>

    My Children

</a>

<!-- Healthcare -->

<p class="px-6 mt-8 mb-2 text-xs font-semibold uppercase tracking-widest text-slate-500">

    Healthcare

</p>

<a
    href="<?= APP_URL ?>/my-clinic-visits"
    class="<?= active('/my-clinic-visits', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M8 2v3M16 2v3M3 9h18M5 5h14a2 2 0 012 2v13H3V7a2 2 0 012-2z" />

    </svg>

    Clinic Visits

</a>

<a
    href="<?= APP_URL ?>/my-vaccinations"
    class="<?= active('/my-vaccinations', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 3l7 3v5c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-3z" />

    </svg>

    Vaccinations

</a>

<a
    href="<?= APP_URL ?>/my-growth"
    class="<?= active('/my-growth', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M4 19h16M7 16V8M12 16V5M17 16v-3" />

    </svg>

    Growth Monitoring

</a>

<a
    href="<?= APP_URL ?>/my-supplements"
    class="<?= active('/my-supplements', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 5a4 4 0 015.657 0l4.343 4.343a4 4 0 11-5.657 5.657L9 10.657A4 4 0 019 5z" />

    </svg>

    Supplements

</a>

<!-- Appointments -->

<p class="px-6 mt-8 mb-2 text-xs font-semibold uppercase tracking-widest text-slate-500">

    Appointments

</p>

<a
    href="<?= APP_URL ?>/my-upcoming-clinics"
    class="<?= active('/my-upcoming-clinics', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M8 2v3M16 2v3M3 9h18" />

    </svg>

    Upcoming Clinics

</a>

<a
    href="<?= APP_URL ?>/my-field-visits"
    class="<?= active('/my-field-visits', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 2h6l1 2h3v18H5V4h3l1-2z" />

    </svg>

    Field Visit History

</a>

<!-- Reports -->

<p class="px-6 mt-8 mb-2 text-xs font-semibold uppercase tracking-widest text-slate-500">

    Reports

</p>

<a
    href="<?= APP_URL ?>/health-records"
    class="<?= active('/health-records', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 17v-6M12 17V7M15 17v-3M5 21h14" />

    </svg>

    Health Records

</a>