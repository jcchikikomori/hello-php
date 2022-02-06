<h1 class="title">Hello!</h1>

<?php
    // show potential errors / feedback (from session)
    // libraries\Helper::getFeedback();
?>
<?php
    // Using Session library
    // if you need user information, just put them in Session::set_user() output them here
    echo "<p>You are " . libraries\Session::get_user_details('full_name') . " from " . libraries\Session::get_user_details('user_logged_in_as') . " Department</p>"
?>
Try to close this browser tab and open it again. Still logged in! ;)
<hr />
<?php if ($this->multi_user_status) { ?>
    <!-- Add another user -->
    <a href="multi_user.php?add_existing_user" class="button">Add another user</a>
    <a href="multi_user.php?switch_user" class="button">Switch user</a>
<?php } ?>

<!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->
<a href="index.php?logout" class="button is-danger">Logout</a>
