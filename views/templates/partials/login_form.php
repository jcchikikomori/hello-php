<div class="columns is-centered is-mobile">
    <div class="column is-full-mobile is-half-tablet is-half-desktop">
        <!-- Migrated from BS into Bulma -->
        <div class="login-panel card">
            <div class="has-text-centered">
                <p class="is-size-3 is-size-4-mobile p-2">
                    <?php
                    if ($this->multi_user_status && libraries\Session::user_logged_in()) {
                        echo 'Add existing user to login';
                    } else {
                        echo 'Login';
                    }
                    ?>
                </p>
            </div>
            <div class="card-body">
                <form method="post" action="index.php" name="loginform" class="box">
                    <?php
                    // show potential errors / feedback (from session)
                    libraries\Helper::getFeedback();
                    ?>
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" placeholder="" name="user_name" type="text" autofocus required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" placeholder="" name="user_password" type="password" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="checkbox">
                            <input type="checkbox" name="remember" value="true">
                            Remember me
                        </label>
                    </div>
                    <input type="submit" class="button is-primary is-fullwidth" name="login" value="Login" />

                    <?php
                    if (($this->multi_user_status) && !libraries\Session::user_logged_in()) {
                        $logged_users = libraries\Session::get('users');
                        if (!empty($logged_users)) {
                            echo "<hr /><p>Other active users..</p>";
                            echo "<ul>";
                            foreach ($logged_users as $user => $value) {
                                echo "<li>" .
                                    "<a href='index.php?login&u=" . $user . "&n=" . $value['user_name'] . "'>" . $value['full_name'] . "</a>";
                                if (!isset($switch_user_requested)) {
                                    echo "<a href='index.php?logout&u=" . $user . "&n=" . $value['user_name'] . "' class='pull-right'>logout</a>";
                                }
                                echo "</li>";
                            }
                            echo "</ul>";
                            echo "<hr />";
                        }
                    }
                    if (isset($multi_user_requested) || isset($switch_user_requested)) {
                        echo '<a href="/" class="button is-primary is-fullwidth">Go back to home</a>';
                    }
                    ?>
                    <hr />
                    <div class="buttons are-small">
                        <a href="register.php" class="button is-fullwidth">Register</a>
                        <a href="forgotpassword.php" class="button is-danger is-fullwidth">Forgot Password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>