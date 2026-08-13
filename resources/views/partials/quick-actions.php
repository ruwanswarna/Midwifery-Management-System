<section
    class="overflow-hidden rounded-xl border border-slate-200
           bg-white shadow-sm"
>
    <div class="border-b border-slate-200 px-6 py-4">
        <h2 class="text-lg font-semibold text-slate-900">
            Quick Actions
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Frequently used registration and monitoring tasks
        </p>
    </div>

    <div class="grid grid-cols-2 gap-4 p-6 sm:grid-cols-3">

        <!-- Register Mother -->
        <a
            href="<?= APP_URL ?>/mothers/create"
            class="group flex flex-col items-center rounded-xl
                   border border-slate-200 p-4 text-center transition
                   hover:-translate-y-0.5 hover:border-blue-300
                   hover:bg-blue-50 hover:shadow-sm"
        >
            <span
                class="flex h-12 w-12 items-center justify-center
                       rounded-xl bg-blue-50 text-blue-600 transition
                       group-hover:bg-blue-100"
            >
                <svg
                    class="h-7 w-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0
                           3.75 3.75 0 0 1 7.5 0ZM4.5 20.25
                           a7.5 7.5 0 0 1 15 0M19 8v6m3-3h-6"
                    />
                </svg>
            </span>

            <span class="mt-3 text-sm font-medium text-slate-700">
                Register Mother
            </span>
        </a>

        <!-- Register Pregnancy -->
        <a
            href="<?= APP_URL ?>/pregnancies/create"
            class="group flex flex-col items-center rounded-xl
                   border border-slate-200 p-4 text-center transition
                   hover:-translate-y-0.5 hover:border-rose-300
                   hover:bg-rose-50 hover:shadow-sm"
        >
            <span
                class="flex h-12 w-12 items-center justify-center
                       rounded-xl bg-rose-50 text-rose-600 transition
                       group-hover:bg-rose-100"
            >
                <svg
                    class="h-7 w-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 8.25c0-2.485-2.1-4.5-4.688-4.5
                           -1.935 0-3.597 1.126-4.312 2.733
                           C11.285 4.876 9.623 3.75 7.688 3.75
                           5.1 3.75 3 5.765 3 8.25
                           c0 7.22 9 12 9 12s9-4.78 9-12Z"
                    />
                </svg>
            </span>

            <span class="mt-3 text-sm font-medium text-slate-700">
                Register Pregnancy
            </span>
        </a>

        <!-- Register Child -->
        <a
            href="<?= APP_URL ?>/children/create"
            class="group flex flex-col items-center rounded-xl
                   border border-slate-200 p-4 text-center transition
                   hover:-translate-y-0.5 hover:border-emerald-300
                   hover:bg-emerald-50 hover:shadow-sm"
        >
            <span
                class="flex h-12 w-12 items-center justify-center
                       rounded-xl bg-emerald-50 text-emerald-600 transition
                       group-hover:bg-emerald-100"
            >
                <svg
                    class="h-7 w-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 8.25a3 3 0 1 0 0-6
                           3 3 0 0 0 0 6ZM6.75 21
                           a5.25 5.25 0 0 1 10.5 0"
                    />
                </svg>
            </span>

            <span class="mt-3 text-sm font-medium text-slate-700">
                Register Child
            </span>
        </a>

        <!-- Field Visit -->
        <a
            href="<?= APP_URL ?>/field-visits/create"
            class="group flex flex-col items-center rounded-xl
                   border border-slate-200 p-4 text-center transition
                   hover:-translate-y-0.5 hover:border-orange-300
                   hover:bg-orange-50 hover:shadow-sm"
        >
            <span
                class="flex h-12 w-12 items-center justify-center
                       rounded-xl bg-orange-50 text-orange-600 transition
                       group-hover:bg-orange-100"
            >
                <svg
                    class="h-7 w-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 20 3.553 17.276A1 1 0 0 1 3
                           16.382V5.618a1 1 0 0 1 .553-.894L9 2
                           m0 18 6-2m-6 2V2m6 16
                           5.447 2.724A1 1 0 0 0 21 19.382
                           V8.618a1 1 0 0 0-.553-.894L15 5
                           m0 13V5m0 0L9 2"
                    />
                </svg>
            </span>

            <span class="mt-3 text-sm font-medium text-slate-700">
                Record Visit
            </span>
        </a>

        <!-- Growth Monitoring -->
        <a
            href="<?= APP_URL ?>/children/growth"
            class="group flex flex-col items-center rounded-xl
                   border border-slate-200 p-4 text-center transition
                   hover:-translate-y-0.5 hover:border-indigo-300
                   hover:bg-indigo-50 hover:shadow-sm"
        >
            <span
                class="flex h-12 w-12 items-center justify-center
                       rounded-xl bg-indigo-50 text-indigo-600 transition
                       group-hover:bg-indigo-100"
            >
                <svg
                    class="h-7 w-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4.5 19.5h15M6.75 16.5
                           l3.75-3.75 3 3 4.5-7.5"
                    />
                </svg>
            </span>

            <span class="mt-3 text-sm font-medium text-slate-700">
                Growth Monitoring
            </span>
        </a>

        <!-- Reports -->
        <a
            href="<?= APP_URL ?>/reports"
            class="group flex flex-col items-center rounded-xl
                   border border-slate-200 p-4 text-center transition
                   hover:-translate-y-0.5 hover:border-slate-400
                   hover:bg-slate-50 hover:shadow-sm"
        >
            <span
                class="flex h-12 w-12 items-center justify-center
                       rounded-xl bg-slate-100 text-slate-700 transition
                       group-hover:bg-slate-200"
            >
                <svg
                    class="h-7 w-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 17v-6m3 6V7m3 10v-3M5 21h14"
                    />
                </svg>
            </span>

            <span class="mt-3 text-sm font-medium text-slate-700">
                View Reports
            </span>
        </a>

    </div>
</section>