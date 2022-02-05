<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <title>hello-php</title>

  <!-- Favicon -->
  <!-- Source: https://www.php.net/download-logos.php -->
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicons/favicon-16x16.png">
  <link rel="manifest" href="/assets/favicons/site.webmanifest">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <!-- Main Style -->
  <link href="assets/css/index.css" rel="stylesheet">
  <link href="https://bulmatemplates.github.io/bulma-templates/css/admin.css" rel="stylesheet">
</head>

<body>
  <?php
  // TODO: Cleanup or create a helper
  if ($user_logged_in) {
    include "./views/templates/partials/admin.php";
  } else {
  ?>
    <section class="section">
      <div class="container">
        <?php include "./views/templates/partials/dialog.php"; ?>
      </div>
    </section>
  <?php
  }

  // echo '<pre>' . print_r(array_keys($GLOBALS)) . '</pre>';
  // echo '<pre>' . neat_html($GLOBALS["auth"]) . '</pre>';
  // echo '<pre>' . print_r($GLOBALS["auth"]->footer_path) . '</pre>';
  ?>