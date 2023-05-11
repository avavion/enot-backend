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
            <h1>Users</h1>

            <ul>
                <?php foreach ($users as $user) : ?>
                    <li>
                        <?= $user['username']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>
</body>

</html>