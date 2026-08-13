<?php
$auth = new Auth();
?>
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Page Header -->

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">

                User Details

            </h1>

            <p class="mt-2 text-slate-500">

                View detailed information about this user.

            </p>

        </div>

        <div class="flex gap-3">

            <a
                href="<?= APP_URL ?>/users/edit/<?= $user['id'] ?>"
                class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-3 rounded-lg">

                Edit User

            </a>

            <a
                href="<?= APP_URL ?>/users"
                class="bg-slate-600 hover:bg-slate-700 text-white px-5 py-3 rounded-lg">

                Back to Users

            </a>

        </div>

    </div>



    <!-- User Information -->

    <div class="bg-white rounded-xl shadow border border-slate-200">

        <div class="border-b px-8 py-5">

            <h2 class="text-xl font-semibold text-slate-800">

                User Information

            </h2>

        </div>

        <div class="p-8">

            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">

                <div>

                    <dt class="text-sm font-medium text-slate-500">

                        User ID

                    </dt>

                    <dd class="mt-1 text-lg text-slate-800">

                        <?= $user['id'] ?>

                    </dd>

                </div>

                <div>

                    <dt class="text-sm font-medium text-slate-500">

                        Username

                    </dt>

                    <dd class="mt-1 text-lg text-slate-800">

                        <?= htmlspecialchars($user['username']) ?>

                    </dd>

                </div>

                <div>

                    <dt class="text-sm font-medium text-slate-500">

                        Full Name

                    </dt>

                    <dd class="mt-1 text-lg text-slate-800">

                        <?= htmlspecialchars($user['full_name']) ?>

                    </dd>

                </div>

                <div>

                    <dt class="text-sm font-medium text-slate-500">

                        Role

                    </dt>

                    <dd class="mt-1 text-lg text-slate-800">

                        <?= htmlspecialchars($user['role_name']) ?>

                    </dd>

                </div>

                <div>

                    <dt class="text-sm font-medium text-slate-500">

                        Status

                    </dt>

                    <dd class="mt-1">

                        <?php if ($user['status'] === 'Active') : ?>

                            <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700">

                                Active

                            </span>

                        <?php else : ?>

                            <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700">

                                Inactive

                            </span>

                        <?php endif; ?>

                    </dd>

                </div>

                <div>

                    <dt class="text-sm font-medium text-slate-500">

                        Created At

                    </dt>

                    <dd class="mt-1 text-lg text-slate-800">

                        <?= $user['created_at'] ?? '-' ?>

                    </dd>

                </div>

                <div>

                    <dt class="text-sm font-medium text-slate-500">

                        Last Updated

                    </dt>

                    <dd class="mt-1 text-lg text-slate-800">

                        <?= $user['updated_at'] ?? '-' ?>

                    </dd>

                </div>

            </dl>

        </div>

    </div>



    <!-- Actions -->

    <div class="bg-white rounded-xl shadow border border-slate-200">

        <div class="p-6 flex justify-end gap-3">

            <a
                href="<?= APP_URL ?>/users/edit/<?= $user['id'] ?>"
                class="px-6 py-3 rounded-lg bg-amber-500 hover:bg-amber-600 text-white">

                Edit

            </a>

            <a
                href="<?= APP_URL ?>/users/delete/<?= $user['id'] ?>"
                onclick="return confirm('Delete this user?')"
                class="px-6 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white">

                Delete

            </a>

        </div>

    </div>

</div>