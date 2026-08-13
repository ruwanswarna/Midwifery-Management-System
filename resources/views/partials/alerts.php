<?php if (!empty($_SESSION['success'])) : ?>

    <div
        class="mb-4 rounded bg-green-100 border border-green-300 text-green-800 p-4">

        <?= $_SESSION['success']; ?>

    </div>

    <?php unset($_SESSION['success']); ?>

<?php endif; ?>


<?php if (!empty($_SESSION['errors'])) : ?>

    <div
        class="mb-4 rounded bg-red-100 border border-red-300 text-red-700 p-4">

        <ul class="list-disc ml-5">

            <?php foreach ($_SESSION['errors'] as $error) : ?>

                <li><?= $error ?></li>

            <?php endforeach; ?>

        </ul>

    </div>

    <?php unset($_SESSION['errors']); ?>

<?php endif; ?>