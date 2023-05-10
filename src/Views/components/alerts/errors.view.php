<?php

use App\Services\Session;

?>

<?php if (Session::exists('errors')) : ?>
    <div class="alerts">
        <?php foreach (Session::get('errors') as $key => $value) : ?>
            <div class="alert" role="alert">
                <p class="alert__text">
                    <?= $value; ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>