<?php

use App\Services\Application;
use App\Services\Auth;
use App\Services\View;

if (is_null(Auth::user())) {
    return Application::$app->response->redirect('/signin');
}

?>

<!DOCTYPE html>
<html lang="en">
<?php View::include('components.head'); ?>

<body>
    <?php View::include('components.header'); ?>
    <main>
        <div class="container">
            <h1>Users</h1>

            <ul>
                <?php foreach ($users as $user) : ?>
                    <li>
                        <?= $user['username']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <?php var_dump(Auth::user()); ?>
        </div>
    </main>
</body>

</html>