<?php /** @var $this \App\Template */ ?>
<section class="mainNavigation">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <nav>
                    <ul id="mainNavigation">
                        <li class="homeLink<?php __($majorSection == 'home' ? ' selected' : '') ?>"><a href="<?php $this->buildLink('index') ?>">Home</a></li>
                        <li class="movieLink<?php __($majorSection == 'movies' ? ' selected' : '') ?>"><a href="<?php $this->buildLink('movies') ?>">Movies</a></li>

                        <?php if ($visitor['user_id']) { ?>
                            <li class="logoutLink<?php __($majorSection == 'logout' ? ' selected' : '') ?>"><a href="<?php $this->buildLink('logout') ?>">Logout</a></li>
                            <li class="accountLink<?php __($majorSection == 'account' ? ' selected' : '') ?>"><a href="<?php $this->buildLink('account') ?>">Account</a></li>
                        <?php } else { ?>
                            <li class="registerLink<?php __($majorSection == 'register' ? ' selected' : '') ?>"><a href="<?php $this->buildLink('register') ?>">Register</a></li>
                            <li class="loginLink<?php __($majorSection == 'login' ? ' selected' : '') ?>"><a href="<?php $this->buildLink('login') ?>">Login</a></li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>