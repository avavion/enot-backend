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
            <h1>valutes</h1>

            <ul>
                <?php foreach ($valutes as $valute) : ?>
                    <li>
                        <?php var_dump($valute) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>
</body>

</html>