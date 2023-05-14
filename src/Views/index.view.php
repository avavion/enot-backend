<?php

use App\Models\User;
use App\Models\Valute;
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

            <div id="parser" class="parser">
                <div class="wrapper">
                    <div class="from">
                        <select data-attr="from" name="from_char" id="from">
                            <option selected value="RUB">Российский рубль</option>
                        </select>
                        <input name="from_value" type="text" value="<?= $valutes[0]['value'] ?>">
                    </div>

                    <div class="mid">
                        <select name="from_to">
                            <option value="0">Из валюты в рубль</option>
                            <option selected value="1">Из рубля в валюту</option>
                        </select>
                    </div>

                    <div class="to">
                        <select data-attr="to" name="to_char" id="to">
                            <?php foreach ($valutes as $valute) : ?>
                                <option value="<?= $valute['char_code']; ?>">
                                    <?= $valute['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input name="to_value" type="text" value="1">
                    </div>

                </div>

                <button class="button button-primary js-convert-button">
                    Convert RUB to
                </button>
            </div>

            <div class="box">
                <button class="button button-primary js-show-details">
                    Show Details
                </button>

                <div class="details">
                    <h3>Current User</h3>
                    <pre><? print_r(Auth::user()); ?></pre>
                    <hr>
                    <h3>All users</h3>
                    <pre><? print_r(User::query()->get()); ?></pre>
                    <hr>
                    <h3>All valutes</h3>
                    <pre><? print_r(Valute::query()->get()); ?></pre>
                </div>
            </div>

        </div>
    </main>
</body>

</html>