# PHP-Google-Login
This project is an implementation of a simple Google Login system in PHP.

## Requirements
1. PHP >= 5.6
2. Composer
2. Google API Console Project with enabled Google+ API and Google OAuth 2.0 API

## Setup Guide
Clone this repository:
git clone https://github.com/[username]/PHP-Google-Login.git

Navigate to the project directory:
cd PHP-Google-Login

Install the dependencies using Composer:
composer install

Create a new project in Google API Console.

Enable Google+ API and Google OAuth 2.0 API for the project.

Create a new OAuth client ID.

Update the client ID, client secret and redirect URI in index.php:

$client->setClientId('YOUR_CLIENT_ID');
$client->setClientSecret('YOUR_CLIENT_SECRET');
$client->setRedirectUri('YOUR_REDIRECT_URI');

Start the PHP built-in server:

php -S localhost:8000

Access the application in your browser at http://localhost:8000.

## Common Errors and Solutions
Missing dependencies: If you get an error related to missing classes, make sure you have installed the dependencies using Composer.
Undefined index: If you get an error related to undefined index in $_GET['code'], make sure that you have granted access to your Google account and the authorization code is being passed in the URL.
Redirect URI mismatch: If you get an error related to redirect URI mismatch, make sure that the redirect URI in your OAuth client ID configuration in Google API Console matches the one in index.php.

## Troubleshooting
If you face any issues, feel free to create an issue in this repository or ask for help in the comments section.
