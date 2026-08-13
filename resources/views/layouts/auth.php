<!DOCTYPE html>

<html lang="en">

<head>
    <?php require ROOT_PATH .
        '/resources/views/partials/head.php'; ?>

</head>
<!-- put styles that affect the entire layout -->

<body class="bg-slate-100">
    <main>
        <!-- load the auth page(login or register) requested -->
        <?php require $viewPath; ?>
    </main>
    <?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
</body>

</html>