
# CryptoKat-API

This api has the purpose of managing digital currencies and their price histories.


## Prerequisites

In order to use this API Locally you'll need:

[Docker](https://www.docker.com/)

[Docker-compose](https://docs.docker.com/compose/install/)

[Composer](https://getcomposer.org/download/)

## Instalation


Copy the enviroment file

```bash
  cp .env.docker .env
```

Install project dependencies

```bash
  composer install
```


Run project containers

```bash
   ./vendor/bin/sail up -d
```

Migrate and seed the project database

```bash
   ./vendor/bin/sail exec app php artisan migrate --seed
```
    
## Tips

When seeded a few currencies will be stored on database. If you wish to add/remove more currencies check the documentation bellow.

You do not need to manually register their price history. Once you call the endpoint to check their current value with or without the specified date it will create the database entry if its not found.


## Documentation

Documentation generated with
[Laravel Request Docs](https://github.com/rakutentech/laravel-request-docs)

Once the api is running you can read it by accessing: [http://localhost/request-docs/](http://localhost/request-docs/)

