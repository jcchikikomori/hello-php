<div class="columns is-centered is-mobile">
    <div class="column is-full-mobile is-half-tablet is-half-desktop">
        <!-- Migrated from BS into Bulma -->
        <div class="login-panel card">
            <div class="has-text-centered">
                <p class="is-size-3 is-size-4-mobile p-2">
                    Password Reset
                </p>
            </div>
            <div class="card-body">
                <form method="post" action="forgotpassword.php?resetnewpassword" name="reset_new_password_form" class="box">
                    <?php
                    // show potential errors / feedback (from session)
                    libraries\Helper::getFeedback();
                    ?>
                    <div class="field">
                        <label class="label">New Password</label>
                        <div class="control">
                            <input class="input" name="new_password" type="password" autofocus required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Repeat your New Password</label>
                        <div class="control">
                            <input class="input" name="repeat_password" type="password" autofocus required>
                        </div>
                    </div>

                    <!-- Hidden fields -->
                    <input name="email" type="hidden" value="<?php echo $email_address; ?>">
                    <input name="reset_code" type="hidden" value="<?php echo $reset_code; ?>">

                    <!-- Change this to a button or input when using this as a form -->
                    <input type="submit" class="button is-primary is-fullwidth" name="reset_new_password" value="Reset My Password" />
                    <!-- <hr />
                    <div class="buttons are-small">
                        <a href="/" class="button is-danger is-fullwidth">Go back to home</a>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
</div>