<?php

use App\Services\Application;
use App\Services\Session;
use App\Services\View;

?>

<!DOCTYPE html>
<html lang="en">
<?php View::include('components.head'); ?>

<body>
    <?php View::include('components.header'); ?>
    <main>
        <div class="container">

            <?php View::include('components.alerts.errors'); ?>

            <form action="/auth/signup" method="POST">
                <label>
                    <span>Username</span>
                    <input value="<?= Application::$app->session->old('username'); ?>" placeholder="Username" type="text" name="username" />
                </label>

                <label>
                    <span>Email</span>
                    <input value="<?= Application::$app->session->old('email'); ?>" placeholder="Email" type="email" name="email" />
                </label>

                <label>
                    <span>Password</span>
                    <input placeholder="Password" type="password" name="password" />
                </label>

                <button class="button" type="submit">Sign Up</button>
            </form>
        </div>
    </main>
</body>

</html>