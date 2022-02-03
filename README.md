# hello-php

## A naked PHP micro framework

<i>previously called "MyPHP" because i am cringing so much on that name</i><br />

## Disclaimer

This is not recommended for very large & complex projects.
Building PHP made more simple over complicated frameworks on the market.
This is also one of my prototype templates.

## Will deprecate older PHP versions!

The world is changing so fast that PHP 5 & 7 will be outdated very soon.

## Features

* Uses PHP 7 features
* Quite & less modular but still easy to learn for newbies, baby!
* OOP Structured & can do CRUD, Login/Register, Pagination (SOON), & REST
* Quite Documented and plenty of comments inside
* Render whether a JSON object or a web page
* Using Medoo for more easier database handling (called DB in Core)

## Additonal Features

* Multi-user login setup like the Google Auth System (disabled by default)
* You can build a function for email using Composer or load your own library in libraries/ dir
* Uses Composer to load external dependencies by loading Composer dependencies (PHPMailer, PHPUnit, etc.) for sure
* NodeJS ready. You can use Yarn or NPM for load public dependencies such as Bootstrap, JQuery or maybe Foundation too! (You can ignore this if you prefer CDNs)
* Currently using [SB-Admin 2](http://startbootstrap.com/template-overviews/sb-admin-2/) front-end template. You can replace them easily with bower! (Don't forget to check Headers & Footers!)
* .example files might help you in your development!

## Requirements

* Knowledge in PHP 7 or higher
* Familiar in Object-Oriented Programming
* PHP 7.2.5 or higher installed on your machine
* Apache or NGINX or any with rewrite support
* Supports MYSQL/MARIADB & SQLITE as well, if you are going to MYSQL, go install and set it up.
* [Composer](https://getcomposer.org) (PHP Dependency Manager, required and it's available even for Windows with XAMPP, or WAMPS!)

## Installation

### Composer to install PHP dependencies

`$ composer install`

NOTE: You can add more dependency by using this command

`$ composer require author/dependency_name`

### Yarn to install front-end dependencies

`$ yarn install`

### Database Installation (Automated)

This project uses `phinx` as database migration tool.

Just execute the following, and that's it!

```
$ php ./vendor/bin/phinx migrate
$ php ./vendor/bin/phinx seed:run
```

### Database Installation (Manual)

The database query for this are provided [here](https://gist.github.com/jcchikikomori/5e10a6d9e549778eff40adb5a3556e4a)

## Known Issues

* Error Handling for REST/JSON (it's up to you to catch it since it's already parsed on JSON format)

## Work to do

[x] SQLite Support
[ ] Email Service
[x] Forgot Password System
[x] Error Handling with .htaccess
[ ] Error Codes
[x] Using REST/JSON formats for new API class (for OAuth, Android, etc.)
[ ] App Deployment like Heroku, AWS, VPS, etc.
[x] Multi-user
[ ] Pagination
[ ] JSON/REST response handling

## Notice

* Again, this is not recommended for large/complex projects
* **For Apache:** This project is provided with a handy .htaccess in the views folder that denies direct access to the files within the folder (so that people cannot render the views directly). However, these .htaccess files only work if you have set
`AllowOverride` to `All` in your Apache Virtual Host configs. There are lots of tutorials on the web on how to do this.
* Laravel's Linux is the easiest way to test your project locally!

## Credits

* This project is technically a fork from [panique's](https://github.com/panique) code base, so big thanks to him!

## License

Licensed under [MIT](http://www.opensource.org/licenses/mit-license.php). You can use this script for free for any
private or commercial projects.
