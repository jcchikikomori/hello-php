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
                            <input class="input" placeholder="Username" name="user_name" type="text" autofocus required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" placeholder="Password" name="user_password" type="password" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="checkbox">
                            <input type="checkbox" name="remember">
                            Remember me
                        </label>
                    </div>
                    <input type="submit" class="button is-primary" name="login" value="Login" />

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
                        echo '<a href="/" class="btn btn btn-primary btn-block">Go back to home</a>';
                    }
                    echo '<br /><br />';
                    echo '<p><a href="forgotpassword.php" class="btn btn btn-primary btn-block">Forgot Password?</a></p>';
                    echo '<p><a href="register.php" class="btn btn btn-primary btn-block">Register</a></p>';
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>