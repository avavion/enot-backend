<?php

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
            <form action="/auth/signin" method="POST">
                <label>
                    <span>Email</span>
                    <input placeholder="Email" type="email" name="email" />
                </label>

                <label>
                    <span>Password</span>
                    <input placeholder="Password" type="password" name="password" />
                </label>

                <button class="button" type="submit">Login</button>
            </form>
        </div>
    </main>
</body>

</html>