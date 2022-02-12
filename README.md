# hello-php

## A naked & tiny PHP starter

## Disclaimer

This is not recommended for very large & complex projects.
Building PHP made more simple over complicated frameworks on the market.
This is also one of my prototype templates.

## Features

* Quite & less modular but still easy to learn for newbies
* OOP Structured
* Documented and plenty of comments inside
* Render whether a JSON object or a web page
* Using Medoo for more easier database handling (called DB in Core)

## Additonal Features

* Multi-user login setup like the Google Auth System (disabled by default)
* Modular PHP application using [Composer](https://getcomposer.org)!
* Supports phpcs (CodeSniffer)
* Supports PHPUnit (Unstable yet)

## Requirements

* Knowledge in PHP 7 or higher
* Familiar in Object-Oriented Programming
* Docker

## Developing on Visual Studio Code (Recommended)

With Docker & VSCode, you can start developing without hassle, or without installing anything.
Know more [here](https://code.visualstudio.com/docs/remote/containers).

## Manual Installation

### Composer to install PHP dependencies

`$ composer install`

NOTE: You can add more dependency by using this command

`$ composer require author/dependency_name`

### Yarn to install front-end dependencies

`$ yarn install`

### Database Installation (Automated)

This project uses [Phinx by CakePHP](https://phinx.org/) as database migration tool.

Just execute the following, and that's it!

```
$ php ./vendor/bin/phinx migrate
$ php ./vendor/bin/phinx seed:run
```

## Notice

* Again, this is not recommended for large/complex projects
* **For Apache:** This project is provided with a handy .htaccess in the views folder that denies direct access to the files within the folder (so that people cannot render the views directly). However, these .htaccess files only work if you have set
`AllowOverride` to `All` in your Apache Virtual Host configs. There are lots of tutorials on the web on how to do this.
* Laravel's Linux is the easiest way to test your project locally!

## Credits

* This project is technically a fork from [panique's](https://github.com/panique) code base, so big thanks to him!

## License

Licensed under [MIT](LICENSE). You can use this script for free for any
private or commercial projects.
