<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Phonebook

Phonebook is a simple project that consists of a phonebook CRUD. You will be able to store and manage your contacts, such as adding images and information. The application makes use of AWS Storage S3.

## Installation

### Required

- PHP ^8.1
- Composer
- NPM ^9
- MySQL (Or change laravel settings to run on your preferred DB)

## Commands

### Installation
```
npm install
```
to install the components used by Vue with Innertia JS.

```
composer install
```
to install the Laravel project and its dependencies.

### To run the Application
```
npm run dev
```
to run vite and load the Vue and Innertia JS components.

```
php artisan serve
```
to run the Laravel application.

```
php artisan migrate:fresh --seed
```

## Examples
Contacts List              |  Contact Details
:-------------------------:|:-------------------------:
![Contact list image.](public/assets/images/readme_1.jpg)   |  ![Contact details page..](public/assets/images/readme_2.jpg)



> [!IMPORTANT]
> In the `UserSeeder.php file` you will find the system's 'Super Admin' user to start using, but if you prefer you can just register a new user. (_New users are registered with the 'Admin'_ profile).

## License

The Phonebook Project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
