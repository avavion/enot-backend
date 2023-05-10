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
        </div>
    </main>
</body>

</html>