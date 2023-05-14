<?php

use App\Services\Session;

?>

<?php if (Session::exists('errors')) : ?>
    <div class="alerts">
        <?php foreach (Session::get('errors') as $key => $value) : ?>

            <?php if (is_array($value)) : ?>
                <?php foreach ($value as $v) : ?>
                    <div class="alert" role="alert">
                        <p class="alert__text">
                            <?= $key ?> - <?= $v; ?>
                        </p>
                    </div>
                <?php endforeach; ?>
                <?php continue; ?>
            <?php endif; ?>

            <div class="alert" role="alert">
                <p class="alert__text">
                    <?= $value; ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php Session::delete('errors'); ?>