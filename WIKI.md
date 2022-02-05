# hello-php Mini Documentation

## Render with additional global variables

To show how straightforward PHP is, the app can extract your data
anywhere you wanted (by setting up like this in root dir -> php file)

```php
// index.php
require_once "classes/App.php";
$app = new classes\App();

// Render with default variable helpers
$app->render("templates/partials/logged_in");

// Render with additional variables
$additional = array("abc" => 123, "xyz" => 789);
$app->render("templates/partials/logged_in", $additional);
```

```php
// views/templates/header.php
...
<body>
  <?php
  // We call additional global variables
  echo $abc;
  echo $xyz;
  // Default global variable
  if ($user_logged_in) {
    include "./views/templates/partials/admin.php";
  } 
  ?>
  ...
```

### Default Global Variables

- `$partial` - Partial render file
- `$user_logged_in` - To determine if user is logged in or not<br />
  Executed in [classes/App.php](classes/App.php)