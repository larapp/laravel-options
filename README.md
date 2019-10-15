# Laravel user options

This package simplifies working with user options of your laravel application. The options are saved in two places:
- default options (directives) are in config / options.php
- user options (directives) are stored in option table

When set, the default options will be overwritten by the corresponding user options. This override can be disabled by default, or it can be disabled in developer mode.

All values are cached and the number of database queries is minimized. When you save a new value (or delete an existing value), the cache is regenerated. The data is always fresh.

### Installation

Install the package via composer:
```shell
$ composer require larapper/laravel-options
```

### Run migrations

Run the following command to run migrations.
```shell
$ php artisan migrate
```

### Publish config

Run the following command to publish configs.
```shell
$ php artisan vendor:publish --provider="Larapp\Options\OptionsServiceProvider" --tag=options
```

### Create new default directives

The default directives are stored in config / options.php
```php
return [
   'some-directive' => 'some value',
];
```

### Create users directive

The user options are accessed like any other object. Example to create:
```php
$option = new \Larapper\Options\Model\Option();
$option->name = 'some-directive';
$option->type = 'string';
$option->value = 'some user value';
$option->save();
```

### Use options

You can determine the value of a directive using the standard config function:
```php
$value = config('options.some-directive');
```

### Refresh cache

Command
```shell
$ php artisan options:clear
```

Code
```php
use Larapper\Options\Model\Option;

Options::refresh();
```

### Casting values

Everything is stored in the database as text. When the values are read, the type is automatically cast. You can control this cast in config / options-package.php

### Package setting

See config/options-package.php for setting package behavior.

After its change you MUST refresh the cache!
