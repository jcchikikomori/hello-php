<div class="columns is-centered is-mobile">
    <div class="column is-full-mobile is-half-tablet is-half-desktop">
        <!-- Migrated from BS into Bulma -->
        <div class="login-panel card">
            <div class="has-text-centered">
                <p class="is-size-3 is-size-4-mobile p-2">
                    Reset Password
                </p>
            </div>
            <div class="card-body">
                <form method="post" action="forgotpassword.php?resetpasswordwithcode" name="reset_password_with_code_form" class="box">
                    <?php
                    // show potential errors / feedback (from session)
                    libraries\Helper::getFeedback();
                    ?>
                    <div class="field">
                        <label class="label">Email Address</label>
                        <div class="control">
                            <input class="input" placeholder="" name="email" type="email" autofocus required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Enter your password reset code.</label>
                        <div class="control">
                            <input class="input" placeholder="Please check your email" name="reset_code" type="password" autofocus required>
                        </div>
                    </div>

                    <!-- Change this to a button or input when using this as a form -->
                    <input type="submit" class="button is-primary is-fullwidth" name="reset_password_with_code" value="Reset My Password" />
                    <hr />
                    <div class="buttons are-small">
                        <a href="/" class="button is-danger is-fullwidth">Go back to home</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
