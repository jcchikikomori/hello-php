<?php
  /**
   * See the magic at: /libraries/Helper.php
   * Source: https://bulma.io/documentation/elements/notification/
   */
?>
<div class="notification is-primary">
  <button class="delete"></button>
  <ul class="list-unstyled"><strong>MSG FROM SERVER</strong><br /><br />
  <?php
    foreach ($_notification_messages as $message) {
      echo '<li>' . $message . '</li>';
    }
  ?>
  </ul>
</div>