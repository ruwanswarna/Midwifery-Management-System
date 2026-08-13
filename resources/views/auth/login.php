<!-- html,head,body already exist in auth.php layout -->
<div class="min-h-screen flex items-center justify-center bg-slate-100 px-4">
    <!-- Put classes specific to the view -->
    <div class="w-full max-w-md">

        <!-- Logo -->

        <div class="text-center mb-8">

            <h1 class="text-4xl font-bold text-blue-700">

                MOMS

            </h1>

            <p class="mt-2 text-gray-600">

                Midwifery Outcomes Management System

            </p>

        </div>

        <!-- Login Card -->

        <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-8">

            <h2 class="text-2xl font-semibold text-slate-800 mb-1">

                Sign In

            </h2>

            <p class="text-sm text-slate-500 mb-6">

                Enter your username and password.

            </p>

            <form
                action="<?= APP_URL ?>/login"
                method="POST">

                <!-- Username -->

                <div class="mb-5">

                    <label
                        for="username"
                        class="block mb-2 text-sm font-medium text-slate-700">

                        Username

                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        <?php // helper function - get old form data 
                        ?>
                        value="<?= old('username') ?>"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        <?php // autocomplete if browser has previous form data
                        ?>
                        autocomplete="username">

                    <?php if (isset($_SESSION['errors']['username'])) : ?>

                        <p class="mt-2 text-sm text-red-600">

                            <?= $_SESSION['errors']['username'] ?>

                        </p>

                    <?php endif; ?>

                </div>

                <!-- Password -->

                <div class="mb-6">

                    <label
                        for="password"
                        class="block mb-2 text-sm font-medium text-slate-700">

                        Password

                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        autocomplete="current-password">

                    <?php if (isset($_SESSION['errors']['password'])) : ?>

                        <p class="mt-2 text-sm text-red-600">

                            <?= $_SESSION['errors']['password'] ?>

                        </p>

                    <?php endif; ?>

                </div>

                <!-- Login Error -->

                <?php if (isset($_SESSION['errors']['login'])) : ?>

                    <div class="mb-6 rounded-lg border border-red-300 bg-red-50 p-3 text-sm text-red-700">

                        <?= $_SESSION['errors']['login'] ?>

                    </div>

                <?php endif; ?>

                <!-- Submit -->

                <button
                    type="submit"
                    class="w-full rounded-lg bg-blue-600 py-3 text-white font-medium hover:bg-blue-700 transition">

                    Sign In

                </button>

            </form>

        </div>

        <!-- Footer -->

        <p class="mt-6 text-center text-sm text-slate-500">

            &copy; <?= date('Y') ?>

            Midwifery Outcomes Management System

        </p>

    </div>

</div>
<?php
unset($_SESSION['errors']);
?>