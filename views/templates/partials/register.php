<div class="columns is-centered is-mobile">
    <div class="column is-full-mobile is-half-tablet is-half-desktop">
        <div class="login-panel card">
            <div class="has-text-centered">
                <p class="is-size-3 is-size-4-mobile p-2">
                    Registration
                </p>
            </div>
            <div class="card-body">
                <form method="post" action="/register" name="registerform" class="box">
                    <?php
                    // show potential errors / feedback
                    libraries\Helper::getFeedback();
                    ?>
                    <div class="field">
                        <label class="label">Username</label>
                        <div class="control">
                            <input class="input" placeholder="Only letters and numbers" name="user_name" type="text" pattern="[a-zA-Z0-9]{2,64}" autofocus required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" placeholder="Min. 6 characters" name="user_password_new" type="password" pattern=".{6,}" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Repeat Password</label>
                        <div class="control">
                            <input class="input" placeholder="Repeat Password" name="user_password_repeat" type="password" pattern=".{6,}" required>
                        </div>
                    </div>
                    <hr />
                    <div class="select is-normal">
                        <select name="user_type" title="User Type" autofocus required>
                            <option selected disabled>Please Select User Type</option>
                            <?php foreach ($user_types as $type) {
                                echo '<option value="' . $type['user_type'] . '">' . $type['type_desc'] . '</option>';
                            } ?>
                        </select>
                    </div>
                    <hr />
                    <div class="field">
                        <label class="label">First Name</label>
                        <div class="control">
                            <input class="input" placeholder="" name="first_name" type="text" pattern="{3,64}" autofocus required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Middle Name</label>
                        <div class="control">
                            <input class="input" placeholder="" name="middle_name" type="text" pattern="{3,64}" autofocus required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Last Name</label>
                        <div class="control">
                            <input class="input" placeholder="" name="last_name" type="text" pattern="{3,64}" autofocus required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">E-mail Address</label>
                        <div class="control">
                            <input class="input" placeholder="" name="user_email" type="email" required>
                        </div>
                    </div>

                    <!-- Change this to a button or input when using this as a form -->
                    <input type="submit" class="button is-primary is-fullwidth" name="register" value="Register" />
                    <hr />
                    <a href="/" class="button is-small is-fullwidth">Go back to Login page</a>
                </form>
            </div>
        </div>
    </div>
</div>