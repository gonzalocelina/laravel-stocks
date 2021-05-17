## About Laravel Stocks

Laravel Stocks is a web application that allows the user to check stock prices.

## Getting started

### Requirements

* Laravel Stocks is powered by [AlphaVantage](https://www.alphavantage.co/). If you don't already have an API key, you can get one at https://www.alphavantage.co/support/#api-key
* You'll need an app from [Facebook developers](https://developers.facebook.com/) in order to get an app ID and secret.

### Installation

Clone the repository

    git clone git@github.com:gonzalocelina/laravel-stocks.git

Switch to the repository folder

    cd laravel-stocks

Install all the dependencies using composer

    php composer.phar install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations *(database connection must be set in .env before running the migrations)*

    php artisan migrate

Start the local development server

    php artisan serve --host=localhost --port=8001
    
*Note: As Google Chrome doesn't support cookies on localhost, it's recommended to use Mozilla Firefox for local development*

You can now access the server at http://localhost:8001


### Environment variables

- `FB_APP_ID` - Facebook app ID
- `FB_APP_SECRET` - Facebook app secret key
- `AV_API_KEY` - Alpha Vantage API key

### Testing

To run all tests

    ./vendor/bin/phpunit
