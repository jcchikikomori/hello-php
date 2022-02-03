<div class="wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel card">
                    <div class="card-header">
                        <h3 class="card-title">Registration</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // show potential errors / feedback
                        libraries\Helper::getFeedback();
                        ?>
                        <form method="post" action="register.php" name="registerform">
                            <fieldset>
                                <div class="form-group">
                                    <select class="form-control" name="user_type" title="User Type" autofocus required>
                                        <option selected disabled>Please Select User Type</option>
                                        <?php foreach ($user_types as $type) {
                                            echo '<option value="' . $type['user_type'] . '">' . $type['type_desc'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input class="form-control"
                                        placeholder="Username (only letters and numbers)"
                                        name="user_name" type="text" pattern="[a-zA-Z0-9]{2,64}" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control"
                                        placeholder="First Name"
                                        name="first_name" type="text" pattern="{3,64}" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control"
                                        placeholder="Middle Name"
                                        name="middle_name" type="text" pattern="{3,64}" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control"
                                        placeholder="Last Name"
                                        name="last_name" type="text" pattern="{3,64}" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control"
                                        placeholder="E-mail"
                                        name="user_email" type="email" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control"
                                        placeholder="Password (min. 6 characters)"
                                        name="user_password_new" type="password" pattern=".{6,}" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control"
                                        placeholder="Repeat Password"
                                        name="user_password_repeat" type="password" pattern=".{6,}" required>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" name="register" value="Register" />
                                <a href="index.php" class="btn btn btn-primary btn-block">Go back to Login page</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
