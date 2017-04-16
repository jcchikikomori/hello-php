<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">MyPHP Login</h3>
                </div>
                <div class="panel-body">
                    <?php
                        // show potential errors / feedback (from session)
                        Helper::getFeedback();
                    ?>
                    <form method="post" action="index.php" name="loginform">
                        <fieldset>
                            <?php
                                if (isset($data) &&
                                    ($data['add_user_requested'] && Session::multi_user_status()) ) {
                                    echo "<p>Add another user!</p>";
                                }
                            ?>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="user_name" type="text" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="user_password" type="password" required>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" class="btn btn-lg btn-success btn-block" name="login" value="Login" />
                            <?php
                                if (isset($data) && !empty($data['logged_users']) && !Session::user_logged_in()) {
                                    echo "<hr /><p>Other active users..</p>";
                                    echo "<ul>";
                                    foreach($data['logged_users'] as $user => $value) {
                                        echo "<li>".
                                                "<a href='index.php?login&u=".$user."&n=".$value['user_name']."'>".$value['full_name']."</a>".
                                                "<a href='index.php?logout&u=".$user."&n=".$value['user_name']."' class='pull-right'>logout</a>".
                                             "</li>";
                                    }
                                    echo "</ul>";
                                }
                            ?>
                            <hr />
                            <a href="register.php" class="btn btn btn-primary btn-block">I would like to Register</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
