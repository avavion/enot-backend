<?php

use App\Services\Auth;

?>
<header class="header" id="header">
    <div class="container">
        <div class="wrapper">
            <h1>Logo</h1>

            <ul>
                <li>
                    <a href="/">
                        Home
                    </a>
                </li>

                <?php if (is_null(Auth::user())) : ?>
                    <li>
                        <a href="/signup">
                            Sign Up
                        </a>
                    </li>

                    <li>
                        <a href="/signin">
                            Sign In
                        </a>
                    </li>
                <?php else : ?>
                    <li>
                        <a href="/auth/logout">
                            Log Out
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>