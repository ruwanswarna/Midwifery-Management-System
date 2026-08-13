<?php
$auth = new Auth();
?>

<div class="space-y-6">

    <!-- Page Header -->

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">

                User Management

            </h1>

            <p class="mt-2 text-slate-500">

                Manage application users and their roles.

            </p>

        </div>

        <a
            href="<?= APP_URL ?>/users/create"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">

            + Add User

        </a>

    </div>


    <!-- Search & Filter -->

    <div class="bg-white rounded-xl shadow border border-slate-200 p-6">

        <form
            action="<?= APP_URL ?>/users"
            method="GET"
            class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <input
                type="text"
                name="search"
                placeholder="Search users..."
                class="border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

            <select
                name="role"
                class="border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                <option value="">All Roles</option>

                <?php foreach ($roles ?? [] as $role) : ?>

                    <option value="<?= $role['id'] ?>">

                        <?= htmlspecialchars($role['name']) ?>

                    </option>

                <?php endforeach; ?>

            </select>

            <select
                name="status"
                class="border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                <option value="">All Status</option>

                <option value="Active">

                    Active

                </option>

                <option value="Inactive">

                    Inactive

                </option>

            </select>

            <button
                class="bg-slate-800 hover:bg-slate-900 text-white rounded-lg px-4 py-3">

                Search

            </button>

        </form>

    </div>


    <!-- Users Table -->

    <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">

        <table class="min-w-full">

            <thead class="bg-slate-100">

                <tr>

                    <th class="px-6 py-4 text-left">

                        ID

                    </th>

                    <th class="px-6 py-4 text-left">

                        Full Name

                    </th>

                    <th class="px-6 py-4 text-left">

                        Username

                    </th>

                    <th class="px-6 py-4 text-left">

                        Role

                    </th>

                    <th class="px-6 py-4 text-left">

                        Status

                    </th>

                    <th class="px-6 py-4 text-center">

                        Actions

                    </th>

                </tr>

            </thead>

            <tbody>

                <?php if (!empty($users)) : ?>

                    <?php foreach ($users as $user) : ?>

                        <tr class="border-t hover:bg-slate-50">

                            <td class="px-6 py-4">

                                <?= $user['id'] ?>

                            </td>

                            <td class="px-6 py-4">

                                <?= htmlspecialchars($user['full_name']) ?>

                            </td>

                            <td class="px-6 py-4">

                                <?= htmlspecialchars($user['username']) ?>

                            </td>

                            <td class="px-6 py-4">

                                <?= htmlspecialchars($user['role_name']) ?>

                            </td>

                            <td class="px-6 py-4">

                                <?php if ($user['status'] === 'Active') : ?>

                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">

                                        Active

                                    </span>

                                <?php else : ?>

                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">

                                        Inactive

                                    </span>

                                <?php endif; ?>

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a
                                        href="<?= APP_URL ?>/users/show/<?= $user['id'] ?>"
                                        class="bg-slate-500 hover:bg-slate-600 text-white px-3 py-2 rounded">

                                        View

                                    </a>

                                    <a
                                        href="<?= APP_URL ?>/users/edit/<?= $user['id'] ?>"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded">

                                        Edit

                                    </a>

                                    <a
                                        href="<?= APP_URL ?>/users/delete/<?= $user['id'] ?>"
                                        onclick="return confirm('Delete this user?')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded">

                                        Delete

                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>

                        <td
                            colspan="6"
                            class="px-6 py-10 text-center text-slate-500">

                            No users found.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>


    <!-- Footer -->

    <div class="flex justify-between items-center text-sm text-slate-500">

        <span>

            Total Users:
            <strong><?= count($users ?? []) ?></strong>

        </span>

        <!-- Pagination Placeholder -->

        <div>

            Pagination

        </div>

    </div>

</div>