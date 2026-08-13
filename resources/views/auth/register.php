<?php
if (!empty($_SESSION['errors'])):
?>

    <div>
        <?php
        foreach ($_SESSION['errors'] as $error):
        ?>
            <p><?= e($error) ?></p>
        <?php
        endforeach;
        unset($_SESSION['errors']);
        ?>
    </div>
<?php
endif;
?>

<!-- html,head,body already exist in auth.php layout -->
<div class="min-h-screen flex items-center justify-center">
    <!-- Put classes specific to the view -->
    <div class="w-full max-w-md bg-white shadow rounded p-6">

        <h1 class="text-2xl font-bold mb-6">

            Register

        </h1>

        <form method="POST" action="<?= APP_URL ?>/register">

            <div class="mb-4">

                <label>Username</label>

                <input
                    type="text"
                    name="username"
                    class="w-full border rounded p-2">

            </div>

            <div class="mb-4">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    class="w-full border rounded p-2">

            </div>

            <button
                class="bg-blue-600 text-white px-4 py-2 rounded">

                Register

            </button>

        </form>

    </div>

</div>