# recharge-app

## Installation
**Clone the repository**
````
   git clone git@github.com:LajwardCo/recharge-app.git

````
**Switch to the repo folder**
````
  cd recharge-app

````
**Install all the dependencies using composer**
````
  composer install

````
**Copy the distribute env file and make the required configuration changes in the .env file (you should change the sertificate key and database connection)**
````
  cp .env.example .env

````
**Generate a new application key**
````
  php artisan key:generate

````
**Generate a new JWT authentication secret key**
````
  php artisan jwt:secret

````

**Run the database migrations (Set the database connection in .env before migrating)**
````
  php artisan migrate

````
**Run the database seeder and you're done**
````
  php artisan db:seed

````
**Start the local development server**
````
  php artisan serve

````
