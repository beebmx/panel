Beeb.mx Panel
===============

beebmx/panel is a CMS (Content Management System) build for kickoff simple and complex projects.
beebmx/panel take your own structure made in Laravel Eloquent ORM and will process all the information in CRUD (create, read, update and delete) form easy as pie.

## Requirements
- Laravel >= 5.3
- PHP >= 5.6.4
- Intervention/image => 2.3
- Doctrine/dbal => 2.5
- Symfony/yaml => 3.1

## Installation
Before you do anything, you need to add the next lines in the right place.

Right now this project is only on GitHub and to use it you need to add the next lines in the composer.json file:

```json
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/beebmx/panel.git"
  }
],
```

In the require section add:
```json
"beebmx/panel": "^2.0",
```

Add the Service Provider in the file `config/app.php`:

```php
Beebmx\Panel\ServiceProvider::class,
```


Add in the file `config/Http/Kernel.php`:

```php
'guest.panel' => \Beebmx\Panel\RedirectIfAuthenticated::class,
'panel' => \Beebmx\Panel\PanelMiddleware::class,
```


Add in `app/User.php` add the next lines

```php
public function profile(){
    return $this->belongsTo('App\Profile');
}
```


Replace the next line in `app/Exceptions/Handler.php`:

```php
return redirect()->guest('login');
```

By:

```php
if ($request->is(config('panel.prefix')) || $request->is(config('panel.prefix').'/*')) {
    return redirect()->guest(config('panel.prefix').'/login');
}else {
    return redirect()->guest('login');
}
```

Then you need to copy panel files in the right place with the next command line:

```sh
php artisan vendor:publish --provider="Beebmx\Panel\ServiceProvider" --tag=config
```

After you need to update the database with the new configuration:

```sh
php artisan migrate
```

By default this `Panel` use a basic configuration for users and profiles structure.
It also have seeds out of the box and you can use it with the next command lines:

```sh
php artisan db:seed --class=ProfilesTableSeeder
php artisan db:seed --class=UsersTableSeeder
```

###Additional Installations

This `Panel` use Laravel structure, for files storage, be sure than you run this command line before you upload anything:

```sh
php artisan storage:link
```

