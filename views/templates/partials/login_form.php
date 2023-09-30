<div class="columns is-centered is-mobile">
    <div class="column is-full-mobile is-half-tablet is-half-desktop">
        <!-- Migrated from BS into Bulma -->
        <div class="login-panel card">
            <div class="has-text-centered">
                <p class="is-size-4 is-size-5-touch p-2">
                    <?php
                    if ($multi_user_status && libraries\Session::user_logged_in()) {
                        echo 'Add existing user to login';
                    } else {
                        echo 'Login';
                    }
                    ?>
                </p>
            </div>
            <div class="card-body">
                <form method="post" action="/" name="loginform" class="box">
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
                    <div class="buttons">
                        <input type="submit" class="button is-primary is-fullwidth" name="login" value="Login" />
                        <?php
                            if ($multi_user_requested || $switch_user_requested) {
                                echo '<a href="/" class="button is-danger is-fullwidth">Cancel</a>';
                            }
                        ?>
                    </div>

                    <?php
                    if (($multi_user_status) && !libraries\Session::user_logged_in()) {
                        $logged_users = libraries\Session::get('users');
                        if (!empty($logged_users)) {
                            echo "<hr /><p>Other active users..</p><br />";
                            echo "<ul>";
                            foreach ($logged_users as $user => $value) {
                                echo "<li>" .
                                    "<div class='buttons'>" .
                                    "<a class='button is-small is-primary is-outlined' href='?login&u=" . $user . "&n=" . $value['user_name'] . "'>" . $value['full_name'] . "</a>";
                                if (!$switch_user_requested) {
                                    echo "<a class='button is-small is-danger is-rounded is-outlined' href='?logout&u=" . $user . "&n=" . $value['user_name'] . "' class='pull-right'> X</a>";
                                }
                                echo "</div></li>";
                            }
                            echo "</ul>";
                        }
                    }
                    ?>
                    <?php if (!$multi_user_requested && !$switch_user_requested) { ?>
                        <hr />
                        <div class="buttons">
                            <a href="/register" class="button is-fullwidth">Register</a>
                            <a href="/forgotpassword" class="button is-danger is-fullwidth">Forgot Password?</a>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>