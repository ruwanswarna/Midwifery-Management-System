<?php
$auth = new Auth();
?>
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Page Header -->

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">

                Edit User

            </h1>

            <p class="mt-2 text-slate-500">

                Update user information.

            </p>

        </div>

        <a
            href="<?= APP_URL ?>/users"
            class="bg-slate-600 hover:bg-slate-700 text-white px-5 py-3 rounded-lg">

            Back to Users

        </a>

    </div>


    <!-- Form Card -->

    <div class="bg-white rounded-xl shadow border border-slate-200">

        <form
            action="<?= APP_URL ?>/users/update/<?= $user['id'] ?>"
            method="POST"
            class="p-8 space-y-8">

            <!-- Account Information -->

            <div>

                <h2 class="text-lg font-semibold text-slate-800 border-b pb-3">

                    Account Information

                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                    <!-- Username -->

                    <div>

                        <label
                            for="username"
                            class="block mb-2 font-medium">

                            Username

                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="<?= old('username') ?? $user['username'] ?>"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                        <?php if (!empty($_SESSION['errors']['username'])) : ?>

                            <p class="mt-2 text-sm text-red-600">

                                <?= $_SESSION['errors']['username'] ?>

                            </p>

                        <?php endif; ?>

                    </div>



                    <!-- Full Name -->

                    <div>

                        <label
                            for="full_name"
                            class="block mb-2 font-medium">

                            Full Name

                        </label>

                        <input
                            type="text"
                            id="full_name"
                            name="full_name"
                            value="<?= old('full_name') ?? $user['full_name'] ?>"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                        <?php if (!empty($_SESSION['errors']['full_name'])) : ?>

                            <p class="mt-2 text-sm text-red-600">

                                <?= $_SESSION['errors']['full_name'] ?>

                            </p>

                        <?php endif; ?>

                    </div>



                    <!-- Password -->

                    <div>

                        <label
                            for="password"
                            class="block mb-2 font-medium">

                            New Password

                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                        <p class="mt-2 text-xs text-slate-500">

                            Leave blank to keep the current password.

                        </p>

                        <?php if (!empty($_SESSION['errors']['password'])) : ?>

                            <p class="mt-2 text-sm text-red-600">

                                <?= $_SESSION['errors']['password'] ?>

                            </p>

                        <?php endif; ?>

                    </div>



                    <!-- Confirm Password -->

                    <div>

                        <label
                            for="confirm_password"
                            class="block mb-2 font-medium">

                            Confirm Password

                        </label>

                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    </div>

                </div>

            </div>



            <!-- User Details -->

            <div>

                <h2 class="text-lg font-semibold text-slate-800 border-b pb-3">

                    User Details

                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                    <!-- Role -->

                    <div>

                        <label
                            for="role_id"
                            class="block mb-2 font-medium">

                            Role

                        </label>

                        <select
                            id="role_id"
                            name="role_id"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                            <?php foreach ($roles as $role) : ?>

                                <option
                                    value="<?= $role['id'] ?>"
                                    <?= (($user['role_id'] == $role['id']) ? 'selected' : '') ?>>

                                    <?= htmlspecialchars($role['name']) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                        <?php if (!empty($_SESSION['errors']['role_id'])) : ?>

                            <p class="mt-2 text-sm text-red-600">

                                <?= $_SESSION['errors']['role_id'] ?>

                            </p>

                        <?php endif; ?>

                    </div>



                    <!-- Status -->

                    <div>

                        <label
                            for="status"
                            class="block mb-2 font-medium">

                            Status

                        </label>

                        <select
                            id="status"
                            name="status"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                            <option
                                value="Active"
                                <?= $user['status'] === 'Active' ? 'selected' : '' ?>>

                                Active

                            </option>

                            <option
                                value="Inactive"
                                <?= $user['status'] === 'Inactive' ? 'selected' : '' ?>>

                                Inactive

                            </option>

                        </select>

                    </div>

                </div>

            </div>



            <!-- Buttons -->

            <div class="flex justify-end gap-3 pt-6 border-t">

                <a
                    href="<?= APP_URL ?>/users"
                    class="px-6 py-3 rounded-lg bg-slate-500 hover:bg-slate-600 text-white">

                    Cancel

                </a>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-lg bg-amber-500 hover:bg-amber-600 text-white">

                    Update User

                </button>

            </div>

        </form>

    </div>

</div>

<?php

unset($_SESSION['errors']);

?>