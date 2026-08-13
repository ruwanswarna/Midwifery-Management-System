<!-- Dashboard -->

<a
    href="<?= APP_URL ?>/dashboard"
    class="<?= active('/dashboard', $currentUri) ?> mx-3 flex items-center gap-3 rounded-lg px-3 py-2.5 transition">

    <!-- Heroicon Home -->

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 10.5L12 3l9 7.5M5.25 9.75V21h13.5V9.75" />

    </svg>

    Dashboard

</a>


<!-- Mother Management -->

<p class="mb-2 mt-7 px-6 text-xs font-semibold uppercase tracking-widest text-slate-500">

    Maternal Care

</p>
<a
    href="<?= APP_URL ?>/families"
    class="<?= activeFor(
                $currentUri,
                [],
                ['/families']
            ) ?> mx-3 flex items-center gap-3 rounded-lg px-3 py-2.5 transition">

    <!-- Family -->

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

    Families

</a>

<a
    href="<?= APP_URL ?>/mothers"
    class="<?= activeFor(
                $currentUri,
                [],
                ['/mothers']
            ) ?> mx-3 flex items-center gap-3 rounded-lg px-3 py-2.5 transition">

    <!-- Users Icon -->

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M17 20h5V18a4 4 0 00-4-4h-1M9 20H4V18a4 4 0 014-4h8a4 4 0 014 4v2M12 10a4 4 0 100-8 4 4 0 000 8z" />

    </svg>

    Mothers

</a>


<a
    href="<?= APP_URL ?>/pregnancies"
    class="<?= activeFor(
                $currentUri,
                [],
                ['/pregnancies']
            ) ?> mx-3 flex items-center gap-3 rounded-lg px-3 py-2.5 transition">

    <!-- Heart Icon -->

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />

    </svg>

    Pregnancies

</a>



<!-- Child Management -->

<p class="mb-2 mt-7 px-6 text-xs font-semibold uppercase tracking-widest text-slate-500">

    Child Health

</p>


<a
    href="<?= APP_URL ?>/children"
    class="<?= activeFor(
                $currentUri,
                [
                    '/children'
                ],
                [
                    '/children/registry',
                    '/children/create',
                    '/children/observations',
                    '/children/reports'
                ],
                [
                    '#^/children/\d+(?:/edit)?$#',
                    '#^/children/\d+/(?:observations|supplements)(?:/.*)?$#'
                ]
            ) ?> mx-3 flex items-center gap-3 rounded-lg px-3 py-2.5 transition">

    <!-- Baby -->

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <circle cx="12" cy="8" r="3" stroke-width="2" />

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M7 21a5 5 0 0110 0" />

    </svg>

    Children

</a>


<a
    href="<?= APP_URL ?>/children/growth"
    class="<?= activeFor(
                $currentUri,
                [],
                [
                    '/children/growth'
                ],
                [
                    '#^/children/\d+/growth(?:/.*)?$#'
                ]
            ) ?> mx-3 flex items-center gap-3 rounded-lg px-3 py-2.5 transition">

    <!-- Chart -->

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
    href="<?= APP_URL ?>/children/vaccinations"
    class="<?= activeFor(
                $currentUri,
                [],
                [
                    '/children/vaccinations'
                ],
                [
                    '#^/children/\d+/vaccinations(?:/.*)?$#'
                ]
            ) ?> mx-3 flex items-center gap-3 rounded-lg px-3 py-2.5 transition">

    <!-- Shield -->

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

    Immunizations

</a>


<a
    href="<?= APP_URL ?>/supplements"
    class="<?= activeFor(
                $currentUri,
                [],
                [
                    '/supplements'
                ],
                [
                    '#^/children/\d+/supplements(?:/.*)?$#',
                    '#^/mothers/\d+/supplements(?:/.*)?$#'
                ]
            ) ?> mx-3 flex items-center gap-3 rounded-lg px-3 py-2.5 transition">

    <!-- Capsule -->

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


<!-- General -->

<p class="mb-2 mt-7 px-6 text-xs font-semibold uppercase tracking-widest text-slate-500">

    General

</p>

<a
    href="<?= APP_URL ?>/field-visits"
    class="<?= active('/field-visits', $currentUri) ?> mx-3 flex items-center gap-3 rounded-lg px-3 py-2.5 transition">

    <!-- field -->

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 2h6l1 2h3v18H5V4h3l1-2zm0 7h6m-6 4h6m-6 4h4" />

    </svg>

    Field Visits

</a>
<a
    href="<?= APP_URL ?>/clinics"
    class="<?= active('/clinics', $currentUri) ?> mx-3 flex items-center gap-3 rounded-lg px-3 py-2.5 transition">

    <!-- Clinics -->

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M3 21h18M5 21V7l7-4 7 4v14" />

    </svg>

    Clinics

</a>
<a
    href="<?= APP_URL ?>/clinic-visits"
    class="<?= active('/clinic-visits', $currentUri) ?> mx-3 flex items-center gap-3 rounded-lg px-3 py-2.5 transition">

    <!-- clinic visits -->

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
    href="<?= APP_URL ?>/reports"
    class="<?= active('/reports', $currentUri) ?> mx-3 flex items-center gap-3 rounded-lg px-3 py-2.5 transition">

    <!-- Report -->

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

    Reports

</a>