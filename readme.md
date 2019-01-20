## Installation

```
git clone https://github.com/PiotrPieniak/Beers.git

cd Beers

composer install

cp .env.example .env

create database and configure it in .env file - set DB_DATABASE, DB_USERNAME and DB_PASSWORD

php artisan key:generate

php artisan migrate

php artisan get:countries

php artisan get:beers

php artisan serve
```

## Api endpoints:
```
api/beers - get all bears

api/beer/{id} - get specific beer

api/brewers - get all brewers

api/countries - get all countries

api/types - get all beer types
```


