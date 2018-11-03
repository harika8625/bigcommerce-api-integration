# BigCommerce API Integration
BigCommerce Customers and Orders V2 API integration using basic authentication.

## Dependencies
This application uses the [Laravel framework](https://laravel.com/docs/5.6) which requires PHP >= 7.1 to run.

You will also need to install [Composer](https://getcomposer.org/download/). Once setup, install dependencies:
```
composer install
```

## Configuration
Copy the included `.env.example` file:
```
cp .env.example .env
```

Open the newly created `.env` file and fill in the `API_KEY` field with the key.

Before you can run the application, you need to generate an application key. You can do so by running:
```
php artisan key:generate
```

## Developing

To serve the application:
```
php -S localhost:8000 -t public
```                               
